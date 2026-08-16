<div>
    <main>
        <section class="relative min-h-[100svh] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img alt="Luxury Properties" class="w-full h-full object-cover object-top"
                    src="{{ asset('frontend/images/properties.jpg') }}" />
                <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>
            </div>
            <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 w-full">
                <div class="text-center space-y-6 sm:space-y-8">
                    <div class="space-y-3 sm:space-y-4">
                        <h2
                            class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold font-serif text-white leading-tight">
                            Propatis
                        </h2>
                        <p class="text-lg sm:text-xl md:text-2xl text-emerald-100 font-light px-4">
                            Connect Directly with Property Owners
                        </p>
                    </div>
                    <form class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-2xl space-y-3 sm:space-y-4">
                        <div class="space-y-2.5 sm:space-y-3">
                            <div class="relative">
                                <i
                                    class="ri-map-pin-line absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base sm:text-lg"></i><input
                                    placeholder="Location (e.g., Lekki, Ikorodu)"
                                    class="w-full pl-10 sm:pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm"
                                    type="text" value="" />
                            </div>
                            <div class="relative">
                                <i
                                    class="ri-home-4-line absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base sm:text-lg"></i><select
                                    class="w-full pl-10 sm:pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none text-sm cursor-pointer">
                                    <option value="">Property Type</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative">
                                <i
                                    class="ri-money-naira-circle-line absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base sm:text-lg"></i><select
                                    class="w-full pl-10 sm:pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none text-sm cursor-pointer">
                                    <option value="">Price Range</option>
                                    <option value="0-10m">Under ₦10M</option>
                                    <option value="10m-30m">₦10M - ₦30M</option>
                                    <option value="30m-50m">₦30M - ₦50M</option>
                                    <option value="50m-100m">₦50M - ₦100M</option>
                                    <option value="100m+">Above ₦100M</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full py-3.5 sm:py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center space-x-2 whitespace-nowrap text-sm sm:text-base cursor-pointer">
                            <i class="ri-search-line text-base sm:text-lg"></i><span>Search Properties</span>
                        </button>
                    </form>
                </div>
            </div>
            <a href="#categories"
                class="absolute bottom-6 sm:bottom-8 left-1/2 -translate-x-1/2 animate-bounce cursor-pointer"><i
                    class="ri-arrow-down-line text-white text-2xl sm:text-3xl"></i></a>
        </section>
        <section id="categories" class="py-14 sm:py-24 bg-stone-50 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-gray-900 mb-3 sm:mb-4">
                        Explore Property Categories
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Find your perfect property from our diverse collection of
                        verified listings
                    </p>
                </div>
                <div class="relative w-full">
                    <div class="relative h-[280px] sm:h-[400px] lg:h-[460px] flex items-center justify-center">
                        <div id="slide-0"
                            class="absolute w-[85%] sm:w-[65%] lg:w-[55%] h-full transition-all duration-700 ease-in-out cursor-pointer z-10 opacity-50 scale-90 translate-x-[75%] sm:translate-x-[60%]">
                            <div
                                class="relative w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl group">
                                <img alt="Landed Properties"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
                                    src="https://readdy.ai/api/search-image?query=elegant%20modern%20duplex%20house%20with%20beautiful%20landscaping%2C%20contemporary%20Nigerian%20architecture%2C%20spacious%20compound%20with%20paved%20driveway%2C%20luxury%20residential%20property%2C%20professional%20real%20estate%20photography%20with%20clear%20blue%20sky%20background&amp;width=800&amp;height=600&amp;seq=cat1&amp;orientation=landscape" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                </div>
                                <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-full whitespace-nowrap">234+
                                        Properties</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-10">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 group-hover:text-emerald-300 transition-colors">
                                        Landed Properties
                                    </h3>
                                    <p
                                        class="text-emerald-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-lg line-clamp-2">
                                        Browse premium landed properties including duplexes,
                                        bungalows, and mansions
                                    </p>
                                    <a href="#properties"
                                        class="inline-flex items-center space-x-2 text-white font-semibold text-sm mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-emerald-300"><span
                                            class="whitespace-nowrap">View All</span><i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="slide-1"
                            class="absolute w-[85%] sm:w-[65%] lg:w-[55%] h-full transition-all duration-700 ease-in-out cursor-pointer z-0 opacity-0 scale-75 translate-x-0">
                            <div
                                class="relative w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl group">
                                <img alt="Uncompleted Structures"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
                                    src="https://readdy.ai/api/search-image?query=uncompleted%20building%20construction%20showing%20concrete%20framework%20and%20structural%20elements%2C%20multiple%20floors%20visible%2C%20construction%20site%20with%20clear%20documentation%2C%20professional%20photography%20with%20simple%20sky%20background&amp;width=800&amp;height=600&amp;seq=cat2&amp;orientation=landscape" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                </div>
                                <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-full whitespace-nowrap">87+
                                        Properties</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-10">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 group-hover:text-emerald-300 transition-colors">
                                        Uncompleted Structures
                                    </h3>
                                    <p
                                        class="text-emerald-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-lg line-clamp-2">
                                        Investment opportunities in uncompleted buildings at
                                        great prices
                                    </p>
                                    <a href="#properties"
                                        class="inline-flex items-center space-x-2 text-white font-semibold text-sm mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-emerald-300"><span
                                            class="whitespace-nowrap">View All</span><i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="slide-2"
                            class="absolute w-[85%] sm:w-[65%] lg:w-[55%] h-full transition-all duration-700 ease-in-out cursor-pointer z-0 opacity-0 scale-75 translate-x-0">
                            <div
                                class="relative w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl group">
                                <img alt="Completed Properties"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
                                    src="https://readdy.ai/api/search-image?query=beautiful%20completed%20residential%20property%20with%20modern%20finishing%2C%20fully%20furnished%20interior%20visible%20through%20windows%2C%20well%20maintained%20exterior%2C%20professional%20real%20estate%20photography%20with%20clear%20background&amp;width=800&amp;height=600&amp;seq=cat3&amp;orientation=landscape" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                </div>
                                <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-full whitespace-nowrap">156+
                                        Properties</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-10">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 group-hover:text-emerald-300 transition-colors">
                                        Completed Properties
                                    </h3>
                                    <p
                                        class="text-emerald-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-lg line-clamp-2">
                                        Move-in ready properties with all finishing and
                                        documentation
                                    </p>
                                    <a href="#properties"
                                        class="inline-flex items-center space-x-2 text-white font-semibold text-sm mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-emerald-300"><span
                                            class="whitespace-nowrap">View All</span><i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="slide-3"
                            class="absolute w-[85%] sm:w-[65%] lg:w-[55%] h-full transition-all duration-700 ease-in-out cursor-pointer z-10 opacity-50 scale-90 -translate-x-[75%] sm:-translate-x-[60%]">
                            <div
                                class="relative w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl group">
                                <img alt="Rented/Lease Properties"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
                                    src="https://readdy.ai/api/search-image?query=modern%20apartment%20building%20exterior%20with%20multiple%20units%2C%20clean%20facade%2C%20balconies%2C%20well%20maintained%20rental%20property%2C%20professional%20real%20estate%20photography%20with%20clear%20sky%20background&amp;width=800&amp;height=600&amp;seq=cat4&amp;orientation=landscape" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                </div>
                                <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-full whitespace-nowrap">198+
                                        Properties</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-10">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 group-hover:text-emerald-300 transition-colors">
                                        Rented/Lease Properties
                                    </h3>
                                    <p
                                        class="text-emerald-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-lg line-clamp-2">
                                        Find your perfect rental home or lease commercial
                                        spaces
                                    </p>
                                    <a href="#properties"
                                        class="inline-flex items-center space-x-2 text-white font-semibold text-sm mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-emerald-300"><span
                                            class="whitespace-nowrap">View All</span><i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="slide-4"
                            class="absolute w-[85%] sm:w-[65%] lg:w-[55%] h-full transition-all duration-700 ease-in-out cursor-pointer z-20 opacity-100 scale-100 translate-x-0">
                            <div
                                class="relative w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl group">
                                <img alt="Short-Let Apartments"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
                                    src="https://readdy.ai/api/search-image?query=luxury%20furnished%20apartment%20interior%20with%20stylish%20modern%20furniture%2C%20spacious%20living%20area%2C%20elegant%20decor%2C%20city%20view%20through%20large%20windows%2C%20professional%20interior%20photography%20with%20clean%20background&amp;width=800&amp;height=600&amp;seq=cat5&amp;orientation=landscape" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                </div>
                                <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-emerald-500 text-white text-xs sm:text-sm font-bold rounded-full whitespace-nowrap">142+
                                        Properties</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 lg:p-10">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 group-hover:text-emerald-300 transition-colors">
                                        Short-Let Apartments
                                    </h3>
                                    <p
                                        class="text-emerald-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-lg line-clamp-2">
                                        Fully furnished apartments for daily, weekly, or
                                        monthly stays
                                    </p>
                                    <a href="#properties"
                                        class="inline-flex items-center space-x-2 text-white font-semibold text-sm mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-emerald-300"><span
                                            class="whitespace-nowrap">View All</span><i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="prev-btn"
                        class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white/90 hover:bg-white text-gray-800 rounded-full shadow-lg transition-all duration-300 hover:scale-110 cursor-pointer whitespace-nowrap"
                        aria-label="Previous category">
                        <i class="ri-arrow-left-s-line text-xl sm:text-2xl"></i></button><button id="next-btn"
                        class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white/90 hover:bg-white text-gray-800 rounded-full shadow-lg transition-all duration-300 hover:scale-110 cursor-pointer whitespace-nowrap"
                        aria-label="Next category">
                        <i class="ri-arrow-right-s-line text-xl sm:text-2xl"></i>
                    </button>
                    <div class="flex items-center justify-center gap-2 sm:gap-3 mt-6 sm:mt-8">
                        <button id="dot-0"
                            class="transition-all duration-500 rounded-full cursor-pointer w-2.5 sm:w-3 h-2.5 sm:h-3 bg-gray-300 hover:bg-gray-400"
                            aria-label="Go to category 1"></button><button id="dot-1"
                            class="transition-all duration-500 rounded-full cursor-pointer w-2.5 sm:w-3 h-2.5 sm:h-3 bg-gray-300 hover:bg-gray-400"
                            aria-label="Go to category 2"></button><button id="dot-2"
                            class="transition-all duration-500 rounded-full cursor-pointer w-2.5 sm:w-3 h-2.5 sm:h-3 bg-gray-300 hover:bg-gray-400"
                            aria-label="Go to category 3"></button><button id="dot-3"
                            class="transition-all duration-500 rounded-full cursor-pointer w-2.5 sm:w-3 h-2.5 sm:h-3 bg-gray-300 hover:bg-gray-400"
                            aria-label="Go to category 4"></button><button id="dot-4"
                            class="transition-all duration-500 rounded-full cursor-pointer w-8 sm:w-10 h-2.5 sm:h-3 bg-emerald-500"
                            aria-label="Go to category 5"></button>
                    </div>
                </div>
            </div>
        </section>
        <section id="properties" class="py-14 sm:py-24 bg-white scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-gray-900 mb-3 sm:mb-4">
                        Featured Properties
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Handpicked premium properties with verified owners and direct
                        contact
                    </p>
                </div>
                <div class="mb-8 sm:mb-12 -mx-4 px-4 sm:mx-0 sm:px-0">
                    <div
                        class="flex items-center sm:justify-center space-x-2 sm:space-x-3 overflow-x-auto pb-3 sm:pb-4 scrollbar-hide">
                        <button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-emerald-600 text-white shadow-lg">
                            All Properties</button><button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Landed</button><button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Completed</button><button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Uncompleted</button><button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Rent/Lease</button><button
                            class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-300 whitespace-nowrap flex-shrink-0 cursor-pointer bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Short-Let
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8" data-product-shop="true">
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="Luxury 5 Bedroom Detached Duplex with BQ"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=modern%20luxury%20five%20bedroom%20detached%20duplex%20house%20with%20swimming%20pool%20and%20manicured%20garden%20in%20upscale%20Nigerian%20neighborhood%2C%20contemporary%20architecture%20with%20clean%20white%20exterior%20walls%2C%20large%20glass%20windows%2C%20elegant%20entrance%20gate%2C%20bright%20daylight%20photography%2C%20professional%20real%20estate%20photo%20with%20simple%20clear%20sky%20background&amp;width=800&amp;height=600&amp;seq=prop1&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 left-0">
                                <div
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 sm:px-4 py-1 sm:py-1.5 text-[10px] sm:text-xs font-bold transform -skew-x-12 shadow-lg whitespace-nowrap">
                                    <span class="inline-block transform skew-x-12">⭐ BOOSTED</span>
                                </div>
                            </div>
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">1247
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    Luxury 5 Bedroom Detached Duplex with BQ
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Lekki Phase
                                        1, Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦85.0M
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        5
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        6
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        450
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Landed
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Adebayo Johnson" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20businessman%20portrait%20wearing%20business%20suit%2C%20confident%20smile%2C%20studio%20photography%20with%20neutral%20gray%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner1&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Adebayo
                                            Johnson</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="4 Bedroom Semi-Detached Duplex"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=beautiful%20four%20bedroom%20semi%20detached%20duplex%20with%20modern%20design%2C%20cream%20and%20brown%20exterior%20paint%2C%20tiled%20compound%2C%20iron%20gate%2C%20tropical%20plants%2C%20Nigerian%20residential%20architecture%2C%20clear%20blue%20sky%2C%20professional%20real%20estate%20photography%20with%20simple%20background&amp;width=800&amp;height=600&amp;seq=prop2&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">892
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    4 Bedroom Semi-Detached Duplex
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Ajah,
                                        Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦45.0M
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        4
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        5
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        320
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Completed
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Chioma Okafor" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20businesswoman%20portrait%20wearing%20elegant%20blazer%2C%20warm%20smile%2C%20studio%20photography%20with%20neutral%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner2&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Chioma
                                            Okafor</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="3 Bedroom Flat - Short Let Available"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=modern%20three%20bedroom%20apartment%20interior%20with%20stylish%20furniture%2C%20spacious%20living%20room%20with%20contemporary%20decor%2C%20large%20windows%20with%20city%20view%2C%20elegant%20lighting%2C%20luxury%20finishes%2C%20professional%20interior%20photography%20with%20clean%20simple%20background&amp;width=800&amp;height=600&amp;seq=prop3&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 left-0">
                                <div
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 sm:px-4 py-1 sm:py-1.5 text-[10px] sm:text-xs font-bold transform -skew-x-12 shadow-lg whitespace-nowrap">
                                    <span class="inline-block transform skew-x-12">⭐ BOOSTED</span>
                                </div>
                            </div>
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">2103
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    3 Bedroom Flat - Short Let Available
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Victoria
                                        Island, Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦150,000/night
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        3
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        3
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        180
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Short-Let
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Ibrahim Musa" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20man%20portrait%20wearing%20traditional%20attire%2C%20friendly%20expression%2C%20studio%20photography%20with%20neutral%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner3&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Ibrahim
                                            Musa</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="Uncompleted 6 Bedroom Mansion"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=uncompleted%20mansion%20construction%20site%20showing%20concrete%20structure%20with%20multiple%20floors%2C%20visible%20columns%20and%20beams%2C%20roofing%20in%20progress%2C%20construction%20materials%20on%20site%2C%20clear%20documentation%20photography%20with%20simple%20sky%20background&amp;width=800&amp;height=600&amp;seq=prop4&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">654
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    Uncompleted 6 Bedroom Mansion
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Ikorodu,
                                        Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦35.0M
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        6
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        7
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        550
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Uncompleted
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Funke Adeleke" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20woman%20portrait%20wearing%20colorful%20African%20print%20dress%2C%20confident%20smile%2C%20studio%20photography%20with%20neutral%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner4&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Funke
                                            Adeleke</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="2 Bedroom Apartment for Rent"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=cozy%20two%20bedroom%20apartment%20with%20modern%20kitchen%2C%20bright%20living%20space%2C%20contemporary%20furniture%2C%20clean%20white%20walls%2C%20wooden%20flooring%2C%20natural%20lighting%2C%20professional%20real%20estate%20interior%20photo%20with%20simple%20background&amp;width=800&amp;height=600&amp;seq=prop5&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">1456
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    2 Bedroom Apartment for Rent
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Ikeja GRA,
                                        Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦1,200,000/year
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        2
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        2
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        120
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Rented/Lease
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Emeka Nwosu" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20man%20portrait%20wearing%20casual%20business%20shirt%2C%20friendly%20smile%2C%20studio%20photography%20with%20neutral%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner5&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Emeka
                                            Nwosu</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
                        <div class="relative h-48 sm:h-64 overflow-hidden">
                            <img alt="Luxury 4 Bedroom Terrace with Pool"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=luxury%20four%20bedroom%20terrace%20house%20with%20private%20swimming%20pool%2C%20modern%20architecture%2C%20glass%20railings%2C%20outdoor%20lounge%20area%2C%20manicured%20lawn%2C%20upscale%20Nigerian%20estate%2C%20professional%20real%20estate%20photography%20with%20clear%20sky%20background&amp;width=800&amp;height=600&amp;seq=prop6&amp;orientation=landscape" />
                            <div class="absolute top-3 sm:top-4 left-0">
                                <div
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 sm:px-4 py-1 sm:py-1.5 text-[10px] sm:text-xs font-bold transform -skew-x-12 shadow-lg whitespace-nowrap">
                                    <span class="inline-block transform skew-x-12">⭐ BOOSTED</span>
                                </div>
                            </div>
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Available</span>
                            </div>
                            <div
                                class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 bg-black/60 backdrop-blur-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full flex items-center space-x-1.5 sm:space-x-2">
                                <i class="ri-eye-line text-white text-xs sm:text-sm"></i><span
                                    class="text-white text-[10px] sm:text-xs font-medium whitespace-nowrap">3421
                                    views</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1.5 sm:mb-2 line-clamp-1">
                                    Luxury 4 Bedroom Terrace with Pool
                                </h3>
                                <div class="flex items-center text-gray-600 text-xs sm:text-sm">
                                    <i class="ri-map-pin-line mr-1"></i><span class="line-clamp-1">Banana
                                        Island, Lagos</span>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-600">
                                ₦120.0M
                            </div>
                            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-hotel-bed-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        4
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Beds
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-drop-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        5
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Baths
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-ruler-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900">
                                        380
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        sqm
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-2.5 text-center">
                                    <i class="ri-home-4-line text-gray-600 text-base sm:text-lg mb-0.5 sm:mb-1"></i>
                                    <div class="text-[10px] sm:text-xs font-semibold text-gray-900 line-clamp-1">
                                        Landed
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        Type
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 pt-3 sm:pt-4 border-t border-gray-100">
                                <img alt="Aisha Bello" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover"
                                    src="https://readdy.ai/api/search-image?query=professional%20Nigerian%20woman%20portrait%20wearing%20elegant%20hijab%20and%20business%20attire%2C%20warm%20smile%2C%20studio%20photography%20with%20neutral%20background%2C%20high%20quality%20headshot&amp;width=200&amp;height=200&amp;seq=owner6&amp;orientation=squarish" />
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-xs sm:text-sm font-semibold text-gray-900 truncate">Aisha
                                            Bello</span><i
                                            class="ri-verified-badge-fill text-blue-500 text-sm sm:text-base flex-shrink-0"></i>
                                    </div>
                                    <p class="text-[10px] sm:text-xs text-gray-500 whitespace-nowrap">
                                        Property Owner
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2 pt-1 sm:pt-2">
                                <button
                                    class="w-full py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl whitespace-nowrap text-sm cursor-pointer">
                                    <i class="ri-whatsapp-line text-base sm:text-lg"></i><span>WhatsApp
                                        Owner</span>
                                </button>
                                <div class="flex space-x-2">
                                    <a href="tel:08067042140"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-phone-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Call</span></a><a
                                        href="mailto:louis670421@gmail.com"
                                        class="flex-1 py-2 sm:py-2.5 border-2 border-gray-200 hover:border-emerald-600 text-gray-700 hover:text-emerald-600 font-medium rounded-xl transition-all duration-300 flex items-center justify-center space-x-1.5 sm:space-x-2 cursor-pointer whitespace-nowrap"><i
                                            class="ri-mail-line text-sm"></i><span
                                            class="text-xs sm:text-sm">Email</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-8 sm:mt-12">
                    <p class="text-sm text-gray-500">
                        You've seen all 6 properties
                    </p>
                </div>
            </div>
        </section>
        <section id="list-property" class="relative overflow-hidden scroll-mt-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[400px] lg:min-h-[600px]">
                <div class="relative overflow-hidden h-64 sm:h-80 lg:h-auto">
                    <img alt="List Your Property" class="absolute inset-0 w-full h-full object-cover"
                        src="https://readdy.ai/api/search-image?query=modern%20luxury%20property%20owner%20holding%20house%20keys%20with%20beautiful%20residential%20building%20in%20background%2C%20successful%20Nigerian%20real%20estate%20transaction%2C%20professional%20photography%20with%20warm%20golden%20hour%20lighting%20and%20simple%20clear%20sky%20background&amp;width=1200&amp;height=800&amp;seq=cta1&amp;orientation=landscape" />
                    <div class="absolute inset-0 bg-emerald-600/85"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center space-y-4 sm:space-y-6 p-6 sm:p-8">
                            <div
                                class="inline-block bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-5 sm:p-8 border border-white/20">
                                <div class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-1 sm:mb-2">
                                    ₦5,000
                                </div>
                                <p class="text-white text-sm sm:text-lg font-medium whitespace-nowrap">
                                    One-time Listing Fee
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white flex items-center justify-center p-6 sm:p-8 lg:p-16">
                    <div class="max-w-lg space-y-6 sm:space-y-8">
                        <div class="space-y-3 sm:space-y-4">
                            <h2
                                class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-gray-900 leading-tight">
                                List Your Property in Minutes
                            </h2>
                            <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                                Join hundreds of property owners who trust Propatis
                                to connect with serious buyers and renters
                            </p>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-emerald-100 rounded-full flex-shrink-0">
                                    <i class="ri-check-line text-emerald-600 text-base sm:text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-0.5 sm:mb-1">
                                        Direct Buyer Contact
                                    </h4>
                                    <p class="text-gray-600 text-xs sm:text-sm">
                                        Your phone and WhatsApp displayed on every listing
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-emerald-100 rounded-full flex-shrink-0">
                                    <i class="ri-check-line text-emerald-600 text-base sm:text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-0.5 sm:mb-1">
                                        Pay Only When Listed
                                    </h4>
                                    <p class="text-gray-600 text-xs sm:text-sm">
                                        Affordable one-time fee with no hidden charges
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-emerald-100 rounded-full flex-shrink-0">
                                    <i class="ri-check-line text-emerald-600 text-base sm:text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-0.5 sm:mb-1">
                                        Boost for Visibility
                                    </h4>
                                    <p class="text-gray-600 text-xs sm:text-sm">
                                        Promote your listing to reach more potential buyers
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <button
                                class="bg-white text-emerald-600 hover:bg-gray-50 px-8 py-4 rounded-lg font-semibold transition flex items-center gap-2 whitespace-nowrap">
                                <i class="ri-add-circle-line text-xl"></i>Start Listing
                            </button>
                            <div class="flex items-center justify-center space-x-2 text-xs sm:text-sm text-gray-500">
                                <i class="ri-lock-line"></i><span>Secure payment via Paystack</span>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-center space-x-6 sm:space-x-8 pt-4 sm:pt-6 border-t border-gray-200">
                            <div class="text-center">
                                <div class="text-xl sm:text-2xl font-bold text-emerald-600">
                                    500+
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-600 whitespace-nowrap">
                                    Active Owners
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl sm:text-2xl font-bold text-emerald-600">
                                    98%
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-600 whitespace-nowrap">
                                    Success Rate
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl sm:text-2xl font-bold text-emerald-600">
                                    24hrs
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-600 whitespace-nowrap">
                                    Avg. Approval
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-14 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 sm:gap-12 items-center">
                    <div class="lg:col-span-2 space-y-4 sm:space-y-6 text-center lg:text-left">
                        <h2
                            class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold font-serif text-gray-900 leading-tight">
                            Why Choose Propatis
                        </h2>
                        <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                            Nigeria's most trusted platform for direct property
                            transactions
                        </p>
                    </div>
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-2 gap-3 sm:gap-6">
                            <div
                                class="bg-gradient-to-br from-stone-50 to-white p-5 sm:p-8 rounded-xl sm:rounded-2xl border border-gray-100 hover:border-emerald-200 transition-all duration-300 hover:shadow-lg">
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-emerald-600">
                                        500+
                                    </div>
                                    <div class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900">
                                        Active Listings
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        Properties available across Lagos
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-stone-50 to-white p-5 sm:p-8 rounded-xl sm:rounded-2xl border border-gray-100 hover:border-emerald-200 transition-all duration-300 hover:shadow-lg">
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-emerald-600">
                                        10,000+
                                    </div>
                                    <div class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900">
                                        Monthly Visitors
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        Serious buyers and renters
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-stone-50 to-white p-5 sm:p-8 rounded-xl sm:rounded-2xl border border-gray-100 hover:border-emerald-200 transition-all duration-300 hover:shadow-lg">
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-emerald-600">
                                        95%
                                    </div>
                                    <div class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900">
                                        Success Rate
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        Properties sold or rented
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-stone-50 to-white p-5 sm:p-8 rounded-xl sm:rounded-2xl border border-gray-100 hover:border-emerald-200 transition-all duration-300 hover:shadow-lg">
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-emerald-600">
                                        98%
                                    </div>
                                    <div class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900">
                                        Owner Satisfaction
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        Verified property owners
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative mt-10 sm:mt-16 h-48 sm:h-64 overflow-hidden rounded-2xl sm:rounded-3xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-100 via-emerald-50 to-emerald-100">
                    </div>
                    <div class="absolute top-10 left-10 w-32 h-32 bg-emerald-200/40 rounded-full blur-3xl">
                    </div>
                    <div class="absolute bottom-10 right-10 w-40 h-40 bg-emerald-300/30 rounded-full blur-3xl">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-emerald-200/20 rounded-full blur-3xl">
                    </div>
                    <div class="relative h-full flex items-center justify-center px-4">
                        <div class="text-center space-y-3 sm:space-y-4">
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                                Ready to Find Your Dream Property?
                            </h3>
                            <a href="#properties"
                                class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 whitespace-nowrap text-sm sm:text-base cursor-pointer">Browse
                                All Properties</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="blog" class="py-14 sm:py-24 bg-white scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-gray-900 mb-3 sm:mb-4">
                        Real Estate Tips &amp; Insights
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Expert advice to help you make informed property decisions in
                        Nigeria
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
                    <article
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                        <div class="relative h-44 sm:h-56 overflow-hidden">
                            <img alt="10 Things to Check Before Buying Property in Lagos"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=professional%20real%20estate%20consultation%20scene%20with%20documents%20and%20property%20plans%20on%20desk%2C%20Nigerian%20business%20setting%2C%20bright%20office%20environment%2C%20professional%20photography%20with%20clean%20background&amp;width=800&amp;height=500&amp;seq=blog1&amp;orientation=landscape" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-600 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Buying
                                    Guide</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div class="flex items-center space-x-3 sm:space-x-4 text-xs sm:text-sm text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <i class="ri-calendar-line"></i><span class="whitespace-nowrap">Jan 15,
                                        2025</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="ri-time-line"></i><span class="whitespace-nowrap">8 min
                                        read</span>
                                </div>
                            </div>
                            <h3
                                class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                10 Things to Check Before Buying Property in Lagos
                            </h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                Essential checklist for property buyers to avoid common
                                pitfalls and make informed decisions when purchasing real
                                estate in Lagos Nigeria.
                            </p>
                            <div
                                class="flex items-center space-x-2 text-emerald-600 font-semibold text-xs sm:text-sm group-hover:space-x-3 transition-all">
                                <span class="whitespace-nowrap">Read Article</span><i class="ri-arrow-right-line"></i>
                            </div>
                        </div>
                    </article>
                    <article
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                        <div class="relative h-44 sm:h-56 overflow-hidden">
                            <img alt="How to Verify Property Documents in Nigeria"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=legal%20property%20documents%20and%20certificates%20on%20desk%20with%20magnifying%20glass%2C%20official%20Nigerian%20property%20papers%2C%20professional%20documentation%20photography%20with%20clean%20background&amp;width=800&amp;height=500&amp;seq=blog2&amp;orientation=landscape" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-600 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Legal
                                    Guide</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div class="flex items-center space-x-3 sm:space-x-4 text-xs sm:text-sm text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <i class="ri-calendar-line"></i><span class="whitespace-nowrap">Jan 12,
                                        2025</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="ri-time-line"></i><span class="whitespace-nowrap">10 min
                                        read</span>
                                </div>
                            </div>
                            <h3
                                class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                How to Verify Property Documents in Nigeria
                            </h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                Complete guide to verifying Certificate of Occupancy,
                                Survey Plans, and other essential property documents to
                                ensure legitimate ownership.
                            </p>
                            <div
                                class="flex items-center space-x-2 text-emerald-600 font-semibold text-xs sm:text-sm group-hover:space-x-3 transition-all">
                                <span class="whitespace-nowrap">Read Article</span><i class="ri-arrow-right-line"></i>
                            </div>
                        </div>
                    </article>
                    <article
                        class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                        <div class="relative h-44 sm:h-56 overflow-hidden">
                            <img alt="Best Locations for Real Estate Investment in Lagos 2025"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://readdy.ai/api/search-image?query=aerial%20view%20of%20modern%20Lagos%20neighborhood%20with%20residential%20properties%2C%20urban%20development%2C%20Nigerian%20cityscape%2C%20professional%20real%20estate%20photography%20with%20clear%20sky%20background&amp;width=800&amp;height=500&amp;seq=blog3&amp;orientation=landscape" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                                <span
                                    class="inline-block px-2.5 sm:px-3 py-1 bg-emerald-600 text-white text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Investment</span>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div class="flex items-center space-x-3 sm:space-x-4 text-xs sm:text-sm text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <i class="ri-calendar-line"></i><span class="whitespace-nowrap">Jan 10,
                                        2025</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="ri-time-line"></i><span class="whitespace-nowrap">12 min
                                        read</span>
                                </div>
                            </div>
                            <h3
                                class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                Best Locations for Real Estate Investment in Lagos 2025
                            </h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                Discover the most promising areas in Lagos for property
                                investment with high ROI potential and strong appreciation
                                rates.
                            </p>
                            <div
                                class="flex items-center space-x-2 text-emerald-600 font-semibold text-xs sm:text-sm group-hover:space-x-3 transition-all">
                                <span class="whitespace-nowrap">Read Article</span><i class="ri-arrow-right-line"></i>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="text-center mt-8 sm:mt-12">
                    <a href="https://wa.me/2348067042140?text=Hello%2C%20I%20want%20to%20read%20more%20real%20estate%20articles%20on%20Propatis."
                        target="_blank" rel="noopener noreferrer"
                        class="inline-block px-6 sm:px-8 py-3 sm:py-4 border-2 border-gray-900 hover:bg-gray-900 text-gray-900 hover:text-white font-semibold rounded-xl transition-all duration-300 whitespace-nowrap text-sm sm:text-base cursor-pointer">View
                        All Articles</a>
                </div>
            </div>
        </section>
        <section id="contact" class="py-14 sm:py-24 bg-stone-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 items-start">
                    <div class="space-y-6 sm:space-y-8">
                        <div class="space-y-3 sm:space-y-4">
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-serif text-gray-900">
                                Get in Touch
                            </h2>
                            <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                                Have questions about listing your property or need
                                assistance? We're here to help you every step of the way.
                            </p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3 sm:gap-4">
                            <div
                                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start space-x-3 sm:space-x-4">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-emerald-100 rounded-lg sm:rounded-xl flex-shrink-0">
                                        <i class="ri-phone-line text-emerald-600 text-lg sm:text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">
                                            Phone
                                        </h4>
                                        <a href="tel:+2348067042140"
                                            class="text-emerald-600 hover:text-emerald-700 font-medium cursor-pointer text-sm sm:text-base">08067042140</a>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                                            Mon-Sat, 8AM-6PM
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start space-x-3 sm:space-x-4">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-emerald-100 rounded-lg sm:rounded-xl flex-shrink-0">
                                        <i class="ri-mail-line text-emerald-600 text-lg sm:text-xl"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">
                                            Email
                                        </h4>
                                        <a href="mailto:louis670421@gmail.com"
                                            class="text-emerald-600 hover:text-emerald-700 font-medium cursor-pointer break-all text-sm sm:text-base">louis670421@gmail.com</a>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                                            24/7 support
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start space-x-3 sm:space-x-4">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-emerald-100 rounded-lg sm:rounded-xl flex-shrink-0">
                                        <i class="ri-whatsapp-line text-emerald-600 text-lg sm:text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">
                                            WhatsApp
                                        </h4>
                                        <a href="https://wa.me/2348067042140" target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-emerald-600 hover:text-emerald-700 font-medium cursor-pointer text-sm sm:text-base">Chat
                                            with us</a>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                                            Quick response
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start space-x-3 sm:space-x-4">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-emerald-100 rounded-lg sm:rounded-xl flex-shrink-0">
                                        <i class="ri-map-pin-line text-emerald-600 text-lg sm:text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">
                                            Office Address
                                        </h4>
                                        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                                            94 Off Alashe Junction, Opposite Police Barracks,
                                            Igbogbo Road, Ikorodu, Lagos
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-10">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-5 sm:mb-6">
                            Send us a Message
                        </h3>
                        <form id="contact-form" data-readdy-form="true" class="space-y-4 sm:space-y-5">
                            <div>
                                <label for="name"
                                    class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Full
                                    Name *</label><input id="name" required=""
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                                    placeholder="Enter your full name" type="text" value=""
                                    name="name" />
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Email
                                    Address *</label><input id="email" required=""
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                                    placeholder="your.email@example.com" type="email" value=""
                                    name="email" />
                            </div>
                            <div>
                                <label for="phone"
                                    class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Phone
                                    Number *</label><input id="phone" required=""
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                                    placeholder="08012345678" type="tel" value="" name="phone" />
                            </div>
                            <div>
                                <label for="subject"
                                    class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Subject
                                    *</label><select id="subject" name="subject" required=""
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent appearance-none text-sm cursor-pointer">
                                    <option value="">Select a subject</option>
                                    <option value="List Property">List a Property</option>
                                    <option value="Property Inquiry">
                                        Property Inquiry
                                    </option>
                                    <option value="Technical Support">
                                        Technical Support
                                    </option>
                                    <option value="Payment Issue">Payment Issue</option>
                                    <option value="General Question">
                                        General Question
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="message"
                                    class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Message
                                    *</label>
                                <textarea id="message" name="message" required="" maxlength="500" rows="4"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none text-sm"
                                    placeholder="Tell us how we can help you..."></textarea>
                                <p class="text-[10px] sm:text-xs text-gray-500 mt-1">
                                    0/500 characters
                                </p>
                            </div>
                            <button type="submit"
                                class="w-full py-3 sm:py-4 bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-400 text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:transform-none whitespace-nowrap text-sm sm:text-base cursor-pointer">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@push('scripts')
    <script>
        // Property Categories Slider
        let currentSlide = 4; // Start with slide-4 (Short-Let Apartments) as active
        const totalSlides = 5;

        // Slide positions configuration
        const slideConfigs = [{
                z: 10,
                opacity: 0.5,
                scale: 0.9,
                translateX: '75%',
                translateXSm: '60%'
            }, // slide-0
            {
                z: 0,
                opacity: 0,
                scale: 0.75,
                translateX: '0%',
                translateXSm: '0%'
            }, // slide-1
            {
                z: 0,
                opacity: 0,
                scale: 0.75,
                translateX: '0%',
                translateXSm: '0%'
            }, // slide-2
            {
                z: 10,
                opacity: 0.5,
                scale: 0.9,
                translateX: '-75%',
                translateXSm: '-60%'
            }, // slide-3
            {
                z: 20,
                opacity: 1,
                scale: 1,
                translateX: '0%',
                translateXSm: '0%'
            } // slide-4 (active)
        ];

        function updateSlides() {
            for (let i = 0; i < totalSlides; i++) {
                const slide = document.getElementById(`slide-${i}`);
                const config = slideConfigs[(i - currentSlide + totalSlides) % totalSlides];

                slide.style.zIndex = config.z;
                slide.style.opacity = config.opacity;
                slide.style.transform =
                    `scale(${config.scale}) translateX(${window.innerWidth >= 640 ? config.translateXSm : config.translateX})`;
            }

            // Update dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.getElementById(`dot-${i}`);
                if (i === currentSlide) {
                    dot.className =
                        'transition-all duration-500 rounded-full cursor-pointer w-8 sm:w-10 h-2.5 sm:h-3 bg-emerald-500';
                } else {
                    dot.className =
                        'transition-all duration-500 rounded-full cursor-pointer w-2.5 sm:w-3 h-2.5 sm:h-3 bg-gray-300 hover:bg-gray-400';
                }
            }
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlides();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlides();
        }

        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateSlides();
        }

        // Event listeners
        document.getElementById('next-btn').addEventListener('click', nextSlide);
        document.getElementById('prev-btn').addEventListener('click', prevSlide);

        for (let i = 0; i < totalSlides; i++) {
            document.getElementById(`dot-${i}`).addEventListener('click', () => goToSlide(i));
        }

        // Initialize
        updateSlides();
    </script>
@endpush
