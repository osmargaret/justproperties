<x-admin.page :title="'Country: '.$country->name" description="Gateways, verification JSON, and plan price overrides for this country ({{ $currencyCode }}).">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.settings.countries') }}" class="text-sm font-medium text-emerald-600 hover:underline">← Back to countries</a>
    </div>

    <form wire:submit="save" class="space-y-8">
        <section class="rounded-lg border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900">Payment gateways</h3>
            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-medium text-gray-600">Primary</label>
                    <input type="text" wire:model="primary_payment_gateway" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="stripe, paystack, …" />
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600">Secondary</label>
                    <input type="text" wire:model="secondary_payment_gateway" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900">Verification requirements (JSON)</h3>
            <textarea wire:model="verificationJson" rows="6" class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 font-mono text-xs"></textarea>
            @error('verificationJson') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </section>

        <section class="rounded-lg border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900">Subscription plan prices ({{ $currencyCode }})</h3>
            <p class="mt-1 text-xs text-gray-500">Leave blank to remove an override for this country.</p>
            <div class="mt-3 space-y-2">
                @foreach ($subscriptionPlans as $plan)
                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        <span class="min-w-[140px] font-medium text-gray-800">{{ $plan->name }}</span>
                        <input type="text" wire:model="subscriptionAmounts.{{ $plan->id }}" class="w-32 rounded-lg border border-gray-200 px-2 py-1 font-mono text-sm" />
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900">Promotion plan prices ({{ $currencyCode }})</h3>
            <div class="mt-3 space-y-2">
                @foreach ($promotionPlans as $plan)
                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        <span class="min-w-[140px] font-medium text-gray-800">{{ $plan->name }}</span>
                        <input type="text" wire:model="promotionAmounts.{{ $plan->id }}" class="w-32 rounded-lg border border-gray-200 px-2 py-1 font-mono text-sm" />
                    </div>
                @endforeach
            </div>
        </section>

        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Save configuration</button>
    </form>
</x-admin.page>
