<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogPostPublishedNotification extends Notification
{
    use Queueable;

    public function __construct(public Post $post) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('A new blog post is available'))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('A new post is available in a category you follow: :post', ['post' => $this->post->title]))
            ->action(__('Read the post'), route('post', $this->post));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'kind' => 'blog_newsletter',
            'title' => __('New blog post'),
            'message' => $this->post->title,
            'url' => route('post', $this->post, absolute: false),
            'post_id' => $this->post->id,
        ];
    }
}
