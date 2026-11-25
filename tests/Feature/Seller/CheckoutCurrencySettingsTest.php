<?php

namespace Tests\Feature\Seller;

use App\Livewire\Seller\Checkout;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutCurrencySettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_uses_payment_gateway_and_bank_details_from_the_payment_currency(): void
    {
        $country = Country::query()->create([
            'name' => 'Nigeria',
            'code' => 'NG',
            'currency_code' => 'NGN',
        ]);
        $user = User::factory()->create(['country_id' => $country->id]);
        Currency::query()->create([
            'currency_code' => 'NGN',
            'currency_name' => 'Nigerian naira',
            'currency_symbol' => '₦',
            'bank_details' => [
                'bank_name' => 'Example Bank',
                'bank_account_number' => '0123456789',
                'account_name' => 'Propatis Limited',
            ],
        ]);
        $payment = Payment::query()->create([
            'user_id' => $user->id,
            'country_id' => $country->id,
            'currency_code' => 'NGN',
            'paymentable_id' => 1,
            'paymentable_type' => Promotion::class,
            'reference' => 'TEST-CURRENCY-CHECKOUT',
            'amount' => 10000,
            'coupon_value' => 0,
            'vat_rate' => 0,
            'vat_value' => 0,
            'total' => 10000,
            'status' => 'pending',
        ]);

        Livewire::actingAs($user)
            ->test(Checkout::class, ['payment' => $payment])
            ->assertSet('paymentMethod', 'bank_transfer')
            ->assertSee('Bank Transfer Details')
            ->assertSee('Example Bank')
            ->assertSee('0123456789');
    }
}
