@if(auth()->user()->is_admin)
    @include('layouts.admin-sidebar')
@elseif((auth()->user()->active_role ?? 'buyer') === 'buyer')
    @include('layouts.buyer-sidebar')
@else
    @include('layouts.seller-sidebar')
@endif
