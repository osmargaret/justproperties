<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')
        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <section class="space-y-6">
                <div class="rounded-xl bg-white p-6 shadow-md">
                    <h1 class="text-2xl font-semibold">Promotions</h1>
                    <p class="mt-2 text-sm text-gray-500">Promote a property to reach more people. Property listings are free; you only pay for promotions.</p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-md">
                    <h2 class="mb-4 text-lg font-semibold">Your properties</h2>
                    <div class="divide-y divide-gray-100">
                        @forelse ($properties as $property)
                            <div class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $property->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $property->promotions_count }} promotion(s)</p>
                                </div>
                                <a href="{{ route('seller.properties.show', $property) }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-emerald-700">Manage promotions</a>
                            </div>
                        @empty
                            <p class="py-4 text-sm text-gray-500">List a property before creating a promotion.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('list-property') }}" class="mt-4 inline-flex text-sm font-medium text-emerald-700 hover:underline">List a property</a>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-md">
                    <h2 class="mb-4 text-lg font-semibold">Promotion history</h2>
                    <div class="divide-y divide-gray-100">
                        @forelse ($promotions as $promotion)
                            <div class="flex items-center justify-between gap-4 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $promotion->plan?->name ?? 'Promotion' }}</p>
                                    <p class="text-sm text-gray-500">{{ $promotion->property?->name }} · {{ ucfirst(str_replace('_', ' ', $promotion->status)) }}</p>
                                </div>
                                @if ($promotion->property)
                                    <a href="{{ route('seller.properties.show', $promotion->property) }}" class="text-sm font-medium text-emerald-700 hover:underline">View</a>
                                @endif
                            </div>
                        @empty
                            <p class="py-4 text-sm text-gray-500">You have not created a promotion yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>
