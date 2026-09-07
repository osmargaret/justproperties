<?php

namespace Tests\Feature\Guest;

use App\Livewire\Guest\LandedProperty;
use App\Models\Category;
use App\Models\Country;
use App\Models\Moderation;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryPropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_published_and_approved_properties_are_displayed(): void
    {
        $user = User::factory()->create();
        $country = Country::query()->firstOrCreate(['code' => 'NG'], ['name' => 'Nigeria', 'is_default' => true]);
        $state = State::query()->firstOrCreate(['slug' => 'lagos'], ['name' => 'Lagos', 'country_id' => $country->id]);
        $category = Category::query()->firstOrCreate(['slug' => 'landed-properties'], ['name' => 'Landed Properties', 'is_property' => true]);

        // 1. Published & Approved -> should be visible
        $approved = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Visible Approved Property',
            'slug' => 'visible-approved-property',
            'description' => 'Visible description',
            'cost' => 5000000,
            'is_published' => true,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $approved->id,
            'status' => 'approved',
        ]);

        // 2. Published & Pending -> should NOT be visible
        $pending = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Hidden Pending Property',
            'slug' => 'hidden-pending-property',
            'description' => 'Hidden description',
            'cost' => 5000000,
            'is_published' => true,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $pending->id,
            'status' => 'pending',
        ]);

        // 3. Published & Rejected -> should NOT be visible
        $rejected = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Hidden Rejected Property',
            'slug' => 'hidden-rejected-property',
            'description' => 'Hidden description',
            'cost' => 5000000,
            'is_published' => true,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $rejected->id,
            'status' => 'rejected',
        ]);

        // 4. Draft & Approved -> should NOT be visible
        $draft = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Hidden Draft Property',
            'slug' => 'hidden-draft-property',
            'description' => 'Hidden description',
            'cost' => 5000000,
            'is_published' => false,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $draft->id,
            'status' => 'approved',
        ]);

        Livewire::test(LandedProperty::class)
            ->assertSee($approved->name)
            ->assertDontSee($pending->name)
            ->assertDontSee($rejected->name)
            ->assertDontSee($draft->name);
    }
}

