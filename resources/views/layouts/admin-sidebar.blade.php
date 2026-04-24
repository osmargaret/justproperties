@php
    $navActive = 'flex items-center gap-4 px-6 py-3 border-l-3 border-emerald-600 text-emerald-600 bg-emerald-50 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-lg';
    $navIdle = 'flex items-center gap-4 px-6 py-3 border-l-3 border-transparent text-gray-500 hover:bg-emerald-50';
    $subNav = 'flex items-center gap-3 px-6 py-2 pl-12 text-sm text-gray-600 hover:bg-emerald-50 border-l-3 border-transparent';
    $subNavActive = 'flex items-center gap-3 px-6 py-2 pl-12 text-sm text-emerald-600 bg-emerald-50 border-l-3 border-emerald-600';
    $settingsOpen = request()->routeIs('admin.settings.*');
    $summaryClass = ($settingsOpen ? $navActive : $navIdle) . ' cursor-pointer list-none [&::-webkit-details-marker]:hidden flex items-center gap-4';
@endphp
<aside class="bg-white rounded-xl shadow-md overflow-hidden h-fit lg:sticky lg:top-24">
    <div class="py-4">
        <div class="font-medium text-gray-500 text-sm mb-2">Admin</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? $navActive : $navIdle }}">
            <i class="ri-dashboard-line text-xl"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') || request()->routeIs('admin.users.show') ? $navActive : $navIdle }}">
            <i class="ri-team-line text-xl"></i><span class="font-medium">Users</span>
        </a>
        <a href="{{ route('admin.subscriptions') }}" class="{{ request()->routeIs('admin.subscriptions') ? $navActive : $navIdle }}">
            <i class="ri-vip-crown-line text-xl"></i><span class="font-medium">Subscriptions</span>
        </a>
        <a href="{{ route('admin.promotions') }}" class="{{ request()->routeIs('admin.promotions') ? $navActive : $navIdle }}">
            <i class="ri-megaphone-line text-xl"></i><span class="font-medium">Promotions</span>
        </a>
        <a href="{{ route('admin.properties') }}" class="{{ request()->routeIs('admin.properties') || request()->routeIs('admin.properties.show') ? $navActive : $navIdle }}">
            <i class="ri-building-line text-xl"></i><span class="font-medium">Properties</span>
        </a>
        <a href="{{ route('admin.inspections') }}" class="{{ request()->routeIs('admin.inspections') ? $navActive : $navIdle }}">
            <i class="ri-calendar-check-line text-xl"></i><span class="font-medium">Inspections</span>
        </a>
        <a href="{{ route('admin.blog') }}" class="{{ request()->routeIs('admin.blog') ? $navActive : $navIdle }}">
            <i class="ri-article-line text-xl"></i><span class="font-medium">Blog</span>
        </a>
        <a href="{{ route('admin.payments') }}" class="{{ request()->routeIs('admin.payments') ? $navActive : $navIdle }}">
            <i class="ri-bank-card-line text-xl"></i><span class="font-medium">Payments</span>
        </a>
        <a href="{{ route('admin.coupons') }}" class="{{ request()->routeIs('admin.coupons') ? $navActive : $navIdle }}">
            <i class="ri-coupon-3-line text-xl"></i><span class="font-medium">Coupons</span>
        </a>

        <details class="group" {{ $settingsOpen ? 'open' : '' }}>
            <summary class="{{ $summaryClass }}">
                <i class="ri-settings-3-line text-xl shrink-0"></i>
                <span class="font-medium flex-1 text-left">Settings</span>
                <i class="ri-arrow-down-s-line text-lg shrink-0 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="pb-1">
                <a href="{{ route('admin.settings.general') }}" class="{{ request()->routeIs('admin.settings.general') ? $subNavActive : $subNav }}">General</a>
                <a href="{{ route('admin.settings.categories') }}" class="{{ request()->routeIs('admin.settings.categories') ? $subNavActive : $subNav }}">Categories</a>
                <a href="{{ route('admin.settings.subscription-plans') }}" class="{{ request()->routeIs('admin.settings.subscription-plans') ? $subNavActive : $subNav }}">Subscription Plans</a>
                <a href="{{ route('admin.settings.promotion-plans') }}" class="{{ request()->routeIs('admin.settings.promotion-plans') ? $subNavActive : $subNav }}">Promotion Plans</a>
                <a href="{{ route('admin.settings.staff') }}" class="{{ request()->routeIs('admin.settings.staff') ? $subNavActive : $subNav }}">Staff</a>
                <a href="{{ route('admin.settings.roles') }}" class="{{ request()->routeIs('admin.settings.roles') ? $subNavActive : $subNav }}">Roles &amp; Permissions</a>
                <a href="{{ route('admin.settings.countries') }}" class="{{ request()->routeIs('admin.settings.countries') ? $subNavActive : $subNav }}">Countries</a>
            </div>
        </details>

        <a href="{{ route('admin.notifications') }}" class="{{ request()->routeIs('admin.notifications') ? $navActive : $navIdle }}">
            <i class="ri-notification-line text-xl"></i><span class="font-medium">Notifications</span>
        </a>
        <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? $navActive : $navIdle }}">
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
