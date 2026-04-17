<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'type', 'permissions'])]
class Role extends Model
{
    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users')
            ->withTimestamps();
    }

    protected function permissionCount(): Attribute
    {
        return Attribute::make(
            get: fn () => count($this->permissions ?? [])
        );
    }
}
