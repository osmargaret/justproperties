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
use Livewire\WithFileUploads;

class Checkout extends Component
{
    use PaymentTrait;
    use WithFileUploads;

    public Payment $payment;

    public ?string $gatewayError = null;

    public string $couponCode = '';
    public ?string $couponMessage = null;
    public bool $couponSuccess = false;

    public string $paymentMethod = '';
    public $receiptFile;

    public function mount(Payment $payment): void
    {
        abort_unless($payment->user_id === Auth::id(), 403);

        $this->payment = $payment->load(['currency', 'paymentable', 'user']);

        if ($this->payment->isCompleted()) {
            session()->flash('status', __('This payment has already been completed.'));

            return;
        }

        $gateway = $this->payment->currency?->payment_gateway;
        $hasBankDetails = ! empty($this->payment->currency?->bank_details);

        if (! $gateway && ! $hasBankDetails) {
            $this->gatewayError = __('No payment method is configured for this currency. Ask an admin to set one under Settings → Currencies.');
        } elseif ($gateway && ! $this->gatewayIsConfigured($gateway)) {
            if ($hasBankDetails) {
                $this->paymentMethod = 'bank_transfer';
            } else {
                $this->gatewayError = __('Payment gateway credentials are missing in the server environment.');
            }
        } else {
            if ($gateway) {
                $this->paymentMethod = $gateway;
            } elseif ($hasBankDetails) {
                $this->paymentMethod = 'bank_transfer';
            }
        }

        if ($this->paymentMethod && $this->paymentMethod !== 'bank_transfer') {
            $this->payment->method = $this->paymentMethod;
            $this->payment->gateway = $this->paymentMethod;
            $this->payment->save();
        }
    }

    public function applyCouponCode()
    {
        $this->couponMessage = null;
        $this->couponSuccess = false;

        $code = trim($this->couponCode);
        if (!$code) {
            $this->couponMessage = 'Please enter a coupon code.';
            return;
        }

        $result = $this->applyCoupon($this->payment, $code);

        if ($result['status']) {
            $this->payment->refresh();
            $this->couponSuccess = true;
            $this->couponCode = '';
            $this->couponMessage = $result['message'];
        } else {
            $this->couponMessage = $result['message'];
        }
    }

    public function pay(): mixed
    {
        if ($this->payment->isCompleted()) {
            return $this->redirectAfterPayment();
        }

        if ($this->paymentMethod === 'bank_transfer') {
            $this->validate([
                'receiptFile' => ['required', 'file', 'image', 'max:5120'], // 5MB max
            ]);

            $path = $this->receiptFile->store('receipts', 'public');
            $this->payment->method = 'bank_transfer';
            $this->payment->gateway = 'bank_transfer';
            $this->payment->receipt = $path;
            $this->payment->status = 'pending';
            $this->payment->save();

            session()->flash('status', __('Receipt uploaded successfully. Your payment is awaiting admin verification.'));

            return $this->redirectAfterPayment();
        }

        if ($this->gatewayError) {
            $this->addError('payment', $this->gatewayError);

            return null;
        }

        $result = $this->initializePayment($this->payment);

        if (! $result || empty($result['redirect_url'])) {
            $this->addError('payment', __('Unable to start payment with the selected gateway. Please try again later.'));

            return null;
        }

        return redirect()->away($result['redirect_url']);
    }

    public function completePaymentLocally(): mixed
    {
        if (! app()->environment('local')) {
            abort(403);
        }

        app(CompletesPayment::class)->complete($this->payment, 'local_test');
        session()->flash('status', __('Payment marked completed (local testing only).'));

        return $this->redirectAfterPayment();
    }

    protected function gatewayIsConfigured(string $gateway): bool
    {
        return match ($gateway) {
            'paystack' => filled(config('services.paystack.secret')),
            'flutterwave' => filled(config('services.flutterwave.secret')),
            default => false,
        };
    }

    protected function redirectAfterPayment(): mixed
    {
        if ($this->payment->paymentable_type === Promotion::class && $this->payment->paymentable_id) {
            $propertyId = Promotion::query()->whereKey($this->payment->paymentable_id)->value('property_id');

            return redirect()->route('seller.properties.show', ['property' => $propertyId, 'tab' => 'promotions']);
        }

        if ($this->payment->paymentable_type === Subscription::class && $this->payment->paymentable_id) {
            $propertyId = SubscribedProperty::query()
                ->where('subscription_id', $this->payment->paymentable_id)
                ->latest('id')
                ->value('property_id');

            if ($propertyId) {
                return redirect()->route('seller.properties.show', ['property' => $propertyId]);
            }
        }

        if ($this->payment->paymentable_type === Property::class && $this->payment->paymentable_id) {
            return redirect()->route('seller.properties.show', ['property' => $this->payment->paymentable_id]);
        }

        return redirect()->route('seller.listed-properties');
    }

    public function render()
    {
        return view('livewire.seller.checkout');
    }
}
