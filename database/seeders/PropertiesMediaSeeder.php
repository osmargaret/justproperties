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
use Illuminate\Support\Str;

class PropertiesMediaSeeder extends Seeder
{
    /**
     * properties → property_features → media (user + morph to property).
     */
    public function run(): void
    {
        $seller = User::query()->where('email', 'seller@example.com')->firstOrFail();
        $admin = User::query()->where('email', 'admin@example.com')->first();
        $landed = Category::query()->where('slug', 'landed-properties')->firstOrFail();
        $completed = Category::query()->where('slug', 'completed-properties')->firstOrFail();
        $country = Country::query()->where('code', 'NG')->firstOrFail();
        $state = State::query()->where('slug', 'lagos')->where('country_id', $country->id)->firstOrFail();
        $city = City::query()->where('slug', 'ikeja')->where('state_id', $state->id)->firstOrFail();

        $props = [
            [
                'name' => '5 Bedroom Duplex — Lekki Phase 1',
                'slug' => Str::slug('5 Bedroom Duplex — Lekki Phase 1'),
                'description' => 'Spacious duplex with BQ, fitted kitchen, and ample parking. Close to major roads.',
                'cost' => 85000000,
                'category_id' => $completed->id,
                'location' => 'Lekki Phase 1, Lagos',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'neighborhood' => 'Lekki',
                'address' => '12 Admiralty Way',
                'show_address' => true,
                'is_published' => true,
                'contact_name' => $seller->name,
                'contact_phone' => $seller->phone,
                'contact_email' => $seller->email,
                'contact_whatsapp' => $seller->phone,
            ],
            [
                'name' => 'Uncompleted 4 Bedroom Terrace — Ajah',
                'slug' => Str::slug('Uncompleted 4 Bedroom Terrace — Ajah'),
                'description' => 'Shell terrace at roofing stage. Corner unit with extra land.',
                'cost' => 45000000,
                'category_id' => $landed->id,
                'location' => 'Ajah, Lagos',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'neighborhood' => 'Ajah',
                'address' => 'Plot 44 Greenfield Estate',
                'show_address' => true,
                'is_published' => false,
                'contact_name' => $seller->name,
                'contact_phone' => $seller->phone,
                'contact_email' => $seller->email,
                'contact_whatsapp' => $seller->phone,
            ],
            [
                'name' => '3 Bedroom Apartment — Ikeja GRA',
                'slug' => Str::slug('3 Bedroom Apartment — Ikeja GRA'),
                'description' => 'Completed apartment in a gated community with 24/7 security.',
                'cost' => 1200000,
                'category_id' => $completed->id,
                'location' => 'Ikeja GRA',
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'neighborhood' => 'Ikeja',
                'address' => '8 Joel Ogunnaike Street',
                'show_address' => false,
                'is_published' => false,
                'contact_name' => $seller->name,
                'contact_phone' => $seller->phone,
                'contact_email' => $seller->email,
                'contact_whatsapp' => $seller->phone,
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
                'name' => $p0->name,
            ],
            [
                'path' => 'properties/seed/hero-facade.jpg',
                'type' => 'image',
                'mime_type' => 'image/jpeg',
                'size' => '245000',
                'extension' => 'jpg',
                'is_primary' => true,
            ]
        );
    }
}