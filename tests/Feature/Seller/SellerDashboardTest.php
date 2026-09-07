<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\SellerDashboard;
use App\Models\Category;
use App\Models\Country;
use App\Models\Moderation;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use App\Models\ViewedProperty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SellerDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createSeller(): User
    {
        return User::factory()->create([
            'active_role' => 'seller',
            'email_verified_at' => now(),
        ]);
    }

    private function createProperty(User $user, bool $published = true, ?string $moderationStatus = 'approved'): Property
    {
        $country = Country::query()->firstOrCreate(['code' => 'NG'], ['name' => 'Nigeria']);
        $state = State::query()->firstOrCreate(['slug' => 'lagos'], ['name' => 'Lagos', 'country_id' => $country->id]);
        $category = Category::query()->firstOrCreate(['slug' => 'landed-properties'], ['name' => 'Landed Properties', 'is_property' => true]);

        $property = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Test Property ' . uniqid(),
            'description' => 'Test property description',
            'cost' => 1000000,
            'is_published' => $published,
        ]);

        if ($moderationStatus !== null) {
            Moderation::query()->create([
                'moderatable_type' => Property::class,
                'moderatable_id' => $property->id,
                'action' => 'created',
                'status' => $moderationStatus,
            ]);
        }

        return $property;
    }

    public function test_seller_dashboard_renders_successfully(): void
    {
        $seller = $this->createSeller();
        $this->createProperty($seller, published: true, moderationStatus: 'approved');

        Livewire::actingAs($seller)
            ->test(SellerDashboard::class)
            ->assertOk()
            ->assertSee('Seller overview')
            ->assertSee('Active listings')
            ->assertSee('Pending review');
    }

    public function test_counts_active_and_pending_listings_accurately(): void
    {
        $seller = $this->createSeller();

        // 2 published & approved
        $this->createProperty($seller, published: true, moderationStatus: 'approved');
        $this->createProperty($seller, published: true, moderationStatus: 'approved');

        // 1 published but pending
        $this->createProperty($seller, published: true, moderationStatus: 'pending');

        // 1 published but rejected
        $this->createProperty($seller, published: true, moderationStatus: 'rejected');

        // 1 draft (unpublished)
        $this->createProperty($seller, published: false, moderationStatus: 'approved');

        Livewire::actingAs($seller)
            ->test(SellerDashboard::class)
            ->assertViewHas('activeListings', 2)
            ->assertViewHas('pendingReview', 1);
    }

    public function test_listing_views_calculated_from_viewed_properties_in_last_30_days(): void
    {
        $seller = $this->createSeller();
        $property = $this->createProperty($seller, published: true, moderationStatus: 'approved');

        $viewer1 = User::factory()->create();
        $viewer2 = User::factory()->create();

        // View within 30 days
        ViewedProperty::query()->forceCreate([
            'user_id' => $viewer1->id,
            'property_id' => $property->id,
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        // View older than 30 days
        ViewedProperty::query()->forceCreate([
            'user_id' => $viewer2->id,
            'property_id' => $property->id,
            'created_at' => now()->subDays(35),
            'updated_at' => now()->subDays(35),
        ]);

        Livewire::actingAs($seller)
            ->test(SellerDashboard::class)
            ->assertViewHas('listingViews', 1);
    }
}

