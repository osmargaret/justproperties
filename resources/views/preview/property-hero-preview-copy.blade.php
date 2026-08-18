@extends('layouts.app')

@section('content')
<div x-data="{ 
    galleryOpen: false, 
    activeSlide: 0,
    images: [
        'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
        'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
        'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'
    ],
    next() { this.activeSlide = (this.activeSlide + 1) % this.images.length; },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.images.length) % this.images.length; }
}" @keydown.window.escape="galleryOpen = false" @keydown.window.right="if(galleryOpen) next()" @keydown.window.left="if(galleryOpen) prev()" class="bg-gray-50 min-h-screen pt-[70px]">

    <!-- HERO SLIDER SECTION -->
    <section class="relative w-full h-[520px] md:h-[620px] lg:h-[680px] bg-gray-950 overflow-hidden group">
        
        <!-- Background Slider Images -->
        <template x-for="(img, idx) in images" :key="idx">
            <div x-show="activeSlide === idx" 
                 x-transition:enter="transition ease-out duration-700" 
                 x-transition:enter-start="opacity-0 scale-105" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-500" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95" 
                 class="absolute inset-0 w-full h-full">
                <img :src="img" alt="Property Image" class="w-full h-full object-cover">
            </div>
        </template>

        <!-- Dark Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/50 to-black/30"></div>

        <!-- Top Breadcrumbs & Floating Controls -->
        <div class="absolute top-6 left-0 right-0 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Breadcrumb Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-black/40 backdrop-blur-md rounded-full text-xs sm:text-sm text-gray-200 border border-white/10 shadow-lg">
                <a href="/" class="hover:text-emerald-400 transition">Home</a>
                <i class="ri-arrow-right-s-line text-gray-400"></i>
                <span class="hover:text-emerald-400 transition cursor-pointer">Rent & Lease</span>
                <i class="ri-arrow-right-s-line text-gray-400"></i>
                <span class="text-white font-medium">Ikeja GRA</span>
            </div>

            <!-- Action Tools (Share, Save, Fullscreen) -->
            <div class="flex items-center gap-2">
                <button @click="galleryOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-black/50 hover:bg-emerald-600 text-white rounded-full text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 transition-all shadow-lg cursor-pointer">
                    <i class="ri-fullscreen-line text-base"></i>
                    <span class="hidden sm:inline">View Photos</span> (<span x-text="images.length"></span>)
                </button>
                <button class="w-10 h-10 bg-black/50 hover:bg-white hover:text-gray-900 text-white rounded-full flex items-center justify-center backdrop-blur-md border border-white/15 transition shadow-lg cursor-pointer">
                    <i class="ri-heart-line text-lg"></i>
                </button>
                <button class="w-10 h-10 bg-black/50 hover:bg-white hover:text-gray-900 text-white rounded-full flex items-center justify-center backdrop-blur-md border border-white/15 transition shadow-lg cursor-pointer">
                    <i class="ri-share-line text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Slider Navigation Arrows -->
        <button @click="prev()" class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/40 hover:bg-emerald-600 text-white backdrop-blur-md border border-white/15 flex items-center justify-center transition-all duration-300 opacity-80 hover:opacity-100 hover:scale-110 cursor-pointer shadow-2xl">
            <i class="ri-arrow-left-s-line text-2xl"></i>
        </button>
        <button @click="next()" class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/40 hover:bg-emerald-600 text-white backdrop-blur-md border border-white/15 flex items-center justify-center transition-all duration-300 opacity-80 hover:opacity-100 hover:scale-110 cursor-pointer shadow-2xl">
            <i class="ri-arrow-right-s-line text-2xl"></i>
        </button>

        <!-- FLOATING HERO INFO PANEL (ON TOP OF SLIDER) -->
        <div class="absolute bottom-8 sm:bottom-12 left-0 right-0 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                
                <!-- Left Column: Title, Badges, Location & Short Description -->
                <div class="lg:col-span-8 space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                            For Rent
                        </span>
                        <span class="px-3 py-1 bg-yellow-500/90 text-black text-xs font-extrabold uppercase tracking-wider rounded-full backdrop-blur-md shadow-md flex items-center gap-1">
                            ⭐ Boosted Listing
                        </span>
                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full backdrop-blur-md border border-white/15">
                            Verified Owner
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white font-serif leading-tight drop-shadow-lg">
                        Luxury 4 Bedroom Detached Duplex with Swimming Pool
                    </h1>

                    <p class="text-emerald-300 text-sm sm:text-base lg:text-lg flex items-center gap-2 font-medium drop-shadow">
                        <i class="ri-map-pin-2-fill text-emerald-400 text-lg"></i>
                        <span>Isaac John Street, Ikeja GRA, Lagos State</span>
                    </p>

                    <p class="text-gray-200 text-xs sm:text-sm lg:text-base max-w-3xl line-clamp-2 leading-relaxed text-shadow-sm">
                        Exquisitely finished 4-bedroom detached mansion featuring modern automated fittings, private swimming pool, smart security systems, and a spacious paved compound in a serene gated estate.
                    </p>
                </div>

                <!-- Right Column: Price & Quick Action Card -->
                <div class="lg:col-span-4 flex flex-col items-start lg:items-end justify-end space-y-3">
                    <div class="p-4 sm:p-5 bg-black/60 backdrop-blur-xl rounded-2xl border border-white/15 shadow-2xl text-left lg:text-right w-full sm:w-auto">
                        <p class="text-xs text-gray-300 font-medium uppercase tracking-wider mb-1">Asking Rent</p>
                        <div class="text-3xl sm:text-4xl font-black text-white flex items-baseline gap-1">
                            <span class="text-emerald-400">₦85,000,000</span>
                            <span class="text-xs sm:text-sm font-normal text-gray-300">/year</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Slider Dots / Progress Indicator -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            <template x-for="(img, idx) in images" :key="idx">
                <button @click="activeSlide = idx" 
                        :class="activeSlide === idx ? 'w-8 bg-emerald-400' : 'w-2.5 bg-white/40 hover:bg-white/70'" 
                        class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
            </template>
        </div>

    </section>

    <!-- PAGE BODY CONTENT BELOW HERO -->
    <main class="white-header max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Quick Overview Bar -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-bed-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Bedrooms</p>
                        <p class="text-base font-bold text-gray-900">4 Beds</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-drop-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Bathrooms</p>
                        <p class="text-base font-bold text-gray-900">5 Baths</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-restaurant-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Kitchens</p>
                        <p class="text-base font-bold text-gray-900">2 Kitchens</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-file-text-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Document</p>
                        <p class="text-base font-bold text-gray-900">C of O</p>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200/80 space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ri-file-list-3-line text-emerald-600"></i> Property Description
                    </h3>
                    <div class="prose max-w-none text-gray-700 text-sm sm:text-base leading-relaxed space-y-3">
                        <p>Welcome to luxury living at Isaac John Street, Ikeja GRA. This contemporary 4-bedroom detached duplex is masterfully engineered with state-of-the-art architectural finishes, smart home technology, and unmatched security features.</p>
                        <p>Key highlights include a private swimming pool, expansive living hall with high ceilings, fully equipped chef's kitchen with marble countertops, all en-suite bedrooms with walk-in closets, and a dedicated boys' quarters (BQ).</p>
                    </div>
                </div>

                <!-- Property Features Checklist -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200/80 space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ri-checkbox-circle-line text-emerald-600"></i> Key Amenities & Features
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> Swimming Pool
                        </div>
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> 24/7 Security
                        </div>
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> Solar Inverter
                        </div>
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> Fitted Kitchen
                        </div>
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> Ample Parking (6 Cars)
                        </div>
                        <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                            <i class="ri-check-line text-emerald-600 font-bold"></i> Water Treatment Plant
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sticky Sidebar: Contact & Owner Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-emerald-100 space-y-6 sticky top-24">
                    
                    <!-- Owner / Agent Profile Header -->
                    <div class="flex items-center gap-4 pb-5 border-b border-gray-100">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Seller Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-emerald-500 shadow">
                        <div>
                            <h4 class="font-bold text-gray-900 text-base">Supreme Haven Real Estate</h4>
                            <p class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                                <i class="ri-verified-badge-fill"></i> Verified Property Agent
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">Member since 2024</p>
                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div class="space-y-3">
                        <a href="tel:+2348000000000" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                            <i class="ri-phone-line text-lg"></i>
                            <span>Call Agent (+234 800 000 0000)</span>
                        </a>
                        <a href="https://wa.me/2348000000000" target="_blank" class="w-full py-3.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-semibold rounded-xl text-sm shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                            <i class="ri-whatsapp-line text-lg"></i>
                            <span>Chat on WhatsApp</span>
                        </a>
                    </div>

                    <!-- Request Inspection Form -->
                    <form class="space-y-3 pt-3 border-t border-gray-100" onsubmit="event.preventDefault(); alert('Inspection request submitted!');">
                        <h5 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Book Property Inspection</h5>
                        <input type="text" placeholder="Your Full Name" class="w-full px-3.5 py-2.5 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        <input type="email" placeholder="Your Email Address" class="w-full px-3.5 py-2.5 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        <input type="text" placeholder="Preferred Date (e.g. Saturday 10:00 AM)" class="w-full px-3.5 py-2.5 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500">
                        <button type="submit" class="w-full py-2.5 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition cursor-pointer">
                            Schedule Inspection
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </main>

    <!-- FULLSCREEN LIGHTBOX OVERLAY -->
    <div x-show="galleryOpen" class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center backdrop-blur-md" x-transition.opacity style="display: none;">
        <button @click="galleryOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition bg-black/40 hover:bg-black/60 rounded-full w-12 h-12 flex items-center justify-center z-[110] cursor-pointer">
            <i class="ri-close-line text-3xl"></i>
        </button>
        
        <button @click.stop="prev()" class="absolute left-6 text-white/70 hover:text-white transition bg-black/40 hover:bg-black/60 rounded-full w-12 h-12 flex items-center justify-center z-[110] cursor-pointer">
            <i class="ri-arrow-left-s-line text-3xl"></i>
        </button>
        
        <img :src="images[activeSlide]" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl transition-all duration-300" @click.stop="">
        
        <button @click.stop="next()" class="absolute right-6 text-white/70 hover:text-white transition bg-black/40 hover:bg-black/60 rounded-full w-12 h-12 flex items-center justify-center z-[110] cursor-pointer">
            <i class="ri-arrow-right-s-line text-3xl"></i>
        </button>
        
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white font-medium bg-black/50 px-4 py-1.5 rounded-full backdrop-blur-md text-xs sm:text-sm">
            <span x-text="activeSlide + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>

</div>
@endsection
