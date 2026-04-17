@php
    $embeddedInProfile = $embeddedInProfile ?? false;
    $user = auth()->user();
    $canSell = $user?->can_sell ?? true;
    $canBuy = $user?->can_buy ?? true;
@endphp

<aside class="profile-sidebar">
    <div class="sidebar-menu">
        @if ($canSell)
            <div class="sidebar-section-label">Selling</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('list-property') }}" class="menu-item {{ request()->routeIs('list-property') ? 'active' : '' }}">
                <i class="ri-add-circle-line"></i>
                <span>Add listing</span>
            </a>
            @if ($embeddedInProfile)
                <div class="menu-item" data-profile-tab="listings" onclick="switchTab('listings', this)">
                    <i class="ri-home-4-line"></i>
                    <span>My listings</span>
                    <span class="badge">3</span>
                </div>
            @else
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="ri-home-4-line"></i>
                    <span>My listings</span>
                    <span class="badge">3</span>
                </a>
            @endif
            <a href="{{ route('transactions') }}" class="menu-item {{ request()->routeIs('transactions') ? 'active' : '' }}">
                <i class="ri-money-dollar-circle-line"></i>
                <span>Transactions</span>
            </a>
            <a href="{{ route('plan') }}" class="menu-item {{ request()->routeIs('plan') ? 'active' : '' }}">
                <i class="ri-vip-diamond-line"></i>
                <span>Subscription plan</span>
            </a>
        @endif

        @if ($canBuy)
            <div class="sidebar-section-label">Buying</div>
            @if ($embeddedInProfile)
                <div class="menu-item" data-profile-tab="favorites" onclick="switchTab('favorites', this)">
                    <i class="ri-heart-line"></i>
                    <span>Saved properties</span>
                    <span class="badge">12</span>
                </div>
            @else
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="ri-heart-line"></i>
                    <span>Saved properties</span>
                    <span class="badge">12</span>
                </a>
            @endif
        @endif

        <div class="sidebar-section-label">Account</div>
        @if ($embeddedInProfile)
            <div class="menu-item active" data-profile-tab="personal" onclick="switchTab('personal', this)">
                <i class="ri-user-line"></i>
                <span>Personal information</span>
            </div>
            <div class="menu-item" data-profile-tab="subscription" onclick="switchTab('subscription', this)">
                <i class="ri-crown-line"></i>
                <span>Subscription &amp; billing</span>
            </div>
            <div class="menu-item" data-profile-tab="documents" onclick="switchTab('documents', this)">
                <i class="ri-file-copy-line"></i>
                <span>Documents</span>
            </div>
            <div class="menu-item" data-profile-tab="notifications" onclick="switchTab('notifications', this)">
                <i class="ri-notification-line"></i>
                <span>Notifications</span>
            </div>
            <div class="menu-item" data-profile-tab="security" onclick="switchTab('security', this)">
                <i class="ri-lock-line"></i>
                <span>Security</span>
            </div>
        @else
            <a href="{{ route('profile') }}" class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="ri-user-line"></i>
                <span>Profile &amp; settings</span>
            </a>
        @endif

        <div class="menu-divider"></div>

        @auth
            <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="menu-item menu-item--logout">
                    <i class="ri-logout-box-r-line"></i>
                    <span>Sign out</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="menu-item">
                <i class="ri-login-box-line"></i>
                <span>Sign in</span>
            </a>
        @endauth
    </div>
</aside>
