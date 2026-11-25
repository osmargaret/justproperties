<?php

namespace App\Livewire\Member;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->whereKey($notificationId)->firstOrFail();
        $notification->markAsRead();
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.member.notifications', [
            'notifications' => Auth::user()->notifications()->latest()->paginate(15),
            'unreadCount' => Auth::user()->unreadNotifications()->count(),
        ]);
    }
}
