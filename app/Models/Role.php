<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'users_permission',
    'subscriptions_permission',
    'promotions_permission',
    'properties_permission',
    'posts_permission',
    'payments_permission',
    'coupons_permission',
    'settings_permission',
])]
class Role extends Model
{
    /**
     * The permission groups available on a role and the actions each supports.
     *
     * @var array<string, list<string>>
     */
    public const PERMISSION_GROUPS = [
        'users_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'subscriptions_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'promotions_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'properties_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'posts_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'payments_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'coupons_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
        'settings_permission' => ['browse', 'read', 'edit', 'add', 'delete'],
    ];

    protected function casts(): array
    {
        return [
            'users_permission' => 'array',
            'subscriptions_permission' => 'array',
            'promotions_permission' => 'array',
            'properties_permission' => 'array',
            'posts_permission' => 'array',
            'payments_permission' => 'array',
            'coupons_permission' => 'array',
            'settings_permission' => 'array',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected function permissionCount(): Attribute
    {
        return Attribute::make(
            get: function () {
                $count = 0;
                foreach (array_keys(self::PERMISSION_GROUPS) as $group) {
                    $count += is_array($this->{$group}) ? count($this->{$group}) : 0;
                }

                return $count;
            }
        );
    }
}
