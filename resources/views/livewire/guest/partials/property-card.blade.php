@props(['property'])

<div class="bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-emerald-200 cursor-pointer">
    <div class="relative h-48 md:h-64 overflow-hidden">
        <a href="{{ route('property.show', $property) }}">
            <img src="{{ $property->media->first()?->url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $property->name }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" />
        </a>
        
        @if($property->promotions()->where('status', 'active')->exists())
        <div class="absolute top-3 left-0 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 text-xs font-bold transform -skew-x-12"><span class="block transform skew-x-12">⭐ BOOSTED</span></div>
        @endif
        
        <div class="absolute top-3 right-3 px-2.5 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">Available</div>
        <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5">
            <i class="ri-eye-line text-white text-xs"></i><span class="text-white text-xs">{{ number_format($property->viewed_by_users_count ?? 0) }}</span>
        </div>
        <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5">
            <i class="ri-image-2-line text-white text-xs"></i><span class="text-white text-xs">{{ $property->media->count() }}</span>
        </div>
    </div>
    <div class="p-4 md:p-6">
        <a href="{{ route('property.show', $property) }}">
            <h3 class="font-bold text-gray-900 mb-2 text-lg truncate hover:text-emerald-600 transition">{{ $property->name }}</h3>
        </a>
        <div class="flex items-center gap-2 text-gray-500 mb-3 text-sm truncate"><i class="ri-map-pin-line"></i> {{ $property->display_location }}</div>
        <div class="flex gap-4 text-gray-500 mb-3 text-xs">
            <span><i class="ri-bed-line"></i> {{ $property->featureValue('bedrooms') ?? 'N/A' }} Beds</span>
            <span><i class="ri-briefcase-line"></i> {{ $property->featureValue('bathrooms') ?? 'N/A' }} Baths</span>
        </div>
        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
            <span class="font-bold text-emerald-600 text-xl">{{ $property->currency?->symbol ?? '₦' }}{{ number_format($property->cost) }}</span>
            <a href="{{ route('property.show', $property) }}" class="text-emerald-600 font-medium text-sm hover:underline">View Details</a>
        </div>
    </div>
</div>
