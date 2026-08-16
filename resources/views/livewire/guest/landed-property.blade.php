<div>
    <!-- Hero Header -->
    <div class="relative min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-emerald-900 to-emerald-600 pt-20">
        <div class="max-w-3xl mx-auto px-4 text-center py-16">
            <h1 class="font-bold font-serif text-white mb-4 text-4xl leading-tight">Landed Properties</h1>
            <p class="text-emerald-200 text-xl">Find your dream landed property from verified owners</p>
        </div>
    </div>

    <!-- Compact Sticky Filter Bar -->
    <div class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-16 sm:top-20 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                
                <!-- Left: Filter Trigger Button & Quick Search -->
                <div class="flex items-center gap-3 flex-1">
                    <button type="button" onclick="openFilterDrawer()" class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl text-sm transition-all shadow-sm hover:shadow-md cursor-pointer whitespace-nowrap">
                        <i class="ri-options-line text-lg"></i>
                        <span>Filter Properties</span>
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-emerald-800 text-emerald-100 text-xs font-bold rounded-full">4</span>
                    </button>

                    <!-- Quick Search Box -->
                    <div class="relative flex-1 max-w-sm hidden sm:block">
                        <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                        <input type="text" placeholder="Quick search location, title, keyword..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-gray-50/50 transition">
                    </div>
                </div>

                <!-- Right: Properties Count & Quick Sort -->
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-500 hidden md:block">
                        Showing <span class="font-semibold text-gray-900">{{ $this->properties->total() }}</span> properties
                    </p>
                    <div class="flex items-center gap-2">
                        <label for="sortBySelect" class="text-xs text-gray-500 font-medium hidden lg:inline-block">Sort by:</label>
                        <select id="sortBySelect" class="px-3 py-2 border border-gray-200 rounded-xl text-gray-700 text-sm outline-none focus:border-emerald-500 bg-white cursor-pointer shadow-xs">
                            <option>Newest First</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Active Filter Badges / Chips -->
            <div class="flex items-center gap-2 pt-3 flex-wrap text-xs">
                <span class="text-gray-400 font-medium mr-1">Active Filters:</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                    State: Lagos
                    <button type="button" class="hover:text-emerald-950 font-bold ml-0.5 cursor-pointer">&times;</button>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                    City: Lekki
                    <button type="button" class="hover:text-emerald-950 font-bold ml-0.5 cursor-pointer">&times;</button>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                    Type: Duplex
                    <button type="button" class="hover:text-emerald-950 font-bold ml-0.5 cursor-pointer">&times;</button>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                    Price: ₦20M - ₦50M
                    <button type="button" class="hover:text-emerald-950 font-bold ml-0.5 cursor-pointer">&times;</button>
                </span>
                <button type="button" class="text-emerald-600 hover:text-emerald-700 font-semibold underline ml-2 cursor-pointer">
                    Clear All
                </button>
            </div>
        </div>
    </div>

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

    <!-- Off-Canvas Backdrop -->
    <div id="filterBackdrop" onclick="closeFilterDrawer()" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs z-50 transition-opacity duration-300 opacity-0 pointer-events-none"></div>

    <!-- Off-Canvas Slide-Over Drawer -->
    <div id="filterDrawer" class="fixed inset-y-0 right-0 max-w-full flex w-full sm:w-[480px] z-50 transform transition-transform duration-300 ease-in-out translate-x-full">
        <div class="w-full bg-white h-full shadow-2xl flex flex-col justify-between overflow-hidden">
            
            <!-- Drawer Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-stone-50/80">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="ri-filter-3-line text-emerald-600"></i> Filter Properties
                    </h2>
                    <p class="text-xs text-gray-500">Customize search fields to find matching properties</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 underline cursor-pointer">
                        Reset All
                    </button>
                    <button type="button" onclick="closeFilterDrawer()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-200 transition-colors cursor-pointer">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Drawer Scrollable Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                
                <!-- 1. Location (Country, State, City) -->
                <div class="space-y-4 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-map-pin-line text-emerald-600"></i> Location
                    </h3>

                    <!-- Country -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Country</label>
                        <select class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-emerald-500 bg-white cursor-pointer">
                            <option value="">Select Country</option>
                            <option value="nigeria" selected>Nigeria</option>
                            <option value="ghana">Ghana</option>
                            <option value="uk">United Kingdom</option>
                            <option value="usa">United States</option>
                            <option value="canada">Canada</option>
                            <option value="uae">United Arab Emirates</option>
                        </select>
                    </div>

                    <!-- State -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">State</label>
                        <select class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-emerald-500 bg-white cursor-pointer">
                            <option value="">All States</option>
                            <option value="lagos" selected>Lagos</option>
                            <option value="abuja">Abuja (FCT)</option>
                            <option value="rivers">Rivers</option>
                            <option value="ogun">Ogun</option>
                            <option value="oyo">Oyo</option>
                            <option value="enugu">Enugu</option>
                            <option value="anambra">Anambra</option>
                            <option value="delta">Delta</option>
                        </select>
                    </div>

                    <!-- City / Area -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">City / Neighborhood</label>
                        <select class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-emerald-500 bg-white cursor-pointer">
                            <option value="">All Cities / Areas</option>
                            <option value="lekki" selected>Lekki</option>
                            <option value="ikorodu">Ikorodu</option>
                            <option value="ajah">Ajah</option>
                            <option value="ikeja">Ikeja</option>
                            <option value="victoria-island">Victoria Island</option>
                            <option value="epe">Epe</option>
                            <option value="sangotedo">Sangotedo</option>
                            <option value="surulere">Surulere</option>
                        </select>
                    </div>
                </div>

                <!-- 2. Property Type -->
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-building-4-line text-emerald-600"></i> Property Type
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2.5 border border-emerald-500 bg-emerald-50/50 rounded-xl cursor-pointer font-medium text-emerald-900">
                            <input type="checkbox" checked class="accent-emerald-600 rounded">
                            <span>Duplex</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Bungalow</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Mansion</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Terraced Duplex</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Detached House</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Land / Plot</span>
                        </label>
                    </div>
                </div>

                <!-- 3. Price Range (₦) -->
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-money-naira-circle-line text-emerald-600"></i> Price Range (₦)
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Min Price</label>
                            <input type="text" placeholder="₦ Min" value="₦20,000,000" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Max Price</label>
                            <input type="text" placeholder="₦ Max" value="₦50,000,000" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>

                    <!-- Quick Price Preset Buttons -->
                    <div class="flex flex-wrap gap-1.5 text-xs pt-1">
                        <button type="button" class="px-2.5 py-1 bg-gray-100 hover:bg-emerald-100 hover:text-emerald-800 text-gray-600 rounded-lg transition font-medium cursor-pointer">Under ₦20M</button>
                        <button type="button" class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg transition font-medium cursor-pointer">₦20M - ₦50M</button>
                        <button type="button" class="px-2.5 py-1 bg-gray-100 hover:bg-emerald-100 hover:text-emerald-800 text-gray-600 rounded-lg transition font-medium cursor-pointer">₦50M - ₦100M</button>
                        <button type="button" class="px-2.5 py-1 bg-gray-100 hover:bg-emerald-100 hover:text-emerald-800 text-gray-600 rounded-lg transition font-medium cursor-pointer">₦100M+</button>
                    </div>
                </div>

                <!-- 4. Bedrooms & Bathrooms -->
                <div class="space-y-4 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-hotel-bed-line text-emerald-600"></i> Bedrooms & Bathrooms
                    </h3>
                    
                    <!-- Bedrooms -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Bedrooms</label>
                        <div class="flex gap-2 text-xs">
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">Any</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">1+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">2+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">3+</button>
                            <button type="button" class="flex-1 py-2 bg-emerald-600 text-white font-bold rounded-xl shadow-xs cursor-pointer">4+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">5+</button>
                        </div>
                    </div>

                    <!-- Bathrooms -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Bathrooms</label>
                        <div class="flex gap-2 text-xs">
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">Any</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">1+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">2+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">3+</button>
                            <button type="button" class="flex-1 py-2 border border-gray-200 rounded-xl hover:border-emerald-500 font-medium text-gray-700 cursor-pointer">4+</button>
                        </div>
                    </div>
                </div>

                <!-- 5. Features & Amenities -->
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-checkbox-multiple-line text-emerald-600"></i> Features & Amenities
                    </h3>
                    <div class="grid grid-cols-2 gap-2.5 text-xs">
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" checked class="accent-emerald-600 rounded">
                            <span>Swimming Pool</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" checked class="accent-emerald-600 rounded">
                            <span>24/7 Security / Gated</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Generator / Solar Power</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Boys Quarter (BQ)</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Water Treatment Plant</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Car Parking Space</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Fitted Modern Kitchen</span>
                        </label>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>CCTV / Security Cameras</span>
                        </label>
                    </div>
                </div>

                <!-- 6. Document Title -->
                <div class="space-y-3 pb-5">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-file-shield-line text-emerald-600"></i> Property Title / Document
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer text-gray-700">
                            <input type="checkbox" checked class="accent-emerald-600 rounded">
                            <span>C of O</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Governor's Consent</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Gazette</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer text-gray-700">
                            <input type="checkbox" class="accent-emerald-600 rounded">
                            <span>Deed of Assignment</span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Drawer Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center gap-3">
                <button type="button" onclick="closeFilterDrawer()" class="w-1/3 py-3 px-4 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-100 transition text-center cursor-pointer">
                    Clear Filters
                </button>
                <button type="button" onclick="closeFilterDrawer()" class="w-2/3 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                    <i class="ri-search-line text-base"></i>
                    <span>Apply Filters</span>
                </button>
            </div>

        </div>
    </div>

    <!-- Vanilla JavaScript for Off-Canvas Drawer -->
    <script>
        function openFilterDrawer() {
            const drawer = document.getElementById('filterDrawer');
            const backdrop = document.getElementById('filterBackdrop');
            if (drawer && backdrop) {
                drawer.classList.remove('translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeFilterDrawer() {
            const drawer = document.getElementById('filterDrawer');
            const backdrop = document.getElementById('filterBackdrop');
            if (drawer && backdrop) {
                drawer.classList.add('translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFilterDrawer();
            }
        });
    </script>
</div>
