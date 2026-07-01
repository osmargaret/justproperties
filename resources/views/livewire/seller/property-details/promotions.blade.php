<div class="space-y-6">
    @if ($this->pendingPaymentPromotions->isNotEmpty())
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-amber-900 mb-3">Awaiting payment</h3>
            <div class="space-y-3">
                @foreach ($this->pendingPaymentPromotions as $promotion)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-lg bg-white border border-amber-100 px-4 py-3" wire:key="pending-promo-{{ $promotion->id }}">
                        <div>
                            <p class="font-medium text-gray-900">{{ $promotion->plan?->name ?? 'Promotion' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Complete payment to activate this promotion. Paid promotions cannot be edited.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="continuePromotionPayment({{ $promotion->id }})" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                                Continue to checkout
                            </button>
                            <button type="button" wire:click="resumePendingPromotion({{ $promotion->id }})" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Resume setup
                            </button>
                            <button type="button" wire:click="cancelPendingPromotion({{ $promotion->id }})" wire:confirm="Cancel this unpaid promotion?" class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                Cancel
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl p-6 shadow-md">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h3 class="text-lg font-semibold">Promotion history</h3>
                <p class="text-sm text-gray-500 mt-1">Track active campaigns, target progress, and linked deliverables.</p>
            </div>
            <button type="button" wire:click="openPromotionWizard" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                Add promotion
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-emerald-600">{{ $this->allPromotions->count() }}</div>
                <div class="text-sm text-gray-500">Total</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-emerald-600">{{ $this->activePromotions->count() }}</div>
                <div class="text-sm text-gray-500">Active (paid)</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-amber-600">{{ $this->pendingPaymentPromotions->count() }}</div>
                <div class="text-sm text-gray-500">Awaiting payment</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-600">{{ $this->inactivePromotions->count() }}</div>
                <div class="text-sm text-gray-500">Ended / other</div>
            </div>
        </div>

        @if ($this->orphanPosts->isNotEmpty())
            <div class="mb-8 border-b border-gray-200 pb-8">
                <h4 class="text-md font-medium mb-3">Property blog posts</h4>
                <p class="text-xs text-gray-500 mb-4">Posts linked to this property but not tied to a promotion deliverable.</p>
                <ul class="space-y-2">
                    @foreach ($this->orphanPosts as $post)
                        <li class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 text-sm">
                            <span class="font-medium">{{ $post->title }}</span>
                            <span class="text-gray-500 capitalize">{{ $post->status }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $listedPromotions = $this->allPromotions->reject(fn ($p) => $p->isPendingPayment());
        @endphp

        @if ($listedPromotions->isEmpty())
            <p class="text-sm text-gray-500">No paid promotions yet for this property.</p>
        @else
            <div class="space-y-4">
                @foreach ($listedPromotions as $promotion)
                    <div class="border border-gray-200 rounded-lg p-4" wire:key="promotion-{{ $promotion->id }}">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="font-medium text-gray-900">{{ $promotion->plan?->name ?? 'Promotion plan' }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $promotion->isInProgress() ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                        @if ($promotion->isInProgress())
                                            {{ $promotion->status === 'pending_content' ? 'Pending content' : 'Active' }}
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $promotion->status)) }}
                                        @endif
                                    </span>
                                    @if ($promotion->isLocked())
                                        <span class="text-xs text-gray-400">Paid · locked</span>
                                    @endif
                                    @if ($promotion->plan?->type)
                                        <span class="text-xs text-gray-500">{{ str_replace('_', ' ', ucfirst($promotion->plan->type)) }}</span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm text-gray-600">
                                    @if ($promotion->start_at && $promotion->hasPaidPayment())
                                        <div>
                                            <span class="text-gray-400 block text-xs">Started</span>
                                            {{ $promotion->start_at->format('M d, Y') }}
                                        </div>
                                    @endif
                                    
                                    @if (! empty($promotion->usage))
                                        <div>
                                            <span class="text-gray-400 block text-xs">Usage</span>
                                            {{ collect($promotion->usage)->map(fn ($v, $k) => "$k: $v")->implode(', ') }}
                                        </div>
                                    @endif
                                    @if ($promotion->target_type && $promotion->target_count)
                                        <div>
                                            <span class="text-gray-400 block text-xs">Target</span>
                                            {{ number_format($promotion->currentProgress()) }} / {{ number_format($promotion->target_count) }} {{ str_replace('_', ' ', $promotion->target_type) }}
                                        </div>
                                    @endif
                                </div>
                                @if ($promotion->target_type && $promotion->target_count && $promotion->hasPaidPayment())
                                    <div class="mt-3">
                                        <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                                            <div class="h-full bg-emerald-500" style="width: {{ $promotion->progressPercent() }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $promotion->progressPercent() }}% complete</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if ($promotion->promotable)
                            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                                <button type="button" wire:click="showPromotionPreview({{ $promotion->id }})" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                                    Preview deliverable <i class="ri-arrow-right-line ml-1"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($previewPromotionId)
        @php
            $previewPromotion = $this->allPromotions->firstWhere('id', $previewPromotionId);
        @endphp
        @if ($previewPromotion)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl overflow-hidden flex flex-col max-h-[90vh]">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Deliverable Preview</h3>
                        <button type="button" wire:click="closePromotionPreview" class="text-gray-400 hover:text-gray-600">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>
                    <div class="p-6 overflow-y-auto">
                        @include('livewire.seller.property-details.partials.deliverable', ['promotion' => $previewPromotion])
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
