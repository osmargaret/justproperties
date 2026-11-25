<?php

namespace App\Livewire\Guest;

use App\Models\AdvertisementPlan;
use App\Models\AdvertisementSpace;
use Livewire\Component;

class Advertise extends Component
{
    public function render()
    {
        return view('livewire.guest.advertise', [
            'spaces' => AdvertisementSpace::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'plans' => AdvertisementPlan::query()
                ->with(['spaces', 'prices.currency'])
                ->where('is_active', true)
                ->whereHas('prices')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
