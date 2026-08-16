<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Price;
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
        $plan = SubscriptionPlan::query()->updateOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter',
                'features' => ['listings' => 3, 'support' => 'email'],
                'seats' => 3,
                'days' => 30,
            ]
        );
        Price::query()->updateOrCreate(
            ['priceable_id' => $plan->id,
                'priceable_type' => SubscriptionPlan::class, 'currency_id' => 1],
            ['amount' => 500.00]
        );
        

        $plan = SubscriptionPlan::query()->updateOrCreate(
            ['slug' => 'professional'],
            [
                'name' => 'Professional',
                'features' => ['listings' => 15, 'support' => 'priority'],
                'seats' => 15,
                'days' => 30,
            ]
        );
        Price::query()->updateOrCreate(
            ['priceable_id' => $plan->id,
                'priceable_type' => SubscriptionPlan::class, 'currency_id' => 1],
            ['amount' => 1500.00]
        );
        

        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'featured-listing'],
            [
                'name' => 'Featured listing',
                'type' => 'featured',
                'features' => ['clicks' => 1000],
            ]
        );
        Price::query()->updateOrCreate(
            ['priceable_id' => $plan->id,
                'priceable_type' => PromotionPlan::class, 'currency_id' => 1],
            ['amount' => 500.00]
        );
        

        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'blog-post-starter'],
            [
                'name' => 'Blog post starter',
                'type' => 'blog_post',
                'features' => ['clicks' => 500, 'posts' => 1],
            ]
        );
        Price::query()->updateOrCreate(
            ['priceable_id' => $plan->id,
                'priceable_type' => PromotionPlan::class, 'currency_id' => 1],
            ['amount' => 1500.00]
        );
        
        $plan = PromotionPlan::query()->updateOrCreate(
            ['slug' => 'newsletter-starter'],
            [
                'name' => 'Newsletter starter',
                'type' => 'newsletter',
                'features' => ['emails' => 1, 'recipients' => 500],
            ]
        );
        Price::query()->updateOrCreate(
            ['priceable_id' => $plan->id,
                'priceable_type' => PromotionPlan::class, 'currency_id' => 1],
            ['amount' => 2500.00]
        );

        Coupon::query()->updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'name' => 'Welcome 10% off',
                'quantity' => 1000,
                'limit_per_user' => 1,
                'start_at' => now()->subMonth(),
                'expires_at' => now()->addYear(),
                'discount' => 10,
                'eligible_items' => ['subscription', 'promotion'],
                'is_published' => true,
            ]
        );
    }
}
