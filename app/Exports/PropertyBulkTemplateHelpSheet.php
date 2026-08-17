<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PropertyBulkTemplateHelpSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $slugExamples = Category::query()
            ->where('is_property', true)
            ->orderBy('name', 'asc')
            ->pluck('slug')
            ->filter()
            ->implode(', ');

        $rows = [[
            'Field',
            'Description',
            'Example',
        ]];

        $rows[] = [
            'category_slug',
            'Must be one of the catalogue slugs: '.$slugExamples,
            'landed-properties',
        ];
        $rows[] = [
            'cost',
            'Listing price in your local currency (same currency as your account country).',
            '85000000',
        ];
        $rows[] = ['show_address', 'Whether the street address is shown publicly.', 'true'];
        $rows[] = ['', '', ''];
        $rows[] = [
            'Dynamic category columns',
            'Add one column per category field key (e.g. bedrooms). Only fill columns that apply to that row\'s category_slug. See the "Field options" sheet for enum/multi_enum choices.',
            'bedrooms = 4',
        ];

        $fields = CategoryField::query()
            ->orderBy('key')
            ->get();

        foreach ($fields as $field) {
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
                sprintf(
                    '%s | type: %s%s',
                    $label,
                    $field->data_type,
                    $field->is_required ? ' | required' : ''
                ),
                is_array($field->options) ? implode(', ', $field->options) : '',
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Help';
    }
}
