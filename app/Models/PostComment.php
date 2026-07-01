<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['post_id', 'name', 'email', 'comment'])]
class PostComment extends Model
{
    protected function casts(): array
    {
        return [];
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
