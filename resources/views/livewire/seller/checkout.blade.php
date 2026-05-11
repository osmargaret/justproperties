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

            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>₦{{ number_format((float) $payment->amount, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Coupon discount</span><span>- ₦{{ number_format((float) $payment->coupon_value, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">VAT ({{ number_format((float) $payment->vat_rate, 1) }}%)</span><span>₦{{ number_format((float) $payment->vat_value, 2) }}</span></div>
                <div class="flex justify-between pt-3 border-t border-gray-200 font-semibold text-base"><span>Total</span><span>₦{{ number_format((float) $payment->total, 2) }}</span></div>
            </div>

            <div class="rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-800 text-xs p-3">
                Gateway selection is controlled by country settings. This is a placeholder completion action until gateway integration is connected.
            </div>

            <div class="flex items-center gap-3">
                <button type="button" wire:click="markAsPaidPlaceholder" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">
                    Continue payment (placeholder)
                </button>
                @if ($payment->paymentable_id)
                    <a href="{{ route('seller.properties.show', ['property' => $payment->paymentable_id]) }}" class="text-sm text-gray-600 hover:text-emerald-700">Back to property details</a>
                @endif
            </div>
        </div>
    </main>
</div>
