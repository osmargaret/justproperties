<?php

namespace App\Services\Notifications;

use App\Models\BlogSubscription;
use App\Models\Post;
use App\Notifications\BlogPostPublishedNotification;

class NotifiesBlogSubscribers
{
    public function notify(Post $post): void
    {
        BlogSubscription::query()
            ->where('category_id', $post->category_id)
            ->where('get_new_posts', true)
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->each(fn ($user) => $user->notify(new BlogPostPublishedNotification($post)));
    }
}
