<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\Country;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use App\Services\Content\ContentGenerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentGenerationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_template_variants_when_ai_disabled(): void
    {
        Setting::setValue('ai.enabled', false, 'boolean');
        Setting::setValue('content.generation_mode', 'ai');

        $property = $this->makeProperty();
        $plan = PromotionPlan::query()->create([
            'name' => 'Blog bundle',
            'slug' => 'blog-bundle',
            'type' => 'blog_post',
            'features' => ['posts' => 1],
        ]);

        $variants = app(ContentGenerationService::class)->generateVariants($property, $plan, 'Highlight the garden.');

        $this->assertCount(2, $variants);
        $this->assertArrayHasKey('title', $variants[0]);
        $this->assertStringContainsString('Highlight the garden', $variants[0]['body']);
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
            'city' => 'Ikeja',
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
