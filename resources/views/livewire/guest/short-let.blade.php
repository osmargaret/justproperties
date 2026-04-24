<div>
    <!-- Hero Section -->
  <section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
      <img src="https://readdy.ai/api/search-image?query=luxury%20furnished%20serviced%20apartment%20for%20short%20let%20in%20Lagos%20with%20modern%20interior%2C%20swimming%20pool%2C%20city%20view%2C%20contemporary%20design%2C%20vacation%20rental%20Nigeria&width=1920&height=600&seq=shortlet-hero&orientation=landscape" alt="Short-Let Apartments" class="w-full h-full object-cover" />
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/70"></div>
    </div>
    <div class="relative z-10 max-w-3xl mx-auto px-4 py-16 md:py-24 text-center">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Short-Let Apartments</h1>
      <p class="text-lg md:text-xl text-emerald-100 font-light">Browse fully furnished apartments for daily, weekly, or monthly rental</p>
    </div>
  </section>

  <!-- Filter Bar -->
  <section class="sticky top-16 md:top-20 z-40 bg-stone-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex flex-wrap gap-3 items-center">
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">All Locations</option>
            <option value="ikorodu">Ikorodu</option>
            <option value="lekki">Lekki</option>
            <option value="ajah">Ajah</option>
            <option value="ikeja">Ikeja</option>
            <option value="vi">Victoria Island</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Property Type</option>
            <option value="duplex">Detached Duplex</option>
            <option value="semi-duplex">Semi-Detached Duplex</option>
            <option value="terrace">Terrace Duplex</option>
            <option value="bungalow">Bungalow</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Bedrooms</option>
            <option value="2">2 Bedrooms</option>
            <option value="3">3 Bedrooms</option>
            <option value="4">4 Bedrooms</option>
            <option value="5">5 Bedrooms</option>
          </select>
        </div>
        <div class="flex-1 min-w-[180px]">
          <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">Daily Rate</option>
            <option value="0-15k">Under ₦15K</option>
            <option value="15k-25k">₦15K - ₦25K</option>
            <option value="25k-40k">₦25K - ₦40K</option>
          </select>
        </div>
        <button class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 flex items-center gap-2 whitespace-nowrap">
          <i class="ri-search-line"></i>Apply
        </button>
        <button class="text-gray-500 text-sm hover:text-emerald-600 underline">Reset All</button>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-8 md:py-12">
    <!-- Category Tabs -->
    <div class="flex flex-wrap gap-2 mb-8 pb-4 border-b border-gray-200">
      <button class="px-5 py-2 rounded-full text-sm font-medium bg-emerald-600 text-white">All Properties</button>
      <button class="px-5 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Detached Duplex</button>
      <button class="px-5 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Semi-Detached</button>
      <button class="px-5 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Terrace</button>
      <button class="px-5 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Bungalow</button>
    </div>

    <!-- Results Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
      <div>
        <h2 class="text-2xl md:text-3xl font-bold">89+ Short-Let Apartments Available</h2>
        <p class="text-gray-500 text-sm mt-1">Fully furnished apartments for short-term stay in Lagos</p>
      </div>
      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-500">Sort by:</label>
        <select class="px-3 py-2 border border-gray-200 rounded-lg bg-white text-sm">
          <option value="newest">Newest First</option>
          <option value="price-low">Price: Low to High</option>
          <option value="price-high">Price: High to Low</option>
        </select>
      </div>
    </div>

    <!-- Property Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
      <!-- Property Card 1 -->
      <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
        <div class="relative h-48 md:h-64 overflow-hidden">
          <img src="https://readdy.ai/api/search-image?query=modern%20luxury%20detached%20duplex%20in%20Lekki%20Lagos%20with%20swimming%20pool%20and%20manicured%20garden%2C%20contemporary%20white%20exterior%2C%20large%20windows%2C%20professional%20real%20estate%20photography&width=800&height=600&seq=landed1&orientation=landscape" alt="Luxury Studio Apartment" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" />
          <div class="absolute top-3 left-0 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 text-xs font-bold transform -skew-x-12"><span class="block transform skew-x-12">⭐ BOOSTED</span></div>
          <div class="absolute top-3 right-3 px-2.5 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">Available</div>
          <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5">
            <i class="ri-eye-line text-white text-xs"></i><span class="text-white text-xs">1,247</span>
          </div>
        </div>
        <div class="p-4 md:p-6">
          <h3 class="font-bold text-gray-900 mb-2 text-lg">Luxury Serviced Apartment</h3>
          <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm"><i class="ri-map-pin-line"></i> Victoria Island</div>
          <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> 2 Beds</span>
            <span><i class="ri-briefcase-line"></i> 2 Baths</span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">₦150,000/month</span>
            <a href="#" class="text-emerald-600 font-medium text-sm">View Details</a>
          </div>
        </div>

        
      </div>

      <!-- Property Card 2 -->
      <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
        <div class="relative h-48 md:h-64 overflow-hidden">
          <img src="https://readdy.ai/api/search-image?query=luxury%20furnished%20studio%20apartment%20for%20short%20let%20in%20Lagos%20with%20modern%20interior%2C%20cozy%20bed%2C%20kitchenette%2C%20smart%20TV%2C%20air%20conditioning&width=800&height=600&seq=shortlet1&orientation=landscape" alt="1 Bedroom Serviced Apartment" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" />
          <div class="absolute top-3 right-3 px-2.5 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">Available</div>
          <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5">
            <i class="ri-eye-line text-white text-xs"></i><span class="text-white text-xs">892</span>
          </div>
        </div>
        <div class="p-4 md:p-6">
          <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 truncate">1 Bedroom Serviced Apartment</h3>
          <div class="flex items-center text-gray-500 text-sm mb-3"><i class="ri-map-pin-line mr-1"></i><span class="truncate">Ajah, Lagos</span></div>
          <div class="text-2xl md:text-3xl font-bold text-emerald-600 mb-4">₦35,000/day</div>
          <div class="grid grid-cols-4 gap-2 mb-3">
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-hotel-bed-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">4</div><div class="text-xs text-gray-500">Beds</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-drop-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">5</div><div class="text-xs text-gray-500">Baths</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-ruler-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">320</div><div class="text-xs text-gray-500">sqm</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-home-4-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">Semi-D</div><div class="text-xs text-gray-500">Type</div></div>
          </div>
          <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mb-3">
            <img src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20businesswoman%20portrait%20wearing%20elegant%20blazer%2C%20warm%20smile%2C%20studio%20photography&width=200&height=200&seq=owner2&orientation=squarish" alt="Owner" class="w-10 md:w-12 h-10 md:h-12 rounded-full object-cover" />
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-1"><span class="text-sm font-semibold text-gray-900 truncate">Chioma Okafor</span><i class="ri-verified-badge-fill text-blue-500 text-sm"></i></div>
              <p class="text-xs text-gray-500">Property Owner</p>
            </div>
          </div>
          <button class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"><i class="ri-whatsapp-line"></i>WhatsApp Owner</button>
          <div class="flex gap-2 mt-2">
            <a href="tel:08067042140" class="flex-1 py-2 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl flex items-center justify-center gap-1 text-sm"><i class="ri-phone-line"></i>Call</a>
            <a href="mailto:louis670421@gmail.com" class="flex-1 py-2 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl flex items-center justify-center gap-1 text-sm"><i class="ri-mail-line"></i>Email</a>
          </div>
        </div>
      </div>

      <!-- Property Card 3 -->
      <div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
        <div class="relative h-48 md:h-64 overflow-hidden">
          <img src="https://readdy.ai/api/search-image?query=luxury%20four%20bedroom%20terrace%20house%20with%20private%20swimming%20pool%2C%20modern%20architecture%2C%20glass%20railings%2C%20outdoor%20lounge%20area%2C%20manicured%20lawn&width=800&height=600&seq=landed3&orientation=landscape" alt="Luxury 2 Bedroom Apartment" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" />
          <div class="absolute top-3 left-0 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 text-xs font-bold transform -skew-x-12"><span class="block transform skew-x-12">⭐ BOOSTED</span></div>
          <div class="absolute top-3 right-3 px-2.5 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">Available</div>
          <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5">
            <i class="ri-eye-line text-white text-xs"></i><span class="text-white text-xs">3,421</span>
          </div>
        </div>
        <div class="p-4 md:p-6">
          <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 truncate">Luxury 2 Bedroom Apartment</h3>
          <div class="flex items-center text-gray-500 text-sm mb-3"><i class="ri-map-pin-line mr-1"></i><span class="truncate">Banana Island, Lagos</span></div>
          <div class="text-2xl md:text-3xl font-bold text-emerald-600 mb-4">₦55,000/day</div>
          <div class="grid grid-cols-4 gap-2 mb-3">
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-hotel-bed-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">4</div><div class="text-xs text-gray-500">Beds</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-drop-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">5</div><div class="text-xs text-gray-500">Baths</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-ruler-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">380</div><div class="text-xs text-gray-500">sqm</div></div>
            <div class="bg-gray-50 rounded-lg p-2 text-center"><i class="ri-home-4-line text-gray-500 text-sm mb-1"></i><div class="text-xs font-semibold">Terrace</div><div class="text-xs text-gray-500">Type</div></div>
          </div>
          <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mb-3">
            <img src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20woman%20portrait%20wearing%20elegant%20hijab%20and%20business%20attire%2C%20warm%20smile&width=200&height=200&seq=owner3&orientation=squarish" alt="Owner" class="w-10 md:w-12 h-10 md:h-12 rounded-full object-cover" />
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-1"><span class="text-sm font-semibold text-gray-900 truncate">Aisha Bello</span><i class="ri-verified-badge-fill text-blue-500 text-sm"></i></div>
              <p class="text-xs text-gray-500">Property Owner</p>
            </div>
          </div>
          <button class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"><i class="ri-whatsapp-line"></i>WhatsApp Owner</button>
          <div class="flex gap-2 mt-2">
            <a href="tel:08067042140" class="flex-1 py-2 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl flex items-center justify-center gap-1 text-sm"><i class="ri-phone-line"></i>Call</a>
            <a href="mailto:louis670421@gmail.com" class="flex-1 py-2 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl flex items-center justify-center gap-1 text-sm"><i class="ri-mail-line"></i>Email</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex flex-wrap justify-center items-center gap-2 mt-12">
      <button class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 cursor-not-allowed opacity-50"><i class="ri-arrow-left-s-line"></i></button>
      <button class="w-10 h-10 border-2 border-emerald-600 bg-emerald-600 text-white rounded-lg flex items-center justify-center font-medium">1</button>
      <button class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:border-emerald-500 hover:text-emerald-600">2</button>
      <button class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:border-emerald-500 hover:text-emerald-600">3</button>
      <button class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:border-emerald-500 hover:text-emerald-600">4</button>
      <span class="text-gray-400">...</span>
      <button class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center hover:border-emerald-500 hover:text-emerald-600"><i class="ri-arrow-right-s-line"></i></button>
    </div>
  </main>

</div>
