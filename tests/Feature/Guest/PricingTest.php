<?php

namespace Tests\Feature\Guest;

use App\Models\Country;
use App\Models\Currency;
use App\Models\PromotionPlan;
use App\Models\PromotionPlanPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_pricing_page_displays_promotion_plans_instead_of_listing_subscriptions(): void
    {
        $country = Country::query()->create([
            'name' => 'Nigeria',
            'slug' => 'nigeria',
            'code' => 'NG',
            'currency' => 'Nigerian Naira',
            'currency_code' => 'NGN',
            'currency_symbol' => '₦'
        ]);
        $currency = Currency::query()->create([
            'currency_code' => 'NGN',
            'currency_name' => 'Nigerian Naira',
            'currency_symbol' => '₦',
        ]);
        $plan = PromotionPlan::query()->create([
            'name' => 'Featured listing boost',
            'slug' => 'featured-listing-boost',
            'type' => 'featured',
            'features' => ['clicks' => 1000],
        ]);
        PromotionPlanPrice::query()->create([
            'promotion_plan_id' => $plan->id,
            'currency_id' => $currency->id,
            'amount' => 500,
            'is_default' => true,
        ]);

        $this->get(route('pricing'))
            ->assertOk()
            ->assertSee('Promotion plans')
            ->assertSee('Featured listing boost')
            ->assertSee('₦500.00')
            ->assertSee('Property listings are free')
            ->assertDontSee('Subscription Plans');
    }
}
