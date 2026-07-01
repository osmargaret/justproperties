<?php

namespace App\Livewire\Guest;

use App\Livewire\Guest\Concerns\DisplaysCategoryProperties;
use Livewire\Component;

class UncompletedProperty extends Component
{
    use DisplaysCategoryProperties;

    protected function getCategorySlug(): string
    {
        return 'uncompleted-properties';
    }
    public function render()
    {
        return view('livewire.guest.uncompleted-property');
    }
}
