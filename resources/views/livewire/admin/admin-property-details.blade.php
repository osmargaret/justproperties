<x-admin.page title="Property details" description="Full listing details and moderation history.">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-lg border border-gray-200 p-4">
            <h3 class="mb-2 font-semibold text-gray-900">{{ $property->name }}</h3>
            <p class="text-sm text-gray-600">{{ $property->description }}</p>
            <div class="mt-3 space-y-1 text-sm text-gray-600">
                <p><span class="font-medium">Owner:</span> {{ $property->user?->name ?? '—' }}</p>
                <p><span class="font-medium">Category:</span> {{ $property->category?->name ?? '—' }}</p>
                <p><span class="font-medium">Status:</span> {{ $property->status }}</p>
            </div>
        </div>
        <div class="rounded-lg border border-gray-200 p-4">
            <h3 class="mb-2 font-semibold text-gray-900">Subscription seats</h3>
            <p class="text-sm text-gray-600 mb-3">Each row is a seat used on the owner&apos;s subscription (via <code class="text-xs">subscribed_properties</code>).</p>
            @if ($property->subscribedPropertyLinks->isEmpty())
                <p class="text-sm text-gray-500">Not assigned to any subscription.</p>
            @else
                <ul class="space-y-2 text-sm">
                    @foreach ($property->subscribedPropertyLinks as $link)
                        <li class="rounded border border-gray-100 px-3 py-2">
                            <span class="font-medium">{{ $link->subscription?->plan?->name ?? 'Plan' }}</span>
                            <span class="text-gray-500">· {{ ucfirst($link->subscription?->status ?? 'unknown') }}</span>
                            @if ($link->subscription?->end_at)
                                <span class="text-gray-400 text-xs block">Ends {{ $link->subscription->end_at->format('M d, Y') }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            <p class="text-sm text-gray-600 mt-4">Promotions: {{ $property->promotions->count() }}</p>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <button wire:click="approve" type="button" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Approve</button>
        <button wire:click="disapprove" type="button" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Disapprove</button>
        <button wire:click="delete" wire:confirm="Delete this property?" type="button" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white">Delete</button>
    </div>

    <div class="mt-6 rounded-lg border border-gray-200">
        <div class="border-b border-gray-200 px-4 py-3 font-medium text-gray-900">Moderation history</div>
        <div class="divide-y divide-gray-100">
            @forelse ($moderations as $moderation)
                <div class="px-4 py-3 text-sm text-gray-700">
                    <span class="font-medium">{{ $moderation->action }}</span> ({{ $moderation->status }}) · {{ $moderation->created_at->format('Y-m-d H:i') }}
                </div>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500">No moderation history yet.</div>
            @endforelse
        </div>
    </div>

    <a href="{{ route('admin.properties') }}" class="mt-6 inline-flex text-sm font-medium text-emerald-600 hover:text-emerald-700">← Back to properties</a>
</x-admin.page>
