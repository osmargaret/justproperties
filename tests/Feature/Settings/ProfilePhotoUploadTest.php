<?php

namespace Tests\Feature\Settings;

use App\Livewire\Auth\SwitchActiveRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProfilePhotoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg');

        Livewire::test(SwitchActiveRole::class)
            ->set('photo', $file);

        $user->refresh();

        $this->assertNotNull($user->photo);
        Storage::disk('public')->assertExists($user->photo);
    }

    public function test_profile_photo_validation_rules(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user);

        // Not an image file (e.g. text file)
        $file = UploadedFile::fake()->create('document.pdf', 500);

        Livewire::test(SwitchActiveRole::class)
            ->set('photo', $file)
            ->assertHasErrors(['photo']);

        $user->refresh();
        $this->assertNull($user->photo);
    }
}
