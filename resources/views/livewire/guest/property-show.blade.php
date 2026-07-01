<div x-data="{ 
    galleryOpen: false, 
    activeImage: 0,
    images: {{ Js::from($property->media->pluck('url')->count() > 0 ? $property->media->pluck('url') : ['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80']) }},
    next() { this.activeImage = this.activeImage === this.images.length - 1 ? 0 : this.activeImage + 1; },
    prev() { this.activeImage = this.activeImage === 0 ? this.images.length - 1 : this.activeImage - 1; }
}" @keydown.window.escape="galleryOpen = false" @keydown.window.right="if(galleryOpen) next()" @keydown.window.left="if(galleryOpen) prev()">
    <main class="max-w-7xl mx-auto px-4 mt-[90px] mb-12">
        <!-- Breadcrumbs & Header -->
        <div class="mb-6">
            <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                <a href="/" class="hover:text-emerald-600">Home</a>
                <i class="ri-arrow-right-s-line"></i>
                <a href="#" class="hover:text-emerald-600">{{ $property->category->name ?? 'Category' }}</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-gray-900">{{ $property->city->name ?? 'City' }}</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $property->name }}</h1>
            <p class="text-gray-500 mt-2 text-lg"><i class="ri-map-pin-line mr-1 text-emerald-600"></i> {{ $property->display_location }}</p>
        </div>

        <!-- Gallery / Featured Image -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4 h-[400px]">
            <div @click="activeImage = 0; galleryOpen = true" class="md:col-span-3 rounded-2xl overflow-hidden relative group cursor-pointer bg-gray-100">
                <img :src="images[0]" alt="{{ $property->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
            </div>
            <div class="hidden md:grid grid-rows-2 gap-4">
                <div @click="activeImage = 1; galleryOpen = true" class="rounded-2xl overflow-hidden cursor-pointer relative group bg-gray-100" x-show="images.length > 1">
                    <img :src="images[1]" alt="{{ $property->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                </div>
                <div @click="activeImage = 2; galleryOpen = true" class="rounded-2xl overflow-hidden relative cursor-pointer group bg-gray-100" x-show="images.length > 2">
                    <img :src="images[2]" alt="{{ $property->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center transition group-hover:bg-black/60" x-show="images.length > 3">
                        <span class="text-white font-bold text-xl flex items-center gap-1"><i class="ri-image-2-line"></i> +<span x-text="images.length - 3"></span> Photos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Overlay -->
        <div x-show="galleryOpen" class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center backdrop-blur-sm" x-transition.opacity style="display: none;">
            <button @click="galleryOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition bg-black/20 hover:bg-black/40 rounded-full w-12 h-12 flex items-center justify-center z-[110]">
                <i class="ri-close-line text-3xl"></i>
            </button>
            
            <button @click.stop="prev()" class="absolute left-6 text-white/70 hover:text-white transition bg-black/20 hover:bg-black/40 rounded-full w-12 h-12 flex items-center justify-center z-[110]">
                <i class="ri-arrow-left-s-line text-3xl"></i>
            </button>
            
            <img :src="images[activeImage]" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl transition-all duration-300" @click.stop="">
            
            <button @click.stop="next()" class="absolute right-6 text-white/70 hover:text-white transition bg-black/20 hover:bg-black/40 rounded-full w-12 h-12 flex items-center justify-center z-[110]">
                <i class="ri-arrow-right-s-line text-3xl"></i>
            </button>
            
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white font-medium bg-black/40 px-4 py-1.5 rounded-full backdrop-blur-md">
                <span x-text="activeImage + 1"></span> / <span x-text="images.length"></span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Quick Overview -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-wrap gap-8">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Bedrooms</p>
                        <p class="font-bold text-xl flex items-center gap-2"><i class="ri-hotel-bed-line text-emerald-600"></i> {{ $property->featureValue('bedrooms') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Bathrooms</p>
                        <p class="font-bold text-xl flex items-center gap-2"><i class="ri-drop-line text-emerald-600"></i> {{ $property->featureValue('bathrooms') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Area</p>
                        <p class="font-bold text-xl flex items-center gap-2"><i class="ri-ruler-line text-emerald-600"></i> {{ $property->featureValue('area') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Category</p>
                        <p class="font-bold text-xl text-emerald-600">{{ $property->category->name ?? 'Property' }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">About this property</h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed space-y-4">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Features & Amenities -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Features & Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-2">
                        @forelse ($property->features as $feature)
                        <div class="flex items-center gap-3 text-gray-700">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600"><i class="ri-check-line"></i></div>
                            <span>{{ $feature->feature }} {{ $feature->value && $feature->value !== '1' ? ' - ' . $feature->value : '' }}</span>
                        </div>
                        @empty
                        <div class="text-gray-500 text-sm">No specific features listed.</div>
                        @endforelse
                    </div>
                </div>

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
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="₦30,000,000" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Interest Rate</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" value="15%">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Loan Term</label>
                            <select class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
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

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Sticky Action Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-emerald-50 sticky top-28">
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-1">Asking Price</p>
                        <div class="text-4xl font-extrabold text-emerald-600 tracking-tight">{{ $property->currency?->symbol ?? '₦' }}{{ number_format($property->cost) }}</div>
                    </div>
                    
                    <div class="space-y-3">
                        @if($property->contact_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $property->contact_whatsapp) }}" target="_blank" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 transition transform hover:-translate-y-0.5">
                            <i class="ri-whatsapp-line text-xl"></i> WhatsApp Owner
                        </a>
                        @endif
                        <div class="grid grid-cols-2 gap-3">
                            <a href="tel:{{ $property->contact_phone }}" class="w-full py-3 border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-bold rounded-xl flex items-center justify-center gap-2 transition">
                                <i class="ri-phone-fill"></i> Call
                            </a>
                            <a href="mailto:{{ $property->contact_email }}" class="w-full py-3 border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-bold rounded-xl flex items-center justify-center gap-2 transition">
                                <i class="ri-mail-send-fill"></i> Email
                            </a>
                        </div>
                    </div>



                    <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-2 gap-3">
                        <button class="py-2.5 px-2 text-gray-700 font-medium rounded-xl flex flex-col items-center justify-center gap-1 transition bg-gray-50 hover:bg-emerald-50 hover:text-emerald-600 group">
                            <i class="ri-heart-3-line text-xl group-hover:fill-emerald-600"></i> 
                            <span class="text-xs">Save Property</span>
                        </button>
                        <button class="py-2.5 px-2 text-gray-700 font-medium rounded-xl flex flex-col items-center justify-center gap-1 transition bg-gray-50 hover:bg-emerald-50 hover:text-emerald-600 group">
                            <i class="ri-notification-3-line text-xl"></i> 
                            <span class="text-xs">Set Alert</span>
                        </button>
                    </div>
                    
                    <div class="mt-6 bg-gray-50 rounded-xl p-4 flex items-center gap-4 border border-gray-100">
                        <div class="relative">
                            <img src="{{ $property->user?->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($property->user?->name ?? 'User') }}" alt="Owner" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                            <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 truncate flex items-center gap-1">{{ $property->user?->name ?? 'Property Owner' }} <i class="ri-verified-badge-fill text-blue-500 text-sm"></i></p>
                            <p class="text-xs text-gray-500 mb-1">Listed Property Owner</p>
                            <p class="text-xs text-emerald-600 font-medium">Verified Profile</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <button wire:click="$set('showReportModal', true)" class="text-xs text-gray-400 hover:text-red-500 transition underline">Report this listing</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
