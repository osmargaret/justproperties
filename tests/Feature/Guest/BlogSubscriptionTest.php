<?php

namespace Tests\Feature\Guest;

use App\Livewire\Guest\BlogPost;
use App\Livewire\Guest\Footer;
use App\Models\BlogSubscription;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class BlogSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_subscribe_to_a_post_without_creating_an_account(): void
    {
        $author = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Market Updates',
            'slug' => 'market-updates',
            'is_property' => false,
        ]);
        $post = Post::query()->create([
            'user_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Market update',
            'content' => 'Market update content',
            'status' => 'published',
        ]);
        $usersCount = User::query()->count();

        Livewire::test(BlogPost::class, ['post' => $post])
            ->set('subscriptionEmail', 'guest@example.com')
            ->call('subscribe')
            ->assertHasNoErrors()
            ->assertSet('statusMessage', 'You are subscribed. We will send updates for this post and related content.');

        $this->assertSame($usersCount, User::query()->count());
        $this->assertDatabaseHas('blog_subscriptions', [
            'email' => 'guest@example.com',
            'category_id' => $category->id,
            'post_id' => $post->id,
            'get_new_posts' => true,
            'get_comments' => true,
        ]);
    }

    public function test_blog_subscription_user_relationship_matches_by_email(): void
    {
        $user = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Market Updates',
            'slug' => 'market-updates',
            'is_property' => false,
        ]);
        $subscription = BlogSubscription::query()->create([
            'email' => $user->email,
            'category_id' => $category->id,
            'get_new_posts' => true,
        ]);

        $this->assertTrue($subscription->user->is($user));
        $this->assertTrue($user->blogSubscriptions->contains($subscription));
    }

    public function test_guest_can_subscribe_to_a_category_from_the_footer(): void
    {
        $category = Category::query()->create([
            'name' => 'Property Updates',
            'slug' => 'property-updates',
            'is_property' => true,
        ]);

        Livewire::test(Footer::class)
            ->set('email', 'guest@example.com')
            ->set('categoryId', $category->id)
            ->call('subscribe')
            ->assertHasNoErrors()
            ->assertSet('statusMessage', 'Successfully subscribed to property alerts!');

        $this->assertDatabaseHas('blog_subscriptions', [
            'email' => 'guest@example.com',
            'category_id' => $category->id,
            'post_id' => null,
            'property_id' => null,
            'get_new_posts' => true,
            'get_comments' => false,
        ]);
    }

    public function test_migration_backfills_and_merges_duplicate_subscriptions(): void
    {
        $migration = require database_path('migrations/2026_10_11_000000_convert_blog_subscriptions_to_email.php');
        $migration->down();

        $user = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Market Updates',
            'slug' => 'market-updates',
            'is_property' => false,
        ]);
        $post = Post::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Market update',
            'content' => 'Market update content',
        ]);

        DB::table('blog_subscriptions')->insert([
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'post_id' => null,
                'property_id' => null,
                'get_new_posts' => false,
                'get_comments' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'post_id' => $post->id,
                'property_id' => null,
                'get_new_posts' => true,
                'get_comments' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $migration->up();

        $subscription = BlogSubscription::query()->sole();

        $this->assertSame(mb_strtolower($user->email), $subscription->email);
        $this->assertSame($post->id, $subscription->post_id);
        $this->assertTrue($subscription->get_new_posts);
        $this->assertTrue($subscription->get_comments);
        $this->assertTrue(Schema::hasColumn('blog_subscriptions', 'email'));
        $this->assertFalse(Schema::hasColumn('blog_subscriptions', 'user_id'));
    }
}
