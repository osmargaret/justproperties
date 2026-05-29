<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'name',
    'slug',
    'description',
    'cost',
    'category_id',
    'location',
    'country_id',
    'state_id',
    'city_id',
    'neighborhood',
    'address',
    'show_address',
    'status',
    'contact_name',
    'contact_phone',
    'contact_email',
    'contact_whatsapp',
    'user_id',
])]
class Property extends Model
{
    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'show_address' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PropertyReview::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(PropertyAlert::class);
    }

    public function savedByUsers(): HasMany
    {
        return $this->hasMany(SavedProperty::class);
    }

    public function viewedByUsers(): HasMany
    {
        return $this->hasMany(ViewedProperty::class);
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function featuredProperties(): HasMany
    {
        return $this->hasMany(FeaturedProperty::class);
    }

    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function subscriptionLinks(): HasMany
    {
        return $this->hasMany(SubscribedProperty::class);
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(get: function (): string {
            return collect([
                $this->address,
                $this->neighborhood,
                $this->city?->name,
                $this->state?->name,
                $this->country?->name,
            ])->filter()->implode(', ');
        });
    }
}
