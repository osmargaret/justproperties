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

            {{-- Payment Method Selection --}}
            @php
                $gateway = $payment->currency?->payment_gateway;
                $bankDetails = $payment->currency?->bank_details;
                $hasGateway = !empty($gateway);
                $hasBank = !empty($bankDetails);
            @endphp

            @if ($payment->status === 'pending')
                @if ($hasGateway && $hasBank)
                    <div class="space-y-2 pt-2">
                        <label class="block text-sm font-semibold text-gray-700">Select Payment Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition {{ $paymentMethod === $gateway ? 'border-emerald-600 bg-emerald-50/30' : 'border-gray-200' }}">
                                <input type="radio" name="payment_method" value="{{ $gateway }}" wire:model.live="paymentMethod" class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <p class="font-medium text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $gateway) }}</p>
                                    <p class="text-xs text-gray-500">Pay securely online</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition {{ $paymentMethod === 'bank_transfer' ? 'border-emerald-600 bg-emerald-50/30' : 'border-gray-200' }}">
                                <input type="radio" name="payment_method" value="bank_transfer" wire:model.live="paymentMethod" class="text-emerald-600 focus:ring-emerald-500">
                                <div>
                                    <p class="font-medium text-sm text-gray-900">Bank Transfer</p>
                                    <p class="text-xs text-gray-500">Pay via bank app/counter</p>
                                </div>
                            </label>
                        </div>
                    </div>
                @elseif ($hasGateway)
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        Gateway: <span class="font-medium capitalize">{{ str_replace('_', ' ', $gateway) }}</span>
                        <span class="text-gray-500">({{ $payment->currency->code }})</span>
                    </div>
                @elseif ($hasBank)
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        Payment Method: <span class="font-medium">Bank Transfer</span>
                        <span class="text-gray-500">({{ $payment->currency->code }})</span>
                    </div>
                @endif
            @endif

            {{-- Bank Details and Receipt Upload if Bank Transfer chosen --}}
            @if ($paymentMethod === 'bank_transfer' && $hasBank && $payment->status === 'pending')
                <div class="border border-amber-100 bg-amber-50/30 rounded-xl p-6 space-y-4">
                    <h3 class="font-semibold text-gray-900 border-b border-amber-200/50 pb-2">Bank Transfer Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-500 block">Bank Name</span>
                            <span class="font-medium text-gray-800">{{ $bankDetails['bank_name'] }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">Account Number</span>
                            <span class="font-medium text-gray-800 font-mono text-base">{{ $bankDetails['bank_account_number'] }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">Account Name</span>
                            <span class="font-medium text-gray-800">{{ $bankDetails['account_name'] }}</span>
                        </div>
                        @if (!empty($bankDetails['swift_code']))
                            <div>
                                <span class="text-xs text-gray-500 block">Swift / Sort Code</span>
                                <span class="font-medium text-gray-800 font-mono">{{ $bankDetails['swift_code'] }}</span>
                            </div>
                        @endif
                    </div>
                    @if (!empty($bankDetails['instructions']))
                        <div class="border-t border-amber-200/40 pt-3">
                            <span class="text-xs text-gray-500 block font-medium">Instructions</span>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line mt-0.5">{{ $bankDetails['instructions'] }}</p>
                        </div>
                    @endif

                    <div class="border-t border-amber-200/40 pt-4 space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Upload Payment Receipt</label>
                        <p class="text-xs text-gray-500">Please transfer the exact sum of <strong>{{ $symbol }}{{ number_format((float) $payment->total, 2) }}</strong> to the account above and upload proof of payment below.</p>
                        
                        <div class="mt-2">
                            <input type="file" wire:model="receiptFile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                            @error('receiptFile') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        @if ($receiptFile)
                            <div class="mt-3 p-2 bg-white rounded-lg border border-gray-200 flex items-center gap-3">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="text-xs">
                                    <p class="font-medium text-gray-800">{{ $receiptFile->getClientOriginalName() }}</p>
                                    <p class="text-gray-500">{{ round($receiptFile->getSize() / 1024) }} KB</p>
                                </div>
                            </div>
                        @endif
                    </div>
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
                        {{ $paymentMethod === 'bank_transfer' ? 'Submit receipt' : 'Pay now' }}
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
