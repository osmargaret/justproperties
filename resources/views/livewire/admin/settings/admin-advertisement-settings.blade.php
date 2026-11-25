<x-admin.page title="Advertising Settings" description="Manage advertising spaces, plans, and prices in each configured currency.">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex gap-2">
            <button wire:click="setTab('spaces')" class="rounded-lg px-4 py-2 text-sm font-semibold {{ $activeTab === 'spaces' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">Spaces</button>
            <button wire:click="setTab('plans')" class="rounded-lg px-4 py-2 text-sm font-semibold {{ $activeTab === 'plans' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">Plans &amp; prices</button>
        </div>
        <button wire:click="{{ $activeTab === 'spaces' ? 'openCreateSpace' : 'openCreatePlan' }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
            {{ $activeTab === 'spaces' ? 'Add Space' : 'Add Plan' }}
        </button>
    </div>

    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search {{ $activeTab }}..." class="mb-4 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm md:max-w-sm">

    @if ($activeTab === 'spaces')
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-left text-sm">
                <thead class="border-b bg-gray-50 text-gray-600">
                    <tr><th class="px-4 py-3">Name</th><th class="px-4 py-3">Format</th><th class="px-4 py-3">Dimensions</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($spaces as $space)
                        <tr>
                            <td class="px-4 py-3"><strong>{{ $space->name }}</strong><div class="text-xs text-gray-500">{{ $space->slug }}</div></td>
                            <td class="px-4 py-3">{{ $space->format ?: '—' }}</td>
                            <td class="px-4 py-3">{{ $space->dimensions ?: '—' }}</td>
                            <td class="px-4 py-3">{{ $space->is_active ? 'Active' : 'Inactive' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <button wire:click="openEditSpace({{ $space->id }})" class="text-emerald-700 hover:underline">Edit</button>
                                <button wire:click="deleteSpace({{ $space->id }})" wire:confirm="Delete this advertising space?" class="ml-3 text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No advertising spaces found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $spaces->links() }}</div>
    @else
        <div class="space-y-3">
            @forelse ($plans as $plan)
                <section class="rounded-lg border border-gray-200 bg-white p-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $plan->name }} <span class="text-xs font-normal text-gray-500">({{ $plan->slug }})</span></h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $plan->description ?: 'No description' }}</p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $plan->billing_quantity }} {{ $plan->billing_period }}{{ $plan->billing_quantity === 1 ? '' : 's' }}
                                · {{ $plan->impressions_included ? number_format($plan->impressions_included).' impressions' : 'Impressions not specified' }}
                                · {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </p>
                            @if ($plan->features)
                                <ul class="mt-2 list-inside list-disc text-xs text-gray-600">
                                    @foreach ($plan->features as $feature)<li>{{ $feature }}</li>@endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="whitespace-nowrap">
                            <button wire:click="openEditPlan({{ $plan->id }})" class="text-emerald-700 hover:underline">Edit</button>
                            <button wire:click="deletePlan({{ $plan->id }})" wire:confirm="Delete this advertising plan?" class="ml-3 text-red-600 hover:underline">Delete</button>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($plan->spaces as $space)
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-700">{{ $space->name }}</span>
                        @endforeach
                    </div>
                    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-sm">
                        @foreach ($plan->prices as $price)
                            <span>{{ $price->currency?->currency_code }} {{ number_format((float) $price->amount, 2) }}{{ $price->is_default ? ' (default)' : '' }}</span>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="rounded-lg border border-gray-200 p-6 text-center text-sm text-gray-500">No advertising plans found.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $plans->links() }}</div>
    @endif

    @if ($showSpaceModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <form wire:submit="saveSpace" class="w-full max-w-xl space-y-4 rounded-xl bg-white p-6 shadow-xl">
                <div class="flex justify-between"><h2 class="text-lg font-semibold">{{ $editingSpaceId ? 'Edit Space' : 'Add Space' }}</h2><button type="button" wire:click="$set('showSpaceModal', false)">Close</button></div>
                <div class="grid gap-3 md:grid-cols-2">
                    <label class="text-sm">Name<input wire:model="spaceName" class="mt-1 w-full rounded border-gray-300">@error('spaceName')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm">Slug<input wire:model="spaceSlug" class="mt-1 w-full rounded border-gray-300">@error('spaceSlug')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm">Format<input wire:model="spaceFormat" class="mt-1 w-full rounded border-gray-300"></label>
                    <label class="text-sm">Dimensions<input wire:model="spaceDimensions" class="mt-1 w-full rounded border-gray-300"></label>
                    <label class="text-sm">Icon class<input wire:model="spaceIcon" class="mt-1 w-full rounded border-gray-300"></label>
                    <label class="text-sm">Sort order<input type="number" wire:model="spaceSortOrder" class="mt-1 w-full rounded border-gray-300"></label>
                </div>
                <label class="block text-sm">Description<textarea wire:model="spaceDescription" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea></label>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="spaceIsActive"> Active</label>
                <div class="flex justify-end gap-2"><button type="button" wire:click="$set('showSpaceModal', false)" class="rounded border px-4 py-2">Cancel</button><button class="rounded bg-emerald-600 px-4 py-2 text-white">Save Space</button></div>
            </form>
        </div>
    @endif

    @if ($showPlanModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
            <form wire:submit="savePlan" class="max-h-[90vh] w-full max-w-3xl space-y-4 overflow-y-auto rounded-xl bg-white p-6 shadow-xl">
                <div class="flex justify-between"><h2 class="text-lg font-semibold">{{ $editingPlanId ? 'Edit Plan' : 'Add Plan' }}</h2><button type="button" wire:click="$set('showPlanModal', false)">Close</button></div>
                <div class="grid gap-3 md:grid-cols-2">
                    <label class="text-sm">Name<input wire:model="planName" class="mt-1 w-full rounded border-gray-300">@error('planName')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm">Slug<input wire:model="planSlug" class="mt-1 w-full rounded border-gray-300">@error('planSlug')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm">Billing quantity<input type="number" min="1" wire:model="billingQuantity" class="mt-1 w-full rounded border-gray-300"></label>
                    <label class="text-sm">Billing period<select wire:model="billingPeriod" class="mt-1 w-full rounded border-gray-300">@foreach (['day', 'week', 'month', 'year', 'email'] as $period)<option value="{{ $period }}">{{ ucfirst($period) }}</option>@endforeach</select></label>
                    <label class="text-sm">Impressions included<input type="number" min="0" wire:model="impressionsIncluded" class="mt-1 w-full rounded border-gray-300"></label>
                </div>
                <label class="block text-sm">Description<textarea wire:model="planDescription" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea></label>
                <label class="block text-sm">Plan features <span class="text-xs text-gray-500">(one per line)</span><textarea wire:model="planFeatures" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea></label>
                <div>
                    <h3 class="mb-2 text-sm font-semibold">Included spaces</h3>
                    <p class="mb-2 text-xs text-gray-500">Leave unselected for packages where the exact placement is chosen separately.</p>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($allSpaces as $space)
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="selectedSpaceIds" value="{{ $space->id }}"> {{ $space->name }}{{ $space->is_active ? '' : ' (inactive)' }}</label>
                        @endforeach
                    </div>
                    @error('selectedSpaceIds')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <div>
                    <div class="mb-2 flex items-center justify-between"><h3 class="text-sm font-semibold">Prices</h3><button type="button" wire:click="addPriceRow" class="text-sm text-emerald-700 hover:underline">Add currency</button></div>
                    @foreach ($priceRows as $index => $row)
                        <div class="mb-2 grid items-end gap-2 sm:grid-cols-[1fr_1fr_auto_auto]">
                            <label class="text-xs">Currency<select wire:model="priceRows.{{ $index }}.currency_id" class="mt-1 w-full rounded border-gray-300 text-sm">@foreach ($currencies as $currency)<option value="{{ $currency->id }}">{{ $currency->currency_code }} — {{ $currency->currency_name }}</option>@endforeach</select></label>
                            <label class="text-xs">Amount<input type="number" min="0" step="0.01" wire:model="priceRows.{{ $index }}.amount" class="mt-1 w-full rounded border-gray-300 text-sm"></label>
                            <label class="flex items-center gap-1 pb-2 text-xs"><input type="checkbox" wire:model="priceRows.{{ $index }}.is_default"> Default</label>
                            <button type="button" wire:click="removePriceRow({{ $index }})" class="pb-2 text-sm text-red-600">Remove</button>
                        </div>
                    @endforeach
                    @error('priceRows')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="planIsActive"> Active</label>
                <div class="flex justify-end gap-2"><button type="button" wire:click="$set('showPlanModal', false)" class="rounded border px-4 py-2">Cancel</button><button class="rounded bg-emerald-600 px-4 py-2 text-white">Save Plan</button></div>
            </form>
        </div>
    @endif
</x-admin.page>
