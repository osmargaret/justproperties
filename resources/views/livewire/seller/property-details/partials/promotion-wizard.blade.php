@if ($showPromotionWizard)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="flex max-h-[min(90vh,900px)] w-full max-w-5xl flex-col rounded-xl bg-white shadow-xl">
            <div class="flex shrink-0 items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h3 class="text-lg font-semibold">{{ $editingPromotionId ? 'Resume promotion setup' : 'Add promotion' }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Choose a bundled promotion plan and continue to checkout.</p>
                </div>
                <button type="button" wire:click="closePromotionWizard" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <div class="min-h-0 flex-1 overflow-y-auto px-6 py-5 space-y-6">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-3">Filter by type</p>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $filters = [
                                'all' => 'All',
                                'blog_post' => 'Blog post',
                                'newsletter' => 'Newsletter',
                                'featured' => 'Featured',
                            ];
                        @endphp
                        @foreach ($filters as $key => $label)
                            <button
                                type="button"
                                wire:click="choosePromotionType('{{ $key }}')"
                                class="rounded-full px-3 py-1.5 text-sm {{ $promotionTypeFilter === $key ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-700 border border-transparent hover:bg-gray-200' }}"
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($this->promotionPlans as $item)
                        @php
                            /** @var \App\Models\PromotionPlan $plan */
                            $plan = $item['plan'];
                            $quote = $item['quote'];
                            $targets = $item['targets'];
                        @endphp
                        <button
                            type="button"
                            wire:click="selectPromotionPlan({{ $plan->id }})"
                            class="text-left rounded-xl border p-4 transition {{ $selectedPromotionPlanId === $plan->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-emerald-300' }}"
                        >
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="font-semibold text-gray-900">{{ $plan->name }}</h4>
                                <span class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ str_replace('_', ' ', $plan->type) }}</span>
                            </div>
                            <div class="mt-3 space-y-1 text-xs text-gray-600">
                                @forelse ($targets as $target)
                                    <p>{{ number_format($target['count']) }} {{ str_replace('_', ' ', $target['type']) }}</p>
                                @empty
                                    <p>No configured targets.</p>
                                @endforelse
                            </div>
                            <div class="mt-3 border-t border-gray-200 pt-3 text-sm font-semibold text-emerald-700">
                                {{ $quote['currency_symbol'] ?? '₦' }}{{ number_format((float) ($quote['amount'] ?? 0), 2) }}
                            </div>
                        </button>
                    @empty
                        <div class="col-span-full rounded-lg border border-dashed border-gray-300 px-4 py-8 text-sm text-gray-500 text-center">
                            No promotion plans available for this filter.
                        </div>
                    @endforelse
                </div>

                @if ($this->selectedPromotionPlan)
                    <div class="rounded-lg border border-gray-200 p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-gray-900">Selected plan</h4>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">{{ str_replace('_', ' ', $this->selectedPromotionPlan->type) }}</span>
                        </div>
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">{{ $this->selectedPromotionPlan->name }}</p>
                            @if ($this->selectedPromotionPlan->primaryTarget())
                                @php($target = $this->selectedPromotionPlan->primaryTarget())
                                <p class="text-xs text-gray-500 mt-1">Target: {{ number_format($target['count']) }} {{ str_replace('_', ' ', $target['type']) }}</p>
                            @endif
                        </div>

                        @if (in_array($this->selectedPromotionPlan->type, ['blog_post', 'newsletter'], true))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Optional direction for content</label>
                                <textarea wire:model="contentBrief" rows="3" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" placeholder="Tell us tone, audience, key benefits, or CTA focus."></textarea>
                                @error('contentBrief') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            @if ($this->generationMode === 'ai')
                                <div class="rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-3 text-xs text-emerald-900">
                                    AI mode is enabled. Generate 2 options and pick 1 before payment.
                                </div>
                                <button type="button" wire:click="generateContentOptions" class="rounded-lg border border-emerald-300 px-3 py-2 text-sm text-emerald-700 hover:bg-emerald-50">
                                    {{ $isGeneratingContent ? 'Generating...' : 'Generate 2 content options' }}
                                </button>
                                @if ($contentVariants !== [])
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                        @foreach ($contentVariants as $variant)
                                            <label class="rounded-lg border p-3 cursor-pointer {{ $selectedVariantKey === $variant['key'] ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}">
                                                <div class="flex items-start gap-2">
                                                    <input type="radio" wire:model="selectedVariantKey" value="{{ $variant['key'] }}" class="mt-1">
                                                    <div>
                                                        <p class="font-medium text-sm text-gray-900">{{ $variant['title'] }}</p>
                                                        <p class="text-xs text-gray-600 mt-1 whitespace-pre-line">{{ \Illuminate\Support\Str::limit($variant['body'], 220) }}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('selectedVariantKey') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                @endif
                            @else
                                <div class="rounded-lg border border-amber-100 bg-amber-50 px-3 py-3 text-xs text-amber-900">
                                    Manual mode is enabled. Content will be prepared after payment within {{ \App\Models\Setting::getValue('content.manual_timeframe_hours', 24) }} hours.
                                </div>
                            @endif
                        @endif

                        @if ($this->selectedPromotionPlan->type === 'newsletter')
                            <div class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-3 text-xs text-blue-900">
                                Newsletter strategy: we send first to people who viewed this property, then to other qualified subscribers.
                            </div>
                        @endif

                        @if ($this->selectedPromotionQuote)
                            <div class="flex items-center justify-between border-t border-gray-200 pt-3 text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium">
                                    {{ $this->selectedPromotionQuote['currency_symbol'] ?? '₦' }}{{ number_format((float) $this->selectedPromotionQuote['amount'], 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex shrink-0 items-center justify-between border-t border-gray-200 bg-white px-6 py-4 rounded-b-xl">
                <button type="button" wire:click="closePromotionWizard" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" wire:click="confirmPromotionPurchase" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                    Continue to checkout
                </button>
            </div>
        </div>
    </div>
@endif
