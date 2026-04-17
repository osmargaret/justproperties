<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'can_sell', 'can_buy'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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
            'can_sell' => 'boolean',
            'can_buy' => 'boolean',
            'two_factor_confirmed_at' => 'datetime',
        ];
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

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users')
            ->withTimestamps();
    }

    public function blogSubscriptions(): HasMany
    {
        return $this->hasMany(NewsletterSubscription::class);
    }

    protected function permissions(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles
                ->pluck('permissions')
                ->flatten(1)
                ->filter()
                ->unique()
                ->values()
                ->all()
        );
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
}
