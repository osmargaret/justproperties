<div>
    <!-- Hero Header -->
    <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
        <div class="max-w-3xl mx-auto px-4 text-center py-16">
            <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Rent & Lease Properties</h1>
            <p class="text-emerald-200 text-xl">Find rental homes, lease apartments, and commercial spaces</p>
        </div>
    </div>

    <!-- Dynamic Off-Canvas Filter Bar & Drawer -->
    @include('livewire.guest.partials.offcanvas-filter')

    <!-- Properties Grid Section -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($this->properties as $property)
                @include('livewire.guest.partials.property-card', ['property' => $property])
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 py-12 text-center text-gray-500">
                    <i class="ri-home-smile-line text-4xl mb-3 block text-gray-300"></i>
                    <p class="text-lg">No properties found in this category yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $this->properties->links() }}
        </div>
    </main>
</div>
