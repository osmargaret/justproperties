<?php

namespace App\Exports;

use App\Models\CategorySetting;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class PropertyBulkTemplateExport implements FromArray, WithHeadings, WithMultipleSheets, WithTitle
{
    use Exportable;

    public function headings(): array
    {
        return [
            'title',
            'description',
            'category_slug',
            'cost',
            'state_name',
            'city',
            'address',
            'neighborhood',
            'show_address',
            'contact_name',
            'contact_phone',
            'contact_email',
            'contact_whatsapp',
            ...$this->dynamicAttributeHeadings(),
        ];
    }

    public function array(): array
    {
        return [[
            'Luxury 4 Bedroom Duplex',
            'Well-finished home with ample parking and good road access.',
            'landed-properties',
            85000000,
            'Lagos',
            'Ikeja',
            '10 Sample Street',
            'Alausa',
            'true',
            'Sample Seller',
            '+2348000000000',
            'seller@example.com',
            '+2348000000000',
            ...array_fill(0, count($this->dynamicAttributeHeadings()), ''),
        ]];
    }

    public function sheets(): array
    {
        return [
            $this,
            new PropertyBulkTemplateHelpSheet,
            new PropertyBulkTemplateOptionsSheet,
        ];
    }

    public function title(): string
    {
        return 'Listings';
    }

    private function dynamicAttributeHeadings(): array
    {
        $reserved = self::reservedBaseColumnKeys();

        return CategorySetting::query()
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->pluck('key')
            ->filter(fn (string $key) => ! in_array($key, $reserved, true))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    public static function reservedBaseColumnKeys(): array
    {
        return [
            'title',
            'description',
            'category_slug',
            'cost',
            'state_name',
            'state_code',
            'city',
            'address',
            'neighborhood',
            'show_address',
            'contact_name',
            'contact_phone',
            'contact_email',
            'contact_whatsapp',
        ];
    }
}
