<?php

namespace App\Livewire\Guest;

use App\Livewire\Guest\Concerns\DisplaysCategoryProperties;
use Livewire\Component;

class LandedProperty extends Component
{
    use DisplaysCategoryProperties;

    protected function getCategorySlug(): string
    {
        return 'landed-properties';
    }
    public function render()
    {
        return view('livewire.guest.landed-property');
    }
}
