@props([
    'title',
    'description' => null,
])
<div class="min-w-0 w-full">
    <main class="white-header min-w-0 w-full max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid min-w-0 grid-cols-1 lg:grid-cols-[300px_minmax(0,1fr)] gap-8">
            @include('layouts.admin-sidebar')

            <div class="min-w-0 bg-white rounded-xl p-8 shadow-md overflow-hidden">
                <div class="mb-8 pb-4 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-900">{{ $title }}</h2>
                    @if($description)
                        <p class="text-gray-500 text-sm mt-1">{{ $description }}</p>
                    @endif
                </div>
                {{ $slot }}
            </div>
        </div>
    </main>
</div>
