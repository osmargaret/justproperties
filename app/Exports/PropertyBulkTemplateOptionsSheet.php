<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PropertyBulkTemplateOptionsSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $rows = [[
            'field_key',
            'label',
            'data_type',
            'allowed_values',
        ]];

        $fields = CategoryField::query()
            ->whereIn('data_type', [
                CategoryField::TYPE_SINGLE_SELECT,
                CategoryField::TYPE_MULTI_SELECT,
                CategoryField::TYPE_ENUM,
                CategoryField::TYPE_MULTI_ENUM,
            ])
            ->orderBy('key')
            ->get();

        foreach ($fields as $field) {
            $options = $field->options;
            $allowed = is_array($options) ? implode(' | ', $options) : '';

            $label = $field->label;
            if (Str::lower($field->label) === 'type' || str_ends_with($field->key, '-type')) {
                $categoryName = Category::query()
                    ->where('is_property', true)
                    ->whereHas('fields', fn ($q) => $q->where('category_fields.id', $field->id))
                    ->value('name');

                if ($categoryName) {
                    $label .= " (For {$categoryName})";
                }
            }

            $rows[] = [
                $field->key,
                $label,
                $field->data_type,
                $allowed,
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Field options';
    }
}
