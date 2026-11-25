<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\AdminPropertyDetails;
use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyAlert;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyAlertNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_approving_a_property_notifies_subscribers_once(): void
    {
        Mail::fake();

        $role = Role::query()->create(['name' => 'Admin', 'slug' => 'admin']);
        $admin = User::factory()->create([
            'role_id' => $role->id,
            'active_role' => 'admin',
        ]);
        $subscriber = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Homes',
            'slug' => 'homes',
            'is_property' => true,
        ]);
        $property = Property::query()->create([
            'user_id' => $subscriber->id,
            'category_id' => $category->id,
            'name' => 'Alert match',
            'slug' => 'alert-match',
            'description' => 'A property matching the subscriber category.',
            'cost' => 100000,
            'is_published' => true,
        ]);
        PropertyAlert::query()->create([
            'user_id' => $subscriber->id,
            'category_id' => $category->id,
            'type' => 'new_property',
            'status' => 'active',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminPropertyDetails::class, ['property' => $property])
            ->call('approve')
            ->call('approve');

        $this->assertDatabaseCount('notifications', 1);
        $this->assertSame(
            'property_alert',
            $subscriber->notifications()->sole()->data['kind'],
        );
    }
}
