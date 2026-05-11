@php
    $user = auth()->user();
    $isAdmin = $user && $user->is_admin;
    $adminRole = $isAdmin ? ($user->active_role ?: 'admin') : null;
@endphp
@if ($isAdmin && $adminRole === 'admin')
    @include('layouts.admin-sidebar')
@elseif ($isAdmin && $adminRole === 'buyer')
    @include('layouts.buyer-sidebar')
@elseif ($isAdmin && $adminRole === 'seller')
    @include('layouts.seller-sidebar')
@elseif (($user->active_role ?? 'buyer') === 'buyer')
    @include('layouts.buyer-sidebar')
@else
    @include('layouts.seller-sidebar')
@endif
