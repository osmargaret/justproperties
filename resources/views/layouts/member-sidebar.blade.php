@php
    $navActive = 'flex items-center gap-4 px-6 py-3 border-l-3 border-emerald-600 text-emerald-600 bg-emerald-50 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-lg';
    $navIdle = 'flex items-center gap-4 px-6 py-3 border-l-3 border-transparent text-gray-500 hover:bg-emerald-50';
@endphp
<aside class="bg-white rounded-xl shadow-md overflow-hidden h-fit lg:sticky lg:top-24">
    <div class="py-4">
        <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard', 'buyer.dashboard', 'seller.dashboard') ? $navActive : $navIdle }}">
            <i class="ri-dashboard-line text-xl"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('account.bookmarks') }}" class="{{ request()->routeIs('account.bookmarks', 'buyer.favourites') ? $navActive : $navIdle }}">
            <i class="ri-bookmark-line text-xl"></i><span class="font-medium">Bookmark</span>
        </a>
        <a href="{{ route('seller.listed-properties') }}" class="{{ request()->routeIs('seller.listed-properties') ? $navActive : $navIdle }}">
            <i class="ri-home-4-line text-xl"></i><span class="font-medium">My Listings</span>
        </a>
        <a href="{{ route('account.notifications') }}" class="{{ request()->routeIs('account.notifications') ? $navActive : $navIdle }}">
            <i class="ri-notification-line text-xl"></i><span class="font-medium">Notifications</span>
        </a>
        <a href="{{ route('account.promotions') }}" class="{{ request()->routeIs('account.promotions') ? $navActive : $navIdle }}">
            <i class="ri-megaphone-line text-xl"></i><span class="font-medium">Promotions</span>
        </a>
        <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile', 'buyer.profile', 'seller.profile') ? $navActive : $navIdle }}">
            <i class="ri-user-3-line text-xl"></i><span class="font-medium">Profile</span>
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
