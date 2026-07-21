<?php

namespace App\Livewire\Guest;

use App\Models\Country;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Pricing extends Component
{
    public ?int $selectedCountryId = null;

    public string $billingCycle = 'monthly'; // 'monthly' or 'yearly'

    public function mount(): void
    {
        // Default to authenticated user's country, then first active country
        if (auth()->check() && auth()->user()->country_id) {
            $this->selectedCountryId = auth()->user()->country_id;
        } else {
            $defaultCountry = Country::where('is_active', true)->first();
            $this->selectedCountryId = $defaultCountry?->id;
        }
    }

    public function switchCountry(int $countryId): void
    {
        $this->selectedCountryId = $countryId;
    }

    public function setBillingCycle(string $cycle): void
    {
        $this->billingCycle = in_array($cycle, ['monthly', 'yearly']) ? $cycle : 'monthly';
    }

    public function selectPlan(int $planId): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        $plan = SubscriptionPlan::findOrFail($planId);

        // Find the price for the selected country
        $price = \App\Models\Price::query()
            ->where('country_id', $this->selectedCountryId)
            ->where('priceable_type', SubscriptionPlan::class)
            ->where('priceable_id', $plan->id)
            ->with('currency')
            ->first();

        if (!$price || !$price->currency) {
            session()->flash('error', __('Pricing is not available for this plan in the selected country.'));
            return;
        }

        $currency = $price->currency;
        $monthlyAmount = (float) $price->amount;
        $yearlyAmount = round($monthlyAmount * 12 * 0.70, 2); // 30% off

        $subtotal = $this->billingCycle === 'yearly' ? $yearlyAmount : $monthlyAmount;
        $days = $this->billingCycle === 'yearly' ? 365 : max(1, (int) $plan->days);

        $vatRate = $subtotal > 0 ? 7.5 : 0.0;
        $vatValue = round(($subtotal * $vatRate) / 100, 2);
        $total = round($subtotal + $vatValue, 2);

        $payment = DB::transaction(function () use ($plan, $currency, $subtotal, $vatRate, $vatValue, $total, $days) {
            $subscription = \App\Models\Subscription::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'seats' => max(1, (int) $plan->seats),
                'days' => $days,
                'start_at' => now(),
                'end_at' => now()->addDays($days),
                'renew_at' => now()->addDays($days),
                'status' => 'pending',
            ]);

            return \App\Models\Payment::create([
                'user_id' => auth()->id(),
                'currency_id' => $currency->id,
                'paymentable_id' => $subscription->id,
                'paymentable_type' => \App\Models\Subscription::class,
                'reference' => 'SUB-'.Str::upper(Str::random(12)),
                'request_id' => null,
                'amount' => $subtotal,
                'vat_rate' => $vatRate,
                'vat_value' => $vatValue,
                'total' => $total,
                'method' => null,
                'status' => 'pending',
            ]);
        });

        $this->redirect(route('seller.checkout', ['payment' => $payment->id]));
    }

    public function render()
    {
        $plans = SubscriptionPlan::with([
            'prices' => function ($q) {
                $q->where('country_id', $this->selectedCountryId)
                  ->with('currency');
            },
        ])->get();

        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $selectedCountry = $countries->firstWhere('id', $this->selectedCountryId);

        return view('livewire.guest.pricing', [
            'plans'           => $plans,
            'countries'       => $countries,
            'selectedCountry' => $selectedCountry,
        ])->layout('layouts.app');
    }
}
