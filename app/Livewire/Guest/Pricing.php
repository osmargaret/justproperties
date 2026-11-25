<?php

namespace App\Livewire\Guest;

use App\Models\Country;
use App\Models\PromotionPlan;
use App\Services\Pricing\ResolvesPlanPrice;
use Livewire\Component;

class Pricing extends Component
{
    public ?int $selectedCountryId = null;

    public function mount(): void
    {
        // Default to authenticated user's country, then first active country
        if (auth()->check() && auth()->user()->country_id) {
            $this->selectedCountryId = auth()->user()->country_id;
        } else {
            $defaultCountry = Country::query()
                ->orderByDesc('is_default')
                ->orderBy('name')
                ->first();
            $this->selectedCountryId = $defaultCountry?->id;
        }
    }

    public function switchCountry(int $countryId): void
    {
        $this->selectedCountryId = $countryId;
    }

    public function render()
    {
        $plans = PromotionPlan::query()
            ->orderBy('name')
            ->get();

        $countries = Country::orderBy('name')->get();
        $selectedCountry = $countries->firstWhere('id', $this->selectedCountryId);
        $resolver = app(ResolvesPlanPrice::class);
        $priceQuotes = $plans->mapWithKeys(
            fn (PromotionPlan $plan): array => [$plan->id => $resolver->forCountry($plan, $selectedCountry)]
        );

        return view('livewire.guest.pricing', [
            'plans'           => $plans,
            'countries'       => $countries,
            'selectedCountry' => $selectedCountry,
            'priceQuotes' => $priceQuotes,
        ])->layout('layouts.app');
    }
}
