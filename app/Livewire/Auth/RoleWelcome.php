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

    /**
     * Set the user's active role and redirect to the appropriate dashboard.
     */
    public function chooseRole(string $role): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login'));
            return;
        }

        $validRoles = ['buyer', 'seller'];

        if (! in_array($role, $validRoles)) {
            return;
        }

        $user->active_role = $role;
        $user->save();

        $this->redirect($user->dashboard_url, navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.role-welcome');
    }
}
