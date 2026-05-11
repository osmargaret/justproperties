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

        if ($user->active_role !== null && $user->active_role !== '') {
            $this->redirect($user->dashboard_url);
        }
    }

    public function render()
    {
        return view('livewire.auth.role-welcome');
    }
}
