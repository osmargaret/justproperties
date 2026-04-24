<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inspection;
use App\Models\Property;
use App\Models\PropertyAlert;
use App\Models\PropertyReview;
use App\Models\SavedProperty;
use App\Models\User;
use App\Models\ViewedProperty;
use Illuminate\Database\Seeder;

class UserEngagementSeeder extends Seeder
{
    /**
     * saved_properties, viewed_properties, property_alerts, property_reviews, inspections.
     */
    public function run(): void
    {
        $buyer = User::query()->where('email', 'buyer@example.com')->firstOrFail();
        $seller = User::query()->where('email', 'seller@example.com')->firstOrFail();
        $properties = Property::query()->where('user_id', $seller->id)->orderBy('id')->get();
        if ($properties->count() < 2) {
            $this->command?->warn('UserEngagementSeeder: need at least 2 properties; skipping engagement rows.');

            return;
        }
        $p1 = $properties->get(0);
        $p2 = $properties->get(1);
        $landed = Category::query()->where('slug', 'landed-properties')->firstOrFail();

        SavedProperty::query()->firstOrCreate(
            ['user_id' => $buyer->id, 'property_id' => $p1->id],
            []
        );

        ViewedProperty::query()->firstOrCreate(
            ['user_id' => $buyer->id, 'property_id' => $p2->id],
            []
        );

        PropertyAlert::query()->firstOrCreate(
            [
                'user_id' => $buyer->id,
                'category_id' => $landed->id,
                'type' => 'new_property',
            ],
            [
                'property_id' => null,
                'status' => 'active',
                'last_sent_at' => null,
            ]
        );

        PropertyReview::query()->firstOrCreate(
            ['property_id' => $p1->id, 'user_id' => $buyer->id],
            [
                'rating' => 5,
                'comment' => 'Excellent listing and transparent communication during the inspection process.',
            ]
        );

        Inspection::query()->firstOrCreate(
            [
                'property_id' => $p1->id,
                'user_id' => $buyer->id,
                'booking_date' => now()->addDays(3)->toDateString(),
            ],
            [
                'buyer_time' => '10:30:00',
                'seller_date' => null,
                'seller_time' => null,
                'confirmed_date' => null,
                'confirmed_time' => null,
                'status' => 'pending',
                'inspection_fee' => $p1->inspection_fee,
            ]
        );
    }
}
