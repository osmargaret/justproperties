<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <section class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-xl bg-white p-6 shadow-md">
                        <p class="text-sm text-gray-500">Active properties</p>
                        <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ $activeListings }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-6 shadow-md">
                        <p class="text-sm text-gray-500">Pending review</p>
                        <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $pendingListings }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-6 shadow-md">
                        <p class="text-sm text-gray-500">Promotions</p>
                        <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ $promotionsCount }}</p>
                    </div>
                </div>

                <section class="rounded-xl bg-white p-6 shadow-md">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="text-xl font-semibold">Properties you posted recently</h2>
                        <a href="{{ route('seller.listed-properties') }}" class="text-sm font-medium text-emerald-700 hover:underline">View all</a>
                    </div>
                    @forelse ($properties as $property)
                        <a href="{{ route('seller.properties.show', $property) }}" class="flex items-center gap-4 border-t border-gray-100 py-4 first:border-0">
                            <img src="{{ $property->media->first()?->url ?? '' }}" alt="" class="h-16 w-20 rounded-lg bg-gray-100 object-cover">
                            <span class="min-w-0 flex-1">
                                <span class="block truncate font-medium text-gray-900">{{ $property->name }}</span>
                                <span class="text-sm text-gray-500">{{ ucfirst($property->status) }} · {{ $property->created_at?->diffForHumans() }}</span>
                            </span>
                            <i class="ri-arrow-right-line text-gray-400"></i>
                        </a>
                    @empty
                        <p class="border-t border-gray-100 py-4 text-sm text-gray-500">You have not posted a property yet.</p>
                    @endforelse
                    <a href="{{ route('list-property') }}" class="mt-2 inline-flex items-center gap-2 text-sm font-medium text-emerald-700 hover:underline">
                        <i class="ri-add-line"></i> List a property
                    </a>
                </section>

                <section class="rounded-xl bg-white p-6 shadow-md">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="text-xl font-semibold">Blog posts you viewed</h2>
                        <a href="{{ route('blog') }}" class="text-sm font-medium text-emerald-700 hover:underline">Browse blog</a>
                    </div>
                    @forelse ($viewedPosts as $view)
                        @if ($view->post)
                            <a href="{{ route('post', $view->post) }}" class="flex items-center gap-4 border-t border-gray-100 py-4 first:border-0">
                                <img src="{{ $view->post->media->first()?->url ?? '' }}" alt="" class="h-16 w-20 rounded-lg bg-gray-100 object-cover">
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate font-medium text-gray-900">{{ $view->post->title }}</span>
                                    <span class="text-sm text-gray-500">Viewed {{ $view->updated_at?->diffForHumans() }}</span>
                                </span>
                                <i class="ri-arrow-right-line text-gray-400"></i>
                            </a>
                        @endif
                    @empty
                        <p class="border-t border-gray-100 py-4 text-sm text-gray-500">Blog posts you view will appear here.</p>
                    @endforelse
                </section>
            </section>
        </div>
    </main>
</div>
