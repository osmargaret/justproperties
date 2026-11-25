<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\AdminCountries;
use App\Livewire\Admin\Settings\AdminCurrencies;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_configuration_is_stored_on_currencies_not_countries(): void
    {
        $this->assertFalse(Schema::hasColumn('countries', 'payment_gateway'));
        $this->assertFalse(Schema::hasColumn('countries', 'bank_details'));
        $this->assertFalse(Schema::hasTable('promotion_currencies'));
        $this->assertTrue(Schema::hasColumn('currencies', 'payment_gateway'));
        $this->assertTrue(Schema::hasColumn('currencies', 'bank_details'));
    }

    public function test_admin_can_create_currency_with_gateway_and_bank_details(): void
    {
        Livewire::actingAs(User::factory()->create())
            ->test(AdminCurrencies::class)
            ->call('openCreate')
            ->set('currency_code', 'ngn')
            ->set('currency_name', 'Nigerian naira')
            ->set('currency_symbol', '₦')
            ->set('payment_gateway', 'paystack')
            ->set('show_manual_payment', true)
            ->set('bank_name', 'Example Bank')
            ->set('bank_account_number', '0123456789')
            ->set('account_name', 'Propatis Limited')
            ->set('swift_code', 'EXAMPLE')
            ->set('bank_instructions', 'Use the currency code as the transfer reference.')
            ->call('saveCurrency')
            ->assertHasNoErrors();

        $currency = Currency::query()->where('currency_code', 'NGN')->firstOrFail();

        $this->assertSame('paystack', $currency->payment_gateway);
        $this->assertSame([
            'bank_name' => 'Example Bank',
            'bank_account_number' => '0123456789',
            'account_name' => 'Propatis Limited',
            'swift_code' => 'EXAMPLE',
            'instructions' => 'Use the currency code as the transfer reference.',
        ], $currency->bank_details);
    }

    public function test_admin_can_create_currency_without_payment_options(): void
    {
        Livewire::actingAs(User::factory()->create())
            ->test(AdminCurrencies::class)
            ->call('openCreate')
            ->set('currency_code', 'EUR')
            ->set('currency_name', 'Euro')
            ->set('payment_gateway', '')
            ->call('saveCurrency')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('currencies', [
            'currency_code' => 'EUR',
            'payment_gateway' => null,
            'bank_details' => null,
        ]);
    }

    public function test_currency_code_cannot_change_while_a_country_uses_it(): void
    {
        $currency = Currency::query()->create([
            'currency_code' => 'USD',
            'currency_name' => 'US dollar',
        ]);
        Country::query()->create([
            'name' => 'United States',
            'code' => 'US',
            'currency_code' => 'USD',
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(AdminCurrencies::class)
            ->call('openEdit', $currency->id)
            ->set('currency_code', 'CAD')
            ->call('saveCurrency')
            ->assertHasErrors('currency_code');

        $this->assertDatabaseHas('currencies', ['currency_code' => 'USD']);
        $this->assertDatabaseMissing('currencies', ['currency_code' => 'CAD']);
    }

    public function test_country_list_can_be_searched_and_is_paginated(): void
    {
        foreach (range(1, 17) as $number) {
            Country::query()->create([
                'name' => sprintf('Test Country %02d', $number),
                'code' => sprintf('T%02d', $number),
            ]);
        }

        Livewire::actingAs(User::factory()->create())
            ->test(AdminCountries::class)
            ->assertSee('Test Country 01')
            ->assertDontSee('Test Country 17')
            ->set('paginators.page', 2)
            ->assertSee('Test Country 17')
            ->set('search', 'Test Country 17')
            ->assertSee('Test Country 17')
            ->assertDontSee('Test Country 01');
    }

    public function test_currency_list_can_be_searched_and_is_paginated(): void
    {
        foreach (range(1, 17) as $number) {
            Currency::query()->create([
                'currency_code' => sprintf('X%02d', $number),
                'currency_name' => sprintf('Test Currency %02d', $number),
            ]);
        }

        Livewire::actingAs(User::factory()->create())
            ->test(AdminCurrencies::class)
            ->assertSee('Test Currency 01')
            ->assertDontSee('Test Currency 17')
            ->set('paginators.page', 2)
            ->assertSee('Test Currency 17')
            ->set('search', 'X17')
            ->assertSee('Test Currency 17')
            ->assertDontSee('Test Currency 01');
    }
}
