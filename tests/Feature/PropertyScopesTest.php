<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Country;
use App\Models\Moderation;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyScopesTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_scopes_filter_correctly(): void
    {
        $user = User::factory()->create();
        $country = Country::query()->firstOrCreate(['code' => 'NG'], ['name' => 'Nigeria']);
        $state = State::query()->firstOrCreate(['slug' => 'lagos'], ['name' => 'Lagos', 'country_id' => $country->id]);
        $category = Category::query()->firstOrCreate(['slug' => 'landed-properties'], ['name' => 'Landed Properties', 'is_property' => true]);

        // Property 1: published & approved
        $prop1 = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Prop 1',
            'description' => 'Desc 1',
            'is_published' => true,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $prop1->id,
            'status' => 'approved',
        ]);

        // Property 2: published & pending
        $prop2 = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Prop 2',
            'description' => 'Desc 2',
            'is_published' => true,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $prop2->id,
            'status' => 'pending',
        ]);

        // Property 3: draft & rejected
        $prop3 = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'name' => 'Prop 3',
            'description' => 'Desc 3',
            'is_published' => false,
        ]);
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $prop3->id,
            'status' => 'rejected',
        ]);

        // Test published scope
        $publishedIds = Property::published()->pluck('id')->all();
        $this->assertContains($prop1->id, $publishedIds);
        $this->assertContains($prop2->id, $publishedIds);
        $this->assertNotContains($prop3->id, $publishedIds);

        // Test approved scope
        $approvedIds = Property::approved()->pluck('id')->all();
        $this->assertContains($prop1->id, $approvedIds);
        $this->assertNotContains($prop2->id, $approvedIds);
        $this->assertNotContains($prop3->id, $approvedIds);

        // Test pending scope
        $pendingIds = Property::pending()->pluck('id')->all();
        $this->assertNotContains($prop1->id, $pendingIds);
        $this->assertContains($prop2->id, $pendingIds);
        $this->assertNotContains($prop3->id, $pendingIds);

        // Test rejected scope
        $rejectedIds = Property::rejected()->pluck('id')->all();
        $this->assertNotContains($prop1->id, $rejectedIds);
        $this->assertNotContains($prop2->id, $rejectedIds);
        $this->assertContains($prop3->id, $rejectedIds);

        // Test latest moderation takes precedence
        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $prop2->id,
            'status' => 'approved',
        ]);

        $this->assertTrue(Property::approved()->where('id', $prop2->id)->exists());
        $this->assertFalse(Property::pending()->where('id', $prop2->id)->exists());
    }
}

