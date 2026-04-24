<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Media;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertiesMediaSeeder extends Seeder
{
    /**
     * properties → property_features → media (user + morph to property).
     */
    public function run(): void
    {
        $seller = User::query()->where('email', 'seller@example.com')->firstOrFail();
        $landed = Category::query()->where('slug', 'landed-properties')->firstOrFail();
        $completed = Category::query()->where('slug', 'completed-properties')->firstOrFail();
        $country = Country::query()->where('code', 'NG')->firstOrFail();
        $state = State::query()->where('slug', 'lagos')->where('country_id', $country->id)->firstOrFail();
        $city = City::query()->where('slug', 'ikeja')->where('state_id', $state->id)->firstOrFail();

        $props = [
            [
                'name' => '5 Bedroom Duplex — Lekki Phase 1',
                'description' => 'Spacious duplex with BQ, fitted kitchen, and ample parking. Close to major roads.',
                'category_id' => $completed->id,
                'type' => 'Detached Duplex',
                'location' => 'Lekki Phase 1, Lagos',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'town' => 'Lekki',
                'address' => '12 Admiralty Way',
                'inspection_fee' => 15000,
            ],
            [
                'name' => 'Uncompleted 4 Bedroom Terrace — Ajah',
                'description' => 'Shell terrace at roofing stage. Corner unit with extra land.',
                'category_id' => $landed->id,
                'type' => 'Roofing Level',
                'location' => 'Ajah, Lagos',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'town' => 'Ajah',
                'address' => 'Plot 44 Greenfield Estate',
                'inspection_fee' => 10000,
            ],
            [
                'name' => '3 Bedroom Apartment — Ikeja GRA',
                'description' => 'Completed apartment in a gated community with 24/7 security.',
                'category_id' => $completed->id,
                'type' => 'Apartment',
                'location' => 'Ikeja GRA',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'town' => 'Ikeja',
                'address' => '8 Joel Ogunnaike Street',
                'inspection_fee' => 8000,
            ],
        ];

        $created = [];
        foreach ($props as $row) {
            $created[] = Property::query()->updateOrCreate(
                ['user_id' => $seller->id, 'name' => $row['name']],
                array_merge($row, ['user_id' => $seller->id])
            );
        }

        $p0 = $created[0];
        PropertyFeature::query()->firstOrCreate(
            ['property_id' => $p0->id, 'feature' => 'parking_space'],
            ['value' => '4', 'unit' => null]
        );
        PropertyFeature::query()->firstOrCreate(
            ['property_id' => $p0->id, 'feature' => 'swimming pool'],
            ['value' => '1', 'unit' => null]
        );

        Media::query()->firstOrCreate(
            [
                'user_id' => $seller->id,
                'mediable_id' => $p0->id,
                'mediable_type' => Property::class,
                'name' => 'hero-facade.jpg',
            ],
            [
                'type' => 'image',
                'mime_type' => 'image/jpeg',
                'size' => '245000',
                'extension' => 'jpg',
                'is_primary' => true,
            ]
        );
    }
}
