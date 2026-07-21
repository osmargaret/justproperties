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
use App\Observers\PropertyObserver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertiesSeeder extends Seeder
{
    public function run(): void
    {
        // Set observer seeding flag to true so that it creates approved moderation records
        PropertyObserver::$seeding = true;

        $sellers = User::query()->where('active_role', 'seller')->get();
        if ($sellers->isEmpty()) {
            $sellers = User::query()->get();
        }

        $categories = Category::query()->where('is_property', true)->get();
        $country = Country::query()->where('code', 'NG')->firstOrFail();
        $state = State::query()->where('slug', 'lagos')->firstOrFail();
        $cities = City::query()->where('state_id', $state->id)->get();

        $neighborhoods = ['Lekki Phase 1', 'Ikoyi', 'Victoria Island', 'Ikeja GRA', 'Ajah', 'Surulere', 'Yaba', 'Gbagada'];
        $propertyTypes = [
            'Luxury 4 Bedroom Terrace Duplex',
            'Modern 3 Bedroom Apartment',
            'Spacious 5 Bedroom Detached House',
            'Premium Serviced Flat',
            'Cozy 2 Bedroom Maisonette',
            'Stunning Penthouse Suite',
            'Standard 3 Bedroom Bungalow',
            'Commercial Office Complex Space',
            'Industrial Warehouse Facility',
            'Residential Serviced Plot of Land'
        ];

        for ($i = 1; $i <= 50; $i++) {
            $seller = $sellers->random();
            $category = $categories->random();
            $city = $cities->random();
            $neighborhood = $neighborhoods[array_rand($neighborhoods)];
            $type = $propertyTypes[array_rand($propertyTypes)];
            
            $name = $type . ' — ' . $neighborhood . ' (Unit ' . $i . ')';
            $slug = Str::slug($name);
            $cost = rand(5, 250) * 1000000; // between 5M and 250M

            $property = Property::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $seller->id,
                    'category_id' => $category->id,
                    'name' => $name,
                    'description' => 'This is a beautifully built ' . strtolower($type) . ' located in the serene neighborhood of ' . $neighborhood . '. It offers top-notch amenities, stable power supply, and maximum security for peaceful living.',
                    'cost' => $cost,
                    'location' => $neighborhood . ', Lagos',
                    'country_id' => $country->id,
                    'state_id' => $state->id,
                    'city_id' => $city->id,
                    'neighborhood' => $neighborhood,
                    'address' => 'Plot ' . rand(1, 100) . ' Road ' . rand(1, 10) . ', ' . $neighborhood,
                    'show_address' => rand(0, 1) === 1,
                    'is_published' => true,
                    'contact_name' => $seller->name,
                    'contact_phone' => $seller->phone,
                    'contact_email' => $seller->email,
                    'contact_whatsapp' => $seller->phone,
                ]
            );

            // Add some features
            PropertyFeature::query()->firstOrCreate(
                ['property_id' => $property->id, 'feature' => 'bedrooms'],
                ['value' => (string)rand(1, 6), 'unit' => null]
            );
            PropertyFeature::query()->firstOrCreate(
                ['property_id' => $property->id, 'feature' => 'bathrooms'],
                ['value' => (string)rand(1, 7), 'unit' => null]
            );

            // Add dummy media record
            Media::query()->firstOrCreate(
                [
                    'user_id' => $seller->id,
                    'mediable_id' => $property->id,
                    'mediable_type' => Property::class,
                    'name' => $property->name,
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

        // Reset observer seeding flag
        PropertyObserver::$seeding = false;
    }
}
