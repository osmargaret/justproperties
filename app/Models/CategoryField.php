<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'key',
    'label',
    'data_type',
    'is_required',
    'options',
    'default_value',
    'validation',
])]
class CategoryField extends Model
{
    protected $table = 'category_fields';

    public const TYPE_SINGLE_SELECT = 'single_select';
    public const TYPE_MULTI_SELECT = 'multi_select';
    public const TYPE_ENUM = 'single_select';
    public const TYPE_MULTI_ENUM = 'multi_select';
    public const TYPE_NUMBER = 'number';
    public const TYPE_TEXT = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_DATE = 'date';

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'options' => 'array',
            'validation' => 'array',
        ];
    }
}
