<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\Country;
use App\Models\Property;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\Subscriptions\ManagesSubscriptionProperties;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagesSubscriptionPropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigns_property_and_respects_seat_limit(): void
    {
        [$user, $property] = $this->seedUserAndProperty();
        $subscription = $this->seedSubscription($user, seats: 1);

        app(ManagesSubscriptionProperties::class)->assign($property, $subscription, $user);

        $this->assertDatabaseHas('subscribed_properties', [
            'property_id' => $property->id,
            'subscription_id' => $subscription->id,
        ]);
        $this->assertSame(0, $subscription->fresh()->remainingSeats());
    }

    public function test_remove_frees_seat(): void
    {
        [$user, $property] = $this->seedUserAndProperty();
        $subscription = $this->seedSubscription($user, seats: 2);
        SubscribedProperty::query()->create([
            'property_id' => $property->id,
            'subscription_id' => $subscription->id,
        ]);

        app(ManagesSubscriptionProperties::class)->remove($property, $subscription, $user);

        $this->assertDatabaseMissing('subscribed_properties', [
            'property_id' => $property->id,
            'subscription_id' => $subscription->id,
        ]);
        $this->assertSame(2, $subscription->fresh()->remainingSeats());
    }

    /**
     * @return array{User, Property}
     */
    private function seedUserAndProperty(): array
    {
        $country = Country::query()->create([
            'name' => 'Nigeria',
            'slug' => 'nigeria',
            'code' => 'NG',
            'is_active' => true,
        ]);
        $category = Category::query()->create(['name' => 'Homes', 'slug' => 'homes']);
        $user = User::factory()->create(['country_id' => $country->id]);
        $property = Property::query()->create([
            'name' => 'Test Home',
            'slug' => 'test-home',
            'description' => str_repeat('Desc ', 5),
            'cost' => 1000,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'status' => 'active',
            'contact_name' => 'A',
            'contact_phone' => '1',
            'contact_email' => $user->email,
            'user_id' => $user->id,
        ]);

        return [$user, $property];
    }

    private function seedSubscription(User $user, int $seats): Subscription
    {
        $plan = SubscriptionPlan::query()->create([
            'name' => 'Starter',
            'slug' => 'starter-'.$seats,
            'seats' => $seats,
            'days' => 30,
        ]);

        $end = now()->addDays(30);

        return Subscription::query()->create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'seats' => $seats,
            'days' => 30,
            'start_at' => now(),
            'end_at' => $end,
            'renew_at' => $end,
            'status' => 'active',
        ]);
    }
}
