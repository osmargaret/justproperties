<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionsAndPaymentsSeeder extends Seeder
{
    /**
     * subscriptions → subscribed_properties → promotions → payments.
     */
    public function run(): void
    {
        $seller = User::query()->where('email', 'seller@example.com')->firstOrFail();
        $plan = SubscriptionPlan::query()->where('slug', 'professional')->firstOrFail();
        $featuredPlan = PromotionPlan::query()->where('slug', 'featured-listing')->firstOrFail();
        $ngn = Currency::query()->where('code', 'NGN')->firstOrFail();
        $coupon = Coupon::query()->where('code', 'WELCOME10')->firstOrFail();

        $start = now()->subDays(5);
        $end = now()->addDays(25);
        $renew = now()->addDays(25);

        $subscription = Subscription::query()->updateOrCreate(
            [
                'user_id' => $seller->id,
                'subscription_plan_id' => $plan->id,
            ],
            [
                'seats' => $plan->seats,
                'days' => $plan->days,
                'start_at' => $start,
                'end_at' => $end,
                'renew_at' => $renew,
                'status' => 'active',
            ]
        );

        $properties = Property::query()->where('user_id', $seller->id)->orderBy('id')->take(2)->get();
        foreach ($properties as $property) {
            SubscribedProperty::query()->firstOrCreate(
                [
                    'property_id' => $property->id,
                    'subscription_id' => $subscription->id,
                ],
                []
            );
        }

        $primaryProperty = Property::query()->where('user_id', $seller->id)->orderBy('id')->firstOrFail();
        Promotion::query()->updateOrCreate(
            [
                'property_id' => $primaryProperty->id,
                'promotion_plan_id' => $featuredPlan->id,
                'user_id' => $seller->id,
            ],
            [
                'start_at' => now()->subDay(),
                'status' => 'active',
            ]
        );

        Payment::query()->updateOrCreate(
            ['reference' => 'SEED-PAY-SUB-001'],
            [
                'user_id' => $seller->id,
                'currency_id' => $ngn->id,
                'paymentable_id' => $subscription->id,
                'paymentable_type' => Subscription::class,
                'request_id' => 'req_seed_001',
                'amount' => 45000,
                'coupon_id' => null,
                'coupon_value' => '0',
                'vat_rate' => 0,
                'vat_value' => 0,
                'total' => 45000,
                'method' => 'card',
                'status' => 'success',
            ]
        );

        
    }
}
