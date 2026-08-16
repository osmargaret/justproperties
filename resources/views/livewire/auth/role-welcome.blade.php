<div class="role-welcome-wrap">
    <div class="rw-inner">

        {{-- Header --}}
        <div class="rw-header">
            <div class="rw-logo-row">
                <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png" alt="Propatis" class="rw-logo-img">
                <span class="rw-logo-text">Propatis</span>
            </div>
            <h1 class="rw-title">
                Welcome{{ auth()->check() && auth()->user()->name ? ', ' . explode(' ', trim(auth()->user()->name), 2)[0] : '' }}!
            </h1>
            <p class="rw-subtitle">
                What would you like to do today? Choose one of the options below to get started. You can always switch between modes later.
            </p>
        </div>

        {{-- 6-Card Grid --}}
        <div class="rw-grid">

            {{-- 1: Rent --}}
            <a href="{{ route('rent-lease') }}" class="rw-card rw-card--rent" wire:navigate>
                <div class="rw-card-icon">
                    <i class="ri-key-2-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Rent a Property</h2>
                    <p class="rw-card-desc">Browse homes, apartments, and commercial spaces available for rent or lease.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </a>

            {{-- 2: Shortlet --}}
            <a href="{{ route('short-lets') }}" class="rw-card rw-card--shortlet" wire:navigate>
                <div class="rw-card-icon">
                    <i class="ri-hotel-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Book a Shortlet</h2>
                    <p class="rw-card-desc">Find furnished apartments and holiday homes for short-term stays.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </a>

            {{-- 3: Buy --}}
            <a href="{{ route('completed-properties') }}" class="rw-card rw-card--buy" wire:navigate>
                <div class="rw-card-icon">
                    <i class="ri-home-heart-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Buy a Property</h2>
                    <p class="rw-card-desc">Discover land, completed homes, and uncompleted structures for sale across Nigeria.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </a>

            {{-- 4: Sell --}}
            <a href="{{ route('list-property') }}" class="rw-card rw-card--sell" wire:navigate>
                <div class="rw-card-icon">
                    <i class="ri-price-tag-3-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Sell / List Property</h2>
                    <p class="rw-card-desc">List your property directly and connect with verified buyers — no agent fees.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </a>

            {{-- 5: Seller Dashboard --}}
            <button type="button" wire:click="chooseRole('seller')" class="rw-card rw-card--seller-dash">
                <div class="rw-card-icon">
                    <i class="ri-building-2-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Seller Dashboard</h2>
                    <p class="rw-card-desc">Manage your listings, subscriptions, documents, and track leads from buyers.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </button>

            {{-- 6: Buyer Dashboard --}}
            <button type="button" wire:click="chooseRole('buyer')" class="rw-card rw-card--buyer-dash">
                <div class="rw-card-icon">
                    <i class="ri-heart-3-line"></i>
                </div>
                <div class="rw-card-body">
                    <h2 class="rw-card-title">Buyer Dashboard</h2>
                    <p class="rw-card-desc">View saved properties, set alerts, manage subscriptions and stay updated on new listings.</p>
                </div>
                <div class="rw-card-arrow"><i class="ri-arrow-right-line"></i></div>
            </button>

        </div>

        {{-- Footer Note --}}
        <p class="rw-footer-note">
            <a href="{{ route('welcome') }}" class="rw-text-link" wire:navigate>Back to site</a>
            <span class="rw-dot">·</span>
            <form method="POST" action="{{ route('logout') }}" class="rw-inline-form">
                @csrf
                <button type="submit" class="rw-text-btn">Sign out</button>
            </form>
        </p>

    </div>
</div>

@push('styles')
    <style>
        /* ===== Wrap ===== */
        .role-welcome-wrap {
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.22);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            animation: rwSlideUp 0.45s ease-out both;
        }

        @keyframes rwSlideUp {
            from { transform: translateY(24px); opacity: 0; }
            to   { transform: translateY(0);   opacity: 1; }
        }

        .rw-inner { max-width: 960px; margin: 0 auto; }

        /* ===== Header ===== */
        .rw-header {
            text-align: center;
            margin-bottom: 2.25rem;
        }

        .rw-logo-row {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .rw-logo-img {
            width: 36px;
            height: 36px;
            border-radius: 0.5rem;
        }

        .rw-logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #111827;
        }

        .rw-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.65rem, 4vw, 2.1rem);
            color: #111827;
            margin-bottom: 0.6rem;
        }

        .rw-subtitle {
            color: #4b5563;
            font-size: 0.9375rem;
            line-height: 1.65;
            max-width: 44rem;
            margin: 0 auto;
        }

        /* ===== Grid ===== */
        .rw-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        /* ===== Card base ===== */
        .rw-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem 1.1rem;
            border: 2px solid #e5e7eb;
            border-radius: 1.1rem;
            text-decoration: none;
            color: inherit;
            background: #fff;
            cursor: pointer;
            font-family: inherit;
            text-align: left;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        }

        .rw-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.15);
        }

        /* Per-card accent colours */
        .rw-card--rent:hover          { border-color: #0ea5e9; }
        .rw-card--shortlet:hover      { border-color: #a855f7; }
        .rw-card--buy:hover           { border-color: #f59e0b; }
        .rw-card--sell:hover          { border-color: #ef4444; }
        .rw-card--seller-dash:hover   { border-color: #0d9488; }
        .rw-card--buyer-dash:hover    { border-color: #059669; }

        .rw-card-icon {
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .rw-card--rent        .rw-card-icon { background: #e0f2fe; color: #0ea5e9; }
        .rw-card--shortlet    .rw-card-icon { background: #f3e8ff; color: #a855f7; }
        .rw-card--buy         .rw-card-icon { background: #fef3c7; color: #f59e0b; }
        .rw-card--sell        .rw-card-icon { background: #fee2e2; color: #ef4444; }
        .rw-card--seller-dash .rw-card-icon { background: #f0fdfa; color: #0d9488; }
        .rw-card--buyer-dash  .rw-card-icon { background: #ecfdf5; color: #059669; }

        .rw-card-body { flex: 1; min-width: 0; }

        .rw-card-title {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rw-card-desc {
            font-size: 0.78125rem;
            color: #6b7280;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rw-card-arrow {
            color: #d1d5db;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: color 0.2s, transform 0.2s;
        }

        .rw-card:hover .rw-card-arrow {
            color: #059669;
            transform: translateX(4px);
        }

        /* ===== Footer ===== */
        .rw-footer-note {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .rw-text-link {
            color: #059669;
            font-weight: 500;
            text-decoration: none;
        }
        .rw-text-link:hover { text-decoration: underline; }

        .rw-dot { margin: 0 0.35rem; }

        .rw-inline-form { display: inline; }

        .rw-text-btn {
            background: none;
            border: none;
            padding: 0;
            color: #059669;
            font-weight: 500;
            cursor: pointer;
            font-size: inherit;
            font-family: inherit;
        }
        .rw-text-btn:hover { text-decoration: underline; }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .rw-grid { grid-template-columns: 1fr 1fr; }
            .role-welcome-wrap { padding: 1.75rem 1.25rem; border-radius: 1.25rem; }
            .rw-card-desc { display: none; }
        }

        @media (max-width: 480px) {
            .rw-grid { grid-template-columns: 1fr; }
            .rw-card-desc { display: block; }
        }
    </style>
@endpush
