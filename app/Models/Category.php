<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'requirements'])]
class Category extends Model
{
    protected function casts(): array
    {
        return [
            'requirements' => 'array',
        ];
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function propertyAlerts(): HasMany
    {
        return $this->hasMany(PropertyAlert::class);
    }

    public function blogSubscriptions(): HasMany
    {
        return $this->hasMany(NewsletterSubscription::class);
    }
}
