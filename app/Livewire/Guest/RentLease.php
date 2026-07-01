<?php

namespace App\Livewire\Guest;

use App\Livewire\Guest\Concerns\DisplaysCategoryProperties;
use Livewire\Component;

class RentLease extends Component
{
    use DisplaysCategoryProperties;

    protected function getCategorySlug(): string
    {
        return 'rent-lease';
    }
    public function render()
    {
        return view('livewire.guest.rent-lease');
    }
}
