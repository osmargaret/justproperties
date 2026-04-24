<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PropertyDetails extends Component
{
    public ?string $property = null;

    public function mount(?string $property = null): void
    {
        $this->property = $property;
    }

    public function render()
    {
        return view('livewire.admin.property-details');
    }
}
