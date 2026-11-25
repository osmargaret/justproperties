<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PromotionsAndPaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::query()->where('email', 'seller@example.com')->first();
        $featuredPlan = PromotionPlan::query()->where('slug', 'featured-listing')->first();
        $country = Country::query()->where('code', 'NG')->first();
        $property = $seller
            ? Property::query()->where('user_id', $seller->id)->orderBy('id')->first()
            : null;

        if (! $seller || ! $featuredPlan || ! $country || ! $property) {
            return;
        }

        $promotion = Promotion::query()->updateOrCreate(
            [
                'property_id' => $property->id,
                'promotion_plan_id' => $featuredPlan->id,
                'user_id' => $seller->id,
            ],
            [
                'start_at' => now()->subDay(),
                'status' => 'active',
            ]
        );

        Payment::query()->updateOrCreate(
            ['reference' => 'SEED-PAY-PROMO-001'],
            [
                'user_id' => $seller->id,
                'country_id' => $country->id,
                'paymentable_id' => $promotion->id,
                'paymentable_type' => Promotion::class,
                'request_id' => 'req_seed_promo_001',
                'amount' => 500,
                'coupon_id' => null,
                'coupon_value' => '0',
                'vat_rate' => 0,
                'vat_value' => 0,
                'total' => 500,
                'method' => 'card',
                'status' => 'success',
            ]
        );
    }
}
