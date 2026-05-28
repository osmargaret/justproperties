<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Country;
use App\Models\CountrySetting;
use App\Models\Currency;
use App\Models\Price;
use App\Models\PromotionPlan;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class AdminCountryConfig extends Component
{
    public Country $country;

    public string $primary_payment_gateway = '';

    public string $secondary_payment_gateway = '';

    public string $verificationJson = '{}';

    /** @var array<string, string> */
    public array $subscriptionAmounts = [];

    /** @var array<string, string> */
    public array $promotionAmounts = [];

    public function mount(Country $country): void
    {
        $this->country = $country->load('settings', 'currency');

        $settings = $country->settings;
        $this->primary_payment_gateway = (string) ($settings?->primary_payment_gateway ?? '');
        $this->secondary_payment_gateway = (string) ($settings?->secondary_payment_gateway ?? '');
        $ver = $settings?->verification_requirements;
        $this->verificationJson = json_encode($ver ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $currencyId = $this->resolveCurrencyId();
        $this->subscriptionAmounts = [];
        foreach (SubscriptionPlan::query()->orderBy('name','asc')->get() as $plan) {
            $this->subscriptionAmounts[(string) $plan->id] = $this->findAmount(
                SubscriptionPlan::class,
                $plan->id,
                $currencyId
            );
        }
        $this->promotionAmounts = [];
        foreach (PromotionPlan::query()->orderBy('name','asc')->get() as $plan) {
            $this->promotionAmounts[(string) $plan->id] = $this->findAmount(
                PromotionPlan::class,
                $plan->id,
                $currencyId
            );
        }
    }

    protected function resolveCurrencyId(): ?int
    {
        return $this->country->currency_id
            ?? Currency::query()->where('is_default', true)->value('id')
            ?? Currency::query()->where('is_active', true)->value('id');
    }

    protected function findAmount(string $priceableType, int $priceableId, ?int $currencyId): string
    {
        if (! $currencyId) {
            return '';
        }

        $price = Price::query()
            ->where('priceable_type', $priceableType)
            ->where('priceable_id', $priceableId)
            ->where('country_id', $this->country->id)
            ->where('currency_id', $currencyId)
            ->first();

        return $price ? (string) $price->amount : '';
    }

    public function save(): void
    {
        $this->validate([
            'primary_payment_gateway' => ['nullable', 'string', 'max:255'],
            'secondary_payment_gateway' => ['nullable', 'string', 'max:255'],
            'verificationJson' => ['nullable', 'string'],
        ]);

        $decoded = json_decode(trim($this->verificationJson) ?: '{}', true);
        if (! is_array($decoded)) {
            $this->addError('verificationJson', __('Must be valid JSON.'));

            return;
        }

        CountrySetting::query()->updateOrCreate(
            ['country_id' => $this->country->id],
            [
                'primary_payment_gateway' => $this->primary_payment_gateway !== '' ? $this->primary_payment_gateway : null,
                'secondary_payment_gateway' => $this->secondary_payment_gateway !== '' ? $this->secondary_payment_gateway : null,
                'verification_requirements' => $decoded,
            ]
        );

        $currencyId = $this->resolveCurrencyId();
        if (! $currencyId) {
            $this->addError('primary_payment_gateway', __('Set a currency on the country (or create a default currency) before saving prices.'));

            return;
        }

        foreach ($this->subscriptionAmounts as $planId => $amountRaw) {
            $this->syncPlanPrice(SubscriptionPlan::class, (int) $planId, $currencyId, (string) $amountRaw);
        }
        foreach ($this->promotionAmounts as $planId => $amountRaw) {
            $this->syncPlanPrice(PromotionPlan::class, (int) $planId, $currencyId, (string) $amountRaw);
        }

        session()->flash('status', __('Country configuration saved.'));
    }

    protected function syncPlanPrice(string $priceableType, int $priceableId, int $currencyId, string $amountRaw): void
    {
        $amountRaw = trim($amountRaw);
        $match = [
            'priceable_type' => $priceableType,
            'priceable_id' => $priceableId,
            'country_id' => $this->country->id,
            'currency_id' => $currencyId,
        ];

        if ($amountRaw === '') {
            Price::query()->where($match)->delete();

            return;
        }

        Price::query()->updateOrCreate($match, ['amount' => $amountRaw]);
    }

    public function render()
    {
        $currencyCode = $this->country->currency?->code
            ?? Currency::query()->where('is_default', true)->value('code')
            ?? '—';

        $subscriptionPlans = SubscriptionPlan::query()->orderBy('name','asc')->get();
        $promotionPlans = PromotionPlan::query()->orderBy('name','asc')->get();

        return view('livewire.admin.settings.admin-country-config', [
            'subscriptionPlans' => $subscriptionPlans,
            'promotionPlans' => $promotionPlans,
            'currencyCode' => $currencyCode,
        ]);
    }
}
