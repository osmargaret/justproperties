<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\ListProperty;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\Price;
use App\Models\Property;
use App\Models\State;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
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
        [$seller, $category, $state, $city] = $this->seedBaseData();

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

    public function test_submit_with_pending_payment_redirects_to_checkout(): void
    {
        [$seller, $category, $state, $city, $currency] = $this->seedBaseData();
        $subscriptionPlan = SubscriptionPlan::query()->create([
            'name' => 'Starter',
            'slug' => 'starter',
            'features' => ['listings' => 1],
            'seats' => 1,
            'days' => 30,
        ]);
        Price::query()->create([
            'amount' => 12000,
            'currency_id' => $currency->id,
            'priceable_id' => $subscriptionPlan->id,
            'priceable_type' => SubscriptionPlan::class,
        ]);
        Storage::fake('public');

        $test = Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Pending Payment Listing')
            ->set('description', str_repeat('Description ', 4))
            ->set('cost', 70000000)
            ->set('state_id', $state->id)
            ->set('city_id', $city->id)
            ->set('address', '20 Broad Street')
            ->set('neighborhood', 'Ikeja')
            ->set('show_address', true)
            ->set('contact_name', 'Seller One')
            ->set('contact_phone', '+2348000000000')
            ->set('contact_email', 'seller@example.com')
            ->set('uploadedImages', [UploadedFile::fake()->image('listing.jpg')])
            ->set('selected_subscription_plan_id', $subscriptionPlan->id)
            ->call('submitListing');

        $property = Property::query()->firstOrFail();
        $payment = Payment::query()->firstOrFail();
        $test->assertRedirect(route('seller.checkout', ['payment' => $payment->id]));

        $this->assertSame('pending_payment', $property->status);
        $this->assertSame('Ikeja', $property->neighborhood);
        $this->assertDatabaseHas('payments', [
            'paymentable_type' => Property::class,
            'paymentable_id' => $property->id,
            'status' => 'pending',
        ]);
    }

    public function test_submit_without_payable_charge_marks_property_active(): void
    {
        [$seller, $category, $state, $city] = $this->seedBaseData();
        $subscriptionPlan = SubscriptionPlan::query()->create([
            'name' => 'Professional',
            'slug' => 'professional',
            'features' => ['listings' => 3],
            'seats' => 3,
            'days' => 30,
        ]);
        $subscription = Subscription::query()->create([
            'user_id' => $seller->id,
            'subscription_plan_id' => $subscriptionPlan->id,
            'seats' => 3,
            'days' => 30,
            'start_at' => now()->subDay(),
            'end_at' => now()->addDays(20),
            'renew_at' => now()->addDays(20),
            'status' => 'active',
        ]);
        Storage::fake('public');

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Active Listing')
            ->set('description', str_repeat('Description ', 4))
            ->set('cost', 72000000)
            ->set('state_id', $state->id)
            ->set('city_id', $city->id)
            ->set('address', '3 Admiralty Way')
            ->set('neighborhood', 'Lekki')
            ->set('contact_name', 'Seller One')
            ->set('contact_phone', '+2348000000000')
            ->set('contact_email', 'seller@example.com')
            ->set('uploadedImages', [UploadedFile::fake()->image('listing.jpg')])
            ->set('subscription_source', ListProperty::SUBSCRIPTION_SOURCE_EXISTING)
            ->set('selected_subscription_id', $subscription->id)
            ->call('submitListing')
            ->assertRedirect();

        $property = Property::query()->firstOrFail();
        $this->assertSame('active', $property->status);
        $this->assertDatabaseCount('payments', 0);
    }

    public function test_submit_with_unused_slots_but_purchase_choice_redirects_to_checkout(): void
    {
        [$seller, $category, $state, $city, $currency] = $this->seedBaseData();
        $heldPlan = SubscriptionPlan::query()->create([
            'name' => 'Held Pack',
            'slug' => 'held-pack',
            'features' => ['listings' => 1],
            'seats' => 1,
            'days' => 30,
        ]);
        Subscription::query()->create([
            'user_id' => $seller->id,
            'subscription_plan_id' => $heldPlan->id,
            'seats' => 1,
            'days' => 30,
            'start_at' => now()->subDay(),
            'end_at' => now()->addDays(20),
            'renew_at' => now()->addDays(20),
            'status' => 'active',
        ]);
        $newPlan = SubscriptionPlan::query()->create([
            'name' => 'Extra Pack',
            'slug' => 'extra-pack',
            'features' => ['listings' => 2],
            'seats' => 2,
            'days' => 30,
        ]);
        Price::query()->create([
            'amount' => 9900,
            'currency_id' => $currency->id,
            'priceable_id' => $newPlan->id,
            'priceable_type' => SubscriptionPlan::class,
        ]);
        Storage::fake('public');

        $test = Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('listing_category_id', $category->id)
            ->set('title', 'Purchase Despite Slots')
            ->set('description', str_repeat('Description ', 4))
            ->set('cost', 61000000)
            ->set('state_id', $state->id)
            ->set('city_id', $city->id)
            ->set('address', '5 Sample Close')
            ->set('neighborhood', 'Gbagada')
            ->set('show_address', true)
            ->set('contact_name', 'Seller One')
            ->set('contact_phone', '+2348000000000')
            ->set('contact_email', 'seller@example.com')
            ->set('uploadedImages', [UploadedFile::fake()->image('listing.jpg')])
            ->set('subscription_source', ListProperty::SUBSCRIPTION_SOURCE_PURCHASE)
            ->set('selected_subscription_plan_id', $newPlan->id)
            ->call('submitListing');

        $this->assertSame(2, Subscription::query()->where('user_id', $seller->id)->count());
        $property = Property::query()->firstOrFail();
        $payment = Payment::query()->firstOrFail();
        $test->assertRedirect(route('seller.checkout', ['payment' => $payment->id]));
        $this->assertSame('pending_payment', $property->status);
        $this->assertSame('pending', $payment->status);
    }

    public function test_bulk_upload_creates_draft_rows_and_redirects_to_listed_properties(): void
    {
        [$seller, $category] = $this->seedBaseData();
        $csv = "title,description,category_slug,cost,state_name,city_name,address,neighborhood,show_address,contact_name,contact_phone,contact_email,contact_whatsapp\n";
        $csv .= "Bulk Listing One,Description one,{$category->slug},12000000,Lagos,Ikeja,10 Street,Alausa,true,Seller One,+2348000000000,seller@example.com,+2348000000000\n";
        $csv .= "Bulk Listing Two,Description two,{$category->slug},22000000,Lagos,Ikeja,22 Street,Magodo,true,Seller One,+2348000000000,seller@example.com,+2348000000000\n";
        $file = UploadedFile::fake()->createWithContent('bulk-properties.csv', $csv);

        Livewire::actingAs($seller)
            ->test(ListProperty::class)
            ->set('bulk_upload_file', $file)
            ->call('processBulkUpload')
            ->assertRedirect(route('seller.listed-properties'));

        $this->assertDatabaseCount('properties', 2);
        $this->assertSame(2, Property::query()->where('status', 'draft')->count());
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
        $currency = Currency::query()->where('code', 'NGN')->firstOrFail();
        $payment = Payment::query()->create([
            'user_id' => $seller->id,
            'currency_id' => $currency->id,
            'paymentable_id' => $property->id,
            'paymentable_type' => Property::class,
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

    /**
     * @return array{User, Category, State, City, Currency}
     */
    private function seedBaseData(): array
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
        $city = City::query()->create([
            'name' => 'Ikeja',
            'slug' => 'ikeja',
            'code' => 'IKJ',
            'state_id' => $state->id,
            'country_id' => $country->id,
            'is_active' => true,
        ]);
        $currency = Currency::query()->create([
            'name' => 'Naira',
            'slug' => 'naira',
            'code' => 'NGN',
            'symbol' => '₦',
            'is_default' => true,
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

        return [$seller, $category, $state, $city, $currency];
    }
}
