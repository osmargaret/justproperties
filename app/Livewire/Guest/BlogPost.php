<?php

namespace App\Livewire\Guest;

use App\Models\BlogSubscription;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use App\Notifications\BlogSubscriptionWelcomeNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BlogPost extends Component
{
    public Post $post;
    public Collection $relatedPosts;
    public string $commentName = '';
    public string $commentEmail = '';
    public string $commentContent = '';
    public string $subscriptionEmail = '';
    public ?string $statusMessage = null;
    public ?string $errorMessage = null;
    public int $readingTime = 1;

    public function mount(Post $post): void
    {
        $post->load(['category', 'user', 'media']);

        $this->post = $post;
        $this->relatedPosts = Post::query()
            ->with(['media', 'category'])
            ->where('status', 'published')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $this->readingTime = max(1, (int) round(str_word_count(strip_tags($post->content)) / 200));
    }

    public function getCommentsProperty()
    {
        return PostComment::query()
            ->where('post_id', $this->post->id)
            ->latest()
            ->get();
    }

    public function submitComment(): void
    {
        $this->validate([
            'commentName' => 'required|string|max:100',
            'commentEmail' => 'required|email|max:150',
            'commentContent' => 'required|string|max:1000',
        ]);

        PostComment::query()->create([
            'post_id' => $this->post->id,
            'name' => $this->commentName,
            'email' => $this->commentEmail,
            'comment' => $this->commentContent,
        ]);

        $this->reset(['commentName', 'commentEmail', 'commentContent']);
        $this->statusMessage = 'Thank you! Your comment has been posted.';
        $this->errorMessage = null;
    }

    public function subscribe(): void
    {
        $this->validate([
            'subscriptionEmail' => 'required|email|max:150',
        ]);

        $user = User::query()->where('email', $this->subscriptionEmail)->first();
        $password = null;

        if (! $user) {
            $password = Str::random(12);

            $user = User::query()->create([
                'name' => Str::before($this->subscriptionEmail, '@') ?: 'Subscriber',
                'email' => $this->subscriptionEmail,
                'password' => $password,
                'email_verified_at' => now(),
                'active_role' => 'buyer',
            ]);
        }

        BlogSubscription::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'category_id' => $this->post->category_id,
                'post_id' => $this->post->id,
            ],
            [
                'property_id' => null,
                'get_new_posts' => true,
                'get_comments' => true,
            ]
        );

        if ($password) {
            $user->notify(new BlogSubscriptionWelcomeNotification($user, $password));
        }

        $this->reset('subscriptionEmail');
        $this->statusMessage = 'You are subscribed. We will send updates for this post and related content.';
        $this->errorMessage = null;
    }

    public function render()
    {
        return view('livewire.guest.blog-post');
    }
}
