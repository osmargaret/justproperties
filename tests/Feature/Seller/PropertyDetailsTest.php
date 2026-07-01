<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\PropertyDetails;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\FeaturedProperty;
use App\Models\Media;
use App\Models\Moderation;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\Payment;
use App\Models\Price;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\State;
use App\Models\User;
use App\Models\ViewedProperty;
use App\Services\Payments\CompletesPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_view_own_property_overview(): void
    {
        [$seller, $property] = $this->seedProperty();

        Livewire::actingAs($seller)
            ->test(PropertyDetails::class, ['property' => $property])
            ->assertOk()
            ->assertSee($property->name)
            ->assertSee('Overview')
            ->assertSee('Views');
    }

    public function test_other_seller_cannot_view_property(): void
    {
        [, $property] = $this->seedProperty();
        $other = User::factory()->create(['active_role' => 'seller', 'email_verified_at' => now()]);

        Livewire::actingAs($other)
            ->test(PropertyDetails::class, ['property' => $property])
            ->assertForbidden();
    }

    public function test_details_update_persists_fields_and_features(): void
    {
        [$seller, $property] = $this->seedProperty();

        Media::query()->create([
            'user_id' => $seller->id,
            'mediable_id' => $property->id,
            'mediable_type' => Property::class,
            'name' => $property->name,
            'path' => 'properties/existing.jpg',
            'type' => 'image',
            'is_primary' => true,
        ]);

        Livewire::actingAs($seller)
            ->test(PropertyDetails::class, ['property' => $property])
            ->set('activeTab', 'details')
            ->set('editName', 'Updated Villa Title')
            ->set('editDescription', str_repeat('Updated description ', 4))
            ->set('editCost', 99000000)
            ->set('editAddress', '99 New Street')
            ->set('editShowAddress', false)
            ->call('updateProperty')
            ->assertHasNoErrors();

        $property->refresh();
        $this->assertSame('Updated Villa Title', $property->name);
        $this->assertFalse($property->show_address);
        $this->assertSame('99 New Street', $property->address);
    }

    public function test_can_upload_additional_media(): void
    {
        Storage::fake('public');
        [$seller, $property] = $this->seedProperty();

        Media::query()->create([
            'user_id' => $seller->id,
            'mediable_id' => $property->id,
            'mediable_type' => Property::class,
            'name' => $property->name,
            'path' => 'properties/existing.jpg',
            'type' => 'image',
            'is_primary' => true,
        ]);

        Livewire::actingAs($seller)
            ->test(PropertyDetails::class, ['property' => $property])
            ->set('uploadedImages', [UploadedFile::fake()->image('new.jpg')])
            ->call('updateProperty')
            ->assertHasNoErrors();

        $this->assertSame(2, $property->media()->count());
    }

    public function test_overview_shows_moderation_status_from_latest_record(): void
    {
        [$seller, $property] = $this->seedProperty();

        Moderation::query()->create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $property->id,
            'moderated_by' => $seller->id,
            'status' => 'approved',
            'reason' => null,
        ]);

        $property->refresh();

        Livewire::actingAs($seller)
            ->test(PropertyDetails::class, ['property' => $property])
            ->assertSee('approved');
    }

    public function test_featured_plan_purchase_creates_pending_promotion_payment(): void
    {
        [$seller, $property] = $this->seedProperty();
        $plan = PromotionPlan::query()->create([
            'name' => 'Featured 1000 clicks',
            'slug' => 'featured-1000',
            'type' => 'featured',
            'features' => ['clicks' => 1000],
        ]);
        $currency = Currency::query()->where('code', 'NGN')->firstOrFail();
        $currency->update(['payment_gateway' => 'paystack']);
        Price::query()->create([
            'priceable_type' => PromotionPlan::class,
            'priceable_id' => $plan->id,
            'currency_id' => $currency->id,
            'country_id' => $seller->country_id,
            'amount' => 15000,
        ]);

        Livewire::actingAs($seller)
            ->test(PropertyDetails::class, ['property' => $property])
            ->call('openPromotionWizard')
            ->call('selectPromotionPlan', $plan->id)
            ->call('confirmPromotionPurchase')
            ->assertRedirect(route('seller.checkout', ['payment' => Payment::query()->latest('id')->value('id')]));

        $promotion = Promotion::query()->latest('id')->firstOrFail();
        $payment = Payment::query()->latest('id')->firstOrFail();

        $this->assertSame('pending_payment', $promotion->status);
        $this->assertSame('clicks', $promotion->target_type);
        $this->assertSame(1000, (int) $promotion->target_count);
        $this->assertSame(Promotion::class, $payment->paymentable_type);
        $this->assertSame($promotion->id, (int) $payment->paymentable_id);
    }

    public function test_checkout_marks_featured_promotion_active_and_creates_deliverable(): void
    {
        [$seller, $property] = $this->seedProperty();
        $plan = PromotionPlan::query()->create([
            'name' => 'Featured 1000 clicks',
            'slug' => 'featured-1000',
            'type' => 'featured',
            'features' => ['clicks' => 1000],
        ]);
        $currency = Currency::query()->where('code', 'NGN')->firstOrFail();
        $promotion = Promotion::query()->create([
            'user_id' => $seller->id,
            'property_id' => $property->id,
            'promotion_plan_id' => $plan->id,
            'start_at' => now(),
            'status' => 'pending_payment',
            'target_type' => 'clicks',
            'target_count' => 1000,
            'usage' => [],
        ]);
        $payment = Payment::query()->create([
            'user_id' => $seller->id,
            'currency_id' => $currency->id,
            'paymentable_id' => $promotion->id,
            'paymentable_type' => Promotion::class,
            'reference' => 'TEST-PROMO-001',
            'amount' => 10000,
            'coupon_value' => 0,
            'vat_rate' => 0,
            'vat_value' => 0,
            'total' => 10000,
            'status' => 'pending',
        ]);

        app(CompletesPayment::class)->complete($payment, 'test');

        $promotion->refresh();
        $this->assertSame('active', $promotion->status);
        $this->assertSame(FeaturedProperty::class, $promotion->promotable_type);
        $this->assertNotNull($promotion->promotable_id);
    }

    public function test_checkout_activates_newsletter_promotion_and_queues_recipients(): void
    {
        [$seller, $property] = $this->seedProperty();
        $viewer = User::factory()->create(['email' => 'viewer@example.com']);
        ViewedProperty::query()->create([
            'user_id' => $viewer->id,
            'property_id' => $property->id,
        ]);

        $plan = PromotionPlan::query()->create([
            'name' => 'Newsletter 10',
            'slug' => 'newsletter-10',
            'type' => 'newsletter',
            'features' => ['emails' => 10],
        ]);
        $currency = Currency::query()->where('code', 'NGN')->firstOrFail();
        $currency->update(['payment_gateway' => 'paystack']);
        $newsletter = Newsletter::query()->create([
            'user_id' => $seller->id,
            'title' => 'NL',
            'subject' => 'Subject line',
            'content' => 'Body copy',
            'audience_type' => 'auto_prioritized',
            'status' => 'draft',
            'content_source' => 'ai',
        ]);
        $promotion = Promotion::query()->create([
            'user_id' => $seller->id,
            'property_id' => $property->id,
            'promotion_plan_id' => $plan->id,
            'start_at' => now(),
            'status' => 'pending_payment',
            'target_type' => 'emails',
            'target_count' => 10,
            'promotable_type' => Newsletter::class,
            'promotable_id' => $newsletter->id,
            'usage' => [],
        ]);
        $payment = Payment::query()->create([
            'user_id' => $seller->id,
            'currency_id' => $currency->id,
            'paymentable_id' => $promotion->id,
            'paymentable_type' => Promotion::class,
            'reference' => 'TEST-PROMO-NL',
            'amount' => 10000,
            'coupon_value' => 0,
            'vat_rate' => 0,
            'vat_value' => 0,
            'total' => 10000,
            'status' => 'pending',
        ]);

        app(CompletesPayment::class)->complete($payment, 'test');

        $promotion->refresh();
        $this->assertSame('active', $promotion->status);
        $this->assertSame(1, NewsletterRecipient::query()->where('newsletter_id', $newsletter->id)->count());
    }

    /**
     * @return array{User, Property, Category, State, City}
     */
    private function seedProperty(): array
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
        Currency::query()->create([
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

        $property = Property::query()->create([
            'name' => 'Test Villa',
            'slug' => 'test-villa-abc',
            'description' => str_repeat('A spacious home. ', 4),
            'cost' => 50000000,
            'category_id' => $category->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'address' => '1 Test Road',
            'neighborhood' => 'Ikeja GRA',
            'show_address' => true,
            'status' => 'active',
            'contact_name' => 'Seller',
            'contact_phone' => '+2348000000000',
            'contact_email' => $seller->email,
            'user_id' => $seller->id,
        ]);

        return [$seller, $property, $category, $state, $city];
    }
}
