<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.buyer-sidebar')

            <div class="space-y-8">
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-4 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">Buyer overview</h2>
                            <p class="text-gray-500 text-sm mt-1">Track saved homes, alerts, and your activity in one place.</p>
                        </div>
                        <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg font-medium text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition whitespace-nowrap">
                            <i class="ri-search-line text-lg"></i>
                            Browse properties
                        </a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">12</div>
                            <div class="text-sm text-gray-500">Saved properties</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">4</div>
                            <div class="text-sm text-gray-500">Active alerts</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">8</div>
                            <div class="text-sm text-gray-500">New matches (7d)</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-emerald-600">3</div>
                            <div class="text-sm text-gray-500">Inspection requests</div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-flashlight-line text-emerald-600"></i>
                        Quick actions
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('buyer.favourites') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-heart-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Saved</div>
                                <div class="text-xs text-gray-500">View favourites</div>
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-notification-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Alerts</div>
                                <div class="text-xs text-gray-500">Email &amp; WhatsApp</div>
                            </div>
                        </a>
                        <a href="{{ route('buyer.security') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-shield-user-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Security</div>
                                <div class="text-xs text-gray-500">Password &amp; 2FA</div>
                            </div>
                        </a>
                        <a href="{{ route('buyer.profile') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition">
                            <span class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center"><i class="ri-user-settings-line text-xl"></i></span>
                            <div>
                                <div class="font-medium text-gray-900">Profile</div>
                                <div class="text-xs text-gray-500">Contact &amp; bio</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl p-8 shadow-md">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold flex items-center gap-2">
                                <i class="ri-heart-line text-emerald-600"></i>
                                Recently saved
                            </h3>
                            <a href="{{ route('buyer.favourites') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View all</a>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex gap-4">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=120&amp;h=80&amp;fit=crop" alt="" class="w-24 h-16 object-cover rounded-lg shrink-0" />
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 truncate">Luxury 5 Bedroom Duplex</p>
                                    <p class="text-xs text-gray-500">Lekki Phase 1 · ₦85M</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=120&amp;h=80&amp;fit=crop" alt="" class="w-24 h-16 object-cover rounded-lg shrink-0" />
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 truncate">4 Bedroom Semi-Detached</p>
                                    <p class="text-xs text-gray-500">Ajah · ₦45M</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-900 to-emerald-600 rounded-xl p-8 text-white shadow-md">
                        <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                            <i class="ri-lightbulb-flash-line"></i>
                            Tips for buyers
                        </h3>
                        <p class="text-emerald-100 text-sm mb-6 leading-relaxed">
                            Turn on instant WhatsApp alerts so you never miss a price drop or a new listing in your saved areas.
                        </p>
                        <ul class="space-y-3 text-sm text-emerald-50">
                            <li class="flex gap-2"><i class="ri-checkbox-circle-fill text-emerald-300 shrink-0 mt-0.5"></i> Save searches to get matched listings faster.</li>
                            <li class="flex gap-2"><i class="ri-checkbox-circle-fill text-emerald-300 shrink-0 mt-0.5"></i> Message owners directly from the property page.</li>
                            <li class="flex gap-2"><i class="ri-checkbox-circle-fill text-emerald-300 shrink-0 mt-0.5"></i> Keep your profile verified to speed up enquiries.</li>
                        </ul>
                        <a href="#" class="mt-6 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white/15 hover:bg-white/25 border border-white/30 text-sm font-medium transition">
                            <i class="ri-settings-3-line"></i>
                            Manage notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
