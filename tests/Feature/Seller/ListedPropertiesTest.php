<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\ListedProperties;
use App\Models\Category;
use App\Models\Country;
use App\Models\Moderation;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ListedPropertiesTest extends TestCase
{
    use RefreshDatabase;

    private function createSeller(): User
    {
        return User::factory()->create([
            'active_role' => 'seller',
            'email_verified_at' => now(),
        ]);
    }

    private function createProperty(User $user, string $name, bool $published = true, ?string $moderationStatus = 'approved'): Property
    {
        $country = Country::query()->firstOrCreate(['code' => 'NG'], ['name' => 'Nigeria']);
        $state = State::query()->firstOrCreate(['slug' => 'lagos'], ['name' => 'Lagos', 'country_id' => $country->id]);
        $category = Category::query()->firstOrCreate(['slug' => 'landed-properties'], ['name' => 'Landed Properties', 'is_property' => true]);

        $property = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => $name,
            'description' => 'Test description',
            'cost' => 5000000,
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

    public function test_can_filter_by_moderation_status_without_error(): void
    {
        $seller = $this->createSeller();

        $approved = $this->createProperty($seller, 'Approved Villa', true, 'approved');
        $pending = $this->createProperty($seller, 'Pending Mansion', true, 'pending');
        $rejected = $this->createProperty($seller, 'Rejected Shack', true, 'rejected');

        // Test filtering by approved
        Livewire::actingAs($seller)
            ->test(ListedProperties::class)
            ->set('filterModeration', 'approved')
            ->assertSee($approved->name)
            ->assertDontSee($pending->name)
            ->assertDontSee($rejected->name);

        // Test filtering by pending
        Livewire::actingAs($seller)
            ->test(ListedProperties::class)
            ->set('filterModeration', 'pending')
            ->assertSee($pending->name)
            ->assertDontSee($approved->name)
            ->assertDontSee($rejected->name);

        // Test filtering by rejected
        Livewire::actingAs($seller)
            ->test(ListedProperties::class)
            ->set('filterModeration', 'rejected')
            ->assertSee($rejected->name)
            ->assertDontSee($approved->name)
            ->assertDontSee($pending->name);
    }
}

