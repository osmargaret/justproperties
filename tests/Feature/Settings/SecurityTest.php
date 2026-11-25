<?php

namespace Tests\Feature\Settings;

use App\Livewire\Buyer\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_settings_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        Livewire::withQueryParams(['tab' => 'security'])
            ->actingAs($user)
            ->test(Profile::class)
            ->assertSee('Update password');
    }

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->actingAs($user);

        Livewire::test(Profile::class)
            ->set('current_password', 'password')
            ->set('new_password', 'NewPassword1!')
            ->set('new_password_confirmation', 'NewPassword1!')
            ->call('updatePassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('NewPassword1!', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->actingAs($user);

        Livewire::test(Profile::class)
            ->set('current_password', 'wrong-password')
            ->set('new_password', 'NewPassword1!')
            ->set('new_password_confirmation', 'NewPassword1!')
            ->call('updatePassword')
            ->assertHasErrors(['current_password']);
    }
}
