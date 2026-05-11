<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'value',
    'data_type',
])]
class Setting extends Model
{
    public static function getValue(string $name, mixed $default = null): mixed
    {
        $row = static::query()->where('name', $name)->first();

        return $row ? static::castStoredValue($row->value, $row->data_type) : $default;
    }

    public static function setValue(string $name, mixed $value, ?string $dataType = null): void
    {
        $type = $dataType ?? match (true) {
            is_bool($value) => 'boolean',
            is_int($value) => 'integer',
            default => 'string',
        };

        static::query()->updateOrCreate(
            ['name' => $name],
            ['value' => is_bool($value) ? ($value ? '1' : '0') : (string) $value, 'data_type' => $type]
        );
    }

    protected static function castStoredValue(?string $raw, ?string $dataType): mixed
    {
        if ($raw === null) {
            return null;
        }

        return match ($dataType) {
            'boolean' => $raw === '1' || $raw === 'true',
            'integer' => (int) $raw,
            default => $raw,
        };
    }
}
