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

        <!-- Filters Section -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Search -->
          <div class="md:col-span-2">
            <input 
              type="text" 
              wire:model.live="search" 
              placeholder="Search property name..." 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
            >
          </div>

           <!-- Status Filter -->
           <div>
             <select 
               wire:model.live="filterStatus" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
             >
               <option value="">All Statuses</option>
               <option value="published">Published</option>
               <option value="draft">Draft</option>
             </select>
           </div>

          <!-- Moderation Filter -->
          <div>
            <select 
              wire:model.live="filterModeration" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
            >
              <option value="">All Moderation</option>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>

        <!-- Sort & Pagination Settings -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Sort by:</label>
            <select 
              wire:model.live="sortBy" 
              class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
            >
              <option value="latest">Latest</option>
              <option value="oldest">Oldest</option>
              <option value="price_high">Price (High to Low)</option>
              <option value="price_low">Price (Low to High)</option>
            </select>
          </div>

          <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Per page:</label>
            <select 
              wire:model.live="perPage" 
              class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
            >
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
          </div>
        </div>

        <!-- Results Count -->
        <div class="mb-4 text-sm text-gray-500">
          Showing {{ $properties->count() }} of {{ $properties->total() }} results
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="w-full">  
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Property</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Category</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Price</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Status</th>

                <th class="text-left py-3 text-gray-500 font-medium text-sm">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($properties as $property)
                <tr class="border-b border-gray-100">
                  <td class="py-3 font-medium">{{ $property->name }}</td>
                  <td class="py-3">{{ $property->category?->name ?? '—' }}</td>
                  <td class="py-3">{{ $property->currency() }} {{ $property->price }}</td>
                  <td class="py-3">
                    @php
                      $statusClass = match($property->status) {
                        'draft' => 'bg-gray-100 text-gray-700',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'live' => 'bg-emerald-100 text-emerald-700',
                        'no subscription' => 'bg-slate-100 text-slate-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                      };
                    @endphp
                    <span class="{{ $statusClass }} text-xs px-2 py-1 rounded-full">{{ str_replace('_', ' ', ucfirst($property->status)) }}</span>
                  </td>
                  
                  <td class="py-3 space-x-2">
                    <a href="{{ route('seller.properties.show', ['property' => $property->id]) }}" class="text-sm text-gray-600 hover:text-emerald-600">View</a>
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

        <!-- Pagination -->
        <div class="mt-6">
          {{ $properties->links() }}
        </div>
      </div>
    </div>
  </main>
</div>