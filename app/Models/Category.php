<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Property + blog catalogue row.
 *
 * Stable slugs (seeded in {@see \Database\Seeders\CategoriesSeeder}):
 * - landed-properties
 * - uncompleted-properties
 * - completed-properties
 * - rent-lease
 * - short-let
 *
 * Field definitions for forms live in {@see CategorySetting} (`category_settings` table).
 * The legacy `requirements` JSON column is deprecated: keep null and use {@see self::settings()} only.
 */
#[Fillable(['name', 'slug', 'requirements'])]
class Category extends Model
{
    protected function casts(): array
    {
        return [
            'requirements' => 'array',
        ];
    }

    public function settings(): HasMany
    {
        return $this->hasMany(CategorySetting::class)->orderBy('sort_order');
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
        return $this->hasMany(BlogSubscription::class);
    }
}
