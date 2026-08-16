<?php

namespace App\Livewire\Auth;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public ?int $country_id = null;

    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms = false;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:40'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'terms' => ['accepted'],
        ];
    }

    public function register(): mixed
    {
        $this->validate();

        $name = trim($this->first_name.' '.$this->last_name);

        $user = User::create([
            'name' => $name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'active_role' => null,
            'two_factor_enable' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // States & cities will be populated when admin adds countries.

        return redirect()->route('verification.notice');
    }

    public function socialSignup(string $provider): void
    {
        session()->flash('status', "Social signup with {$provider} is not implemented yet.");
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'countries' => Country::query()
                ->where('is_active', true)
                ->orderBy('name','asc')
                ->get(['id', 'name', 'flag']),
        ]);
    }
}
