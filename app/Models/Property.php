<?php

namespace App\Models;

use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

#[Fillable([
    'name',
    'slug',
    'description',
    'cost',
    'category_id',
    'location',
    'country_id',
    'state_id',
    'city',
    'neighborhood',
    'address',
    'show_address',
    'is_published',
    'contact_name',
    'contact_phone',
    'contact_email',
    'contact_whatsapp',
    'user_id',
])]
#[ObservedBy([PropertyObserver::class])]
class Property extends Model
{
    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'show_address' => 'boolean',
            'is_published' => 'boolean',
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
        // Cities are stored as freeform strings on the property now.
        throw new \BadMethodCallException('Property::city relation removed; use the `city` attribute instead.');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(PropertyReport::class);
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

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
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
    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }

    
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscribed_properties')
            ->withTimestamps();
    }

    /**
     * Pivot rows in subscribed_properties (property ↔ subscription seat usage).
     */
    public function subscribedPropertyLinks(): HasMany
    {
        return $this->hasMany(SubscribedProperty::class);
    }

    /** @deprecated Use subscribedPropertyLinks() — kept for existing eager loads */
    public function subscriptionLinks(): HasMany
    {
        return $this->subscribedPropertyLinks();
    }

    /**
     * The subscribed_properties row tying this listing to an active subscription (if any).
     */
    public function activeSubscribedPropertyLink(): HasOne
    {
        return $this->hasOne(SubscribedProperty::class)
            ->whereHas('subscription', function (Builder $query): void {
                $query->where('status', 'active')
                    ->where('end_at', '>=', now());
            })
            ->latestOfMany();
    }

    /** @deprecated Use activeSubscribedPropertyLink() */
    public function activeSubscriptionLink(): HasOne
    {
        return $this->activeSubscribedPropertyLink();
    }

    public function scopeWithOverviewStats(Builder $query): Builder
    {
        return $query->withCount([
            'viewedByUsers',
            'savedByUsers',
            'alerts',
            'reports',
            'promotions',
        ]);
    }

    protected function displayLocation(): Attribute
    {
        return Attribute::make(get: function (): string {
            if (! $this->show_address) {
                return collect([
                    $this->neighborhood,
                    $this->city,
                    $this->state?->name,
                    $this->country?->name,
                ])->filter()->implode(', ');
            }

            return $this->full_address;
        });
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(get: function (): string {
            return collect([
                $this->address,
                $this->neighborhood,
                    $this->city,
                $this->state?->name,
                $this->country?->name,
            ])->filter()->implode(', ');
        });
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (! $this->is_published) {
                    return 'draft';
                }

                $hasActiveSubscription = $this->activeSubscribedPropertyLink()->exists();
                $latestModeration = $this->latestModeration;

                if ($latestModeration) {
                    switch ($latestModeration->status) {
                        case 'approved':
                            return $hasActiveSubscription ? 'live' : 'no subscription';
                        case 'pending':
                        case 'rejected':
                            return $latestModeration->status;
                        default:
                            return 'pending';
                    }
                }

                // No moderation record - check subscription status
                return $hasActiveSubscription ? 'live' : 'no subscription';
            },
        );
    }

    public function currency()
    {
        return $this->user->country?->currency->symbol ?? '$';
    }

    public function featureValue(string $feature): ?string
    {
        return $this->features->firstWhere('feature', $feature)?->value;
    }

    public function getPriceAttribute()
    {
        if ($this->cost === null) {
            return null;
        }

        $value = (float) $this->cost;

        // Define thresholds and their suffixes
        $thresholds = [
            1_000_000_000 => 'B',
            1_000_000 => 'M',
            1_000 => 'K',
        ];

        foreach ($thresholds as $threshold => $suffix) {
            if (abs($value) >= $threshold) {
                $divided = $value / $threshold;

                // Round to 1 decimal place and remove trailing zeros
                $formatted = rtrim(rtrim(number_format($divided, 1), '0'), '.');

                return $formatted.$suffix;
            }
        }

        // For numbers less than 1000, return as is
        return (string) $value;
    }
}
