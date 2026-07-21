<?php

namespace App\Livewire\Seller;

use App\Http\Traits\PaymentTrait;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Property;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Services\Payments\CompletesPayment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentCallback extends Component
{
    use PaymentTrait;

    public function mount(): mixed
    {
        $reference = request()->query('reference') ?? request()->query('tx_ref') ?? request()->query('trxref');

        if (! $reference) {
            session()->flash('error', __('Payment reference was not returned by the gateway.'));

            return redirect()->route('seller.listed-properties');
        }

        $payment = Payment::query()
            ->where('reference', $reference)
            ->where('user_id', Auth::id())
            ->first();

        if (! $payment) {
            session()->flash('error', __('Payment record not found.'));
            return redirect()->route('seller.listed-properties');
        }

        if ($payment->isCompleted()) {
            return $this->redirectAfterPayment($payment);
        }

        $verification = $this->verifyPayment($payment);
        
        if (! $verification || ! ($verification['status'] ?? false) || ($verification['trx_status'] ?? '') !== 'success') {
            $payment->status = 'failed';
            $payment->save();
            session()->flash('error', __('Payment could not be verified. Please try again or contact support.'));
            return redirect()->route('seller.checkout', ['payment' => $payment->id]);
        }
        app(CompletesPayment::class)->complete(
            $payment,
            (string) ($verification['method'] ?? $payment->method),
            is_array($verification) ? $verification : null,
        );

        session()->flash('status', __('Payment completed successfully.'));

        return $this->redirectAfterPayment($payment->fresh());
    }

    protected function redirectAfterPayment(Payment $payment): mixed
    {
        if ($payment->paymentable_type === Promotion::class && $payment->paymentable_id) {
            $propertyId = Promotion::query()->whereKey($payment->paymentable_id)->value('property_id');

            return redirect()->route('seller.properties.show', [
                'property' => $propertyId,
                'tab' => 'promotions',
            ]);
        }

        if ($payment->paymentable_type === Subscription::class && $payment->paymentable_id) {
            $propertyId = SubscribedProperty::query()
                ->where('subscription_id', $payment->paymentable_id)
                ->latest('id')
                ->value('property_id');

            if ($propertyId) {
                return redirect()->route('seller.properties.show', ['property' => $propertyId]);
            }
        }

        if ($payment->paymentable_type === Property::class && $payment->paymentable_id) {
            return redirect()->route('seller.properties.show', ['property' => $payment->paymentable_id]);
        }

        return redirect()->route('seller.listed-properties');
    }

    public function render()
    {
        return view('livewire.seller.payment-callback');
    }
}
