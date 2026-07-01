<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['name', 'slug', 'type', 'features'])]
class PromotionPlan extends Model
{

    public const TARGET_KEYS = ['clicks', 'recipients', 'posts', 'emails'];

    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    /**
     * @return array{type: string, count: int}|null
     */
    public function primaryTarget(): ?array
    {
        $features = (array) ($this->features ?? []);

        foreach (self::TARGET_KEYS as $key) {
            $count = (int) ($features[$key] ?? 0);
            if ($count > 0) {
                return ['type' => $key, 'count' => $count];
            }
        }

        return null;
    }

    /**
     * @return array<int, array{type: string, count: int}>
     */
    public function targetsForDisplay(): array
    {
        $targets = [];
        $features = (array) ($this->features ?? []);

        foreach (self::TARGET_KEYS as $key) {
            $count = (int) ($features[$key] ?? 0);
            if ($count > 0) {
                $targets[] = ['type' => $key, 'count' => $count];
            }
        }

        return $targets;
    }
}
