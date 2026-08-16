<div>
  <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
    <div class="max-w-3xl mx-auto px-4 text-center py-16">
      <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Facilities</h1>
      <p class="text-emerald-200 text-xl">Find your dream facility from verified owners</p>
    </div>
  </div>

  <!-- Filter -->
  <div class="bg-stone-50 border-b border-gray-200 sticky top-16 sm:top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex flex-wrap gap-3 items-center">
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-gray-700 cursor-pointer outline-none focus:border-emerald-500 text-sm">
            <option>Location</option>
            <option>Ikorodu</option>
            <option>Lekki</option>
            <option>Ajah</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-gray-700 cursor-pointer outline-none focus:border-emerald-500 text-sm">
            <option>Property Type</option>
            <option>Duplex</option>
            <option>Bungalow</option>
            <option>Mansion</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-gray-700 cursor-pointer outline-none focus:border-emerald-500 text-sm">
            <option>Price Range</option>
            <option>₦0 - ₦20M</option>
            <option>₦20M - ₦50M</option>
            <option>₦50M - ₦100M</option>
            <option>₦100M+</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-gray-700 cursor-pointer outline-none focus:border-emerald-500 text-sm">
            <option>Bedrooms</option>
            <option>2 Beds</option>
            <option>3 Beds</option>
            <option>4 Beds</option>
            <option>5+ Beds</option>
          </select>
        </div>
        <button class="px-6 py-2.5 text-white font-medium rounded-lg transition hover:-translate-y-1 whitespace-nowrap bg-emerald-600 text-sm">
          <i class="ri-search-line mr-2"></i>Search
        </button>
      </div>
    </div>
  </div>

  <main class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <p class="text-gray-500 text-base">Showing <span class="font-semibold">{{ $this->properties->total() }}</span> completed properties</p>
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
