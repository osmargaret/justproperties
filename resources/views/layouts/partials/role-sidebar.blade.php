@php
    $user = auth()->user();
    $isAdmin = $user && $user->is_admin;
    $adminRole = $isAdmin ? ($user->active_role ?: 'admin') : null;
@endphp
@if ($isAdmin && $adminRole === 'admin')
    @include('layouts.admin-sidebar')
@else
    @include('layouts.member-sidebar')
@endif
