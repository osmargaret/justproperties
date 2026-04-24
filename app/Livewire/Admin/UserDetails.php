<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class UserDetails extends Component
{
    public ?string $user = null;

    public function mount(?string $user = null): void
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.user-details');
    }
}
