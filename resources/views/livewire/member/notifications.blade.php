<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')
        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <section class="rounded-xl bg-white p-6 shadow-md">
                <div class="mb-6 flex items-center justify-between gap-4 border-b border-gray-200 pb-4">
                    <div>
                        <h1 class="text-2xl font-semibold">Notifications</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $unreadCount }} unread</p>
                    </div>
                    @if ($unreadCount > 0)
                        <button type="button" wire:click="markAllAsRead" class="text-sm font-medium text-emerald-700 hover:underline">Mark all as read</button>
                    @endif
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($notifications as $notification)
                        @php($data = $notification->data)
                        <article class="flex items-start gap-4 py-4 {{ $notification->read_at ? 'opacity-70' : '' }}">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-700">
                                <i class="{{ ($data['kind'] ?? '') === 'property_alert' ? 'ri-home-4-line' : 'ri-article-line' }}"></i>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-900">{{ $data['title'] ?? 'Update' }}</p>
                                <p class="mt-1 text-sm text-gray-600">{{ $data['message'] ?? '' }}</p>
                                <p class="mt-2 text-xs text-gray-400">{{ $notification->created_at?->diffForHumans() }}</p>
                                @if (! empty($data['url']))
                                    <a href="{{ $data['url'] }}" class="mt-2 inline-block text-sm font-medium text-emerald-700 hover:underline">View update</a>
                                @endif
                            </div>
                            @if (! $notification->read_at)
                                <button type="button" wire:click="markAsRead('{{ $notification->id }}')" class="shrink-0 text-xs text-gray-500 hover:text-emerald-700">Mark read</button>
                            @endif
                        </article>
                    @empty
                        <p class="py-8 text-center text-sm text-gray-500">Property alerts and blog updates will appear here.</p>
                    @endforelse
                </div>
                <div class="mt-6">{{ $notifications->links() }}</div>
            </section>
        </div>
    </main>
</div>
