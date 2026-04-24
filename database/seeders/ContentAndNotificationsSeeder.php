<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentAndNotificationsSeeder extends Seeder
{
    /**
     * posts → blog_subscriptions (may reference posts) → notifications.
     */
    public function run(): void
    {
        $seller = User::query()->where('email', 'seller@example.com')->firstOrFail();
        $buyer = User::query()->where('email', 'buyer@example.com')->firstOrFail();
        $blogCategory = Category::query()->where('slug', 'completed-properties')->firstOrFail();
        $property = Property::query()->where('user_id', $seller->id)->orderBy('id')->first();

        $post = Post::query()->updateOrCreate(
            ['slug' => 'lagos-market-q1-2026'],
            [
                'user_id' => $seller->id,
                'category_id' => $blogCategory->id,
                'property_id' => $property?->id,
                'title' => 'Lagos property market: what sellers should know in Q1',
                'excerpt' => 'A concise overview of asking prices and time-on-market trends across key corridors.',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Supply in prime corridors remains tight while buyer enquiries have picked up week over week.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ]
        );

        NewsletterSubscription::query()->firstOrCreate(
            [
                'user_id' => $buyer->id,
                'category_id' => $blogCategory->id,
                'post_id' => null,
            ],
            [
                'property_id' => null,
                'get_new_posts' => true,
                'get_comments' => false,
            ]
        );

        NewsletterSubscription::query()->firstOrCreate(
            [
                'user_id' => $buyer->id,
                'category_id' => $blogCategory->id,
                'post_id' => $post->id,
            ],
            [
                'property_id' => null,
                'get_new_posts' => false,
                'get_comments' => true,
            ]
        );

        $seedNotificationId = '00000000-0000-4000-8000-000000000001';
        DB::table('notifications')->updateOrInsert(
            ['id' => $seedNotificationId],
            [
                'type' => 'App\Notifications\Database\ExampleNotification',
                'notifiable_type' => User::class,
                'notifiable_id' => $buyer->id,
                'data' => json_encode(['title' => 'Welcome', 'body' => 'Your account is ready to save listings and book inspections.']),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
