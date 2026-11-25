<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Currency;
use App\Models\PromotionPlan;
use App\Models\PromotionPlanPrice;
use App\Services\Pricing\ResolvesPlanPrice;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PromotionPlanPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_fresh_schema_uses_currency_prices_and_payment_currency_snapshot(): void
    {
        $this->assertFalse(Schema::hasTable('prices'));
        $this->assertTrue(Schema::hasTable('currencies'));
        $this->assertFalse(Schema::hasTable('promotion_currencies'));
        $this->assertTrue(Schema::hasTable('promotion_plan_prices'));
        $this->assertTrue(Schema::hasColumn('payments', 'currency_code'));
    }

    public function test_it_uses_the_country_currency_price_or_the_plan_default(): void
    {
        $nigerianNaira = Currency::query()->create([
            'currency_code' => 'NGN',
            'currency_name' => 'Nigerian Naira',
            'currency_symbol' => '₦',
        ]);
        $usDollar = Currency::query()->create([
            'currency_code' => 'USD',
            'currency_name' => 'US Dollar',
            'currency_symbol' => '$',
        ]);

        $nigeria = Country::query()->create([
            'name' => 'Nigeria',
            'code' => 'NG',
            'currency_code' => 'NGN',
        ]);
        $canada = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
            'currency_code' => 'CAD',
        ]);
        $plan = PromotionPlan::query()->create([
            'name' => 'Featured listing',
            'slug' => 'featured-listing',
            'type' => 'featured',
        ]);
        PromotionPlanPrice::query()->create([
            'promotion_plan_id' => $plan->id,
            'currency_id' => $nigerianNaira->id,
            'amount' => 1500,
            'is_default' => false,
        ]);
        PromotionPlanPrice::query()->create([
            'promotion_plan_id' => $plan->id,
            'currency_id' => $usDollar->id,
            'amount' => 10,
            'is_default' => true,
        ]);

        $resolver = app(ResolvesPlanPrice::class);
        $nigeriaQuote = $resolver->forCountry($plan, $nigeria);
        $canadaQuote = $resolver->forCountry($plan, $canada);

        $this->assertSame('NGN', $nigeriaQuote['currency_code']);
        $this->assertSame(1500.0, $nigeriaQuote['amount']);
        $this->assertFalse($nigeriaQuote['is_default']);
        $this->assertSame('USD', $canadaQuote['currency_code']);
        $this->assertSame(10.0, $canadaQuote['amount']);
        $this->assertTrue($canadaQuote['is_default']);
    }

    public function test_a_plan_cannot_have_multiple_default_prices(): void
    {
        foreach (['USD', 'EUR'] as $code) {
            Currency::query()->create([
                'currency_code' => $code,
                'currency_name' => $code,
                'currency_symbol' => $code,
            ]);
        }

        $plan = PromotionPlan::query()->create([
            'name' => 'Featured listing',
            'slug' => 'featured-listing',
            'type' => 'featured',
        ]);
        $usd = Currency::query()->where('currency_code', 'USD')->firstOrFail();
        $eur = Currency::query()->where('currency_code', 'EUR')->firstOrFail();
        PromotionPlanPrice::query()->create([
            'promotion_plan_id' => $plan->id,
            'currency_id' => $usd->id,
            'amount' => 10,
            'is_default' => true,
        ]);

        $this->expectException(QueryException::class);
        PromotionPlanPrice::query()->create([
            'promotion_plan_id' => $plan->id,
            'currency_id' => $eur->id,
            'amount' => 9,
            'is_default' => true,
        ]);
    }

    public function test_a_plan_cannot_have_two_prices_for_the_same_currency(): void
    {
        $currency = Currency::query()->create([
            'currency_code' => 'USD',
            'currency_name' => 'US Dollar',
            'currency_symbol' => '$',
        ]);

        $plan = PromotionPlan::query()->create([
            'name' => 'Featured listing',
            'slug' => 'featured-listing',
            'type' => 'featured',
        ]);
        $price = [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $currency->id,
            'amount' => 10,
            'is_default' => true,
        ];
        PromotionPlanPrice::query()->create($price);

        $this->expectException(QueryException::class);
        PromotionPlanPrice::query()->create(array_merge($price, [
            'amount' => 12,
            'is_default' => false,
        ]));
    }

}
