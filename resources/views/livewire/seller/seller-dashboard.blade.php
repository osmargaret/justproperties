<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.seller-sidebar')

            <div class="space-y-8">
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-4 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">Seller overview</h2>
                            <p class="text-gray-500 text-sm mt-1">Monitor listings, subscription usage, and buyer interest.</p>
                        </div>
                        <a href="{{ route('list-property') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg font-medium text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition whitespace-nowrap">
                            <i class="ri-add-circle-line text-lg"></i>
                            New listing
                        </a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">{{ $activeListings }}</div>
                            <div class="text-sm text-gray-500">Active listings</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">{{ $pendingReview }}</div>
                            <div class="text-sm text-gray-500">Pending review</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">{{ $listingViews >= 1000 ? number_format($listingViews / 1000, 1) . 'k' : number_format($listingViews) }}</div>
                            <div class="text-sm text-gray-500">Listing Views (30d)</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">{{ $promotionsCount }}</div>
                            <div class="text-sm text-gray-500">Promotions</div>
                        </div>
                        
                    </div>

                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-dashboard-line text-emerald-600"></i>
                        Quick actions
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('seller.listed-properties') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-home-4-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">My listings</div>
                                <div class="text-xs text-gray-500">Edit or renew</div>
                            </div>
                        </a>
                        <a href="{{ route('seller.subscriptions') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-crown-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Subscription</div>
                                <div class="text-xs text-gray-500">Plan &amp; billing</div>
                            </div>
                        </a>
                        <a href="{{ route('seller.profile') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-file-shield-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Documents</div>
                                <div class="text-xs text-gray-500">Verification</div>
                            </div>
                        </a>
                        <a href="{{ route('seller.transactions') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-exchange-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Transactions</div>
                                <div class="text-xs text-gray-500">Payments</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-md overflow-x-auto">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 min-w-[520px]">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="ri-bar-chart-2-line text-emerald-600"></i>
                            Listing performance
                        </h3>
                        <a href="{{ route('seller.listed-properties') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Manage all</a>
                    </div>
                    <table class="w-full min-w-[520px]">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 text-gray-500 font-medium text-sm">Property</th>
                                <th class="text-left py-3 text-gray-500 font-medium text-sm">Status</th>
                                <th class="text-left py-3 text-gray-500 font-medium text-sm">Views</th>
                                <th class="text-left py-3 text-gray-500 font-medium text-sm">Leads</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topProperties as $property)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 font-medium text-gray-900">{{ $property->name }}</td>
                                     <td class="py-3">
                                         @php
                                             $statusClass = match($property->status) {
                                                 'Live' => 'bg-emerald-100 text-emerald-700',
                                                 'pending' => 'bg-yellow-100 text-yellow-800',
                                                 'draft' => 'bg-gray-100 text-gray-700',
                                                 'no subscription' => 'bg-slate-100 text-slate-700',
                                                 default => 'bg-slate-100 text-slate-700',
                                             };
                                         @endphp
                                         <span class="{{ $statusClass }} text-xs px-2 py-1 rounded-full">{{ ucfirst(str_replace('_', ' ', $property->status)) }}</span>
                                     </td>
                                    <td class="py-3 text-gray-600">{{ number_format($property->views ?? 0) }}</td>
                                    <td class="py-3 text-gray-600">{{ number_format($property->leads ?? 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">No active listings yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-green-100 rounded-xl p-8 border border-emerald-200 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-emerald-900 mb-1 flex items-center gap-2">
                                <i class="ri-rocket-line text-emerald-600"></i>
                                Grow your reach
                            </h3>
                            <p class="text-sm text-gray-600 max-w-xl">
                                Verified documents and complete listing details rank higher in search and build trust with serious buyers.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3 shrink-0">
                            <a href="{{ route('seller.documents') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-emerald-600 text-emerald-700 font-medium text-sm hover:bg-emerald-600 hover:text-white transition">
                                <i class="ri-upload-cloud-line"></i>
                                Upload documents
                            </a>
                            <a href="{{ route('seller.listed-properties') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 text-white font-medium text-sm hover:bg-emerald-700 transition">
                                <i class="ri-price-tag-3-line"></i>
                                View Listings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
