<x-admin.page title="Currencies" description="Currencies available for promotion and advertisement prices, with payment gateway and bank transfer details.">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search currencies by name, code, or symbol..."
            aria-label="Search currencies"
            class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm sm:max-w-sm">
        <button type="button" wire:click="openCreate" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Add currency</button>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Currency</th>
                    <th class="px-4 py-3">Gateway</th>
                    <th class="px-4 py-3">Bank transfer</th>
                    <th class="px-4 py-3">Promotion prices</th>
                    <th class="px-4 py-3">Advertisement prices</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($currencies as $currency)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">
                            {{ $currency->currency_symbol }} {{ $currency->currency_code }}
                            <span class="block text-xs font-normal text-gray-500">{{ $currency->currency_name }}</span>
                        </td>
                        <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $currency->payment_gateway ?? '—') }}</td>
                        <td class="px-4 py-3">{{ $currency->bank_details ? 'Enabled' : '—' }}</td>
                        <td class="px-4 py-3">{{ $currency->promotion_plan_prices_count }}</td>
                        <td class="px-4 py-3">{{ $currency->advertisement_plan_prices_count }}</td>
                        <td class="px-4 py-3">
                            <button type="button" wire:click="openEdit({{ $currency->id }})" class="text-emerald-600 hover:underline">Edit</button>
                            <button type="button" wire:click="deleteCurrency({{ $currency->id }})" wire:confirm="{{ __('Delete this currency?') }}" class="ml-2 text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No currencies found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $currencies->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" wire:click.self="closeModal">
            <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-xl bg-white p-6 shadow-xl" @click.stop>
                <h3 class="text-lg font-semibold text-gray-900">{{ $editingId ? __('Edit currency') : __('New currency') }}</h3>
                <form wire:submit="saveCurrency" class="mt-4 space-y-3">
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Code</label>
                            <input type="text" wire:model="currency_code" placeholder="NGN" maxlength="3" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm uppercase" />
                            @error('currency_code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="currency_name" placeholder="Nigerian naira" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
                            @error('currency_name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Symbol</label>
                        <input type="text" wire:model="currency_symbol" placeholder="₦" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
                        @error('currency_symbol') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Payment gateway</label>
                        <select wire:model="payment_gateway" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            <option value="">None</option>
                            <option value="paystack">Paystack</option>
                            <option value="flutterwave">Flutterwave</option>
                        </select>
                        @error('payment_gateway') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input type="checkbox" wire:model.live="show_manual_payment" class="rounded border-gray-300 text-emerald-600" />
                        Enable manual bank transfer
                    </label>
                    @if ($show_manual_payment)
                        <div class="space-y-2 rounded-lg border border-amber-100 bg-amber-50 p-3">
                            <div>
                                <label class="text-xs font-medium text-gray-600">Bank name</label>
                                <input type="text" wire:model="bank_name" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm" />
                                @error('bank_name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600">Account number</label>
                                <input type="text" wire:model="bank_account_number" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm" />
                                @error('bank_account_number') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600">Account name</label>
                                <input type="text" wire:model="account_name" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm" />
                                @error('account_name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600">Swift / sort code</label>
                                <input type="text" wire:model="swift_code" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm" />
                                @error('swift_code') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600">Payment instructions</label>
                                <textarea wire:model="bank_instructions" rows="2" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-1.5 text-sm"></textarea>
                                @error('bank_instructions') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Save</button>
                        <button type="button" wire:click="closeModal" class="rounded-lg border border-gray-200 px-4 py-2 text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-admin.page>
