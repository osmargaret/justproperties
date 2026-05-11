<x-admin.page title="Payments" description="Payment records with quick detail modal.">
    <div class="mb-4 grid grid-cols-1 gap-3 md:grid-cols-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search reference or user..." class="rounded-lg border border-gray-200 px-3 py-2 text-sm" />
        <input wire:model.live="dateFrom" type="date" class="rounded-lg border border-gray-200 px-3 py-2 text-sm" />
        <input wire:model.live="dateTo" type="date" class="rounded-lg border border-gray-200 px-3 py-2 text-sm" />
        <select wire:model.live="status" class="rounded-lg border border-gray-200 px-3 py-2 text-sm">
            <option value="">All statuses</option>
            @foreach ($statuses as $statusOption)
                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Reference</th>
                    <th class="px-4 py-3">Details</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">View More</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $payment->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $payment->reference }}</td>
                        <td class="px-4 py-3">{{ $payment->details ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $payment->user?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $payment->currency?->symbol ?? '' }}{{ number_format((float) $payment->total, 2) }}</td>
                        <td class="px-4 py-3">{{ $payment->status }}</td>
                        <td class="px-4 py-3"><button wire:click="showPayment({{ $payment->id }})" class="font-medium text-emerald-600 hover:underline">View</button></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->links() }}</div>

    @if ($selectedPayment)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <div class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Payment information</h3>
                    <button wire:click="closePayment" class="text-gray-500 hover:text-gray-700">Close</button>
                </div>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><span class="font-medium">Reference:</span> {{ $selectedPayment->reference }}</p>
                    <p><span class="font-medium">User:</span> {{ $selectedPayment->user?->name ?? '—' }}</p>
                    <p><span class="font-medium">Amount:</span> {{ $selectedPayment->currency?->symbol ?? '' }}{{ number_format((float) $selectedPayment->total, 2) }}</p>
                    <p><span class="font-medium">Status:</span> {{ $selectedPayment->status }}</p>
                    <p><span class="font-medium">Gateway:</span> {{ $selectedPayment->gateway ?? '—' }}</p>
                    <p><span class="font-medium">Details:</span> {{ $selectedPayment->details ?? '—' }}</p>
                </div>
            </div>
        </div>
    @endif
</x-admin.page>
