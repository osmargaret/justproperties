@php
    $currencySymbol = $this->activeCurrency?->symbol ?? '₦';
    $activeCategory = $categories->firstWhere('id', (int) $editCategoryId);
@endphp

<div class="bg-white rounded-xl p-8 shadow-md">
    <h3 class="text-lg font-semibold mb-6 flex items-center gap-2">
        <i class="ri-edit-line text-emerald-600"></i> Edit property details
    </h3>

    @if ($this->activeSubscription)
        <div class="mb-8 rounded-lg border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-900">
            <p class="font-medium">Subscription (read-only)</p>
            <p class="mt-1 text-emerald-800">
                {{ $this->activeSubscription->plan?->name ?? 'Plan' }}
                — active until {{ $this->activeSubscription->end_at?->format('M d, Y') ?? 'N/A' }}
            </p>
        </div>
    @endif

    <form wire:submit="updateProperty" class="space-y-8">
        <div>
            <h4 class="text-md font-medium mb-4 flex items-center gap-2">
                <i class="ri-home-4-line text-emerald-600"></i> Property details
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Property title *</label>
                    <input type="text" wire:model="editName" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editName') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Description *</label>
                    <textarea wire:model="editDescription" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    @error('editDescription') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Listing category *</label>
                    <select wire:model.live="editCategoryId" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="">Select category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('editCategoryId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Cost ({{ $currencySymbol }}) *</label>
                    <input type="number" wire:model="editCost" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editCost') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            @include('livewire.seller.partials.category-settings-fields', ['settings' => $activeCategory?->settings ?? collect()])
        </div>

        <div>
            <h4 class="text-md font-medium mb-4 flex items-center gap-2">
                <i class="ri-map-pin-line text-emerald-600"></i> Location
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">State *</label>
                    <select wire:model.live="editStateId" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                        <option value="">Select state</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    @error('editStateId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">City / LGA *</label>
                    <input wire:model="editCity" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                    @error('editCity') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Street address *</label>
                    <input type="text" wire:model="editAddress" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editAddress') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Neighborhood / landmark</label>
                    <input type="text" wire:model="editNeighborhood" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editNeighborhood') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model.live="editShowAddress" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        Show full address on listing
                    </label>
                </div>
            </div>
        </div>

        <div>
            <h4 class="text-md font-medium mb-4 flex items-center gap-2">
                <i class="ri-image-line text-emerald-600"></i> Property images *
            </h4>
            @if ($property->media->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    @foreach ($property->media as $media)
                        <div class="aspect-square rounded-lg overflow-hidden relative border border-gray-200" wire:key="existing-media-{{ $media->id }}">
                            @if ($media->url)
                                <img src="{{ $media->url }}" alt="" class="w-full h-full object-cover">
                            @endif
                            <button
                                type="button"
                                wire:click="removeExistingMedia({{ $media->id }})"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center"
                                title="Remove image"
                            >
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            <label class="block border-2 border-dashed border-gray-200 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition-all">
                <input type="file" wire:model="uploadedImages" multiple accept="image/*" class="hidden">
                <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
                <p class="text-gray-500">Click to add more images</p>
                <p class="text-gray-400 text-sm mt-2">Up to 10 total, JPEG/PNG/WebP up to 5MB each</p>
            </label>
            @error('uploadedImages') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            @error('uploadedImages.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            @if ($uploadedImages)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    @foreach ($uploadedImages as $index => $image)
                        <div class="aspect-square rounded-lg overflow-hidden relative border border-gray-200">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover" alt="New upload {{ $index + 1 }}">
                            <button type="button" wire:click="removeImage({{ $index }})" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h4 class="text-md font-medium mb-4 flex items-center gap-2">
                <i class="ri-contacts-line text-emerald-600"></i> Contact information
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Contact name *</label>
                    <input type="text" wire:model="editContactName" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editContactName') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Phone *</label>
                    <input type="tel" wire:model="editContactPhone" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editContactPhone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Email *</label>
                    <input type="email" wire:model="editContactEmail" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editContactEmail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">WhatsApp</label>
                    <input type="tel" wire:model="editContactWhatsapp" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                    @error('editContactWhatsapp') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" class="rounded-lg bg-emerald-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-emerald-700 transition-colors shadow-sm">
                Save changes
            </button>
            
            @if($property->is_published)
                <button type="button" wire:click="togglePublishStatus" class="rounded-lg bg-white border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <i class="ri-draft-line mr-1"></i> Save as Draft (Unpublish)
                </button>
            @else
                <button type="button" wire:click="togglePublishStatus" class="rounded-lg bg-amber-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-amber-600 transition-colors shadow-sm">
                    <i class="ri-global-line mr-1"></i> Publish Listing
                </button>
            @endif
        </div>
    </form>
</div>
