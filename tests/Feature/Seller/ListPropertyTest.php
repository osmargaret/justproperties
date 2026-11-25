<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\ListProperty;
use App\Models\Category;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use App\Services\GeographyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ListPropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_save_listing_as_draft_and_redirect_to_property_details(): void
    {
        [$seller, $category, $state] = $this->seedBaseData();

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Draft Listing')
            ->set('cost', 50000000)
            ->call('saveDraft')
            ->assertRedirect();

        $property = Property::query()->firstOrFail();
        $this->assertSame('draft', $property->status);
        $this->assertNotNull($property->slug);
        $this->assertSame($seller->country_id, $property->country_id);
    }

    public function test_submitting_a_listing_is_free_and_awaits_moderation(): void
    {
        [$seller, $category, $state] = $this->seedBaseData();
        Storage::fake('public');

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Free Listing')
            ->set('description', str_repeat('Description ', 4))
            ->set('cost', 70000000)
            ->set('state_id', $state->id)
            ->set('city', 'Ikeja')
            ->set('address', '20 Broad Street')
            ->set('neighborhood', 'Ikeja')
            ->set('show_address', true)
            ->set('contact_name', 'Seller One')
            ->set('contact_phone', '+2348000000000')
            ->set('contact_email', 'seller@example.com')
            ->set('uploadedImages', [UploadedFile::fake()->image('listing.jpg')])
            ->call('submitListing');

        $property = Property::query()->firstOrFail();
        $this->assertSame('pending', $property->status);
        $this->assertSame('Ikeja', $property->neighborhood);
        $this->assertDatabaseCount('payments', 0);
    }

    public function test_listing_country_defaults_to_the_location_session_and_scopes_states(): void
    {
        [$seller] = $this->seedBaseData();
        $canada = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        State::query()->create([
            'name' => 'Ontario',
            'slug' => 'ontario',
            'code' => 'ON',
            'country_id' => $canada->id,
        ]);
        session()->put('current_location', ['country_id' => $canada->id]);

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->assertSet('country_id', $canada->id)
            ->assertSee('Ontario')
            ->assertDontSee('Lagos');
    }

    public function test_selecting_a_country_fetches_its_states_when_none_are_stored(): void
    {
        [$seller] = $this->seedBaseData();
        $ghana = Country::query()->create([
            'name' => 'Ghana',
            'code' => 'GH',
        ]);
        $geography = \Mockery::mock(GeographyService::class);
        $geography->shouldReceive('fetchAndSaveStates')
            ->once()
            ->withArgs(fn (Country $country): bool => $country->is($ghana))
            ->andReturnUsing(function (Country $country): void {
                State::query()->create([
                    'name' => 'Greater Accra',
                    'slug' => 'greater-accra',
                    'code' => 'AA',
                    'country_id' => $country->id,
                ]);
            });
        $this->app->instance(GeographyService::class, $geography);

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('country_id', $ghana->id)
            ->assertSet('state_id', null)
            ->assertSee('Greater Accra');
    }

    public function test_submitted_listing_uses_the_selected_country(): void
    {
        [$seller, $category] = $this->seedBaseData();
        Storage::fake('public');
        $canada = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        $ontario = State::query()->create([
            'name' => 'Ontario',
            'slug' => 'ontario',
            'code' => 'ON',
            'country_id' => $canada->id,
        ]);
        session()->put('current_location', ['country_id' => $canada->id]);

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Canada Listing')
            ->set('description', str_repeat('Description ', 4))
            ->set('cost', 70000000)
            ->set('state_id', $ontario->id)
            ->set('city', 'Toronto')
            ->set('address', '20 King Street')
            ->set('contact_name', 'Seller One')
            ->set('contact_phone', '+2348000000000')
            ->set('contact_email', 'seller@example.com')
            ->set('uploadedImages', [UploadedFile::fake()->image('listing.jpg')])
            ->call('submitListing')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('properties', [
            'name' => 'Canada Listing',
            'country_id' => $canada->id,
            'state_id' => $ontario->id,
        ]);
    }

    public function test_bulk_upload_creates_draft_rows_and_redirects_to_listed_properties(): void
    {
        [$seller, $category] = $this->seedBaseData();
        $csv = "title,description,category_slug,cost,state,city,address,neighborhood,show_address,contact_name,contact_phone,contact_email,contact_whatsapp\n";
        $csv .= "Bulk Listing One,Description one,{$category->slug},12000000,Lagos,Ikeja,10 Street,Alausa,true,Seller One,+2348000000000,seller@example.com,+2348000000000\n";
        $csv .= "Bulk Listing Two,Description two,{$category->slug},22000000,Lagos,Ikeja,22 Street,Magodo,true,Seller One,+2348000000000,seller@example.com,+2348000000000\n";
        $file = UploadedFile::fake()->createWithContent('bulk-properties.csv', $csv);

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('bulk_upload_file', $file)
            ->call('processBulkUpload')
            ->assertRedirect(route('seller.listed-properties'));

        $this->assertDatabaseCount('properties', 2);
        $this->assertSame(2, Property::query()->where('is_published', false)->count());
    }

    public function test_bulk_template_download_route_is_accessible_for_seller(): void
    {
        [$seller] = $this->seedBaseData();

        $this->actingAs($seller)
            ->get(route('seller.bulk-template.download'))
            ->assertOk();
    }

    public function test_checkout_route_requires_owner_and_renders(): void
    {
        [$seller, $category] = $this->seedBaseData();
        $property = Property::query()->create([
            'name' => 'Checkout Property',
            'slug' => 'checkout-property',
            'description' => 'Checkout desc',
            'cost' => 30000000,
            'category_id' => $category->id,
            'country_id' => $seller->country_id,
            'status' => 'pending_payment',
            'user_id' => $seller->id,
        ]);
        $country = Country::query()->where('code', 'NG')->firstOrFail();
        $promotionPlan = PromotionPlan::query()->create([
            'name' => 'Featured',
            'slug' => 'featured',
            'type' => 'featured',
            'features' => [],
        ]);
        $promotion = Promotion::query()->create([
            'user_id' => $seller->id,
            'property_id' => $property->id,
            'promotion_plan_id' => $promotionPlan->id,
            'start_at' => now(),
            'status' => 'pending_payment',
        ]);
        $payment = Payment::query()->create([
            'user_id' => $seller->id,
            'country_id' => $country->id,
            'paymentable_id' => $promotion->id,
            'paymentable_type' => Promotion::class,
            'reference' => 'TEST-CHECKOUT-001',
            'amount' => 10000,
            'coupon_value' => 0,
            'vat_rate' => 7.5,
            'vat_value' => 750,
            'total' => 10750,
            'status' => 'pending',
        ]);

        $this->actingAs($seller)
            ->get(route('seller.checkout', ['payment' => $payment->id]))
            ->assertOk()
            ->assertSee('Checkout')
            ->assertSee('TEST-CHECKOUT-001');
    }

    public function test_checkout_rejects_non_promotion_payments(): void
    {
        [$seller, $category] = $this->seedBaseData();
        $property = Property::query()->create([
            'name' => 'Legacy property payment',
            'slug' => 'legacy-property-payment',
            'description' => 'A legacy payment for a property listing.',
            'cost' => 30000000,
            'category_id' => $category->id,
            'user_id' => $seller->id,
        ]);
        $country = Country::query()->where('code', 'NG')->firstOrFail();
        $payment = Payment::query()->create([
            'user_id' => $seller->id,
            'country_id' => $country->id,
            'paymentable_id' => $property->id,
            'paymentable_type' => Property::class,
            'reference' => 'LEGACY-PROPERTY-001',
            'amount' => 10000,
            'total' => 10000,
            'status' => 'pending',
        ]);

        $this->actingAs($seller)
            ->get(route('seller.checkout', ['payment' => $payment->id]))
            ->assertNotFound();
    }

    /**
     * @return array{User, Category, State}
     */
    private function seedBaseData(): array
    {
        $country = Country::query()->create([
            'name' => 'Nigeria',
            'slug' => 'nigeria',
            'code' => 'NG',
            'currency' => 'Nigerian Naira',
            'currency_code' => 'NGN',
            'currency_symbol' => '₦'
        ]);
        $state = State::query()->create([
            'name' => 'Lagos',
            'slug' => 'lagos',
            'code' => 'LA',
            'country_id' => $country->id
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

        return [$seller, $category, $state];
    }
}
