@php
    $rentFreq = $property->featureValue('rent_amount_frequency');
    $freqSuffix = match (strtolower(trim($rentFreq ?? ''))) {
        'per annum', 'per year', 'yearly', 'annually', 'year' => '/year',
        'per month', 'monthly', 'month' => '/month',
        'per week', 'weekly', 'week' => '/week',
        'per day', 'daily', 'day' => '/day',
        'per night', 'nightly', 'night' => '/night',
        'per quarter', 'quarterly', 'quarter' => '/quarter',
        default => $rentFreq ? '/' . strtolower(trim(str_ireplace(['per ', 'Per '], '', $rentFreq))) : '',
    };

    $rawFeatures = $property->features;
    $featuresList = [];
    if ($rawFeatures) {
        $decoded = json_decode($rawFeatures, true);
        $featuresList = is_array($decoded) ? $decoded : array_map('trim', explode(',', (string) $rawFeatures));
    }
@endphp

<div x-data="{ 
    galleryOpen: false, 
    activeSlide: 0,
    images: {{ Js::from($property->media->pluck('url')->count() > 0 ? $property->media->pluck('url') : ['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80']) }},
    next() { this.activeSlide = (this.activeSlide + 1) % this.images.length; },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.images.length) % this.images.length; }
}" @keydown.window.escape="galleryOpen = false" @keydown.window.right="if(galleryOpen) next()" @keydown.window.left="if(galleryOpen) prev()" class="bg-gray-50 min-h-screen">

    <!-- HERO SLIDER SECTION (Starts from top behind navbar) -->
    <section class="relative w-full h-[540px] sm:h-[620px] lg:h-[700px] bg-gray-950 overflow-hidden group">
        
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
                <img :src="img" alt="{{ $property->name }}" class="w-full h-full object-cover">
            </div>
        </template>

        <!-- Dark Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/30 to-gray-950"></div>

        <!-- Top Breadcrumbs & Floating Controls (Below Navbar) -->
        <div class="absolute top-20 sm:top-24 left-0 right-0 z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end md:justify-between items-center">
            <!-- Breadcrumb Pill (Hidden on Mobile) -->
            <div class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-black/40 backdrop-blur-md rounded-full text-xs sm:text-sm text-gray-200 border border-white/10 shadow-lg">
                <a href="/" class="hover:text-emerald-400 transition">Home</a>
                <i class="ri-arrow-right-s-line text-gray-400"></i>
                @if($property->category)
                    <a href="{{ route($property->category->slug) }}" class="hover:text-emerald-400 transition cursor-pointer">{{ $property->category->name }}</a>
                    <i class="ri-arrow-right-s-line text-gray-400"></i>
                @endif
                <span class="text-white font-medium truncate max-w-[200px]">{{ $property->city ?? $property->state?->name ?? 'Details' }}</span>
            </div>

            <!-- Action Tools (Share, Fullscreen) -->
            <div class="flex items-center gap-2">
                <button @click="galleryOpen = true" class="inline-flex items-center gap-2 px-3.5 py-2 bg-black/50 hover:bg-emerald-600 text-white rounded-full text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 transition-all shadow-lg cursor-pointer">
                    <i class="ri-fullscreen-line text-base"></i>
                    <span class="hidden sm:inline">View Photos</span> (<span x-text="images.length"></span>)
                </button>
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Property link copied to clipboard!');" class="w-9 h-9 sm:w-10 sm:h-10 bg-black/50 hover:bg-white hover:text-gray-900 text-white rounded-full flex items-center justify-center backdrop-blur-md border border-white/15 transition shadow-lg cursor-pointer" title="Share Property">
                    <i class="ri-share-line text-base sm:text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Slider Navigation Arrows -->
        <template x-if="images.length > 1">
            <div>
                <button @click="prev()" class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-emerald-600 text-white backdrop-blur-md border border-white/15 flex items-center justify-center transition-all duration-300 opacity-90 hover:opacity-100 hover:scale-110 cursor-pointer shadow-2xl">
                    <i class="ri-arrow-left-s-line text-xl sm:text-2xl"></i>
                </button>
                <button @click="next()" class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-emerald-600 text-white backdrop-blur-md border border-white/15 flex items-center justify-center transition-all duration-300 opacity-90 hover:opacity-100 hover:scale-110 cursor-pointer shadow-2xl">
                    <i class="ri-arrow-right-s-line text-xl sm:text-2xl"></i>
                </button>
            </div>
        </template>

        <!-- FLOATING HERO INFO PANEL (ON TOP OF SLIDER) -->
        <div class="absolute bottom-6 sm:bottom-12 left-0 right-0 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                
                <!-- Left Column: Title, Badges, Location & Short Description -->
                <div class="lg:col-span-8 space-y-3">
                    <div class="flex flex-wrap items-center gap-2">
                        @if($property->category)
                            <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                                {{ $property->category->name }}
                            </span>
                        @endif

                        @if($property->promotions()->where('status', 'active')->exists())
                            <span class="px-3 py-1 bg-yellow-500/90 text-black text-xs font-extrabold uppercase tracking-wider rounded-full backdrop-blur-md shadow-md flex items-center gap-1">
                                ⭐ Boosted Listing
                            </span>
                        @endif

                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full backdrop-blur-md border border-white/15">
                            Available
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white font-serif leading-tight drop-shadow-lg">
                        {{ $property->name }}
                    </h1>

                    <p class="text-emerald-300 text-sm sm:text-base lg:text-lg flex items-center gap-2 font-medium drop-shadow">
                        <i class="ri-map-pin-2-fill text-emerald-400 text-lg"></i>
                        <span>{{ $property->display_location }}</span>
                    </p>

                    @if($property->description)
                        <p class="text-gray-200 text-xs sm:text-sm lg:text-base max-w-3xl line-clamp-2 leading-relaxed text-shadow-sm">
                            {{ Str::limit(strip_tags($property->description), 180) }}
                        </p>
                    @endif
                </div>

                <!-- Right Column: Price Badge -->
                <div class="lg:col-span-4 flex flex-col items-start lg:items-end justify-end space-y-3">
                    <div class="p-4 sm:p-5 bg-black/60 backdrop-blur-xl rounded-2xl border border-white/15 shadow-2xl text-left lg:text-right w-full sm:w-auto">
                        <p class="text-xs text-gray-300 font-medium uppercase tracking-wider mb-1">Asking Price</p>
                        <div class="text-3xl sm:text-4xl font-black text-white flex items-baseline gap-1">
                            <span class="text-emerald-400">{{ $property->currency ?? '₦' }}{{ number_format($property->cost) }}</span>
                            @if($freqSuffix)
                                <span class="text-xs sm:text-sm font-normal text-gray-300">{{ $freqSuffix }}</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Slider Dots Indicator (Only if multiple images) -->
        <template x-if="images.length > 1">
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                <template x-for="(img, idx) in images" :key="idx">
                    <button @click="activeSlide = idx" 
                            :class="activeSlide === idx ? 'w-8 bg-emerald-400' : 'w-2.5 bg-white/40 hover:bg-white/70'" 
                            class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                </template>
            </div>
        </template>

    </section>

    <!-- PAGE BODY CONTENT BELOW HERO -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Quick Overview Bar -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-hotel-bed-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Bedrooms</p>
                        <p class="text-base font-bold text-gray-900">{{ $property->featureValue('bedrooms') ?? 'N/A' }} Beds</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-drop-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Bathrooms</p>
                        <p class="text-base font-bold text-gray-900">{{ $property->featureValue('bathrooms') ?? 'N/A' }} Baths</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-restaurant-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Kitchens</p>
                        <p class="text-base font-bold text-gray-900">{{ $property->featureValue('kitchens') ?? 'N/A' }} Kitchens</p>
                    </div>
                    <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <i class="ri-file-text-line text-2xl text-emerald-600 mb-1 block"></i>
                        <p class="text-xs text-gray-500 font-medium">Document / Type</p>
                        <p class="text-base font-bold text-gray-900 truncate" title="{{ $property->featureValue('title_document') ?? $property->featureValue(($property->category?->slug ?? '').'-type') ?? 'Verified' }}">
                            {{ $property->featureValue('title_document') ?? $property->featureValue(($property->category?->slug ?? '').'-type') ?? 'Verified' }}
                        </p>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200/80 space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="ri-file-list-3-line text-emerald-600"></i> Property Description
                    </h3>
                    <div class="prose max-w-none text-gray-700 text-sm sm:text-base leading-relaxed space-y-3">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Property Features Checklist -->
                @if(!empty($featuresList))
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200/80 space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ri-checkbox-circle-line text-emerald-600"></i> Key Amenities & Features
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                            @foreach($featuresList as $feat)
                                <div class="flex items-center gap-2.5 p-3 bg-stone-50 rounded-xl border border-stone-200/60 font-medium text-gray-800">
                                    <i class="ri-check-line text-emerald-600 font-bold"></i> {{ $feat['feature'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Map Location -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Location</h2>
                    <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center relative overflow-hidden">
                        <!-- Placeholder for Map -->
                        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                        <div class="text-center z-10">
                            <i class="ri-map-pin-2-fill text-4xl text-emerald-600"></i>
                            <p class="font-medium text-gray-700 mt-2">{{ $property->display_location }}</p>
                        </div>
                    </div>
                </div>

                <!-- Mortgage Calculator -->
                <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100">
                    <h2 class="text-2xl font-bold mb-2 text-gray-900">Mortgage Calculator</h2>
                    <p class="text-gray-600 mb-6">Estimate your monthly payments for this property.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Down Payment (20%)</label>
                            <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="₦30,000,000" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Interest Rate</label>
                            <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="15%">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Loan Term</label>
                            <select class="w-full p-2 border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option>15 Years</option>
                                <option>20 Years</option>
                                <option>30 Years</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl border border-emerald-200 flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Estimated Monthly Payment</p>
                            <p class="text-2xl font-bold text-emerald-600">₦1,680,500<span class="text-sm font-normal text-gray-500">/mo</span></p>
                        </div>
                    </div>
                </div>

                <!-- Financing Adverts -->
                <div class="mt-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Sponsored Financing Partners</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="#" class="block p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:shadow-md transition bg-white group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-bold text-gray-900">Access Bank Mortgages</div>
                                <i class="ri-external-link-line text-gray-400 group-hover:text-emerald-500"></i>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Get pre-approved for up to ₦100M with competitive interest rates.</p>
                            <span class="text-xs font-semibold text-emerald-600">Apply Now</span>
                        </a>
                        <a href="#" class="block p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:shadow-md transition bg-white group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="font-bold text-gray-900">Stanbic IBTC Home Loans</div>
                                <i class="ri-external-link-line text-gray-400 group-hover:text-emerald-500"></i>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Flexible equity contributions and up to 20 years repayment plan.</p>
                            <span class="text-xs font-semibold text-emerald-600">Learn More</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right Sticky Sidebar: Contact & Owner Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-emerald-100 space-y-6 sticky top-24">
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Asking Price</p>
                        <div class="text-3xl font-extrabold text-emerald-600 tracking-tight flex items-baseline gap-1">
                            <span>{{ $property->currency ?? '₦' }}{{ number_format($property->cost) }}</span>
                            @if($freqSuffix)
                                <span class="text-sm font-normal text-gray-500">{{ $freqSuffix }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        @if($property->contact_whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $property->contact_whatsapp) }}" target="_blank" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 transition transform hover:-translate-y-0.5">
                                <i class="ri-whatsapp-line text-xl"></i> WhatsApp Owner
                            </a>
                        @endif
                        <div class="grid grid-cols-2 gap-3">
                            @if($property->contact_phone)
                                <a href="tel:{{ $property->contact_phone }}" class="w-full py-3 border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-bold rounded-xl flex items-center justify-center gap-2 transition text-xs sm:text-sm">
                                    <i class="ri-phone-fill"></i> Call
                                </a>
                            @endif
                            @if($property->contact_email)
                                <a href="mailto:{{ $property->contact_email }}" class="w-full py-3 border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-bold rounded-xl flex items-center justify-center gap-2 transition text-xs sm:text-sm">
                                    <i class="ri-mail-send-fill"></i> Email
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Owner Profile Box -->
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-4 border border-gray-100">
                        <div class="relative">
                            <img src="{{ $property->user?->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($property->contact_name ?? $property->user?->name ?? 'User') }}" alt="Owner" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                            <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 truncate flex items-center gap-1">
                                {{ $property->contact_name ?? $property->user?->name ?? 'Property Owner' }} 
                                <i class="ri-verified-badge-fill text-blue-500 text-sm"></i>
                            </p>
                            <p class="text-xs text-gray-500 mb-1">Listed Property Contact</p>
                            <p class="text-xs text-emerald-600 font-medium">Verified Profile</p>
                        </div>
                    </div>
                    
                    <div class="text-center pt-2">
                        <button wire:click="$set('showReportModal', true)" class="text-xs text-gray-400 hover:text-red-500 transition underline cursor-pointer">Report this listing</button>
                    </div>
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

    <!-- Report Modal -->
    @if($showReportModal)
    <div class="fixed inset-0 z-[200] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-xl text-gray-900">Report Listing</h3>
                <button wire:click="$set('showReportModal', false)" class="text-gray-400 hover:text-red-500 transition">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <form wire:submit="submitReport" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason for reporting</label>
                        <select wire:model="reportReason" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                            <option value="">Select a reason...</option>
                            <option value="spam">Spam / Fake Listing</option>
                            <option value="fraud">Fraud / Scam</option>
                            <option value="inaccurate">Inaccurate Information</option>
                            <option value="sold">Already Sold / Rented</option>
                            <option value="offensive">Offensive Content</option>
                            <option value="other">Other</option>
                        </select>
                        @error('reportReason') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Additional details (Optional)</label>
                        <textarea wire:model="reportDescription" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Please provide more information..."></textarea>
                        @error('reportDescription') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="$set('showReportModal', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
                        <i class="ri-flag-line"></i> Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-[200] bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3" x-transition>
        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400"><i class="ri-check-line"></i></div>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

</div>
