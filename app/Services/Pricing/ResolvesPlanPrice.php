<?php

namespace App\Services\Pricing;

use App\Models\Country;
use App\Models\Currency;
use App\Models\PromotionPlan;
use App\Models\User;
use LogicException;

class ResolvesPlanPrice
{
    /**
     * @return array{amount: float, country_id: int|null, currency_code: string, currency_name: string, currency_symbol: string|null, is_default: bool}
     */
    public function forUser(PromotionPlan $plan, User $user): array
    {
        $country = $user->country;
        if (! $country) {
            $country = Country::query()
                ->orderByDesc('is_default')
                ->orderBy('name')
                ->first();
        }

        return $this->forCountry($plan, $country);
    }

    /**
     * @return array{amount: float, country_id: int|null, currency_code: string, currency_name: string, currency_symbol: string|null, is_default: bool}
     */
    public function forCountry(PromotionPlan $plan, ?Country $country): array
    {
        $currencyCode = strtoupper(trim((string) $country?->currency_code));
        $currencyId = $currencyCode !== ''
            ? Currency::query()->where('currency_code', $currencyCode)->value('id')
            : null;

        $price = $currencyId
            ? $plan->prices()->with('currency')->where('currency_id', $currencyId)->first()
            : null;

        $price ??= $plan->prices()
            ->with('currency')
            ->where('is_default', true)
            ->first();

        if (! $price || ! $price->currency) {
            throw new LogicException("Promotion plan {$plan->id} must have a valid default price.");
        }

        return [
            'amount' => (float) $price->amount,
            'country_id' => $country?->id,
            'currency_code' => $price->currency->currency_code,
            'currency_name' => $price->currency->currency_name,
            'currency_symbol' => $price->currency->currency_symbol,
            'is_default' => $price->is_default,
        ];
    }
}
