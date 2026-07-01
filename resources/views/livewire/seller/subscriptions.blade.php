<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    @if (session('status'))
      <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.seller-sidebar')

      <div class="bg-white rounded-xl p-8 shadow-md space-y-8">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
          <div>
            <h2 class="text-2xl font-semibold">Subscription &amp; Billing</h2>
            <p class="text-sm text-gray-500 mt-1">Each subscription has a fixed number of seats. Assign properties from their overview tab.</p>
          </div>
          <button wire:click="$set('showPurchaseModal', true)" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Buy new subscription</button>
        </div>

        <div class="mb-4 text-sm text-gray-500">Click any subscription row below to view payment details, see linked properties, and add or remove properties from that subscription.</div>

        <div>
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">All subscriptions</h3>
            <select wire:model.live="filterStatus" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
              <option value="active">Active</option>
              <option value="pending">Pending</option>
              <option value="expired">Expired</option>
              <option value="all">All</option>
            </select>
          </div>
          @if ($subscriptions->isEmpty())
            <p class="text-sm text-gray-500">No subscriptions yet.</p>
          @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
              <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                  <tr>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Seats</th>
                    <th class="px-4 py-3">Ends</th>
                    <th class="px-4 py-3">Properties</th>
                    <th class="px-4 py-3">Action</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  @foreach ($subscriptions as $subscription)
                    <tr class="hover:bg-gray-50">
                      <td class="px-4 py-3 font-medium">{{ $subscription->plan?->name ?? '—' }}</td>
                      <td class="px-4 py-3 capitalize">{{ $subscription->status }}</td>
                      <td class="px-4 py-3">{{ $subscription->usedSeats() }} / {{ $subscription->seats }}</td>
                      <td class="px-4 py-3">{{ $subscription->end_at?->format('M d, Y') ?? '—' }}</td>
                      <td class="px-4 py-3">
                        @if ($subscription->subscribedProperties->isEmpty())
                          <span class="text-gray-400">None</span>
                        @else
                          <ul class="space-y-1">
                            @foreach ($subscription->subscribedProperties as $link)
                              <li>
                                <a href="{{ route('seller.properties.show', ['property' => $link->property_id]) }}" class="text-emerald-700 hover:underline">
                                  {{ $link->property?->name ?? 'Property #'.$link->property_id }}
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </td>
                      <td class="px-4 py-3">
                        <button wire:click="openSubscriptionModal({{ $subscription->id }})" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700">View subscription</button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>

  @if($showSubscriptionModal && $selectedSubscription)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
      <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Subscription Details</h3>
            <p class="text-sm text-gray-500">Manage properties and view payment details for this subscription.</p>
          </div>
          <button wire:click="closeSubscriptionModal" class="text-gray-400 hover:text-gray-600">
            <i class="ri-close-line text-2xl"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
          <div class="space-y-4">
            <div class="rounded-xl border border-gray-200 p-4">
              <div class="flex items-center justify-between mb-3">
                <span class="font-semibold text-gray-900">Subscription</span>
                <span class="capitalize text-sm text-white bg-emerald-600 px-3 py-1 rounded-full">{{ $selectedSubscription->status }}</span>
              </div>
              <p class="text-sm text-gray-600">{{ $selectedSubscription->plan?->name ?? 'Plan' }}</p>
              <div class="grid grid-cols-2 gap-3 text-sm text-gray-500 mt-4">
                <div>
                  <div class="font-semibold text-gray-900">Seats</div>
                  <div>{{ $selectedSubscription->usedSeats() }} / {{ $selectedSubscription->seats }}</div>
                </div>
                <div>
                  <div class="font-semibold text-gray-900">Ends</div>
                  <div>{{ $selectedSubscription->end_at?->format('M d, Y') ?? '—' }}</div>
                </div>
              </div>
            </div>

            <div class="rounded-xl border border-gray-200 p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Payment Details</h4>
              @if($selectedSubscriptionPayments->isEmpty())
                <p class="text-sm text-gray-500">No payments found for this subscription.</p>
              @else
                <div class="space-y-4">
                  @foreach($selectedSubscriptionPayments->take(3) as $payment)
                    <div class="rounded-xl bg-gray-50 p-4">
                      <div class="flex items-center justify-between gap-3 text-sm text-gray-500 mb-2">
                        <span>Reference</span>
                        <span class="font-medium text-gray-900">{{ $payment->reference }}</span>
                      </div>
                      <div class="grid grid-cols-2 gap-3 text-sm text-gray-600">
                        <div>
                          <div class="text-xs text-gray-400">Status</div>
                          <div class="font-medium capitalize">{{ $payment->status }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-400">Total</div>
                          <div class="font-medium">{{ $payment->currency?->symbol ?? 'NGN' }}{{ number_format($payment->total, 2) }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-400">Method</div>
                          <div>{{ $payment->method ?? 'N/A' }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-400">Paid</div>
                          <div>{{ $payment->paid_at?->format('M d, Y') ?? '—' }}</div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          <div class="space-y-4">
            <div class="rounded-xl border border-gray-200 p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Linked Properties</h4>
              @if($subscriptionMessage)
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">{{ $subscriptionMessage }}</div>
              @endif
              @if($subscriptionError)
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-800">{{ $subscriptionError }}</div>
              @endif
              @if($selectedSubscription->subscribedProperties->isEmpty())
                <p class="text-sm text-gray-500">No properties are currently linked to this subscription.</p>
              @else
                <ul class="space-y-3">
                  @foreach($selectedSubscription->subscribedProperties as $link)
                    <li class="flex items-start justify-between gap-3 rounded-xl border border-gray-200 bg-white p-3">
                      <div>
                        <a href="{{ route('seller.properties.show', ['property' => $link->property_id]) }}" class="font-medium text-gray-900 hover:underline">{{ $link->property?->name ?? 'Property #'.$link->property_id }}</a>
                        <p class="text-sm text-gray-500">{{ $link->property?->category?->name ?? '' }}</p>
                      </div>
                      <button wire:click="removePropertyFromSubscription({{ $link->id }})" class="text-sm text-red-600 hover:underline">Remove</button>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>

            <div class="rounded-xl border border-gray-200 p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Add a Property</h4>
              @if($availableProperties->isEmpty())
                <p class="text-sm text-gray-500">No available properties are eligible to be added at this time.</p>
              @else
                <div class="space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Property</label>
                    <select wire:model.defer="selectedPropertyToAttachId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                      <option value="">Select a property</option>
                      @foreach($availableProperties as $property)
                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                      @endforeach
                    </select>
                    @error('selectedPropertyToAttachId') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>
                  <button wire:click="addPropertyToSubscription" class="w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Attach property</button>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if($showPurchaseModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Buy New Subscription</h3>
                <button wire:click="$set('showPurchaseModal', false)" class="text-gray-400 hover:text-gray-600">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($plans as $plan)
                    <div wire:click="$set('selectedPlanId', {{ $plan->id }})" class="border rounded-lg p-4 cursor-pointer transition-all {{ $selectedPlanId === $plan->id ? 'border-emerald-600 bg-emerald-50 ring-2 ring-emerald-600' : 'border-gray-200 hover:border-emerald-300' }}">
                        <h4 class="font-bold text-gray-900">{{ $plan->name }}</h4>
                        <div class="text-2xl font-extrabold text-emerald-600 my-2">
                            {{ $this->activeCurrency?->symbol ?? '' }}{{ number_format($plan->prices->first()?->amount ?? 0, 2) }}
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><i class="ri-check-line text-emerald-500 mr-1"></i> {{ $plan->seats }} Listing Seats</li>
                            <li><i class="ri-check-line text-emerald-500 mr-1"></i> Valid for {{ $plan->days }} days</li>
                        </ul>
                    </div>
                    @endforeach
                </div>
                
                @if($selectedPlanId)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="font-semibold text-sm text-gray-700 mb-2">Order Summary</h4>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Subtotal</span>
                        <span>{{ $this->activeCurrency?->symbol ?? '' }}{{ number_format($this->getSubtotalAmount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>VAT ({{ $this->getVatRate() }}%)</span>
                        <span>{{ $this->activeCurrency?->symbol ?? '' }}{{ number_format($this->getVatAmount(), 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-base mt-2 pt-2 border-t border-gray-200">
                        <span>Total</span>
                        <span>{{ $this->activeCurrency?->symbol ?? '' }}{{ number_format($this->getTotalAmount(), 2) }}</span>
                    </div>
                </div>
                @endif
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3 bg-gray-50">
                <button wire:click="$set('showPurchaseModal', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button wire:click="buySubscription" @if(!$selectedPlanId) disabled @endif class="px-6 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Proceed to Payment
                </button>
            </div>
        </div>
    </div>
  @endif
</div>
