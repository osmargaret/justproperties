@php
    $stats = $this->overviewStats;
    $currencySymbol = $this->activeCurrency?->symbol ?? '₦';
@endphp

<div class="space-y-6">
    @if ($property->media->isNotEmpty())
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-image-line text-emerald-600"></i> Photos
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach ($property->media->sortByDesc('is_primary') as $media)
                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 relative">
                        @if ($media->url)
                            <img src="{{ $media->url }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm">No preview</div>
                        @endif
                        @if ($media->is_primary)
                            <span class="absolute top-2 left-2 text-[10px] uppercase tracking-wide px-2 py-0.5 rounded-full bg-emerald-600 text-white">Primary</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-emerald-600">{{ number_format($stats['views']) }}</div>
            <div class="text-sm text-gray-500">Views</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-emerald-600">{{ number_format($stats['saves']) }}</div>
            <div class="text-sm text-gray-500">Saved</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-emerald-600">{{ number_format($stats['alerts']) }}</div>
            <div class="text-sm text-gray-500">Alerts</div>
        </div>
        
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-emerald-600">{{ $stats['active_promotions'] }}</div>
            <div class="text-sm text-gray-500">Active promos</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-home-4-line text-emerald-600"></i> Listing
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500">Category</dt>
                    <dd class="font-medium text-gray-900 text-right">{{ $property->category?->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500">Price</dt>
                    <dd class="font-medium text-gray-900">{{ $currencySymbol }}{{ number_format((float) $property->cost, 2) }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500">Listed</dt>
                    <dd class="font-medium text-gray-900">{{ $property->created_at->format('M d, Y') }}</dd>
                </div>
                @if ($property->slug)
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500">Slug</dt>
                        <dd class="font-mono text-xs text-gray-700 truncate max-w-[200px]" title="{{ $property->slug }}">{{ $property->slug }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-map-pin-line text-emerald-600"></i> Location
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500">State</dt>
                    <dd class="font-medium text-gray-900">{{ $property->state?->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500">City / LGA</dt>
                    <dd class="font-medium text-gray-900">{{ $property->city?->name ?? '—' }}</dd>
                </div>
                @if ($property->show_address)
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500">Address</dt>
                        <dd class="font-medium text-gray-900 text-right">{{ $property->address ?: '—' }}</dd>
                    </div>
                @else
                    <div class="rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-600">
                        Street address hidden on public listing.
                    </div>
                @endif
                @if ($property->neighborhood)
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500">Neighborhood</dt>
                        <dd class="font-medium text-gray-900">{{ $property->neighborhood }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>

    @if ($property->features->isNotEmpty())
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-list-settings-line text-emerald-600"></i> Features
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($property->features as $feature)
                    @php
                        $label = $this->featureLabels[$feature->feature] ?? str_replace('_', ' ', ucfirst($feature->feature));
                        $displayValue = $feature->value;
                        $decoded = json_decode($feature->value, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $displayValue = implode(', ', $decoded);
                        }
                    @endphp
                    <span class="inline-flex items-center gap-1 text-sm px-3 py-1.5 rounded-full bg-gray-100 text-gray-800">
                        <span class="text-gray-500">{{ $label }}:</span>
                        <span class="font-medium">{{ $displayValue }}</span>
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-crown-line text-emerald-600"></i> Subscription seat
            </h3>
            @if ($this->currentSubscriptionAssignment)
                @php($sub = $this->currentSubscriptionAssignment)
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-lg">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $sub->plan?->name ?? 'Plan' }}</p>
                            <p class="text-sm text-gray-600">
                                Ends {{ $sub->end_at?->format('M d, Y') ?? 'N/A' }}
                                · {{ $sub->usedSeats() }} / {{ $sub->seats }} seats used on this plan
                            </p>
                        </div>
                        <span class="text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">Assigned</span>
                    </div>
                    <button
                        type="button"
                        wire:click="removePropertyFromSubscription"
                        wire:confirm="Remove this property from the subscription? The seat will become available again."
                        class="text-sm text-red-600 hover:underline"
                    >
                        Remove from subscription
                    </button>
                </div>
            @else
                <p class="text-sm text-gray-500 mb-4">This listing is not using a subscription seat yet. Assign it to an active plan with seats available.</p>
                @if ($this->assignableSubscriptions->isEmpty())
                    <a href="{{ route('seller.subscriptions') }}" class="inline-flex text-sm font-medium text-emerald-700 hover:underline">
                        View subscriptions →
                    </a>
                @else
                    <form wire:submit="assignPropertyToSubscription" class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Subscription plan</label>
                            <select wire:model="selectedSubscriptionId" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                                <option value="">Select a subscription…</option>
                                @foreach ($this->assignableSubscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">
                                        {{ $subscription->plan?->name ?? 'Plan' }}
                                        ({{ $subscription->usedSeats() }}/{{ $subscription->seats }} used
                                        @if ($subscription->remainingSeats() > 0)
                                            · {{ $subscription->remainingSeats() }} left
                                        @endif
                                        · ends {{ $subscription->end_at?->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedSubscriptionId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                            Assign to subscription
                        </button>
                    </form>
                @endif
            @endif
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="ri-shield-check-line text-emerald-600"></i> Moderation
            </h3>
            @if ($property->latestModeration)
                <div class="rounded-lg border border-gray-200 p-4 text-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-medium capitalize">{{ $property->latestModeration->status }}</span>
                        <span class="text-gray-400 text-xs">{{ $property->latestModeration->created_at->diffForHumans() }}</span>
                    </div>
                    @if ($property->latestModeration->reason)
                        <p class="text-gray-600">{{ $property->latestModeration->reason }}</p>
                    @endif
                    @if ($property->latestModeration->moderator)
                        <p class="text-xs text-gray-500">By {{ $property->latestModeration->moderator->name }}</p>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500">No moderation history yet.</p>
            @endif
        </div>
    </div>

  

    <div class="bg-white rounded-xl p-6 shadow-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <i class="ri-megaphone-line text-emerald-600"></i> Promotions
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                {{ $this->activePromotions->count() }} active · {{ $this->allPromotions->count() }} total
            </p>
        </div>
        <div class="flex gap-2">
            <button type="button" wire:click="openPromotionWizard" class="rounded-lg border border-emerald-600 px-5 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-50">
                Add promotion
            </button>
            <button type="button" wire:click="switchTab('promotions')" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                View promotions
            </button>
        </div>
    </div>
</div>
