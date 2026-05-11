<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\CategorySetting;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PropertyBulkTemplateHelpSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $slugExamples = Category::query()
            ->orderBy('name')
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
            'Add one column per category_settings key (e.g. bedrooms). Only fill columns that apply to that row\'s category_slug. See the "Field options" sheet for enum/multi_enum choices.',
            'bedrooms = 4',
        ];

        $settings = CategorySetting::query()
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->get();

        foreach ($settings as $setting) {
            $rows[] = [
                $setting->key,
                sprintf(
                    '%s | category: %s | type: %s%s',
                    $setting->label,
                    $setting->category?->slug ?? 'unknown',
                    $setting->data_type,
                    $setting->is_required ? ' | required' : ''
                ),
                in_array($setting->data_type, [CategorySetting::TYPE_ENUM, CategorySetting::TYPE_MULTI_ENUM], true) && is_array($setting->options)
                    ? 'See Field options sheet'
                    : (is_array($setting->options) ? implode(', ', $setting->options) : ''),
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Help';
    }
}
