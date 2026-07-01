<div>
    <!-- Blog Hero -->
    <section class="blog-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <h1 class="hero-title">Real Estate Insights</h1>
            <p class="hero-subtitle">Expert advice, market trends, and property tips for Nigerian real estate</p>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-box">
                    <input type="text" wire:model.live.debounce.300ms="search" class="search-input" placeholder="Search articles..." />
                    <button class="search-btn">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Category Filters -->
        <div class="category-filters">
            <button wire:click="$set('category', '')" class="category-filter {{ $category === '' ? 'active' : '' }}">All Posts</button>
            @foreach($categories as $cat)
                <button wire:click="$set('category', '{{ $cat->slug }}')" class="category-filter {{ $category === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</button>
            @endforeach
        </div>

        <!-- Featured Post -->
        @if($featuredPost)
        <div class="featured-post">
            <div class="featured-grid">
                <div class="featured-image">
                    <img src="{{ $featuredPost->media->first()?->url ?? 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                        alt="{{ $featuredPost->title }}" />
                </div>
                <div class="featured-content">
                    <span class="featured-category">{{ $featuredPost->category?->name ?? 'Uncategorized' }}</span>
                    <h2 class="featured-title">{{ $featuredPost->title }}</h2>
                    <div class="featured-meta">
                        <span><i class="ri-calendar-line"></i> {{ $featuredPost->published_at?->format('M d, Y') ?? 'Recently' }}</span>
                        <span><i class="ri-time-line"></i> {{ ceil(str_word_count(strip_tags($featuredPost->content)) / 200) }} min read</span>
                        <span><i class="ri-eye-line"></i> {{ number_format($featuredPost->views_count) }} views</span>
                    </div>
                    <p class="featured-excerpt">
                        {{ $featuredPost->excerpt ?? str($featuredPost->content)->limit(150) }}
                    </p>
                    <a href="{{ route('post',$featuredPost) }}" class="read-more-btn">
                        Read Full Article <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Blog Grid -->
        <div class="blog-grid">
            @forelse($posts as $post)
            <article class="blog-card">
                <div class="card-image">
                    <img src="{{ $post->media->first()?->url ?? 'https://images.unsplash.com/photo-1560520031-3a4dc4e9de0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                        alt="{{ $post->title }}" />
                    <span class="card-category">{{ $post->category?->name ?? 'Uncategorized' }}</span>
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span><i class="ri-calendar-line"></i> {{ $post->published_at?->format('M d, Y') ?? 'Recently' }}</span>
                        <span><i class="ri-time-line"></i> {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    </div>
                    <h3 class="card-title">{{ $post->title }}</h3>
                    <p class="card-excerpt">
                        {{ $post->excerpt ?? str($post->content)->limit(100) }}
                    </p>
                    <a href="{{ route('post',$post) }}" class="card-link">
                        Read Article <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </article>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem 0; color: #6b7280;">
                    <p>No articles found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Newsletter Section -->
        <section class="newsletter-section">
            <h2 class="newsletter-title">Never Miss an Update</h2>
            <p class="newsletter-text">
                Subscribe to our newsletter and get the latest real estate insights,
                market trends, and property tips delivered to your inbox.
            </p>
            <form class="newsletter-form" id="blogNewsletterForm">
                <input type="email" class="newsletter-input" placeholder="Enter your email address" required />
                <button type="submit" class="newsletter-submit">Subscribe</button>
            </form>
        </section>

        <!-- Popular Posts -->
        @if($popularPosts->count() > 0)
        <section class="popular-section">
            <h2 class="section-title">Most Popular Articles</h2>
            <div class="popular-grid">
                @foreach($popularPosts as $popPost)
                <div class="popular-card">
                    <div class="popular-image">
                        <img src="{{ $popPost->media->first()?->url ?? 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}"
                            alt="{{ $popPost->title }}" />
                    </div>
                    <div class="popular-info">
                        <h4>{{ $popPost->title }}</h4>
                        <p><i class="ri-eye-line"></i> {{ number_format($popPost->views_count) }} views</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $posts->links(data: ['scrollTo' => false]) }}
        </div>
    </main>

</div>
@push('styles')
    <style>
        /* .blog-hero {
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
        } */

        .list-property-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #059669;
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .list-property-btn:hover {
            background-color: #047857;
        }

        .sign-in-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            color: #ffffff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sign-in-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        @media (min-width: 1024px) {
            .mobile-menu-btn {
                display: none;
            }
        }

        .mobile-list-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: none;
            border: none;
            color: #ffffff;
            font-weight: 500;
            cursor: pointer;
            border-radius: 0.5rem;
        }

        .mobile-menu-icon {
            padding: 0.5rem;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-menu {
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            max-height: 0;
            opacity: 0;
        }

        .mobile-menu.open {
            max-height: 500px;
            opacity: 1;
        }

        .mobile-menu-content {
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mobile-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .mobile-link:hover {
            background-color: #ecfdf5;
            color: #059669;
        }

        .mobile-link i {
            font-size: 1.125rem;
        }

        .mobile-signin {
            background-color: #059669;
            color: white;
        }

        .mobile-signin:hover {
            background-color: #047857;
            color: white;
        }

        /* Hero Section */
        .blog-hero {
            position: relative;
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 800px;
            margin: 0 auto;
            padding: 6rem 1rem;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        @media (min-width: 640px) {
            .hero-title {
                font-size: 4rem;
            }
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: #d1fae5;
            margin-bottom: 2rem;
        }

        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-box {
            display: flex;
            background: white;
            border-radius: 9999px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            outline: none;
            font-size: 1rem;
        }

        .search-btn {
            background: #059669;
            color: white;
            border: none;
            padding: 1rem 2rem;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background: #047857;
        }

        /* Main Content */
        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        /* Featured Post */
        .featured-post {
            margin-bottom: 4rem;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 1024px) {
            .featured-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .featured-image {
            height: 300px;
            overflow: hidden;
        }

        @media (min-width: 1024px) {
            .featured-image {
                height: 100%;
                min-height: 400px;
            }
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .featured-post:hover .featured-image img {
            transform: scale(1.05);
        }

        .featured-content {
            padding: 2rem;
        }

        .featured-category {
            display: inline-block;
            background: #059669;
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .featured-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .featured-meta {
            display: flex;
            gap: 1.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .featured-meta i {
            margin-right: 0.25rem;
        }

        .featured-excerpt {
            color: #4b5563;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #059669;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .read-more-btn:hover {
            background: #047857;
        }

        /* Category Filters */
        .category-filters {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
        }

        .category-filter {
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: #f3f4f6;
            color: #374151;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-filter:hover {
            background-color: #e5e7eb;
        }

        .category-filter.active {
            background-color: #059669;
            color: white;
        }

        /* Blog Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        @media (min-width: 640px) {
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .blog-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Blog Card */
        .blog-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
        }

        .blog-card:hover {
            transform: translateY(-0.5rem);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: #a7f3d0;
        }

        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .blog-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-category {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: #059669;
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-meta {
            display: flex;
            gap: 1rem;
            color: #6b7280;
            font-size: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .card-meta i {
            margin-right: 0.25rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .card-excerpt {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #059669;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: gap 0.3s ease;
        }

        .card-link:hover {
            gap: 0.75rem;
        }

        /* Newsletter Section */
        .newsletter-section {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            margin: 4rem 0;
            text-align: center;
            color: white;
        }

        .newsletter-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .newsletter-text {
            font-size: 1rem;
            color: #d1fae5;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .newsletter-form {
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .newsletter-form {
                flex-direction: column;
            }
        }

        .newsletter-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            outline: none;
        }

        .newsletter-submit {
            background: white;
            color: #059669;
            border: none;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-submit:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        /* Popular Posts Sidebar */
        .popular-section {
            margin-top: 4rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        .popular-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .popular-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .popular-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .popular-card {
            display: flex;
            gap: 1rem;
            background: white;
            padding: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .popular-card:hover {
            transform: translateY(-0.25rem);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .popular-image {
            width: 80px;
            height: 80px;
            border-radius: 0.5rem;
            overflow: hidden;
            flex-shrink: 0;
        }

        .popular-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .popular-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }

        .popular-info p {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }

        .page-btn {
            min-width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: white;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .page-btn:hover:not(.active):not(.disabled) {
            background-color: #f3f4f6;
        }

        .page-btn.active {
            background-color: #059669;
            border-color: #059669;
            color: white;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Footer */
        .footer {
            background: linear-gradient(to bottom right, #064e3b, #065f46, #064e3b);
            color: white;
            margin-top: 3rem;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 640px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .footer-logo img {
            height: 40px;
            width: auto;
        }

        .footer-logo span {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .footer-description {
            color: #d1fae5;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .social-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .footer-title {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #a7f3d0;
            margin-bottom: 1rem;
        }

        .footer-nav {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-nav a,
        .footer-nav button {
            color: #ecfdf5;
            text-decoration: none;
            font-size: 0.875rem;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .footer-nav a:hover,
        .footer-nav button:hover {
            color: white;
            text-decoration: underline;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ecfdf5;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .contact-item:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(4, 120, 87, 0.5);
            padding: 1rem 0;
        }

        .footer-bottom-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .footer-bottom-content {
                flex-direction: row;
            }
        }

        .copyright {
            color: #a7f3d0;
            font-size: 0.875rem;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            color: #a7f3d0;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        /* WhatsApp Float */
        .whatsapp-float {
            position: fixed;
            bottom: 1.5rem;
            right: 1rem;
            z-index: 50;
            width: 3.5rem;
            height: 3.5rem;
            background-color: #059669;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            border: none;
            animation: pulse 2s infinite;
        }

        @media (min-width: 640px) {
            .whatsapp-float {
                width: 4rem;
                height: 4rem;
                right: 1.5rem;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .whatsapp-float i {
            font-size: 1.5rem;
        }

        .whatsapp-tooltip {
            position: absolute;
            right: 100%;
            margin-right: 1rem;
            background: #111827;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .whatsapp-float:hover .whatsapp-tooltip {
            opacity: 1;
        }

        .whatsapp-ping {
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background-color: #34d399;
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    </style>
@endpush
