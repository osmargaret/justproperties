<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.partials.role-sidebar')

      <div id="listings-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">My Listings</h2>
          <a href="{{ route('list-property') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700"><i class="ri-add-line mr-1"></i> New Listing</a>
        </div>
        @if (session('status'))
          <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif
        <table class="w-full">  
          <thead>
            <tr class="border-b border-gray-200">
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Property</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Category</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Price</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Status</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Moderation</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($properties as $property)
              <tr class="border-b border-gray-100">
                <td class="py-3 font-medium">{{ $property->name }}</td>
                <td class="py-3">{{ $property->category?->name ?? '—' }}</td>
                <td class="py-3">₦{{ number_format((float) $property->cost, 2) }}</td>
                <td class="py-3">
                  @php
                    $statusClass = match($property->status) {
                      'active' => 'bg-emerald-100 text-emerald-700',
                      'pending_payment' => 'bg-yellow-100 text-yellow-700',
                      'draft' => 'bg-gray-100 text-gray-700',
                      default => 'bg-slate-100 text-slate-700',
                    };
                  @endphp
                  <span class="{{ $statusClass }} text-xs px-2 py-1 rounded-full">{{ str_replace('_', ' ', ucfirst($property->status)) }}</span>
                </td>
                <td class="py-3">
                  @php
                    $moderationClass = match($property->moderation_status) {
                      'approved' => 'bg-emerald-100 text-emerald-700',
                      'rejected' => 'bg-red-100 text-red-700',
                      default => 'bg-amber-100 text-amber-700',
                    };
                  @endphp
                  <span class="{{ $moderationClass }} text-xs px-2 py-1 rounded-full">{{ ucfirst($property->moderation_status ?? 'pending') }}</span>
                </td>
                <td class="py-3 space-x-2">
                  <a href="{{ route('seller.properties.show', ['property' => $property->id]) }}" class="text-sm text-gray-600 hover:text-emerald-600">View</a>
                  <a href="{{ route('list-property') }}" class="text-sm text-gray-600 hover:text-emerald-600">Edit</a>
                  @if ($property->status === 'pending_payment')
                    @php
                      $pendingPayment = \App\Models\Payment::query()
                        ->where('paymentable_type', \App\Models\Property::class)
                        ->where('paymentable_id', $property->id)
                        ->where('status', 'pending')
                        ->latest()
                        ->first();
                    @endphp
                    @if ($pendingPayment)
                      <a href="{{ route('seller.checkout', ['payment' => $pendingPayment->id]) }}" class="text-sm text-emerald-700 hover:text-emerald-900">Checkout</a>
                    @endif
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-8 text-center text-gray-500">No listings yet. Create one to get started.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>