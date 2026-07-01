<?php

namespace App\Http\Traits;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait PaystackTrait
{
    public function initiatePaystack(Payment $payment): string|false
    {
        $payment->loadMissing('user', 'currency');

        $response = Http::withToken((string) config('services.paystack.secret'))
            ->acceptJson()
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $payment->user->email,
                'amount' => (int) round($payment->payable * 100),
                'currency' => strtoupper($payment->currency_code),
                'reference' => $payment->reference,
                'callback_url' => route('seller.payment.callback', ['reference' => $payment->reference]),
            ]);

        Log::info('paystack.initialize', ['reference' => $payment->reference, 'status' => $response->status()]);

        if (! $response->successful()) {
            return false;
        }

        $body = $response->json();

        if (! ($body['status'] ?? false)) {
            return false;
        }

        return (string) ($body['data']['authorization_url'] ?? false);
    }

    protected function verifyPaystackPayment(string $reference): ?object
    {
        $response = Http::withToken((string) config('services.paystack.secret'))
            ->acceptJson()
            ->get('https://api.paystack.co/transaction/verify/'.$reference);
        if (! $response->successful()) {
            return null;
        }

        return (object) $response->json();
    }
}
