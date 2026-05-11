<div>
    <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
        @include('layouts.profile-header')

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="submitListing" class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-8">
            <div class="bg-white rounded-xl p-8 shadow-md">
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="ri-home-4-line text-emerald-600"></i> Property Details
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Property Title *</label>
                            <input type="text" wire:model.blur="title" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Luxury 5 Bedroom Duplex with BQ" />
                            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Property Description *</label>
                            <textarea wire:model.blur="description" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" rows="4"></textarea>
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Listing category *</label>
                            <select wire:model.live="listing_category_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                <option value="">Select category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('listing_category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Cost ({{ $activeCurrency?->symbol ?? '₦' }}) *</label>
                            <input type="number" wire:model.blur="cost" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., 85000000" />
                            @error('cost') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                        
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $activeCategory = $listing_category_id ? $categories->firstWhere('id', (int) $listing_category_id) : null;
                        @endphp
                        @include('livewire.seller.partials.category-settings-fields', ['settings' => $activeCategory?->settings ?? collect()])
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="ri-map-pin-line text-emerald-600"></i> Location
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">State *</label>
                            <select wire:model.live="state_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">City/LGA *</label>
                            <select wire:model.live="city_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                <option value="">Select city/LGA</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Street Address *</label>
                            <input type="text" wire:model.blur="address" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Neighborhood/Landmark</label>
                            <input type="text" wire:model.blur="neighborhood" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('neighborhood') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model.live="show_address" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                Show full address on listing
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="ri-image-line text-emerald-600"></i> Property Images *
                    </h3>
                    <label class="block border-2 border-dashed border-gray-200 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition-all">
                        <input type="file" wire:model="uploadedImages" multiple accept="image/*" class="hidden">
                        <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Click to upload images</p>
                        <p class="text-gray-400 text-sm mt-2">Maximum 10 images, JPEG/PNG/WebP up to 5MB each</p>
                    </label>
                    @error('uploadedImages') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    @error('uploadedImages.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    @if ($uploadedImages)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            @foreach ($uploadedImages as $index => $image)
                                <div class="aspect-square rounded-lg overflow-hidden relative border border-gray-200">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview {{ $index + 1 }}">
                                    <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="ri-contacts-line text-emerald-600"></i> Contact Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Contact Name *</label>
                            <input type="text" wire:model.blur="contact_name" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('contact_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" wire:model.blur="contact_phone" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('contact_phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Email *</label>
                            <input type="email" wire:model.blur="contact_email" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('contact_email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">WhatsApp</label>
                            <input type="tel" wire:model.blur="contact_whatsapp" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                            @error('contact_whatsapp') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">

                <div class="bg-gradient-to-r from-emerald-900 to-emerald-600 rounded-xl p-8 mb-8 text-white flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-lg font-bold mb-2">Upload Multiple Properties</h2>
                        <p class="text-emerald-100 text-sm">Use excel or csv file to upload your properties</p>
                    </div>
                    <a href="{{ route('seller.bulk-template.download') }}" class="text-emerald-100 text-sm hover:underline">Download sample file</a>
                    <button type="button" wire:click="openBulkUploadModal" class="bg-white/20 px-6 py-2 rounded-full font-semibold border border-white/30">
                        <i class="ri-file-upload-line mr-2"></i>
                        Upload properties file
                    </button>

                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="ri-crown-line text-emerald-600"></i> Subscription
                    </h3>
                    @if ($this->hasUnusedSubscriptions)
                        <fieldset class="space-y-3 mb-4">
                            <legend class="text-xs font-medium text-gray-600 mb-1">Apply this listing using</legend>
                            <label @class([
                                'flex items-start gap-3 cursor-pointer rounded-lg border p-3 transition-colors',
                                'border-emerald-500 bg-emerald-50/70' => $subscription_source === 'existing',
                                'border-gray-200' => $subscription_source !== 'existing',
                            ])>
                                <input type="radio" wire:model.live="subscription_source" value="existing" class="mt-0.5 border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span>
                                    <span class="block text-sm font-medium text-gray-900">Use an existing subscription</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Uses one free slot. No plan charge for this listing.</span>
                                </span>
                            </label>
                            <label @class([
                                'flex items-start gap-3 cursor-pointer rounded-lg border p-3 transition-colors',
                                'border-emerald-500 bg-emerald-50/70' => $subscription_source === 'purchase',
                                'border-gray-200' => $subscription_source !== 'purchase',
                            ])>
                                <input type="radio" wire:model.live="subscription_source" value="purchase" class="mt-0.5 border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span>
                                    <span class="block text-sm font-medium text-gray-900">Buy a new subscription</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Purchase a plan for this listing even if you still have slots elsewhere.</span>
                                </span>
                            </label>
                        </fieldset>
                        @if ($subscription_source === 'existing')
                            <p class="text-xs text-gray-500 mb-2">Select which subscription should cover this listing.</p>
                            <select wire:model.live="selected_subscription_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white">
                                <option value="">Choose subscription</option>
                                @foreach ($availableSubscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">
                                        {{ $subscription->plan?->name ?? 'Subscription' }} — {{ $subscription->remaining_slots }} slot(s) left
                                    </option>
                                @endforeach
                            </select>
                            @error('selected_subscription_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        @else
                            <p class="text-xs text-gray-500 mb-2">Choose a plan to purchase for this listing.</p>
                            <select wire:model.live="selected_subscription_plan_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white">
                                <option value="">Choose subscription plan</option>
                                @foreach ($subscriptionPlans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->seats }} listings / {{ $plan->days }} days)</option>
                                @endforeach
                            </select>
                            @error('selected_subscription_plan_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        @endif
                        @error('subscription_source') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    @else
                        <p class="text-xs text-gray-500 mb-3">No unused subscription found. Choose a plan to purchase.</p>
                        <select wire:model.live="selected_subscription_plan_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white">
                            <option value="">Choose subscription plan</option>
                            @foreach ($subscriptionPlans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->seats }} listings / {{ $plan->days }} days)</option>
                            @endforeach
                        </select>
                        @error('selected_subscription_plan_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    @endif
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                        <i class="ri-rocket-line text-emerald-600"></i> Boost Your Listing
                    </h3>
                    <p class="text-gray-500 text-xs mb-4">Optional promotion</p>
                    <select wire:model.live="selected_promotion_plan_id" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white">
                        <option value="">No promotion</option>
                        @foreach ($promotionPlans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->days }} days)</option>
                        @endforeach
                    </select>
                    @error('selected_promotion_plan_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md sticky top-24">
                    <h3 class="text-xl font-semibold mb-6 pb-4 border-b border-gray-200">Payment Summary</h3>
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subscription</span>
                            <span class="font-medium">{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->subscriptionAmount(), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Promotion</span>
                            <span class="font-medium">{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->promotionAmount(), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->subtotalAmount(), 2) }}</span>
                        </div>
                        @if ($this->couponDiscountAmount() > 0)
                            <div class="flex justify-between text-sm text-emerald-700">
                                <span>Promo discount</span>
                                <span>-{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->couponDiscountAmount(), 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">VAT ({{ number_format($this->vatRate(), 1) }}%)</span>
                            <span class="font-medium">{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->vatAmount(), 2) }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between py-4 border-t-2 border-gray-200 mb-6">
                        <span class="font-bold">Total</span>
                        <span class="font-bold text-2xl text-emerald-600">{{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->totalAmount(), 2) }}</span>
                    </div>
                    @if ($this->subtotalAmount() > 0)
                        <div class="flex gap-2 mb-4">
                            <input type="text" wire:model.defer="promo_code" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm" placeholder="Enter promo code" />
                            <button type="button" wire:click="applyPromoCode" class="px-4 py-2 bg-gray-100 rounded-lg font-medium hover:bg-gray-200">Apply</button>
                        </div>
                        @error('promo_code') <p class="text-sm text-red-600 mb-4">{{ $message }}</p> @enderror
                    @endif

                    <div class="rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-800 text-xs p-3 mb-4">
                        Payment gateway is selected automatically based on your country settings.
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button type="button" wire:click="saveDraft" class="w-full py-4 border border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-semibold rounded-lg flex items-center justify-center gap-2 transition-all">
                            <i class="ri-save-line"></i> Save as Draft
                        </button>
                        <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg flex items-center justify-center gap-2 transition-all">
                        @if ($this->requiresPayment())
                            <i class="ri-lock-line"></i> Pay {{ $activeCurrency?->symbol ?? '₦' }}{{ number_format($this->totalAmount(), 2) }} & Submit Listing
                        @else
                            <i class="ri-check-line"></i> Submit Listing
                        @endif
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @if ($showBulkUploadModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" wire:keydown.escape="closeBulkUploadModal">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Bulk upload properties</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Upload CSV/Excel using the sample template. Each row is saved as draft. Dynamic category fields use the same column names as in the template (for example <code>bedrooms</code>), not a prefix. See the Help and Field options sheets in the downloaded file.
                            </p>
                        </div>
                        <button type="button" wire:click="closeBulkUploadModal" class="text-gray-500 hover:text-gray-800">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-4 mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select file (.csv, .xlsx, .xls)</label>
                        <input type="file" wire:model="bulk_upload_file" accept=".csv,.xlsx,.xls" class="block w-full text-sm text-gray-700">
                        @error('bulk_upload_file') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                    </div>

                    @if ($bulkUploadErrors)
                        <div class="max-h-40 overflow-y-auto rounded-lg border border-amber-300 bg-amber-50 p-3 mb-4 text-sm text-amber-800">
                            <p class="font-medium mb-2">Some rows failed:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($bulkUploadErrors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeBulkUploadModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="button" wire:click="processBulkUpload" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Upload and save drafts</button>
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>