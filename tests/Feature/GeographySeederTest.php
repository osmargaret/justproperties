<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Currency;
use Database\Seeders\GeographySeeder;
use Database\Seeders\PlansCouponsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeographySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_upserts_countries_from_the_local_json_file(): void
    {
        $countries = json_decode(file_get_contents(base_path('countries.json')), true, 512, JSON_THROW_ON_ERROR);
        $nigerianStates = json_decode(file_get_contents(base_path('nigeria-states.json')), true, 512, JSON_THROW_ON_ERROR);
        $nigeria = Country::query()->create([
            'name' => 'Old country name',
            'code' => 'NG',
        ]);
        Currency::query()->create([
            'currency_code' => 'NGN',
            'currency_name' => 'Existing Nigerian naira',
            'currency_symbol' => '₦',
            'payment_gateway' => 'flutterwave',
        ]);

        app(GeographySeeder::class)->run();

        $this->assertSame(count($countries), Country::query()->count());
        $this->assertDatabaseHas('countries', [
            'code' => 'AF',
            'name' => 'Afghanistan',
            'currency_code' => 'AFN',
        ]);
        $this->assertDatabaseHas('countries', [
            'code' => 'NG',
            'name' => 'Nigeria',
            'slug' => 'nigeria',
            'phone_code' => '+234',
            'currency_code' => 'NGN',
        ]);
        $this->assertSame(count($nigerianStates), $nigeria->states()->count());
        $this->assertDatabaseHas('states', [
            'country_id' => $nigeria->id,
            'name' => 'Abia',
            'slug' => 'abia',
            'code' => 'AB',
        ]);

        $this->assertDatabaseHas('currencies', [
            'currency_code' => 'NGN',
            'currency_name' => 'Existing Nigerian naira',
            'currency_symbol' => '₦',
            'payment_gateway' => 'flutterwave',
        ]);
        $this->assertDatabaseHas('currencies', [
            'currency_code' => 'USD',
            'currency_name' => 'US Dollar',
            'currency_symbol' => '$',
        ]);
        $this->assertDatabaseMissing('currencies', ['currency_code' => 'AFN']);
        $currencyCount = Currency::query()->count();
        $this->assertSame(2, $currencyCount);

        app(GeographySeeder::class)->run();

        $this->assertSame(count($countries), Country::query()->count());
        $this->assertSame(count($nigerianStates), $nigeria->fresh()->states()->count());
        $this->assertSame($currencyCount, Currency::query()->count());
        $this->assertSame('NG', $nigeria->fresh()->code);
    }

    public function test_plan_seeder_creates_a_default_currency_price_without_overriding_an_existing_default(): void
    {
        app(GeographySeeder::class)->run();
        app(PlansCouponsSeeder::class)->run();

        $this->assertEqualsCanonicalizing(
            ['NGN', 'USD'],
            Currency::query()->orderBy('currency_code')->pluck('currency_code')->all()
        );

        $plan = \App\Models\PromotionPlan::query()->where('slug', 'featured-listing')->firstOrFail();
        $naira = Currency::query()->where('currency_code', 'NGN')->firstOrFail();
        $dollar = Currency::query()->where('currency_code', 'USD')->firstOrFail();
        $this->assertDatabaseHas('promotion_plan_prices', [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $naira->id,
            'is_default' => true,
        ]);

        $plan->prices()->update(['is_default' => false]);
        $plan->prices()->create([
            'currency_id' => $dollar->id,
            'amount' => 20,
            'is_default' => true,
        ]);

        app(PlansCouponsSeeder::class)->run();

        $this->assertDatabaseHas('promotion_plan_prices', [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $naira->id,
            'is_default' => false,
        ]);
        $this->assertDatabaseHas('promotion_plan_prices', [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $dollar->id,
            'is_default' => true,
        ]);
    }
}
