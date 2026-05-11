<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function mount(): void
    {
        $user = Auth::user();
        if ($user && $user->is_admin && $user->active_role !== 'admin') {
            $user->forceFill(['active_role' => 'admin'])->save();
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
