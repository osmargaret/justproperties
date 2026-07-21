<?php

namespace App\Livewire\Guest;

use App\Models\Category;
use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        $categories = Category::query()
            ->where('is_property', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.guest.welcome', [
            'categories' => $categories,
        ]);
    }
}
