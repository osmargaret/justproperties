<?php

namespace App\Exports;

use App\Models\CategorySetting;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PropertyBulkTemplateOptionsSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $rows = [[
            'category_slug',
            'field_key',
            'label',
            'data_type',
            'allowed_values',
        ]];

        $settings = CategorySetting::query()
            ->with('category')
            ->whereIn('data_type', [CategorySetting::TYPE_ENUM, CategorySetting::TYPE_MULTI_ENUM])
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->get();

        foreach ($settings as $setting) {
            $options = $setting->options;
            $allowed = is_array($options) ? implode(' | ', $options) : '';

            $rows[] = [
                $setting->category?->slug ?? '',
                $setting->key,
                $setting->label,
                $setting->data_type,
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
