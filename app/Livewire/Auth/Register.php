<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $account_type = 'buyer';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'account_type' => 'required|in:buyer,seller,agent',
        ];
    }

    public function togglePassword()
    {
        // This will be handled by JavaScript
    }

    public function socialSignup($provider)
    {
        // Implement social signup logic here
        // For now, just redirect or show message
        session()->flash('status', "Social signup with {$provider} is not implemented yet.");
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}