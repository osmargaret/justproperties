<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'phone', 'active_role', 'country_id', 'role_id', 'suspended_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmailContract
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'suspended_at' => 'datetime',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function propertyReviews(): HasMany
    {
        return $this->hasMany(PropertyReview::class);
    }

    public function propertyAlerts(): HasMany
    {
        return $this->hasMany(PropertyAlert::class);
    }

    public function savedProperties(): HasMany
    {
        return $this->hasMany(SavedProperty::class);
    }

    public function viewedProperties(): HasMany
    {
        return $this->hasMany(ViewedProperty::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function blogSubscriptions(): HasMany
    {
        return $this->hasMany(NewsletterSubscription::class);
    }

    protected function permissions(): Attribute
    {
        return Attribute::make(
            get: function () {
                $permissions = $this->role?->permissions ?? [];

                return collect(is_array($permissions) ? $permissions : [])
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();
            }
        );
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(get: function (): bool {
            return $this->role?->type === 'admin';
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    protected function position(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->is_admin) {
                    $role = $this->active_role;
                    if ($role === null || $role === '' || $role === 'admin') {
                        return 'Admin';
                    }

                    return $role === 'seller' ? 'Seller' : 'Buyer';
                }
                if ($this->active_role === null || $this->active_role === '') {
                    return 'Member';
                }

                return $this->active_role === 'seller' ? 'Seller' : 'Buyer';
            }
        );
    }

    protected function dashboardUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->active_role === 'admin') {
                    return route('admin.dashboard', absolute: false);
                }
                if ($this->active_role === 'buyer') {
                    return route('buyer.dashboard', absolute: false);
                }
                if ($this->active_role === 'seller') {
                    return route('seller.dashboard', absolute: false);
                }
                if ($this->is_admin) {
                    return route('admin.dashboard', absolute: false);
                }

                return route('home', absolute: false);
            }
        );
    }
}
