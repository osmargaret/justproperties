<?php

namespace App\Livewire\Seller;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public Payment $payment;

    public function mount(Payment $payment): void
    {
        abort_unless($payment->user_id === Auth::id(), 403);

        $this->payment = $payment;
    }

    public function markAsPaidPlaceholder(): mixed
    {
        $this->payment->status = 'completed';
        $this->payment->method = $this->payment->method ?: 'gateway_placeholder';
        $this->payment->save();

        if ($this->payment->paymentable_type === Property::class && $this->payment->paymentable_id) {
            Property::query()
                ->whereKey($this->payment->paymentable_id)
                ->where('user_id', Auth::id())
                ->update(['status' => 'active']);
        }

        session()->flash('status', __('Payment marked completed (placeholder flow).'));

        return redirect()->route('seller.properties.show', ['property' => $this->payment->paymentable_id]);
    }

    public function render()
    {
        return view('livewire.seller.checkout');
    }
}
