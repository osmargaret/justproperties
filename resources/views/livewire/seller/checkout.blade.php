<div>
    <main class="white-header max-w-4xl mx-auto px-4 mt-[90px] mb-8">
        <div class="bg-white rounded-xl p-8 shadow-md space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-semibold">Checkout</h2>
                <p class="text-sm text-gray-500 mt-1">Reference: {{ $payment->reference }}</p>
            </div>

            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            @php
                $symbol = $payment->currency?->symbol ?? '₦';
            @endphp

            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>{{ $symbol }}{{ number_format((float) $payment->amount, 2) }}</span></div>
                @if($payment->coupon_value > 0)
                <div class="flex justify-between text-emerald-600"><span class="font-medium">Coupon applied</span><span>- {{ $symbol }}{{ number_format((float) $payment->coupon_value, 2) }}</span></div>
                @endif
                <div class="flex justify-between"><span class="text-gray-500">VAT ({{ number_format((float) $payment->vat_rate, 1) }}%)</span><span>{{ $symbol }}{{ number_format((float) $payment->vat_value, 2) }}</span></div>
                <div class="flex justify-between pt-3 border-t border-gray-200 font-semibold text-base"><span>Total</span><span>{{ $symbol }}{{ number_format((float) $payment->total, 2) }}</span></div>
            </div>

            @if($payment->status === 'pending' && !$payment->coupon_id)
            <div class="pt-4 border-t border-gray-200">
                <label for="coupon" class="block text-sm font-medium text-gray-700 mb-1">Have a coupon code?</label>
                <div class="flex gap-2">
                    <input type="text" wire:model="couponCode" placeholder="Enter code" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <button type="button" wire:click="applyCouponCode" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition">Apply</button>
                </div>
                @if($couponMessage)
                    <p class="mt-2 text-sm {{ $couponSuccess ? 'text-emerald-600' : 'text-red-600' }}">{{ $couponMessage }}</p>
                @endif
            </div>
            @endif

            @if ($payment->currency?->payment_gateway)
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                    Gateway: <span class="font-medium capitalize">{{ str_replace('_', ' ', $payment->currency->payment_gateway) }}</span>
                    <span class="text-gray-500">({{ $payment->currency->code }})</span>
                </div>
            @endif

            @if ($gatewayError)
                <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ $gatewayError }}</div>
            @endif

            @error('payment')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex flex-wrap items-center gap-3">
                @if (! $gatewayError && $payment->status === 'pending')
                    <button type="button" wire:click="pay" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">
                        Pay now
                    </button>
                @endif

                @if (app()->environment('local') && $payment->status === 'pending')
                    <button type="button" wire:click="completePaymentLocally" class="px-5 py-3 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                        Complete locally (dev)
                    </button>
                @endif

                @if ($payment->paymentable_type === \App\Models\Property::class && $payment->paymentable_id)
                    <a href="{{ route('seller.properties.show', ['property' => $payment->paymentable_id]) }}" class="text-sm text-gray-600 hover:text-emerald-700">Back to property details</a>
                @elseif ($payment->paymentable_type === \App\Models\Subscription::class && $payment->paymentable_id)
                    @php
                        $subscriptionPropertyId = \App\Models\SubscribedProperty::query()
                            ->where('subscription_id', $payment->paymentable_id)
                            ->latest('id')
                            ->value('property_id');
                    @endphp
                    @if ($subscriptionPropertyId)
                        <a href="{{ route('seller.properties.show', ['property' => $subscriptionPropertyId]) }}" class="text-sm text-gray-600 hover:text-emerald-700">Back to property details</a>
                    @endif
                @elseif ($payment->paymentable_type === \App\Models\Promotion::class && $payment->paymentable?->property_id)
                    <a href="{{ route('seller.properties.show', ['property' => $payment->paymentable->property_id, 'tab' => 'promotions']) }}" class="text-sm text-gray-600 hover:text-emerald-700">Back to promotions</a>
                @endif
            </div>
        </div>
    </main>
</div>
