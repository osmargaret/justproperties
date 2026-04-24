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
      <p class="text-gray-500 text-base">Showing <span class="font-semibold">15</span> rental properties</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Property 1 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover hover:scale-105 transition" />
          <span class="absolute top-3 left-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Rent</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">Modern 2-Bedroom Apartment</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Ogba, Ikeja</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 2 Beds</span>
            <span><i class="ri-briefcase-line"></i> 2 Baths</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦2,500,000/yr</span>
            <a href="#" class="text-emerald-600 font-medium text-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Property 2 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover hover:scale-105 transition" />
          <span class="absolute top-3 left-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Lease</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">4-Bedroom Duplex</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Ikorodu</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 4 Beds</span>
            <span><i class="ri-briefcase-line"></i> 3 Baths</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦4,200,000/yr</span>
            <a href="#" class="text-emerald-600 font-medium text-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Property 3 -->
      <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition border border-gray-100">
        <div class="relative h-56 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover hover:scale-105 transition" />
          <span class="absolute top-3 left-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">For Rent</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">3-Bedroom Flat</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Victoria Island</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 3 Beds</span>
            <span><i class="ri-briefcase-line"></i> 3 Baths</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦6,000,000/yr</span>
            <a href="#" class="text-emerald-600 font-medium text-sm">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
