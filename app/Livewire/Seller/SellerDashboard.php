<?php

namespace App\Livewire\Seller;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerDashboard extends Component
{
    public function mount(): void
    {
        $user = Auth::user();
        if ($user && $user->active_role !== 'seller') {
            $user->forceFill(['active_role' => 'seller'])->save();
        }
    }

    public function render()
    {
        return view('livewire.seller.seller-dashboard');
    }
}
