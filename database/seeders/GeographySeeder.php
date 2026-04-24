<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\CountryCurrency;
use App\Models\Currency;
use App\Models\Price;
use App\Models\State;
use Illuminate\Database\Seeder;

class GeographySeeder extends Seeder
{
    /**
     * countries → currencies → states → cities → country_currencies → prices (currency only, morph nullable).
     */
    public function run(): void
    {
        $nigeria = Country::query()->updateOrCreate(
            ['code' => 'NG'],
            [
                'name' => 'Nigeria',
                'slug' => 'nigeria',
                'flag' => '🇳🇬',
                'phone_code' => '+234',
                'language_code' => 'en',
                'is_active' => true,
            ]
        );

        $usa = Country::query()->updateOrCreate(
            ['code' => 'US'],
            [
                'name' => 'United States',
                'slug' => 'united-states',
                'flag' => '🇺🇸',
                'phone_code' => '+1',
                'language_code' => 'en',
                'is_active' => true,
            ]
        );

        foreach (
            [
                ['code' => 'GH', 'name' => 'Ghana', 'slug' => 'ghana', 'flag' => '🇬🇭', 'phone_code' => '+233'],
                ['code' => 'KE', 'name' => 'Kenya', 'slug' => 'kenya', 'flag' => '🇰🇪', 'phone_code' => '+254'],
                ['code' => 'ZA', 'name' => 'South Africa', 'slug' => 'south-africa', 'flag' => '🇿🇦', 'phone_code' => '+27'],
            ] as $row
        ) {
            Country::query()->updateOrCreate(
                ['code' => $row['code']],
                [
                    'name' => $row['name'],
                    'slug' => $row['slug'],
                    'flag' => $row['flag'],
                    'phone_code' => $row['phone_code'],
                    'language_code' => 'en',
                    'is_active' => true,
                ]
            );
        }

        $ngn = Currency::query()->updateOrCreate(
            ['code' => 'NGN'],
            [
                'name' => 'Nigerian Naira',
                'slug' => 'ngn',
                'symbol' => '₦',
                'symbol_position' => 'before',
                'thousands_separator' => ',',
                'decimal_separator' => '.',
                'decimal_multiplier' => '100',
                'is_default' => true,
                'is_active' => true,
            ]
        );

        Currency::query()->where('id', '!=', $ngn->id)->update(['is_default' => false]);

        $usd = Currency::query()->updateOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'US Dollar',
                'slug' => 'usd',
                'symbol' => '$',
                'symbol_position' => 'before',
                'thousands_separator' => ',',
                'decimal_separator' => '.',
                'decimal_multiplier' => '100',
                'is_default' => false,
                'is_active' => true,
            ]
        );

        $lagosState = State::query()->updateOrCreate(
            ['country_id' => $nigeria->id, 'slug' => 'lagos'],
            [
                'name' => 'Lagos',
                'code' => 'LA',
                'is_active' => true,
            ]
        );

        State::query()->updateOrCreate(
            ['country_id' => $usa->id, 'slug' => 'california'],
            [
                'name' => 'California',
                'code' => 'CA',
                'is_active' => true,
            ]
        );

        $ikeja = City::query()->updateOrCreate(
            ['state_id' => $lagosState->id, 'slug' => 'ikeja'],
            [
                'name' => 'Ikeja',
                'code' => 'IKE',
                'country_id' => $nigeria->id,
                'is_active' => true,
            ]
        );

        City::query()->updateOrCreate(
            ['state_id' => $lagosState->id, 'slug' => 'lekki'],
            [
                'name' => 'Lekki',
                'code' => 'LEK',
                'country_id' => $nigeria->id,
                'is_active' => true,
            ]
        );

        foreach ([[$nigeria->id, $ngn->id], [$nigeria->id, $usd->id], [$usa->id, $usd->id]] as [$countryId, $currencyId]) {
            CountryCurrency::query()->firstOrCreate(
                ['country_id' => $countryId, 'currency_id' => $currencyId],
                []
            );
        }

        Price::query()->firstOrCreate(
            [
                'currency_id' => $ngn->id,
                'priceable_id' => null,
                'priceable_type' => null,
            ],
            ['amount' => 5000000.00]
        );
    }
}
