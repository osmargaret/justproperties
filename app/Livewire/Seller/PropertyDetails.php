<?php

namespace App\Livewire\Seller;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PropertyDetails extends Component
{
    public Property $property;

    public ?Payment $pendingPayment = null;

    public function mount(Property $property): void
    {
        abort_unless($property->user_id === Auth::id(), 403);

        $this->property = $property;
        $this->pendingPayment = Payment::query()
            ->where('paymentable_type', Property::class)
            ->where('paymentable_id', $property->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }

    public function render()
    {
        return view('livewire.seller.property-details');
    }
}
