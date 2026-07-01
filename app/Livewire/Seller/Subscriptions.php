<?php

namespace App\Livewire\Seller;

use App\Models\Currency;
use App\Models\Payment;
use App\Models\Price;
use App\Models\Property;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Subscriptions extends Component
{
    public string $filterStatus = 'active';
    public bool $showPurchaseModal = false;
    public bool $showSubscriptionModal = false;
    public ?int $selectedPlanId = null;
    public ?int $selectedSubscriptionId = null;
    public ?Subscription $selectedSubscription = null;
    public $selectedSubscriptionPayments = [];
    public $availableProperties = [];
    public ?int $selectedPropertyToAttachId = null;
    public ?string $subscriptionMessage = null;
    public ?string $subscriptionError = null;

    #[Computed]
    public function activeCurrency(): ?Currency
    {
        return Currency::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('is_default', true)->orWhere('code', 'NGN');
            })
            ->orderByDesc('is_default')
            ->first();
    }

    public function getSubscriptionAmount(): float
    {
        if (!$this->selectedPlanId || !$this->activeCurrency) {
            return 0.0;
        }

        $price = Price::query()
            ->where('currency_id', $this->activeCurrency->id)
            ->where('priceable_type', SubscriptionPlan::class)
            ->where('priceable_id', $this->selectedPlanId)
            ->value('amount');

        return $price !== null ? (float) $price : 0.0;
    }

    public function getSubtotalAmount(): float
    {
        return round($this->getSubscriptionAmount(), 2);
    }

    public function getVatRate(): float
    {
        return $this->getSubtotalAmount() > 0 ? 7.5 : 0.0;
    }

    public function getVatAmount(): float
    {
        return round(($this->getSubtotalAmount() * $this->getVatRate()) / 100, 2);
    }

    public function getTotalAmount(): float
    {
        return round($this->getSubtotalAmount() + $this->getVatAmount(), 2);
    }

    public function buySubscription()
    {
        $this->validate([
            'selectedPlanId' => ['required', 'exists:subscription_plans,id'],
        ]);

        $plan = SubscriptionPlan::whereKey($this->selectedPlanId)->first();
        $total = $this->getTotalAmount();

        if ($total <= 0) {
            return;
        }

        $payment = DB::transaction(function () use ($plan) {
            $subscription = Subscription::create([
                'user_id' => Auth::id(),
                'subscription_plan_id' => $plan->id,
                'seats' => max(1, (int) $plan->seats),
                'days' => max(1, (int) $plan->days),
                'start_at' => now(),
                'end_at' => now()->addDays(max(1, (int) $plan->days)),
                'renew_at' => now()->addDays(max(1, (int) $plan->days)),
                'status' => 'pending',
            ]);

            return Payment::create([
                'user_id' => Auth::id(),
                'currency_id' => $this->activeCurrency->id,
                'paymentable_id' => $subscription->id,
                'paymentable_type' => Subscription::class,
                'reference' => 'SUB-'.Str::upper(Str::random(12)),
                'request_id' => null,
                'amount' => $this->getSubtotalAmount(),
                'vat_rate' => $this->getVatRate(),
                'vat_value' => $this->getVatAmount(),
                'total' => $this->getTotalAmount(),
                'method' => null,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('seller.checkout', ['payment' => $payment->id]);
    }

    public function openSubscriptionModal(int $subscriptionId): void
    {
        $this->reset(['selectedPropertyToAttachId', 'subscriptionMessage', 'subscriptionError']);
        $this->selectedSubscriptionId = $subscriptionId;
        $this->selectedSubscription = Subscription::query()
            ->with(['plan', 'subscribedProperties.property.category'])
            ->where('user_id', Auth::id())
            ->find($subscriptionId);
        $this->selectedSubscriptionPayments = Payment::query()
            ->with('currency')
            ->where('paymentable_type', Subscription::class)
            ->where('paymentable_id', $subscriptionId)
            ->orderByDesc('created_at')
            ->get();
        $this->availableProperties = Property::query()
            ->where('user_id', Auth::id())
            ->where('is_published', true)
            ->whereDoesntHave('activeSubscribedPropertyLink')
            ->orderByDesc('created_at')
            ->get();
        $this->showSubscriptionModal = true;
    }

    public function closeSubscriptionModal(): void
    {
        $this->showSubscriptionModal = false;
        $this->selectedSubscriptionId = null;
        $this->selectedSubscription = null;
        $this->selectedSubscriptionPayments = [];
        $this->selectedPropertyToAttachId = null;
        $this->resetValidation();
    }

    public function addPropertyToSubscription(): void
    {
        $this->validate([
            'selectedPropertyToAttachId' => ['required', 'exists:properties,id'],
        ]);

        $subscription = $this->selectedSubscription;

        if (! $subscription) {
            $this->subscriptionError = 'Subscription not found.';
            return;
        }

        $property = Property::query()
            ->where('id', $this->selectedPropertyToAttachId)
            ->where('user_id', Auth::id())
            ->whereDoesntHave('activeSubscribedPropertyLink')
            ->first();

        if (! $property) {
            $this->subscriptionError = 'Selected property is not available for this subscription.';
            return;
        }

        if ($subscription->remainingSeats() <= 0) {
            $this->subscriptionError = 'This subscription has no available seats.';
            return;
        }

        SubscribedProperty::create([
            'property_id' => $property->id,
            'subscription_id' => $subscription->id,
        ]);

        $this->refreshSelectedSubscription();
        $this->selectedSubscriptionPayments = Payment::query()
            ->with('currency')
            ->where('paymentable_type', Subscription::class)
            ->where('paymentable_id', $subscription->id)
            ->orderByDesc('created_at')
            ->get();
        $this->subscriptionMessage = 'Property added to the subscription.';
        $this->selectedPropertyToAttachId = null;
        $this->resetValidation();
    }

    public function removePropertyFromSubscription(int $subscribedPropertyId): void
    {
        $subscription = $this->selectedSubscription;

        if (! $subscription) {
            $this->subscriptionError = 'Subscription not found.';
            return;
        }

        $link = SubscribedProperty::query()
            ->where('id', $subscribedPropertyId)
            ->where('subscription_id', $subscription->id)
            ->first();

        if (! $link) {
            $this->subscriptionError = 'Property link not found for this subscription.';
            return;
        }

        SubscribedProperty::destroy($link->id);

        $this->refreshSelectedSubscription();
        $this->selectedSubscriptionPayments = Payment::query()
            ->with('currency')
            ->where('paymentable_type', Subscription::class)
            ->where('paymentable_id', $subscription->id)
            ->orderByDesc('created_at')
            ->get();
        $this->subscriptionMessage = 'Property removed from the subscription.';
        $this->resetValidation();
    }

    protected function refreshSelectedSubscription(): void
    {
        if (! $this->selectedSubscriptionId) {
            $this->selectedSubscription = null;
            return;
        }

        $this->selectedSubscription = Subscription::query()
            ->with(['plan', 'subscribedProperties.property.category'])
            ->where('user_id', Auth::id())
            ->find($this->selectedSubscriptionId);
    }

    public function getSelectedSubscriptionProperty()
    {
        if (! $this->selectedSubscriptionId) {
            return null;
        }

        return Subscription::query()
            ->with(['plan', 'subscribedProperties.property'])
            ->withCount('subscribedProperties')
            ->where('user_id', Auth::id())
            ->find($this->selectedSubscriptionId);
    }

    public function getSelectedSubscriptionPaymentsProperty()
    {
        if (! $this->selectedSubscriptionId) {
            return collect();
        }

        return Payment::query()
            ->with('currency')
            ->where('paymentable_type', Subscription::class)
            ->where('paymentable_id', $this->selectedSubscriptionId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function getAvailablePropertiesProperty()
    {
        return $this->availableProperties;
    }

    public function render()
    {
        $query = Subscription::query()
            ->where('user_id', Auth::id())
            ->with(['plan', 'subscribedProperties.property'])
            ->withCount('subscribedProperties')
            ->orderByDesc('start_at');

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $subscriptions = $query->get()
            ->map(function (Subscription $subscription) {
                $subscription->remaining_seats = $subscription->remainingSeats();
                return $subscription;
            });

        $plans = SubscriptionPlan::with(['prices' => function($q) {
            if ($this->activeCurrency) {
                $q->where('currency_id', $this->activeCurrency->id);
            }
        }])->orderBy('seats', 'asc')->get();

        return view('livewire.seller.subscriptions', [
            'subscriptions' => $subscriptions,
            'plans' => $plans,
        ]);
    }
}
