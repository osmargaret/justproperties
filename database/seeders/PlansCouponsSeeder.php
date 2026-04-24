<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\PromotionPlan;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class PlansCouponsSeeder extends Seeder
{
    /**
     * subscription_plans → promotion_plans → coupons (no FK to other domain tables).
     */
    public function run(): void
    {
        SubscriptionPlan::query()->updateOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter',
                'features' => ['listings' => 3, 'support' => 'email'],
                'seats' => 3,
                'days' => 30,
            ]
        );

        SubscriptionPlan::query()->updateOrCreate(
            ['slug' => 'professional'],
            [
                'name' => 'Professional',
                'features' => ['listings' => 15, 'support' => 'priority'],
                'seats' => 15,
                'days' => 30,
            ]
        );

        PromotionPlan::query()->updateOrCreate(
            ['slug' => 'featured-listing'],
            [
                'name' => 'Featured listing',
                'type' => 'featured listings',
                'features' => ['homepage' => true, 'duration_days' => 14],
                'days' => 14,
            ]
        );

        PromotionPlan::query()->updateOrCreate(
            ['slug' => 'extra-views'],
            [
                'name' => 'Boost views',
                'type' => 'views',
                'features' => ['impressions' => 10000],
                'days' => 7,
            ]
        );

        Coupon::query()->updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'name' => 'Welcome 10% off',
                'quantity' => 1000,
                'limit_per_user' => 1,
                'limit_for_user' => null,
                'start_at' => now()->subMonth(),
                'expires_at' => now()->addYear(),
                'is_percentage' => true,
                'discount' => 10,
                'discount_cap' => 50000,
                'minimum_spend' => 10000,
                'eligible_items' => ['subscription', 'promotion'],
                'is_published' => true,
            ]
        );
    }
}
