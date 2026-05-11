<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        JustProperties Ikorodu Lagos - Buy, Rent &amp; Lease Properties Direct
        from Owners | Real Estate Marketplace Nigeria
    </title>
    <meta name="description"
        content="JustProperties connects property buyers and renters directly with verified owners in Ikorodu, Lagos, Nigeria. Browse landed properties, uncompleted structures, completed properties, short-let apartments. No agent fees. Direct WhatsApp contact. List your property today." />
    <meta name="keywords"
        content="real estate Ikorodu Lagos, properties for sale Nigeria, buy property direct from owner, rent apartment Lagos, short let Ikorodu, landed property Nigeria" />
    <link rel="canonical" href="https://justproperties.com/" />
    <meta name="last-modified" content="2025-01-01" />
    <meta property="og:title" content="JustProperties - Direct Property Marketplace in Ikorodu Lagos Nigeria" />
    <meta property="og:description"
        content="Connect directly with property owners. Buy, rent, or lease properties without agent fees." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://justproperties.com/" />
    <meta property="og:image" content="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="JustProperties - Direct Property Marketplace" />
    <meta name="twitter:description" content="Connect directly with property owners in Lagos Nigeria" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@600&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@600&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600;700;800&amp;display=swap"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
        theme: {
            extend: {
            fontFamily: {
                serif: ['Playfair Display', 'serif'],
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                brand: {
                50: '#ecfdf5',
                100: '#d1fae5',
                200: '#a7f3d0',
                300: '#6ee7b7',
                400: '#34d399',
                500: '#10b981',
                600: '#059669',
                700: '#047857',
                800: '#065f46',
                900: '#064e3b',
                }
            }
            }
        }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
    
    
    @stack('styles')
    
</head>

<body style="overflow: unset">

    <div class="min-h-screen bg-white">
        <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a class="nav-brand flex items-center space-x-2" href="{{ route('welcome') }}">
                    <img alt="JustProperties Logo" class="h-9 sm:h-12 w-auto" src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" />
                    <h1 class="text-lg sm:text-2xl font-bold font-serif text-white">JustProperties</h1>
                </a>
                <div class="hidden lg:flex items-center space-x-5">
                    <a href="{{ route('landed-properties') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Landed Properties</a>
                    <a href="{{ route('uncompleted-properties') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Uncompleted</a>
                    <a href="{{ route('completed-properties') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Completed</a>
                    <a href="{{ route('rent-lease') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Rent/Lease</a>
                    <a href="{{ route('short-lets') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Short-Let</a>
                    <!-- <a href="{{ route('blog') }}" class="text-base font-medium transition-colors whitespace-nowrap cursor-pointer text-white hover:text-emerald-300">Blog</a> -->
                </div>
                <div class="hidden lg:flex items-center space-x-3">
                <a href="{{ route('list-property') }}" class="flex items-center gap-2 text-white px-5 py-2.5 rounded-lg font-medium transition whitespace-nowrap bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-400 hover:from-emerald-700 hover:via-emerald-600 hover:to-emerald-500 shadow-md hover:shadow-lg">
                    <i class="ri-add-circle-line text-lg"></i>List Property
                </a>
                @guest
                <a href="{{ route('login') }}" class="text-base flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium transition-colors cursor-pointer whitespace-nowrap text-white hover:bg-white/10">
                    <i class="ri-user-line text-xl w-5 h-5 flex items-center justify-center"></i>
                    <span class="text-sm">Sign In</span>
                </a>
                @else
                <a href="{{ auth()->user()->dashboard_url }}" class="nav-auth-pill flex items-center gap-3 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-full cursor-pointer transition-colors">
                    <span class="w-8 h-8 shrink-0 rounded-full bg-emerald-600 flex items-center justify-center text-white text-sm font-semibold">{{ strtoupper(auth()->user()->initials()) }}</span>
                    <span class="hidden sm:block text-left">
                        <span class="nav-auth-name block text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                        <span class="nav-auth-sub block text-xs text-emerald-300">{{ auth()->user()->position }}</span>
                    </span>
                    <i class="nav-auth-chevron ri-arrow-down-s-line text-white/70"></i>
                </a>
                @endguest
                </div>
                <div class="flex items-center space-x-3 lg:hidden">
                <a href="{{ route('list-property') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 rounded-lg transition text-gray-700">
                    <i class="ri-add-circle-line text-xl"></i>
                    <span class="font-medium">List Property</span>
                </a>
                <button id="mobileMenuToggle" class="p-2 rounded-lg cursor-pointer text-white" aria-label="Toggle mobile menu" aria-expanded="false">
                    <i class="ri-menu-line text-2xl"></i>
                </button>
                </div>
            </div>
            </div>
            <div id="mobileMenu" class="mobile-menu lg:hidden">
                <div class="px-4 py-5 flex flex-col gap-1">
                    <a href="{{ route('landed-properties') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-landscape-line text-lg"></i>
                        <span class="font-medium">Landed Properties</span>
                    </a>
                    <a href="{{ route('uncompleted-properties') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-building-2-line text-lg"></i>
                        <span class="font-medium">Uncompleted</span>
                    </a>
                    <a href="{{ route('completed-properties') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-home-4-line text-lg"></i>
                        <span class="font-medium">Completed</span>
                    </a>
                    <a href="{{ route('rent-lease') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-key-line text-lg"></i>
                        <span class="font-medium">Rent/Lease</span>
                    </a>
                    <a href="{{ route('short-lets') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-hotel-line text-lg"></i>
                        <span class="font-medium">Short-Let</span>
                    </a>
                    <a href="{{ route('blog') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="ri-article-line text-lg"></i>
                        <span class="font-medium">Blog</span>
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="mt-2 flex items-center gap-3 px-4 py-3 rounded-lg transition bg-emerald-600 text-white hover:bg-emerald-700">
                        <i class="ri-user-line text-lg"></i>
                        <span class="font-medium">Sign In / Sign Up</span>
                    </a>
                    @else
                    <a href="{{ auth()->user()->dashboard_url }}" class="mt-2 flex items-center gap-3 px-4 py-3 rounded-lg transition bg-gray-100 text-gray-900 hover:bg-gray-200">
                        <span class="w-10 h-10 shrink-0 rounded-full bg-emerald-600 flex items-center justify-center text-white text-sm font-semibold">{{ strtoupper(auth()->user()->initials()) }}</span>
                        <div class="min-w-0 flex-1">
                            <div class="font-medium truncate">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-emerald-600">{{ auth()->user()->position }}</div>
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-1 px-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 text-left font-medium">
                            <i class="ri-logout-box-r-line text-lg"></i>
                            <span>Log out</span>
                        </button>
                    </form>
                    @endguest
                </div>
            </div>
        </nav>

        {{ $slot }}

    
        <footer class="text-white mt-12 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900">
            <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
                <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" alt="JustProperties" class="h-10 w-auto" />
                    <span class="text-xl font-bold font-serif">JustProperties</span>
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
                        <form id="newsletter-form" data-readdy-form="true" class="space-y-3 sm:space-y-4">
                            <div class="">
                                <input placeholder="Enter your email" required=""
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-transparent border-b-2 border-white/30 focus:border-white text-white placeholder-emerald-200 outline-none transition-colors text-xs sm:text-sm"
                                    type="email" value="" name="email" />
                                
                            </div>
                            <div class="">
                                <select class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-emerald-800 hover:bg-emerald-700 disabled:bg-emerald-700 rounded-lg transition-colors cursor-pointer whitespace-nowrap text-white placeholder-emerald-200 outline-none transition-colors text-xs sm:text-sm" name="" id="">
                                    <option value="">Select Property Type</option>
                                    <option value="1">Landed Property</option>
                                    <option value="2">Uncompleted Property</option>
                                    <option value="3">Completed Property</option>
                                    <option value="4">Rent/Lease Property</option>
                                    <option value="5">Short-Let Property</option>
                                </select>
                                
                            </div>

                            <button type="submit"
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-emerald-500 hover:bg-emerald-400 disabled:bg-emerald-700 rounded-lg transition-colors cursor-pointer whitespace-nowrap text-white">
                                Get property alerts.
                                <i class="ri-arrow-right-line text-sm sm:text-base"></i>
                            </button>
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
                    </nav>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-300 mb-4">Resources</h3>
                    <nav class="flex flex-col gap-3">
                        <a href="#" class="text-emerald-200 hover:text-white text-sm transition">Buying Guide</a>
                        <a href="#" class="text-emerald-200 hover:text-white text-sm transition">Legal Tips</a>
                        <a href="#" class="text-emerald-200 hover:text-white text-sm transition">Investment Guide</a>
                        <a href="#" class="text-emerald-200 hover:text-white text-sm transition">Market Report</a>
                        <a href="index.html" class="text-emerald-200 hover:text-white text-sm transition">FAQ</a>
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
                <p class="text-emerald-200 text-sm">© 2026 JustProperties. All rights reserved.</p>
                <div class="flex gap-6">
                <a href="{{ route('terms-of-service') }}" class="text-emerald-200 hover:text-white text-sm transition">Terms of Service</a>
                <a href="{{ route('privacy-policy') }}" class="text-emerald-200 hover:text-white text-sm transition">Privacy Policy</a>
                </div>
            </div>
            </div>
        </footer>
        <button
            class="fixed bottom-6 right-4 sm:right-6 z-50 w-14 h-14 sm:w-16 sm:h-16 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 flex items-center justify-center group cursor-pointer"
            aria-label="WhatsApp Support">
            <i class="ri-customer-service-2-line text-xl sm:text-2xl group-hover:scale-110 transition-transform"></i>
            <div
                class="absolute right-full mr-3 sm:mr-4 bg-gray-900 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap hidden sm:block">
                Need Help? Chat with us
                <div class="absolute top-1/2 -right-1 -translate-y-1/2 w-2 h-2 bg-gray-900 transform rotate-45">
                </div>
            </div>
            <span class="absolute inset-0 rounded-full bg-emerald-400 animate-ping opacity-75"></span>
        </button>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', () => {
                const isOpen = mobileMenu.classList.toggle('open');
                mobileMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        const forceSolidNavbar = Boolean(
            document.querySelector('.white-header, .force-solid-navbar, [data-navbar="solid"]')
        );

        const updateNavbarState = () => {
            if (!navbar) return;

            if (forceSolidNavbar || window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };

        updateNavbarState();
        window.addEventListener('scroll', updateNavbarState);
    </script>
    @stack('scripts')
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
</body>

</html>
