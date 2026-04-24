<div>
    <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
        <div class="max-w-3xl mx-auto px-4 text-center py-16">
        <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Landed Properties</h1>
        <p class="text-emerald-200 text-xl">Find your dream landed property from verified owners</p>
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

  <!-- Properties Grid -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <p class="text-gray-500 text-base">Showing <span class="font-semibold text-gray-900">18</span> landed properties</p>
      <select class="border-none bg-transparent text-gray-700 font-medium outline-none text-sm">
        <option>Newest First</option>
        <option>Price: Low to High</option>
        <option>Price: High to Low</option>
      </select>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Property 1 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Property" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
          <span class="absolute top-3 left-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Sale</span>
          <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow"><i class="ri-heart-line text-gray-400"></i></button>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">Luxury 5-Bedroom Duplex</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Ikorodu, Lagos</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 5 Beds</span>
            <span><i class="ri-briefcase-line"></i> 5 Baths</span>
            <span><i class="ri-ruler-line"></i> 450sqft</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦65,000,000</span>
            <a href="#" class="text-emerald-600 font-medium text-sm hover:underline">View Details</a>
          </div>
        </div>
      </div>

      <!-- Property 2 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Property" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
          <span class="absolute top-3 left-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Sale</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">4-Bedroom Bungalow</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Gbaga, Ikorodu</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 4 Beds</span>
            <span><i class="ri-briefcase-line"></i> 3 Baths</span>
            <span><i class="ri-ruler-line"></i> 300sqft</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦35,000,000</span>
            <a href="#" class="text-emerald-600 font-medium text-sm hover:underline">View Details</a>
          </div>
        </div>
      </div>

      <!-- Property 3 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Property" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
          <span class="absolute top-3 left-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Sale</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">6-Bedroom Mansion</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Agric, Ikorodu</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 6 Beds</span>
            <span><i class="ri-briefcase-line"></i> 7 Baths</span>
            <span><i class="ri-ruler-line"></i> 700sqft</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦120,000,000</span>
            <a href="#" class="text-emerald-600 font-medium text-sm hover:underline">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center gap-2 mt-12">
      <button class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400"><i class="ri-arrow-left-s-line"></i></button>
      <button class="w-10 h-10 flex items-center justify-center rounded-lg text-white bg-emerald-600">1</button>
      <button class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50">2</button>
      <button class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-lg text-gray-500"><i class="ri-arrow-right-s-line"></i></button>
    </div>
  </main>
</div>
