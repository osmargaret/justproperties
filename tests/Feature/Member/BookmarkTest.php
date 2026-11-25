<?php

namespace Tests\Feature\Member;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_add_and_remove_a_property_bookmark(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::query()->create([
            'name' => 'Homes',
            'slug' => 'homes',
            'is_property' => true,
        ]);
        $property = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Bookmark property',
            'description' => 'A property available to bookmark.',
            'cost' => 100000,
        ]);

        $this->actingAs($user)
            ->withSession(['_token' => 'bookmark-token'])
            ->post(route('properties.bookmark.toggle', $property), ['_token' => 'bookmark-token'])
            ->assertRedirect();
        $this->assertDatabaseHas('saved_properties', [
            'user_id' => $user->id,
            'property_id' => $property->id,
        ]);

        $this->post(route('properties.bookmark.toggle', $property), ['_token' => 'bookmark-token'])
            ->assertRedirect();
        $this->assertDatabaseCount('saved_properties', 0);
    }
}
