<?php

namespace Tests\Feature\Guest;

use App\Livewire\Guest\PropertyShow;
use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyShowRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_let_category_breadcrumb_uses_the_registered_route_name(): void
    {
        $user = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Short Let',
            'slug' => 'short-let',
            'is_property' => true,
        ]);
        $property = Property::query()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Short Let Apartment',
            'slug' => 'short-let-apartment',
            'description' => 'A short let property.',
            'cost' => 100000,
            'is_published' => true,
        ]);

        Livewire::test(PropertyShow::class, ['property' => $property])
            ->assertSee(route('short-lets'));
    }
}
