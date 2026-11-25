<?php

namespace Tests\Feature;

use App\Livewire\Admin\AdminAdvertisements;
use App\Livewire\Admin\Settings\AdminAdvertisementSettings;
use App\Models\AdvertisementPlan;
use App\Models\AdvertisementSpace;
use App\Models\Currency;
use Database\Seeders\AdvertisementCatalogueSeeder;
use Database\Seeders\GeographySeeder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdvertisingCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalogue_seeder_preserves_the_original_rate_card_and_is_idempotent(): void
    {
        app(GeographySeeder::class)->run();
        app(AdvertisementCatalogueSeeder::class)->run();

        $this->assertSame(6, AdvertisementSpace::query()->count());
        $this->assertSame(9, AdvertisementPlan::query()->count());
        $rateCard = [
            'homepage-hero-weekly' => ['NGN' => 35000, 'USD' => 25],
            'catalog-listing-weekly' => ['NGN' => 25000, 'USD' => 18],
            'property-details-weekly' => ['NGN' => 20000, 'USD' => 15],
            'blog-sidebar-weekly' => ['NGN' => 15000, 'USD' => 10],
            'newsletter-email-cpm' => ['NGN' => 30000, 'USD' => 20],
            'partner-directory-monthly' => ['NGN' => 50000, 'USD' => 35],
            'starter-package' => ['NGN' => 150000],
            'growth-package' => ['NGN' => 380000],
            'enterprise-partner' => ['NGN' => 1200000],
        ];
        foreach ($rateCard as $slug => $prices) {
            $planId = AdvertisementPlan::query()->where('slug', $slug)->value('id');
            foreach ($prices as $currencyCode => $amount) {
                $this->assertDatabaseHas('advertisement_plan_prices', [
                    'advertisement_plan_id' => $planId,
                    'currency_id' => Currency::query()->where('currency_code', $currencyCode)->value('id'),
                    'amount' => $amount,
                    'is_default' => $currencyCode === 'NGN',
                ]);
            }
        }

        $starter = AdvertisementPlan::query()->where('slug', 'starter-package')->firstOrFail();
        $enterprise = AdvertisementPlan::query()->with('spaces')->where('slug', 'enterprise-partner')->firstOrFail();
        $this->assertSame(50000, $starter->impressions_included);
        $this->assertContains('1 Placement Area Spot', $starter->features);
        $this->assertSame(750000, $enterprise->impressions_included);
        $this->assertCount(6, $enterprise->spaces);

        app(AdvertisementCatalogueSeeder::class)->run();

        $this->assertSame(6, AdvertisementSpace::query()->count());
        $this->assertSame(9, AdvertisementPlan::query()->count());
        $this->assertSame(15, \App\Models\AdvertisementPlanPrice::query()->count());
    }

    public function test_admin_can_create_spaces_and_multi_currency_plans(): void
    {
        $usd = $this->createCurrency('USD', '$');
        $ngn = $this->createCurrency('NGN', '₦');

        $component = Livewire::actingAs(User::factory()->create())
            ->test(AdminAdvertisementSettings::class)
            ->call('openCreateSpace')
            ->set('spaceName', 'Homepage Banner')
            ->set('spaceSlug', 'homepage-banner')
            ->set('spaceDescription', 'Top-of-page banner')
            ->set('spaceDimensions', '1200 x 300 px')
            ->call('saveSpace')
            ->assertHasNoErrors();

        $space = AdvertisementSpace::query()->where('slug', 'homepage-banner')->firstOrFail();
        $component->call('openCreatePlan')
            ->set('planName', 'Weekly Homepage')
            ->set('planSlug', 'weekly-homepage')
            ->set('billingPeriod', 'week')
            ->set('selectedSpaceIds', [$space->id])
            ->set('priceRows', [
                ['currency_id' => $usd->id, 'amount' => '25', 'is_default' => true],
                ['currency_id' => $ngn->id, 'amount' => '35000', 'is_default' => false],
            ])
            ->call('savePlan')
            ->assertHasNoErrors();

        $plan = AdvertisementPlan::query()->where('slug', 'weekly-homepage')->firstOrFail();
        $this->assertDatabaseHas('advertisement_plan_spaces', [
            'advertisement_plan_id' => $plan->id,
            'advertisement_space_id' => $space->id,
        ]);
        $this->assertDatabaseHas('advertisement_plan_prices', [
            'advertisement_plan_id' => $plan->id,
            'currency_id' => $usd->id,
            'amount' => 25,
            'is_default' => true,
        ]);
        $this->assertDatabaseHas('advertisement_plan_prices', [
            'advertisement_plan_id' => $plan->id,
            'currency_id' => $ngn->id,
            'amount' => 35000,
            'is_default' => false,
        ]);

        $this->get(route('advertise'))->assertOk()->assertSee('Homepage Banner')->assertSee('Weekly Homepage');
        $this->get(route('advertise.rate-card'))->assertOk()->assertSee('NGN')->assertSee('USD');
    }

    public function test_plan_requires_exactly_one_default_price(): void
    {
        $currency = $this->createCurrency('USD', '$');
        $space = AdvertisementSpace::query()->create([
            'name' => 'Homepage Banner',
            'slug' => 'homepage-banner',
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(AdminAdvertisementSettings::class)
            ->call('openCreatePlan')
            ->set('planName', 'Weekly Homepage')
            ->set('planSlug', 'weekly-homepage')
            ->set('selectedSpaceIds', [$space->id])
            ->set('priceRows', [
                ['currency_id' => $currency->id, 'amount' => '25', 'is_default' => false],
            ])
            ->call('savePlan')
            ->assertHasErrors('priceRows');

        $this->assertDatabaseMissing('advertisement_plans', ['slug' => 'weekly-homepage']);
    }

    public function test_admin_advertisement_amount_comes_from_the_selected_plan_currency_price(): void
    {
        Storage::fake('public');
        $currency = $this->createCurrency('NGN', '₦');
        $space = AdvertisementSpace::query()->create([
            'name' => 'Homepage Banner',
            'slug' => 'homepage-banner',
        ]);
        $plan = AdvertisementPlan::query()->create([
            'name' => 'Weekly Homepage',
            'slug' => 'weekly-homepage',
            'billing_period' => 'week',
            'is_active' => true,
        ]);
        $plan->spaces()->attach($space);
        $plan->prices()->create([
            'currency_id' => $currency->id,
            'amount' => 35000,
            'is_default' => true,
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(AdminAdvertisements::class)
            ->set('new_company', 'Example Co')
            ->set('new_email', 'ads@example.com')
            ->set('new_plan_id', $plan->id)
            ->set('new_currency_id', $currency->id)
            ->set('new_payment_status', 'pending')
            ->set('new_image', UploadedFile::fake()->image('banner.jpg'))
            ->call('createAd')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('advertisements', [
            'advertisement_plan_id' => $plan->id,
            'currency_id' => $currency->id,
            'amount' => 35000,
            'company' => 'Example Co',
        ]);
    }

    private function createCurrency(string $code, string $symbol): Currency
    {
        return Currency::query()->create([
            'currency_code' => $code,
            'currency_name' => $code,
            'currency_symbol' => $symbol,
        ]);
    }
}
