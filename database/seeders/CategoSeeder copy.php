<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategorySetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoSeeder extends Seeder
{
    /** @var list<string> */
    private array $multiEnumKeys = [
        'features',
        'estate_facilities',
        'house_rules_highlights',
        'suitable_for',
    ];

    /**
     * Fixed catalogue categories (property + blog). Field definitions live in `category_settings`.
     */
    public function run(): void
    {
        // --- Property categories (is_property = true) ---
        $catalogue = [
            $this->landedProperties(),
            $this->uncompletedProperties(),
            $this->completedProperties(),
            $this->rentLease(),
            $this->shortLet(),
            $this->facilities(),
        ];

        foreach ($catalogue as $row) {
            $requirements = $row['requirements'];
            $category = Category::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name'        => $row['name'],
                    'requirements' => null,
                    'is_property' => true,
                ]
            );
            $this->syncCategorySettings($category, $requirements);
        }

        // --- Blog-only categories (is_property = false) ---
        $blogCategories = [
            ['name' => 'Mortgage & Financing Guide', 'slug' => 'mortgage-financing-guide'],
            ['name' => 'Tax & Insurance Advice',     'slug' => 'tax-insurance-advice'],
            ['name' => 'Property Management Tips',   'slug' => 'property-management-tips'],
            ['name' => 'Investment Guide',            'slug' => 'investment-guide'],
            ['name' => 'Legal Tips',                  'slug' => 'legal-tips'],
        ];

        foreach ($blogCategories as $row) {
            Category::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name'        => $row['name'],
                    'requirements' => null,
                    'is_property' => false,
                ]
            );
        }
    }

    private function syncCategorySettings(Category $category, array $requirements): void
    {
        $category->settings()->delete();

        $sort = 0;
        foreach ($requirements as $key => $value) {
            $sort += 10;
            [$dataType, $isRequired, $options, $defaultValue] = $this->mapRequirementValue($key, $value);

            CategorySetting::query()->create([
                'category_id' => $category->id,
                'key' => $key,
                'label' => Str::headline(str_replace('_', ' ', $key)),
                'data_type' => $dataType,
                'is_required' => $isRequired,
                'options' => $options,
                'default_value' => $defaultValue,
                'validation' => null,
                'sort_order' => $sort,
            ]);
        }
    }

    /**
     * @return array{0: string, 1: bool, 2: ?array, 3: mixed}
     */
    private function mapRequirementValue(string $key, mixed $value): array
    {
        if (is_array($value)) {
            $dataType = in_array($key, $this->multiEnumKeys, true) ? 'multi_enum' : 'enum';
            $isRequired = $key === 'type' || $key === 'area_unit';

            return [$dataType, $isRequired, $value, null];
        }

        if ($value === 'required') {
            return [$this->scalarDataTypeForKey($key), true, null, null];
        }

        if ($value === 'optional' || $value === 'input') {
            return [$this->scalarDataTypeForKey($key), false, null, null];
        }

        return ['text', false, null, null];
    }

    private function scalarDataTypeForKey(string $key): string
    {
        if (str_ends_with($key, '_date')) {
            return 'date';
        }

        if (str_contains($key, '_time') || str_contains($key, 'check_in') || str_contains($key, 'check_out')) {
            return 'text';
        }

        if (preg_match('/(_km|_minutes|_year|_nights|_guests|_infants|fee|deposit|charge|months|days|percentage|complete)/i', $key)) {
            return 'number';
        }

        if (in_array($key, ['area', 'bedrooms', 'bathrooms', 'kitchens'], true)) {
            return 'number';
        }

        return 'text';
    }

    private function landedProperties(): array
    {
        return [
            'slug' => 'landed-properties',
            'name' => 'Landed Properties',
            'requirements' => [
                'type' => [
                    'Bare land / plot',
                    'Foundation stage',
                    'DPC / Block work',
                    'Lintel level',
                    'Roofing stage',
                    'Semi-finished shell',
                    'Fully fenced plot',
                    'Corner plot',
                    'Serviced plot',
                ],
                'area' => 'required',
                'area_unit' => ['square_meters', 'square_feet', 'acres', 'hectares', 'plots'],
                'bedrooms' => 'optional',
                'bathrooms' => 'optional',
                'kitchens' => 'optional',
                'features' => [
                    'Perimeter fencing',
                    'Gate house',
                    'Borehole on site',
                    '3-phase electricity nearby',
                    'Drainage channel',
                    'Road frontage',
                    'Survey beacon visible',
                    'Corner piece',
                    'Gazetted area',
                    'Excision in process',
                    'Dry land',
                    'Waterlogged (disclosed)',
                    'Topography surveyed',
                ],
                'title_document' => [
                    'Certificate of Occupancy (C of O)',
                    'Governor\'s Consent',
                    'Excision',
                    'Registered survey plan',
                    'Deed of assignment',
                    'Family receipt / customary',
                    'Global acquisition file',
                    'Relevant court judgement (registered)',
                ],
                'zoning_use' => ['Residential', 'Mixed-use', 'Commercial', 'Industrial', 'Agricultural', 'Not specified'],
                'road_access' => ['Paved / tarred', 'Motorable earth road', 'Footpath only', 'Planned estate road'],
                'topography' => ['Flat', 'Gently sloping', 'Steep', 'Valley / flood-prone (disclosed)'],
                'plot_shape' => ['Regular', 'Irregular', 'Corner', 'Double frontage'],
                'encumbrance_disclosure' => ['None known', 'Easement disclosed', 'Mortgage disclosed', 'Litigation disclosed'],
                'nearest_landmark' => 'input',
                'distance_to_main_road_km' => 'input',
                'soil_test_available' => ['Yes', 'No', 'Available on request'],
                'survey_plan_available' => ['Yes', 'No', 'In progress'],
                'asking_price_negotiable' => ['Firm', 'Slightly negotiable', 'Open to offers'],
            ],
        ];
    }

    private function uncompletedProperties(): array
    {
        return [
            'slug' => 'uncompleted-properties',
            'name' => 'Uncompleted Properties',
            'requirements' => [
                'type' => [
                    'Detached duplex (shell)',
                    'Semi-detached (shell)',
                    'Terrace unit (shell)',
                    'Bungalow (shell)',
                    'Block of flats (shell)',
                    'High-rise shell (floor plate)',
                    'Mansion (shell)',
                    'Shop / commercial shell',
                ],
                'area' => 'required',
                'area_unit' => ['square_meters', 'square_feet', 'plots'],
                'bedrooms' => 'required',
                'bathrooms' => 'required',
                'kitchens' => 'required',
                'features' => [
                    'POP ceiling (partial)',
                    'Aluminium window frames fixed',
                    'External plastering done',
                    'Internal plastering done',
                    'Roofing sheets installed',
                    'Borehole',
                    'Septic tank',
                    'Interlocked compound',
                    'Security post shell',
                    'Balcony',
                    'Walk-in closet shell',
                    'Staircase cast',
                    'Elevator shaft (shell)',
                    'Solar pre-wiring',
                ],
                'construction_stage' => [
                    'Substructure complete',
                    'Block work to lintel',
                    'Roofing in progress',
                    'First fix (MEP rough-in)',
                    'Second fix (finishes)',
                    'External works only remaining',
                ],
                'estimated_completion_date' => 'input',
                'percentage_complete_estimate' => 'input',
                'architectural_drawings_available' => ['As-built PDF', 'Provisional', 'Not available'],
                'structural_engineer_certificate' => ['Available', 'Not yet', 'N/A'],
                'developer_track_record' => ['Major developer', 'Mid-size developer', 'Private owner-builder'],
                'warranty_on_structure' => ['Yes', 'No', 'Negotiable'],
                'materials_spec_grade' => ['Economy', 'Standard', 'Premium', 'Luxury'],
                'site_inspection_slots' => ['Weekdays', 'Weekends', 'By appointment only'],
                'hoa_estate_name' => 'input',
                'hoa_established' => ['Yes', 'No', 'Planned'],
            ],
        ];
    }

    private function completedProperties(): array
    {
        return [
            'slug' => 'completed-properties',
            'name' => 'Completed Properties',
            'requirements' => [
                'type' => [
                    'Detached duplex',
                    'Semi-detached duplex',
                    'Terrace duplex',
                    'Bungalow',
                    'Penthouse',
                    'Apartment / flat',
                    'Mansion',
                    'Boys quarters (attached)',
                    'Smart home',
                ],
                'area' => 'required',
                'area_unit' => ['square_meters', 'square_feet'],
                'bedrooms' => 'required',
                'bathrooms' => 'required',
                'kitchens' => 'required',
                'features' => [
                    'Wi-Fi ready',
                    'Swimming pool',
                    'Boys quarters',
                    'Fully furnished',
                    'Semi-furnished',
                    'Unfurnished',
                    '24/7 security',
                    '24/7 electricity (estate PHCN + backup)',
                    'Inverter + batteries',
                    'Dedicated generator',
                    'CCTV',
                    'Video doorbell',
                    'Parking space (covered)',
                    'Parking space (open)',
                    'Fenced',
                    'Gated compound',
                    'C of O',
                    'Governor\'s consent',
                    'Smart locks',
                    'Walk-in closet',
                    'Home office nook',
                    'Rooftop terrace',
                    'Green area / garden',
                    'Water treatment',
                    'Central DSTV dish',
                ],
                'furnishing_level' => ['Unfurnished', 'Semi-furnished', 'Fully furnished', 'Serviced apartment style'],
                'building_age_bracket' => ['New (0–1 yr)', '1–5 years', '5–10 years', '10+ years', 'Renovated recently'],
                'floor_level' => ['Ground', '1st', '2nd', '3rd+', 'Penthouse', 'Multi-storey own full block'],
                'service_charge_frequency' => ['Monthly', 'Quarterly', 'Annually', 'None stated'],
                'service_charge_amount_band' => ['None', 'Low', 'Medium', 'High', 'Exact figure in listing'],
                'estate_facilities' => ['Club house', 'Gym', 'Children play area', 'Jogging track', 'Street lights', 'Waste management'],
                'nearest_school_hospital_minutes' => 'input',
                'move_in_ready_date' => 'input',
                'defects_disclosure' => ['None', 'Minor cosmetic', 'Major (disclosed in report)'],
                'last_renovation_year' => 'input',
            ],
        ];
    }

    private function rentLease(): array
    {
        return [
            'slug' => 'rent-lease',
            'name' => 'Rent / Lease',
            'requirements' => [
                'type' => [
                    'Duplex',
                    'Bungalow',
                    'Mansion',
                    'Terrace',
                    'Semi-detached',
                    'Apartment / flat',
                    'Studio apartment',
                    'Shop / retail space',
                    'Office space',
                    'Warehouse',
                    'Short office suite',
                ],
                'area' => 'required',
                'area_unit' => ['square_meters', 'square_feet'],
                'bedrooms' => 'required',
                'bathrooms' => 'required',
                'kitchens' => 'required',
                'features' => [
                    'Wi-Fi included',
                    'Swimming pool (estate)',
                    'Boys quarters',
                    'Furnished',
                    'Semi-furnished',
                    'Unfurnished',
                    '24/7 security',
                    '24/7 electricity (prepaid)',
                    'Dedicated parking',
                    'Visitor parking',
                    'Water treatment',
                    'DSTV / streaming ready',
                    'Washing machine',
                    'Air conditioning (split units)',
                    'Balcony',
                    'Elevator in block',
                    'Pet-friendly (with deposit)',
                    'Serviced (cleaning + linen)',
                ],
                'tenure_type' => ['Annual lease', 'Two-year lease', 'Monthly (corporate)', 'Short-term rolling'],
                'rent_amount_frequency' => ['Per annum', 'Per month', 'Per quarter'],
                'lease_duration_months' => 'input',
                'renewal_clause' => ['Automatic renewal', 'Fresh negotiation', 'Fixed term only'],
                'agency_legal_fees_policy' => ['Standard 10% agency + legal', 'Negotiable', 'Owner pays agency', 'All-inclusive rent'],
                'caution_deposit_months' => 'input',
                'service_charge_included_in_rent' => ['Yes', 'No', 'Partially'],
                'utilities_deposit' => 'input',
                'inventory_list_included' => ['Yes', 'No', 'Optional add-on'],
                'subletting_allowed' => ['No', 'With landlord consent', 'Corporate only'],
                'notice_period_days' => 'input',
                'rent_review_clause' => ['Fixed for lease term', 'Annual CPI-linked', 'Negotiable'],
                'landlord_reference_required' => ['Yes', 'No', 'For corporate only'],
            ],
        ];
    }

    private function shortLet(): array
    {
        return [
            'slug' => 'short-let',
            'name' => 'Short-Let',
            'requirements' => [
                'type' => [
                    'Studio short-let',
                    '1-bedroom apartment',
                    '2-bedroom apartment',
                    '3-bedroom apartment',
                    '4+ bedroom duplex short-let',
                    'Penthouse short-let',
                    'Luxe villa',
                    'Corporate apartment',
                ],
                'area' => 'required',
                'area_unit' => ['square_meters', 'square_feet'],
                'bedrooms' => 'required',
                'bathrooms' => 'required',
                'kitchens' => 'required',
                'features' => [
                    'Wi-Fi',
                    'Swimming pool',
                    'Boys quarters',
                    'Fully furnished',
                    '24/7 security',
                    '24/7 electricity',
                    'Dedicated parking',
                    'Netflix / smart TV',
                    'Washing machine',
                    'Housekeeping (daily)',
                    'Housekeeping (on request)',
                    'Air conditioning',
                    'Backup inverter',
                    'DSTV / streaming subscriptions',
                    'Workspace / desk',
                    'Family-friendly',
                    'Events not allowed',
                    'Small events allowed (surcharge)',
                ],
                'minimum_stay_nights' => 'input',
                'maximum_guests' => 'input',
                'maximum_infants' => 'input',
                'check_in_time' => 'input',
                'check_out_time' => 'input',
                'flexible_check_in' => ['Strict', '±2 hours flex', 'Self check-in (lockbox / smart lock)'],
                'cleaning_fee_per_stay' => 'input',
                'extra_guest_fee_per_night' => 'input',
                'cancellation_policy' => ['Flexible', 'Moderate', 'Strict', 'Non-refundable discount tier'],
                'instant_book' => ['Enabled', 'Request to book'],
                'suitable_for' => ['Business travellers', 'Families', 'Tourists', 'Remote workers', 'Small team offsites'],
                'house_rules_highlights' => ['No smoking', 'No parties', 'No pets', 'Quiet hours 10pm–7am'],
                'linen_towels_provided' => ['Yes', 'Yes (premium)', 'Bring your own'],
                'kitchen_equipment_tier' => ['Basic', 'Full', 'Chef-ready'],
                'occupancy_tax_or_vat_note' => 'input',
            ],
        ];
    }

    private function facilities(): array
    {
        return [
            'slug' => 'facilities',
            'name' => 'Facilities',
            'requirements' => [
                'type' => [
                    'Factory / Warehouse',
                    'Industrial Space',
                    'Hotel / Guest House',
                    'Hospital / Clinic',
                    'School / Educational',
                    'Church / Religious',
                    'Event Centre / Hall',
                    'Shopping Complex',
                    'Filling Station',
                    'Cold Room / Storage',
                    'Office Complex',
                    'Other',
                ],
                'area'          => 'input',
                'area_unit'     => ['sqm', 'sqft', 'hectare', 'acre'],
                'floors'        => 'input',
                'capacity'      => 'input',
                'water_supply'  => ['Borehole', 'Municipal', 'Water truck', 'Well'],
                'power_supply'  => ['NEPA/PHCN only', 'Generator', 'Solar', 'Generator + Solar'],
                'security'      => ['Fenced', 'Fenced + Guard', 'CCTV', 'CCTV + Guard'],
                'parking_spaces' => 'input',
                'condition'     => ['New', 'Good', 'Fair', 'Needs renovation'],
                'available_for' => ['Sale', 'Lease', 'Lease + Purchase option'],
                'year_built'    => 'input',
            ],
        ];
    }
}
