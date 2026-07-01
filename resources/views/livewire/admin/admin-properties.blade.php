<x-admin.page title="Properties" description="Property moderation queue and actions.">
    <div class="mb-4 grid grid-cols-1 gap-3 md:grid-cols-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search user or property..." class="rounded-lg border border-gray-200 px-3 py-2 text-sm" />
        <select wire:model.live="category" class="rounded-lg border border-gray-200 px-3 py-2 text-sm">
            <option value="">All categories</option>
            @foreach ($categories as $categoryOption)
                <option value="{{ $categoryOption->id }}">{{ $categoryOption->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="status" class="rounded-lg border border-gray-200 px-3 py-2 text-sm">
            <option value="">All statuses</option>
            @foreach ($statusOptions as $statusOption)
                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
            @endforeach
        </select>
        <button wire:click="$set('sortDir', $sortDir === 'asc' ? 'desc' : 'asc')" class="rounded-lg border px-3 py-2 text-sm">Toggle Date Sort</button>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Date Listed</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Category &amp; Type</th>
                    <th class="px-4 py-3">Property</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($properties as $property)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $property->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ $property->user?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $property->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.properties.show', ['property' => $property->id]) }}" class="text-emerald-600 hover:underline">{{ $property->name }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $property->status }}</td>
                        </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No properties found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $properties->links() }}</div>
</x-admin.page>
