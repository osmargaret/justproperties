<?php

namespace App\Livewire\Member;

use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Promotions extends Component
{
    public function render()
    {
        return view('livewire.member.promotions', [
            'promotions' => Promotion::query()
                ->with(['property', 'plan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get(),
            'properties' => Auth::user()->properties()
                ->withCount('promotions')
                ->latest()
                ->get(),
        ]);
    }
}
