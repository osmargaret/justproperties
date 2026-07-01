@php
    $navActive = 'flex items-center gap-4 px-6 py-3 border-l-3 border-emerald-600 text-emerald-600 bg-emerald-50 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-lg';
    $navIdle = 'flex items-center gap-4 px-6 py-3 border-l-3 border-transparent text-gray-500 hover:bg-emerald-50';
@endphp
<aside class="bg-white rounded-xl shadow-md overflow-hidden h-fit lg:sticky lg:top-24">
    <div class="py-4">
        <div class="font-medium text-gray-500 text-sm mb-2">Buying</div>
        <a href="{{ route('buyer.dashboard') }}" class="{{ request()->routeIs('buyer.dashboard') ? $navActive : $navIdle }}">
            <i class="ri-dashboard-line text-xl"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('buyer.favourites') }}" class="{{ request()->routeIs('buyer.favourites') ? $navActive : $navIdle }}">
            <i class="ri-heart-line text-xl"></i><span class="font-medium">Saved Properties</span>
        </a>
        <a href="{{ route('buyer.property-alerts') }}" class="{{ request()->routeIs('buyer.property-alerts') ? $navActive : $navIdle }}">
            <i class="ri-alarm-warning-line text-xl"></i><span class="font-medium">Property Alerts</span>
        </a>
        <a href="{{ route('buyer.saved-blog-posts') }}" class="{{ request()->routeIs('buyer.saved-blog-posts') ? $navActive : $navIdle }}">
            <i class="ri-bookmark-line text-xl"></i><span class="font-medium">Saved Blog Post</span>
        </a>
        <a href="{{ route('buyer.blog-subscriptions') }}" class="{{ request()->routeIs('buyer.blog-subscriptions') ? $navActive : $navIdle }}">
            <i class="ri-mail-send-line text-xl"></i><span class="font-medium">Blog Subscriptions</span>
        </a>
        
        <a href="{{ route('buyer.profile') }}" class="{{ request()->routeIs('buyer.profile') ? $navActive : $navIdle }}">
            <i class="ri-user-3-line text-xl"></i><span class="font-medium">Profile</span>
        </a>
        <a href="{{ route('buyer.security') }}" class="{{ request()->routeIs('buyer.security') ? $navActive : $navIdle }}">
            <i class="ri-lock-line text-xl"></i><span class="font-medium">Security</span>
        </a>

        <div class="border-t border-gray-200 my-2"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left flex items-center gap-4 px-6 py-3 hover:bg-emerald-50 text-gray-500 border-l-3 border-transparent">
                <i class="ri-logout-box-r-line text-xl"></i><span class="font-medium">Sign Out</span>
            </button>
        </form>
    </div>
</aside>
