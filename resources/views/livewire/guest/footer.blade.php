<footer class="text-white mt-12 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900">
    <div class="max-w-7xl mx-auto px-4 pt-12">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Propatis" class="h-10 w-auto" />
                    <span class="text-xl font-bold font-serif">Propatis</span>
                </div>
                <p class="text-emerald-200 text-sm mb-6 leading-normal">Nigeria's premier direct property marketplace connecting verified owners with serious buyers and renters.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                        <i class="ri-instagram-line"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                        <i class="ri-facebook-fill"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                        <i class="ri-twitter-x-line"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                        <i class="ri-linkedin-fill"></i>
                    </a>
                </div>
            </div>
            <div>
                <div class="">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-4">
                        Stay Updated
                    </h3>
                    <form wire:submit="subscribe" class="space-y-3 sm:space-y-4">
                        <div class="">
                            <input wire:model="email" placeholder="Enter your email" required=""
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-transparent border-b-2 border-white/30 focus:border-white text-white placeholder-emerald-200 outline-none transition-colors text-xs sm:text-sm"
                                type="email" />
                            @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="">
                            <select wire:model="categoryId" required class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-emerald-800 hover:bg-emerald-700 disabled:bg-emerald-700 rounded-lg transition-colors cursor-pointer whitespace-nowrap text-white placeholder-emerald-200 outline-none transition-colors text-xs sm:text-sm">
                                <option value="">Select Property Type</option>
                                @foreach($propertyCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categoryId') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-emerald-500 hover:bg-emerald-400 disabled:bg-emerald-700 rounded-lg transition-colors cursor-pointer flex items-center justify-center gap-2 whitespace-nowrap text-white">
                            <span wire:loading.remove wire:target="subscribe">Get property alerts. <i class="ri-arrow-right-line text-sm sm:text-base"></i></span>
                            <span wire:loading wire:target="subscribe"><i class="ri-loader-4-line animate-spin"></i> Subscribing...</span>
                        </button>

                        @if($errorMessage)
                            <div class="text-red-400 text-xs mt-2">{{ $errorMessage }}</div>
                        @endif
                    </form>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-4">Quick Links</h3>
                <nav class="flex flex-col gap-3">
                    <a href="{{ route('about') }}" class="text-emerald-200 hover:text-white text-sm transition">About Us</a>
                    <a href="{{ route('pricing') }}" class="text-emerald-200 hover:text-white text-sm transition">Pricing</a>
                    <a href="{{ route('blog') }}" class="text-emerald-200 hover:text-white text-sm transition">Blog</a>
                    <a href="{{ route('contact') }}" class="text-emerald-200 hover:text-white text-sm transition">Contact</a>
                    <a href="{{ route('advertise') }}" class="text-emerald-200 hover:text-white text-sm transition">Advertize</a>
                </nav>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-4">Resources</h3>
                <nav class="flex flex-col gap-3">
                    @foreach($nonPropertyCategories as $category)
                        <a href="{{ route('blog', ['category' => $category->slug]) }}" class="text-emerald-200 hover:text-white text-sm transition">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-4">Contact Us</h3>
                <div class="flex flex-col gap-3">
                    <a href="tel:+2348067042140" class="flex items-center gap-2 text-emerald-200 hover:text-white text-sm transition">
                        <i class="ri-phone-line"></i>
                        08067042140
                    </a>
                    <a href="mailto:louis670421@gmail.com" class="flex items-center gap-2 text-emerald-200 hover:text-white text-sm transition">
                        <i class="ri-mail-line"></i>
                        louis670421@gmail.com
                    </a>
                    <a href="#" class="flex items-center gap-2 text-emerald-200 hover:text-white text-sm transition">
                        <i class="ri-whatsapp-line"></i>
                        WhatsApp Support
                    </a>
                    <p class="text-emerald-200 text-xs sm:text-sm leading-relaxed">
                        94 Off Alashe Junction, Opposite Police Barracks, Igbogbo
                        Road, Ikorodu
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-emerald-700/50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-emerald-200 text-sm">© 2026 Propatis. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="{{ route('terms-of-service') }}" class="text-emerald-200 hover:text-white text-sm transition">Terms of Service</a>
                <a href="{{ route('privacy-policy') }}" class="text-emerald-200 hover:text-white text-sm transition">Privacy Policy</a>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if($statusMessage)
        <div class="fixed inset-0 z-[200] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transform transition-all">
                <div class="p-8 text-center text-gray-900">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-check-line text-3xl font-bold"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Subscribed!</h3>
                    <p class="text-gray-600 mb-6">{{ $statusMessage }}</p>
                    <button wire:click="$set('statusMessage', null)" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition">
                        Done
                    </button>
                </div>
            </div>
        </div>
    @endif
</footer>
