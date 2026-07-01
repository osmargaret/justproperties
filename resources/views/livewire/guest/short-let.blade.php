<div>
  <!-- Hero -->
  <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
    <div class="max-w-3xl mx-auto px-4 text-center py-16">
      <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Short-Let Apartments</h1>
      <p class="text-emerald-200 text-xl">Browse fully furnished apartments for daily, weekly, or monthly rental</p>
    </div>
  </div>

  <!-- Filter -->
  <div class="bg-stone-50 border-b border-gray-200 sticky top-16 sm:top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex flex-wrap gap-3 items-center">
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">All Locations</option>
            <option value="ikorodu">Ikorodu</option>
            <option value="lekki">Lekki</option>
            <option value="ajah">Ajah</option>
            <option value="ikeja">Ikeja</option>
            <option value="vi">Victoria Island</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Property Type</option>
            <option value="duplex">Detached Duplex</option>
            <option value="semi-duplex">Semi-Detached Duplex</option>
            <option value="terrace">Terrace Duplex</option>
            <option value="bungalow">Bungalow</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Bedrooms</option>
            <option value="2">2 Bedrooms</option>
            <option value="3">3 Bedrooms</option>
            <option value="4">4 Bedrooms</option>
            <option value="5">5 Bedrooms</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Daily Rate</option>
            <option value="0-15k">Under ₦15K</option>
            <option value="15k-25k">₦15K - ₦25K</option>
            <option value="25k-40k">₦25K - ₦40K</option>
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
      <p class="text-gray-500 text-base">Showing <span class="font-semibold">{{ $this->properties->total() }}</span> short-let properties</p>
    </div>

    <!-- Property Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
      @forelse($this->properties as $property)
        @include('livewire.guest.partials.property-card', ['property' => $property])
      @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 py-12 text-center text-gray-500">
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
