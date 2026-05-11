<?php

namespace App\Livewire\Seller;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListedProperties extends Component
{
    public function render()
    {
        $properties = Property::query()
            ->with(['category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.seller.listed-properties', [
            'properties' => $properties,
        ]);
    }
}
