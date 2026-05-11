<div class="profile-header bg-gradient-to-r from-emerald-900 to-emerald-600 rounded-xl p-8 mb-8 text-white flex items-center gap-8 flex-wrap">
    <div class="relative">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile"
            class="w-24 h-24 rounded-full object-cover border-4 border-white/30" />
        <div
            class="absolute bottom-0 right-0 w-8 h-8 bg-white rounded-full flex items-center justify-center text-emerald-600 cursor-pointer border-2 border-emerald-600">
            <i class="ri-camera-line text-sm"></i>
        </div>
    </div>
    <div class="flex-1 min-w-[200px]">
        <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->name }}</h1>
        <div class="flex flex-wrap gap-4 text-emerald-100 text-sm">
            @if (auth()->user()->country)
                <span><i class="ri-map-pin-line mr-1"></i> {{ auth()->user()->country->name }}</span>
            @endif
            <span><i class="ri-calendar-line mr-1"></i> Member since
                {{ auth()->user()->created_at?->format('M Y') ?? '—' }}</span>
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-700 rounded-full text-xs">
                <i class="ri-shield-user-line"></i> {{ auth()->user()->position }}
            </span>
        </div>
    </div>
    @livewire('auth.switch-active-role')
</div>
