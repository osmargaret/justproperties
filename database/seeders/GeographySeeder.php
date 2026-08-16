<?php

namespace Database\Seeders;


use App\Models\Country;
use App\Models\CountryCurrency;
use App\Models\Currency;
use App\Models\Price;
use App\Services\GeographyService;
use Illuminate\Database\Seeder;

class GeographySeeder extends Seeder
{
    /**
     * countries → currencies → states → cities → country_currencies → prices (currency only, morph nullable).
     */
    public function run(): void
    {
        // Create only Nigeria here. States and cities will be fetched via GeographyService.
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
                'payment_gateway' => 'paystack',
            ]
        );

        Currency::query()->where('id', '!=', $ngn->id)->update(['is_default' => false]);

        // Link Nigeria to NGN
        CountryCurrency::query()->firstOrCreate([
            'country_id' => $nigeria->id,
            'currency_id' => $ngn->id,
        ], []);

        Price::query()->firstOrCreate(
            [
                'currency_id' => $ngn->id,
                'priceable_id' => null,
                'priceable_type' => null,
            ],
            ['amount' => 5000000.00]
        );

        // Fetch states and cities for Nigeria using GeographyService (uses updateOrCreate internally)
        try {
            app(GeographyService::class)->fetchAndSave($nigeria);
        } catch (\Throwable $e) {
            // Swallow errors in seeder but log if available
            if (function_exists('logger')) {
                logger()->warning('GeographySeeder: failed to fetch states/cities for Nigeria: '.$e->getMessage());
            }
        }
    }
}
