<?php

namespace App\Livewire\Guest;

use App\Livewire\Guest\Concerns\DisplaysCategoryProperties;
use Livewire\Component;

class ShortLet extends Component
{
    use DisplaysCategoryProperties;

    protected function getCategorySlug(): string
    {
        return 'short-let';
    }
    public function render()
    {
        return view('livewire.guest.short-let');
    }
}
