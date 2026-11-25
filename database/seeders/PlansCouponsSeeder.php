<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\PromotionPlan;
use Illuminate\Database\Seeder;

class PlansCouponsSeeder extends Seeder
{
    /**
     * Promotion plans and coupons (no FK to other domain tables).
     */
    public function run(): void
    {
        $country = Country::query()->where('code', 'NG')->first()
            ?? Country::query()->first();
        if (! $country) {
            throw new \RuntimeException('Run GeographySeeder before PlansCouponsSeeder.');
        }

        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'featured-listing'],
            [
                'name' => 'Featured listing',
                'type' => 'featured',
                'features' => ['clicks' => 1000],
            ]
        );
        $this->upsertDefaultPrice($plan, $country, 500.00);

        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'blog-post-starter'],
            [
                'name' => 'Blog post starter',
                'type' => 'blog_post',
                'features' => ['clicks' => 500, 'posts' => 1],
            ]
        );
        $this->upsertDefaultPrice($plan, $country, 1500.00);

        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'newsletter-starter'],
            [
                'name' => 'Newsletter starter',
                'type' => 'newsletter',
                'features' => ['emails' => 1, 'recipients' => 500],
            ]
        );
        $this->upsertDefaultPrice($plan, $country, 2500.00);

        Coupon::query()->updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'name' => 'Welcome 10% off',
                'quantity' => 1000,
                'limit_per_user' => 1,
                'start_at' => now()->subMonth(),
                'expires_at' => now()->addYear(),
                'discount' => 10,
                'eligible_items' => ['promotion'],
                'is_published' => true,
            ]
        );
    }

    private function upsertDefaultPrice(PromotionPlan $plan, Country $country, float $amount): void
    {
        $currencyCode = strtoupper(trim((string) $country->currency_code));
        if ($currencyCode === '' || strlen($currencyCode) !== 3) {
            throw new \UnexpectedValueException("Country {$country->id} must have a valid currency code.");
        }

        $currency = Currency::query()->where('currency_code', $currencyCode)->first();
        if (! $currency) {
            throw new \RuntimeException("Currency {$currencyCode} must be seeded before promotion prices.");
        }

        $existingPrice = $plan->prices()->where('currency_id', $currency->id)->first();
        $hasDefaultPrice = $plan->prices()->where('is_default', true)->exists();
        $isDefault = $existingPrice?->is_default || ! $hasDefaultPrice;

        if ($isDefault) {
            $plan->prices()->where('is_default', true)->update(['is_default' => false]);
        }

        $plan->prices()->updateOrCreate(
            ['currency_id' => $currency->id],
            ['amount' => $amount, 'is_default' => $isDefault]
        );
    }
}
