<?php

namespace Tests\Feature\Member;

use App\Livewire\Buyer\Profile;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ProfilePreferencesTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_preferences_require_matching_category_types(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $propertyCategory = Category::query()->create([
            'name' => 'Homes',
            'slug' => 'homes',
            'is_property' => true,
        ]);
        $blogCategory = Category::query()->create([
            'name' => 'News',
            'slug' => 'news',
            'is_property' => false,
        ]);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('propertyAlertCategoryIds', [$blogCategory->id])
            ->call('updateNotificationPreferences')
            ->assertHasErrors(['propertyAlertCategoryIds.0']);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('propertyAlertCategoryIds', [$propertyCategory->id])
            ->set('blogCategoryIds', [$blogCategory->id])
            ->call('updateNotificationPreferences')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('property_alerts', [
            'user_id' => $user->id,
            'category_id' => $propertyCategory->id,
            'type' => 'new_property',
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('blog_subscriptions', [
            'email' => $user->email,
            'category_id' => $blogCategory->id,
            'get_new_posts' => true,
        ]);
    }

    public function test_security_tab_updates_password_from_profile(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        Livewire::withQueryParams(['tab' => 'security'])
            ->actingAs($user)
            ->test(Profile::class)
            ->assertSet('activeTab', 'security')
            ->set('current_password', 'password')
            ->set('new_password', 'updated-password')
            ->set('new_password_confirmation', 'updated-password')
            ->call('updatePassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('updated-password', $user->fresh()->password));
    }

    public function test_legacy_security_route_redirects_to_profile_security_tab(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'active_role' => 'buyer',
        ]);

        $this->actingAs($user)
            ->get(route('security.edit'))
            ->assertRedirect(route('account.profile', ['tab' => 'security']));
    }
}
