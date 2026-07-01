<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Newsletter;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\SavedProperty;
use App\Models\State;
use App\Models\User;
use App\Models\ViewedProperty;
use App\Services\Promotions\NewsletterRecipientBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterRecipientBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_builds_recipients_viewers_before_savers(): void
    {
        $property = $this->makeProperty();
        $viewer = User::factory()->create(['email' => 'viewer@example.com']);
        $saver = User::factory()->create(['email' => 'saver@example.com']);

        ViewedProperty::query()->create([
            'user_id' => $viewer->id,
            'property_id' => $property->id,
        ]);
        SavedProperty::query()->create([
            'user_id' => $saver->id,
            'property_id' => $property->id,
        ]);

        $plan = PromotionPlan::query()->create([
            'name' => 'Newsletter 50',
            'slug' => 'newsletter-50',
            'type' => 'newsletter',
            'features' => ['emails' => 50],
        ]);

        $promotion = Promotion::query()->create([
            'user_id' => $property->user_id,
            'property_id' => $property->id,
            'promotion_plan_id' => $plan->id,
            'start_at' => now(),
            'status' => 'active',
            'target_type' => 'emails',
            'target_count' => 50,
            'usage' => [],
        ]);

        $newsletter = Newsletter::query()->create([
            'user_id' => $property->user_id,
            'title' => 'Test newsletter',
            'content' => 'Hello',
            'audience_type' => 'auto_prioritized',
            'status' => 'draft',
        ]);

        $count = app(NewsletterRecipientBuilder::class)->buildFor($newsletter, $promotion);

        $this->assertSame(2, $count);
        $this->assertSame(
            'viewer@example.com',
            $newsletter->recipients()->orderBy('id')->value('email')
        );
    }

    private function makeProperty(): Property
    {
        $country = Country::query()->create([
            'name' => 'Nigeria',
            'slug' => 'nigeria',
            'code' => 'NG',
            'is_active' => true,
        ]);
        $state = State::query()->create([
            'name' => 'Lagos',
            'slug' => 'lagos',
            'code' => 'LA',
            'country_id' => $country->id,
            'is_active' => true,
        ]);
        $city = City::query()->create([
            'name' => 'Ikeja',
            'slug' => 'ikeja',
            'code' => 'IKJ',
            'state_id' => $state->id,
            'country_id' => $country->id,
            'is_active' => true,
        ]);
        $category = Category::query()->create([
            'name' => 'Landed Properties',
            'slug' => 'landed-properties',
        ]);
        $seller = User::factory()->create([
            'country_id' => $country->id,
            'active_role' => 'seller',
            'email_verified_at' => now(),
        ]);

        return Property::query()->create([
            'name' => 'Test Villa',
            'slug' => 'test-villa',
            'description' => str_repeat('A spacious home. ', 4),
            'cost' => 50000000,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'address' => '1 Test Road',
            'neighborhood' => 'Ikeja GRA',
            'show_address' => true,
            'status' => 'active',
            'contact_name' => 'Seller',
            'contact_phone' => '+2348000000000',
            'contact_email' => $seller->email,
            'user_id' => $seller->id,
        ]);
    }
}
