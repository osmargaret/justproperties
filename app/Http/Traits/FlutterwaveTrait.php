<?php

namespace App\Http\Traits;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait FlutterwaveTrait
{
    protected function initiateFlutterWave(Payment $payment): string|false
    {
        $payment->loadMissing('user', 'currency');

        $response = Http::withToken((string) config('services.flutterwave.secret'))
            ->acceptJson()
            ->post('https://api.flutterwave.com/v3/payments', [
                'customer' => [
                    'email' => $payment->user->email,
                    'phonenumber' => $payment->user->phone ?? '',
                    'name' => $payment->user->name,
                ],
                'tx_ref' => $payment->reference,
                'currency' => strtoupper($payment->currency_code),
                'payment_options' => 'card,account,ussd',
                'redirect_url' => route('seller.payment.callback', ['reference' => $payment->reference]),
                'amount' => $payment->payable,
                'customizations' => [
                    'title' => config('app.name'),
                    'description' => 'Payment',
                ],
            ]);

        Log::info('flutterwave.initialize', ['reference' => $payment->reference, 'status' => $response->status()]);

        if (! $response->successful()) {
            return false;
        }

        $body = $response->json();

        if (($body['status'] ?? '') !== 'success') {
            return false;
        }

        return (string) ($body['data']['link'] ?? false);
    }

    protected function verifyFlutterWavePayment(string $reference): ?object
    {
        $response = Http::withToken((string) config('services.flutterwave.secret'))
            ->acceptJson()
            ->get('https://api.flutterwave.com/v3/transactions/verify_by_reference', [
                'tx_ref' => $reference,
            ]);

        if (! $response->successful()) {
            return null;
        }

        return (object) $response->json();
    }
}
