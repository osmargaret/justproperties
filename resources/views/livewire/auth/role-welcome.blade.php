<div class="role-welcome-card">
    <div class="role-welcome-inner">
        <div class="role-welcome-header">
            <div class="logo-row">
                <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png"
                    alt="JustProperties" class="logo-img">
                <span class="logo-text">JustProperties</span>
            </div>
            <h1>Welcome{{ auth()->check() && auth()->user()->name ? ', ' . explode(' ', trim(auth()->user()->name), 2)[0] : '' }}</h1>
            <p class="lead">You are signed in. Choose how you want to use the platform first — you can switch between buyer and seller tools anytime by visiting each dashboard.</p>
        </div>

        <div class="role-columns">
            <section class="role-panel buyer">
                <div class="role-panel-icon"><i class="ri-home-heart-line"></i></div>
                <h2>As a buyer</h2>
                <p class="role-panel-intro">Search listings, save favourites, set property alerts, and manage notifications in one place.</p>
                <ul class="role-features">
                    <li><i class="ri-check-line"></i> Browse land, completed builds, rentals, and short lets</li>
                    <li><i class="ri-check-line"></i> Save properties and get alerted when new matches appear</li>
                    <li><i class="ri-check-line"></i> Track saved properties and listing activity</li>
                </ul>
                <a href="{{ route('buyer.dashboard') }}" class="role-cta buyer-cta" wire:navigate>
                    <span>Go to buyer dashboard</span>
                    <i class="ri-arrow-right-line"></i>
                </a>
            </section>

            <section class="role-panel seller">
                <div class="role-panel-icon"><i class="ri-building-2-line"></i></div>
                <h2>As a seller</h2>
                <p class="role-panel-intro">List properties, manage subscriptions and documents, run promotions, and track leads from interested buyers.</p>
                <ul class="role-features">
                    <li><i class="ri-check-line"></i> Create and manage your property listings</li>
                    <li><i class="ri-check-line"></i> Handle subscriptions, transactions, and uploads</li>
                    <li><i class="ri-check-line"></i> Use promotions to reach more buyers</li>
                </ul>
                <a href="{{ route('seller.dashboard') }}" class="role-cta seller-cta" wire:navigate>
                    <span>Go to seller dashboard</span>
                    <i class="ri-arrow-right-line"></i>
                </a>
            </section>
        </div>

        <p class="role-footer-note">
            <a href="{{ route('welcome') }}" class="text-link">Back to site</a>
            <span class="dot">·</span>
            <form method="POST" action="{{ route('logout') }}" class="inline-form">@csrf<button type="submit" class="text-link-btn">Sign out</button></form>
        </p>
    </div>
</div>

@push('styles')
    <style>
        .role-welcome-card {
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .role-welcome-inner {
            max-width: 880px;
            margin: 0 auto;
        }

        .role-welcome-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-row {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: #111827;
        }

        .role-welcome-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            color: #111827;
            margin-bottom: 0.75rem;
        }

        .lead {
            color: #4b5563;
            font-size: 1rem;
            line-height: 1.65;
            max-width: 42rem;
            margin: 0 auto;
        }

        .role-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .role-panel {
            border: 2px solid #e5e7eb;
            border-radius: 1.25rem;
            padding: 1.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .role-panel:hover {
            box-shadow: 0 10px 30px -10px rgba(5, 150, 105, 0.2);
        }

        .role-panel.buyer:hover {
            border-color: #059669;
        }

        .role-panel.seller:hover {
            border-color: #0d9488;
        }

        .role-panel-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .buyer .role-panel-icon {
            background: #ecfdf5;
            color: #059669;
        }

        .seller .role-panel-icon {
            background: #f0fdfa;
            color: #0d9488;
        }

        .role-panel h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .role-panel-intro {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.55;
            margin-bottom: 1rem;
        }

        .role-features {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem;
            flex: 1;
        }

        .role-features li {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .role-features i {
            color: #059669;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .seller .role-features i {
            color: #0d9488;
        }

        .role-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
        }

        .role-cta:hover {
            transform: translateY(-1px);
        }

        .buyer-cta {
            background: #059669;
            color: #fff;
        }

        .buyer-cta:hover {
            background: #047857;
            color: #fff;
        }

        .seller-cta {
            background: #0f766e;
            color: #fff;
        }

        .seller-cta:hover {
            background: #115e59;
            color: #fff;
        }

        .role-footer-note {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .text-link {
            color: #059669;
            font-weight: 500;
            text-decoration: none;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .inline-form {
            display: inline;
        }

        .text-link-btn {
            background: none;
            border: none;
            padding: 0;
            color: #059669;
            font-weight: 500;
            cursor: pointer;
            font-size: inherit;
            font-family: inherit;
        }

        .text-link-btn:hover {
            text-decoration: underline;
        }

        .dot {
            margin: 0 0.35rem;
        }

        @media (max-width: 768px) {
            .role-columns {
                grid-template-columns: 1fr;
            }

            .role-welcome-card {
                padding: 1.75rem 1.25rem;
                border-radius: 1.25rem;
            }
        }
    </style>
@endpush
