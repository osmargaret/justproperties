<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'user_id',
    'category_id',
    'property_id',
    'title',
    'slug',
    'excerpt',
    'content',
    'content_source',
    'ai_generated_at',
    'status',
    'published_at',
    'tags',
])]
class Post extends Model
{
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
            'ai_generated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function blogSubscriptions(): HasMany
    {
        return $this->hasMany(NewsletterSubscription::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function promotions(): MorphMany
    {
        return $this->morphMany(Promotion::class, 'promotable');
    }
}
