<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class VerifyEmail extends Component
{
    public function mount(): void
    {
        if (Auth::user()?->hasVerifiedEmail()) {
            $this->redirect(Auth::user()->dashboard_url, navigate: true);
        }
    }

    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirect(Auth::user()->dashboard_url, navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        session()->flash('status', __('A fresh verification link has been sent to your email address.'));
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
