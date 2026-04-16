<?php

namespace App\Livewire\Blog;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BlogRoll extends Component
{
    public function render()
    {
        return view('livewire.blog.blog-roll');
    }
}
