<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Register;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function createCountry(): Country
    {
        return Country::query()->updateOrCreate(
            ['code' => 'NG'],
            [
                'name' => 'Nigeria',
                'slug' => 'nigeria',
                'flag' => '🇳🇬',
                'phone_code' => '+234',
                'language_code' => 'en',
                'is_active' => true,
            ]
        );
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->createCountry();

        $this->get(route('register'))->assertOk();
    }

    public function test_new_users_can_register(): void
    {
        $country = $this->createCountry();

        Livewire::test(Register::class)
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'new-user@example.com')
            ->set('phone', '+2348000000000')
            ->set('country_id', $country->id)
            ->set('password', 'Password1!')
            ->set('password_confirmation', 'Password1!')
            ->set('terms', true)
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect(route('verification.notice'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'new-user@example.com',
            'country_id' => $country->id,
            'active_role' => null,
        ]);

        $this->assertInstanceOf(User::class, User::query()->where('email', 'new-user@example.com')->first());
    }
}
