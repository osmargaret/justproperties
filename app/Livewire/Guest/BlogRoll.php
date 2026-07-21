<?php

namespace App\Livewire\Guest;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Url;

#[Layout('layouts.app')]
class BlogRoll extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $category = '';

    #[Url]
    public $tag = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingTag()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'tag']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::query()
            ->with(['category', 'media'])
            ->where('status', 'published');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        if ($this->tag) {
            $tag = $this->tag;
            $query->where(function ($q) use ($tag) {
                $q->where('tags', 'like', $tag)
                  ->orWhere('tags', 'like', $tag.',%')
                  ->orWhere('tags', 'like', '%, '.$tag)
                  ->orWhere('tags', 'like', '%, '.$tag.',%');
            });
        }

        // Fetch Featured Post (Active Promotion)
        $featuredPost = Post::query()
            ->with(['category', 'media'])
            ->where('status', 'published')
            ->whereHas('promotions', function ($q) {
                $q->where('status', 'active');
            })
            ->latest()
            ->first();

        // Fallback to Most Popular Post if no active promotion
        if (!$featuredPost) {
            $featuredPost = Post::query()
                ->with(['category', 'media'])
                ->where('status', 'published')
                ->orderByDesc('views_count')
                ->first();
        }

        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        $posts = $query->latest('published_at')->paginate(6);

        $popularPosts = Post::query()
            ->with(['category', 'media'])
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->take(4)
            ->get();

        $categories = Category::query()->has('posts')->get();

        return view('livewire.guest.blog-roll', [
            'featuredPost' => $featuredPost,
            'posts' => $posts,
            'popularPosts' => $popularPosts,
            'categories' => $categories,
        ]);
    }
}
