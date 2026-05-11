<div class="flex flex-wrap gap-2">
    @if ($isAdmin)
        @if ($role === 'admin')
            <button wire:click="switchRole('seller')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-store-2-line"></i> Switch to seller
            </button>
            <button wire:click="switchRole('buyer')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-user-heart-line"></i> Switch to buyer
            </button>
        @elseif ($role === 'seller')
            <button wire:click="switchRole('buyer')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-user-heart-line"></i> Switch to buyer
            </button>
            <button wire:click="switchRole('admin')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-dashboard-3-line"></i> Switch to admin
            </button>
        @else
            {{-- buyer --}}
            <button wire:click="switchRole('seller')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-store-2-line"></i> Switch to seller
            </button>
            <button wire:click="switchRole('admin')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-dashboard-3-line"></i> Switch to admin
            </button>
        @endif
    @else
        @if ($role === 'buyer')
            <button wire:click="switchRole('seller')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-store-2-line"></i> Switch to seller
            </button>
        @elseif ($role === 'seller')
            <button wire:click="switchRole('buyer')"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold border border-white/40 bg-white/15 hover:bg-white/25 transition">
                <i class="ri-user-heart-line"></i> Switch to buyer
            </button>
        @endif
    @endif
</div>