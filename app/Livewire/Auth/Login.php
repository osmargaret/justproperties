<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function togglePassword()
    {
        // This will be handled by JavaScript
    }

    public function socialLogin($provider)
    {
        // Implement social login logic here
        // For now, just redirect or show message
        session()->flash('status', "Social login with {$provider} is not implemented yet.");
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}