<?php

namespace App\Livewire\Guest;

use App\Livewire\Guest\Concerns\DisplaysCategoryProperties;
use Livewire\Component;

class CompletedProperty extends Component
{
    use DisplaysCategoryProperties;

    protected function getCategorySlug(): string
    {
        return 'completed-properties';
    }
    public function render()
    {
        return view('livewire.guest.completed-property');
    }
}
