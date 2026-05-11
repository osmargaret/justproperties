<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'property_id',
    'views_count',
    'clicked_action_count',
    'click_count',
    'target_type',
    'target_count',
    'start_at',
    'status',
])]
class FeaturedProperty extends Model
{
    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'clicked_action_count' => 'integer',
            'click_count' => 'integer',
            'target_count' => 'integer',
            'start_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
