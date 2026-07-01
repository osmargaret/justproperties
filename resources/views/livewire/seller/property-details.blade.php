<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
            @include('layouts.partials.role-sidebar')

            <div class="space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-semibold">{{ $property->name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $property->display_location }}</p>
                        </div>
                         <div class="flex flex-wrap gap-2">
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
                             <span class="{{ $statusClass }} text-xs px-3 py-1 rounded-full">{{ ucfirst(str_replace('_', ' ', $property->status)) }}</span>
                             
                         </div>
                    </div>
                    @if ($pendingPayment)
                        <div class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 p-3 text-sm text-yellow-800">
                            Pending payment detected for this listing.
                            <a class="font-medium underline ml-1" href="{{ route('seller.checkout', ['payment' => $pendingPayment->id]) }}">Continue checkout</a>
                        </div>
                    @endif
                </div>

                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button type="button" wire:click="switchTab('overview')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'overview' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Overview
                        </button>
                        <button type="button" wire:click="switchTab('promotions')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'promotions' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Promotions
                            @if ($this->allPromotions->isNotEmpty())
                                <span class="ml-1 text-xs text-gray-400">({{ $this->allPromotions->count() }})</span>
                            @endif
                        </button>
                        <button type="button" wire:click="switchTab('details')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'details' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Details
                        </button>
                    </nav>
                </div>

                @if ($activeTab === 'overview')
                    @include('livewire.seller.property-details.overview')
                @endif

                @if ($activeTab === 'promotions')
                    @include('livewire.seller.property-details.promotions')
                @endif

                @if ($activeTab === 'details')
                    @include('livewire.seller.property-details.details')
                @endif
            </div>
        </div>

        @include('livewire.seller.property-details.partials.promotion-wizard')

        @if ($this->previewNewsletter)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" wire:keydown.escape.window="closeNewsletterPreview">
                <div class="w-full max-w-2xl rounded-xl bg-white shadow-xl max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Newsletter preview</h3>
                            @if ($this->previewNewsletter->subject)
                                <p class="text-sm text-gray-500 mt-1">Subject: {{ $this->previewNewsletter->subject }}</p>
                            @endif
                        </div>
                        <button type="button" wire:click="closeNewsletterPreview" class="text-gray-400 hover:text-gray-600" aria-label="Close">
                            <span class="sr-only">Close</span>
                            ✕
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto px-6 py-4">
                        <div class="whitespace-pre-line text-sm text-gray-800">{{ $this->previewNewsletter->content ?: 'No content yet.' }}</div>
                        @if ($this->previewNewsletter->recipients->isNotEmpty())
                            <div class="mt-6 border-t border-gray-100 pt-4">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Recipient queue ({{ $this->previewNewsletter->recipients->count() }})</p>
                                <ul class="space-y-1 text-xs text-gray-600 max-h-40 overflow-y-auto">
                                    @foreach ($this->previewNewsletter->recipients->take(20) as $recipient)
                                        <li class="flex justify-between gap-2">
                                            <span class="truncate">{{ $recipient->email }}</span>
                                            <span class="capitalize text-gray-400 shrink-0">{{ $recipient->status }}</span>
                                        </li>
                                    @endforeach
                                    @if ($this->previewNewsletter->recipients->count() > 20)
                                        <li class="text-gray-400">…and {{ $this->previewNewsletter->recipients->count() - 20 }} more</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
                        <button type="button" wire:click="closeNewsletterPreview" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>
