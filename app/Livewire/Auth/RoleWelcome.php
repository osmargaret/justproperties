<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class RoleWelcome extends Component
{
    public function mount(): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login'));

            return;
        }

        if ($user->is_admin) {
            $this->redirect(route('admin.dashboard'));

            return;
        }

        $this->redirect(route('account.dashboard'));
    }

    public function chooseRole(string $role): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login'));
            return;
        }

        $this->redirect(route('account.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.role-welcome');
    }
}
