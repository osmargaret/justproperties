<?php

namespace App\Livewire\Buyer;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BuyerDashboard extends Component
{
    public function mount(): void
    {
        $user = Auth::user();
        if ($user && $user->active_role !== 'buyer') {
            $user->forceFill(['active_role' => 'buyer'])->save();
        }
    }

    public function render()
    {
        return view('livewire.buyer.buyer-dashboard');
    }
}
