<div>
    <!-- Hero -->
  <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
    <div class="max-w-3xl mx-auto px-4 text-center py-16">
      <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Rent & Lease Properties</h1>
      <p class="text-emerald-200 text-xl">Find rental properties from verified owners</p>
    </div>
  </div>

  <!-- Filter -->
  <div class="bg-stone-50 border-b border-gray-200 sticky top-16 sm:top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex flex-wrap gap-3 items-center">
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option>Location</option>
            <option>Ikorodu</option><option>Lekki</option><option>Ikoyi</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option>Property Type</option>
            <option>Apartment</option><option>Duplex</option><option>House</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Bedrooms</option>
            <option value="2">2 Bedrooms</option>
            <option value="3">3 Bedrooms</option>
            <option value="4">4 Bedrooms</option>
            <option value="5">5 Bedrooms</option>
            <option value="6">6+ Bedrooms</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option>Price Range</option>
            <option>₦500k - ₦1M</option><option>₦1M - ₦3M</option><option>₦3M - ₦5M</option><option>₦5M+</option>
          </select>
        </div>
        <button class="px-6 py-2.5 text-white font-medium rounded-lg bg-emerald-600 text-sm">
          <i class="ri-search-line mr-2"></i>Search
        </button>
      </div>
    </div>
  </div>
  

  <!-- Properties -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <p class="text-gray-500 text-base">Showing <span class="font-semibold">{{ $this->properties->total() }}</span> rental properties</p>
    </div>

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
