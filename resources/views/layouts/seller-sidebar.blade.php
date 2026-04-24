@php
    $navActive = 'flex items-center gap-4 px-6 py-3 border-l-3 border-emerald-600 text-emerald-600 bg-emerald-50 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-lg';
    $navIdle = 'flex items-center gap-4 px-6 py-3 border-l-3 border-transparent text-gray-500 hover:bg-emerald-50';
@endphp
<aside class="bg-white rounded-xl shadow-md overflow-hidden h-fit lg:sticky lg:top-24">
    <div class="py-4">
        <div class="font-medium text-gray-500 text-sm mb-2">Selling</div>
        <a href="{{ route('seller-dashboard') }}" class="{{ request()->routeIs('seller-dashboard') ? $navActive : $navIdle }}">
            <i class="ri-dashboard-line text-xl"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('list-property') }}" class="{{ request()->routeIs('list-property') ? $navActive : $navIdle }}">
            <i class="ri-add-circle-line text-xl"></i><span class="font-medium">List Property</span>
        </a>
        <a href="{{ route('listed-properties') }}" class="{{ request()->routeIs('listed-properties') ? $navActive : $navIdle }}">
            <i class="ri-home-4-line text-xl"></i><span class="font-medium">My Listings</span>
        </a>
        <a href="{{ route('subscriptions') }}" class="{{ request()->routeIs('subscriptions') ? $navActive : $navIdle }}">
            <i class="ri-vip-diamond-line text-xl"></i>
            <span class="font-medium">Subscriptions</span>
        </a>
        <a href="{{ route('transactions') }}" class="{{ request()->routeIs('transactions') ? $navActive : $navIdle }}">
            <i class="ri-money-dollar-circle-line text-xl"></i>
            <span class="font-medium">Transactions</span>
        </a>
        <a href="{{ route('seller.promotions') }}" class="{{ request()->routeIs('seller.promotions') ? $navActive : $navIdle }}">
            <i class="ri-megaphone-line text-xl"></i>
            <span class="font-medium">Promotions</span>
        </a>
        <a href="{{ route('seller.notifications') }}" class="{{ request()->routeIs('seller.notifications') ? $navActive : $navIdle }}">
            <i class="ri-notification-line text-xl"></i><span class="font-medium">Notifications</span>
        </a>
        <a href="{{ route('seller.profile') }}" class="{{ request()->routeIs('seller.profile') ? $navActive : $navIdle }}">
            <i class="ri-user-3-line text-xl"></i><span class="font-medium">Profile</span>
        </a>
        <a href="{{ route('seller.settings') }}" class="{{ request()->routeIs('seller.settings') ? $navActive : $navIdle }}">
            <i class="ri-settings-3-line text-xl"></i>
            <span class="font-medium">Settings</span>
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
