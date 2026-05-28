<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function suspend(): void
    {
        $this->user->update(['suspended_at' => now()]);
        $this->user->refresh();
        session()->flash('status', __('User suspended.'));
    }

    public function unsuspend(): void
    {
        $this->user->update(['suspended_at' => null]);
        $this->user->refresh();
        session()->flash('status', __('User unsuspended.'));
    }

    public function delete(): mixed
    {
        $this->user->delete();
        session()->flash('status', __('User deleted.'));

        return redirect()->route('admin.users');
    }

    public function render()
    {
        $this->user->loadCount(['properties', 'subscriptions']);

        return view('livewire.admin.user-details');
    }
}
