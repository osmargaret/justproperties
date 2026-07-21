<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

#[Layout('layouts.auth')]
class SwitchActiveRole extends Component
{
    use WithFileUploads;

    public $user;

    public $isAdmin;

    public $role;

    public $photo;

    public function mount(): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'));
        }
        $this->user = Auth::user();
        $this->isAdmin = $this->user->is_admin;
        $this->role = $this->isAdmin ? ($this->user->active_role ?: 'admin') : $this->user->active_role;
    }

    public function switchRole(string $role): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirect(route('login'));

            return;
        }

        $role = match ($role) {
            'admin', 'buyer', 'seller' => $role,
            default => null,
        };

        if ($role === null) {
            return;
        }

        if ($role === 'admin' && ! $user->is_admin) {
            return;
        }

        $user->active_role = $role;
        $user->save();

        $this->redirect($user->fresh()->dashboard_url);
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048', // 2MB Max
        ]);

        $path = $this->photo->store('profile-photos', 'public');

        $user = Auth::user();
        if ($user && $user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        if ($user) {
            $user->photo = $path;
            $user->save();
        }
    }

    public function render()
    {
        return view('livewire.auth.switch-active-role');
    }
}
