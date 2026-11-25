<?php

namespace Tests\Feature\Member;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewedPostHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_post_views_are_stored_once_in_history(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $post = $this->createPost($user);

        $this->actingAs($user)
            ->get(route('post', $post))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('post', $post))
            ->assertOk();

        $this->assertDatabaseCount('viewed_posts', 1);
        $this->assertDatabaseHas('viewed_posts', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_guest_post_views_are_not_added_to_member_history(): void
    {
        $post = $this->createPost(User::factory()->create());

        $this->get(route('post', $post))->assertOk();

        $this->assertDatabaseCount('viewed_posts', 0);
    }

    private function createPost(User $author): Post
    {
        $category = Category::query()->create([
            'name' => 'Blog',
            'slug' => 'blog',
            'is_property' => false,
        ]);

        return Post::query()->create([
            'user_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Viewed post',
            'slug' => 'viewed-post-'.$author->id,
            'content' => 'A sample article used to test member viewing history.',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
