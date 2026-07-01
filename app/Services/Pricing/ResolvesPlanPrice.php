<?php

namespace App\Services\Pricing;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Price;
use App\Models\User;

class ResolvesPlanPrice
{
    /**
     * @return array{amount: float, currency_id: int|null, currency_code: string|null, currency_symbol: string|null}
     */
    public function forUser(string $priceableType, int $priceableId, User $user): array
    {
        $country = $user->country_id ? Country::query()->find($user->country_id) : null;
        $currency = $this->resolveCurrency($country);

        if (! $currency) {
            return [
                'amount' => 0.0,
                'currency_id' => null,
                'currency_code' => null,
                'currency_symbol' => null,
            ];
        }

        $amount = $this->resolveAmount($priceableType, $priceableId, $currency->id, $country?->id);

        return [
            'amount' => $amount,
            'currency_id' => $currency->id,
            'currency_code' => $currency->code,
            'currency_symbol' => $currency->symbol,
        ];
    }

    private function resolveCurrency(?Country $country): ?Currency
    {
        if ($country?->currency_id) {
            return Currency::query()->find($country->currency_id);
        }

        return Currency::query()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('code')
            ->first();
    }

    private function resolveAmount(string $priceableType, int $priceableId, int $currencyId, ?int $countryId): float
    {
        if ($countryId) {
            $countryAmount = Price::query()
                ->where('priceable_type', $priceableType)
                ->where('priceable_id', $priceableId)
                ->where('currency_id', $currencyId)
                ->where('country_id', $countryId)
                ->value('amount');

            if ($countryAmount !== null) {
                return (float) $countryAmount;
            }
        }

        $globalAmount = Price::query()
            ->where('priceable_type', $priceableType)
            ->where('priceable_id', $priceableId)
            ->where('currency_id', $currencyId)
            ->whereNull('country_id')
            ->value('amount');

        return $globalAmount !== null ? (float) $globalAmount : 0.0;
    }
}
