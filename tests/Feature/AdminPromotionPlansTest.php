<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\AdminPromotionPlans;
use App\Livewire\Admin\Settings\AdminCountries;
use App\Models\Country;
use App\Models\Currency;
use App\Models\PromotionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AdminPromotionPlansTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_must_select_exactly_one_default_price(): void
    {
        $this->createCurrencies();

        Livewire::actingAs(User::factory()->create())->test(AdminPromotionPlans::class)
            ->call('openCreate')
            ->set('name', 'Featured listing')
            ->set('type', 'featured')
            ->set('priceRows', [
                ['currency_id' => $this->currencyId('EUR'), 'amount' => '9', 'is_default' => false],
                ['currency_id' => $this->currencyId('USD'), 'amount' => '10', 'is_default' => false],
            ])
            ->call('savePlan')
            ->assertHasErrors('priceRows');

        $this->assertDatabaseMissing('promotion_plans', ['slug' => 'featured-listing']);
    }

    public function test_admin_can_save_currency_prices_with_one_default(): void
    {
        $this->createCurrencies();

        Livewire::actingAs(User::factory()->create())->test(AdminPromotionPlans::class)
            ->call('openCreate')
            ->set('name', 'Featured listing')
            ->set('type', 'featured')
            ->set('priceRows', [
                ['currency_id' => $this->currencyId('EUR'), 'amount' => '9', 'is_default' => false],
                ['currency_id' => $this->currencyId('USD'), 'amount' => '10', 'is_default' => true],
            ])
            ->call('savePlan')
            ->assertHasNoErrors();

        $plan = PromotionPlan::query()->where('slug', 'featured-listing')->firstOrFail();
        $this->assertDatabaseHas('promotion_plan_prices', [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $this->currencyId('EUR'),
            'amount' => 9,
            'is_default' => false,
        ]);
        $this->assertDatabaseHas('promotion_plan_prices', [
            'promotion_plan_id' => $plan->id,
            'currency_id' => $this->currencyId('USD'),
            'amount' => 10,
            'is_default' => true,
        ]);
    }

    public function test_plan_currency_options_only_include_configured_currencies(): void
    {
        $this->createCurrencies();
        Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
            'currency' => 'Canadian Dollar',
            'currency_code' => 'CAD',
            'currency_symbol' => '$',
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(AdminPromotionPlans::class)
            ->call('openCreate')
            ->assertSee('USD — USD')
            ->assertSee('EUR — EUR')
            ->assertDontSee('CAD — Canadian Dollar');
    }

    public function test_admin_country_currency_is_not_used_to_define_promotion_currency(): void
    {
        Queue::fake();

        Livewire::actingAs(User::factory()->create())->test(AdminCountries::class)
            ->call('openCreate')
            ->set('name', 'Canada')
            ->set('code', 'CA')
            ->set('currency', 'Canadian Dollar')
            ->set('currency_code', 'CAD')
            ->set('currency_symbol', '$')
            ->call('saveCountry')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('countries', [
            'code' => 'CA',
            'currency_code' => 'CAD',
        ]);
        $this->assertDatabaseMissing('currencies', ['currency_code' => 'CAD']);
    }

    private function createCurrencies(): void
    {
        foreach (['USD', 'EUR'] as $code) {
            Currency::query()->create([
                'currency_code' => $code,
                'currency_name' => $code,
                'currency_symbol' => $code,
            ]);
        }
    }

    private function currencyId(string $code): int
    {
        return (int) Currency::query()->where('currency_code', $code)->value('id');
    }
}
