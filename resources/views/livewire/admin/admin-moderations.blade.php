<x-admin.page title="Moderations" description="Review and manage pending items for approval.">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <div class="mb-4 flex gap-2">
        <button type="button" wire:click="$set('filter', 'pending')" class="rounded-lg px-3 py-1 text-sm font-medium {{ $filter === 'pending' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">Pending</button>
        <button type="button" wire:click="$set('filter', 'processed')" class="rounded-lg px-3 py-1 text-sm font-medium {{ $filter === 'processed' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">Processed</button>
        <button type="button" wire:click="$set('filter', 'all')" class="rounded-lg px-3 py-1 text-sm font-medium {{ $filter === 'all' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">All</button>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2">Item</th>
                    <th class="px-3 py-2">Owner</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Moderated By</th>
                    <th class="px-3 py-2">Reason</th>
                    <th class="px-3 py-2">Moderated At</th>
                    <th class="px-3 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($moderations as $moderation)
                    <tr>
                        <td class="px-3 py-2">
                            @if($moderation->moderatable)
                                @if($moderation->moderatable_type === 'property')
                                    <a href="{{ route('admin.properties.show', $moderation->moderatable->id, absolute: false) }}" class="text-emerald-600 hover:underline" target="_blank">
                                        {{ $moderation->moderatable->name ?? '—' }}
                                    </a>
                                @elseif($moderation->moderatable_type === 'user')
                                    {{ $moderation->moderatable->name ?? '—' }}
                                @else
                                    {{ class_basename($moderation->moderatable_type) }} #{{ $moderation->moderatable_id }}
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if($moderation->moderatable_type === 'property')
                                {{ $moderation->moderatable->user->name ?? '—' }}
                            @elseif($moderation->moderatable_type === 'user')
                                {{ $moderation->moderatable->role?->name ?? '—' }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ $moderation->moderatable_type ? class_basename($moderation->moderatable_type) : '—' }}</td>
                        <td class="px-3 py-2">
                            @if($moderation->status === 'pending')
                                <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Pending</span>
                            @elseif($moderation->status === 'approved')
                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-800">Approved</span>
                            @else
                                <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ $moderation->moderator->name ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-500">{{ $moderation->reason ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-500">{{ $moderation->created_at?->diffForHumans() ?? '—' }}</td>
                        <td class="px-3 py-2">
                            @if($moderation->status === 'pending')
                                <button type="button" wire:click="approve({{ $moderation->id }})" class="text-emerald-600 hover:underline">Approve</button>
                                <button type="button" wire:click="reject({{ $moderation->id }})" wire:confirm="{{ __('Reject this item?') }}" class="ml-2 text-red-600 hover:underline">Reject</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No moderations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.page>