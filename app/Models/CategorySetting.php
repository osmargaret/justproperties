<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'category_id',
    'key',
    'label',
    'data_type',
    'is_required',
    'options',
    'default_value',
    'validation',
    'sort_order',
])]
class CategorySetting extends Model
{
    public const TYPE_ENUM = 'enum';

    public const TYPE_MULTI_ENUM = 'multi_enum';

    public const TYPE_NUMBER = 'number';

    public const TYPE_TEXT = 'text';

    public const TYPE_TEXTAREA = 'textarea';

    public const TYPE_BOOLEAN = 'boolean';

    public const TYPE_DATE = 'date';

    protected $table = 'category_settings';

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'options' => 'array',
            'validation' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
