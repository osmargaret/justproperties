<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')
        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <section class="rounded-xl bg-white p-6 shadow-md">
                <h1 class="mb-6 border-b border-gray-200 pb-4 text-2xl font-semibold">Bookmarks</h1>
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('status') }}</div>
                @endif
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @forelse ($bookmarks as $bookmark)
                        @if ($bookmark->property)
                            <article class="overflow-hidden rounded-lg border border-gray-200">
                                <a href="{{ route('property.show', $bookmark->property) }}">
                                    <img src="{{ $bookmark->property->media->first()?->url ?? '' }}" alt="" class="h-44 w-full bg-gray-100 object-cover">
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('property.show', $bookmark->property) }}" class="font-semibold text-gray-900 hover:text-emerald-700">{{ $bookmark->property->name }}</a>
                                    <p class="mt-1 text-sm text-gray-500">{{ $bookmark->property->display_location }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="font-semibold text-emerald-700">{{ $bookmark->property->currency }}{{ number_format((float) $bookmark->property->cost) }}</span>
                                        <button type="button" wire:click="remove({{ $bookmark->id }})" class="text-sm text-red-600 hover:underline">Remove bookmark</button>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @empty
                        <p class="text-sm text-gray-500">Properties you bookmark will appear here.</p>
                    @endforelse
                </div>
                <div class="mt-6">{{ $bookmarks->links() }}</div>
            </section>
        </div>
    </main>
</div>
