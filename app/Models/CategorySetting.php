<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'category_id',
    'category_field_id',
    'sort_order',
])]
class CategorySetting extends Model
{
    protected $table = 'category_settings';

    // Type constants forwarded from CategoryField for backward compatibility
    public const TYPE_SINGLE_SELECT = CategoryField::TYPE_SINGLE_SELECT;
    public const TYPE_MULTI_SELECT = CategoryField::TYPE_MULTI_SELECT;
    public const TYPE_ENUM = CategoryField::TYPE_SINGLE_SELECT;
    public const TYPE_MULTI_ENUM = CategoryField::TYPE_MULTI_SELECT;
    public const TYPE_NUMBER = CategoryField::TYPE_NUMBER;
    public const TYPE_TEXT = CategoryField::TYPE_TEXT;
    public const TYPE_TEXTAREA = CategoryField::TYPE_TEXTAREA;
    public const TYPE_BOOLEAN = CategoryField::TYPE_BOOLEAN;
    public const TYPE_DATE = CategoryField::TYPE_DATE;

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(CategoryField::class, 'category_field_id');
    }

    public function getKeyAttribute(): ?string
    {
        return $this->field?->key;
    }

    public function getLabelAttribute(): ?string
    {
        return $this->field?->label;
    }

    public function getDataTypeAttribute(): ?string
    {
        return $this->field?->data_type;
    }

    public function getIsRequiredAttribute(): bool
    {
        return (bool) ($this->field?->is_required ?? false);
    }

    public function getOptionsAttribute(): ?array
    {
        return $this->field?->options;
    }
}
