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
                            <label class="block font-medium text-sm text-gray-700 mb-2">Cost *</label>
                            <input type="number" min="1" wire:model.blur="cost" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., 85000000" />
                            @error('cost') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                        
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $activeCategory = $listing_category_id ? $categories->firstWhere('id', (int) $listing_category_id) : null;
                        @endphp
                        @include('livewire.seller.partials.category-settings-fields', ['settings' => $activeCategory?->fields ?? $activeCategory?->settings ?? collect()])
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                        <i class="ri-map-pin-line text-emerald-600"></i> Location
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Country *</label>
                            <div class="relative" x-data="{
                                open: false,
                                search: @js($countries->firstWhere('id', $country_id)?->name ?? ''),
                                selectedCountryId: @js($country_id),
                                countries: @js($countries->map(fn ($country) => [
                                    'id' => $country->id,
                                    'name' => $country->name,
                                    'flag' => $country->flag,
                                ])->values()),
                                get filteredCountries() {
                                    const query = this.search.trim().toLowerCase();
                                    return this.countries.filter(country => country.name.toLowerCase().includes(query));
                                },
                                selectCountry(country) {
                                    this.selectedCountryId = country.id;
                                    this.search = country.name;
                                    this.open = false;
                                    this.$wire.set('country_id', country.id);
                                }
                            }" @click.outside="open = false">
                                <input type="text" x-model="search"
                                    @focus="open = true; $event.target.select()"
                                    @input="open = true; if (selectedCountryId !== null) { selectedCountryId = null; $wire.set('country_id', null); }"
                                    @keydown.escape="open = false"
                                    @keydown.enter.prevent="if (filteredCountries.length) selectCountry(filteredCountries[0])"
                                    autocomplete="off" placeholder="Search for a country"
                                    class="w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    role="combobox" aria-autocomplete="list" :aria-expanded="open.toString()">
                                <div x-show="open" x-cloak class="absolute z-40 mt-1 max-h-56 w-full overflow-auto rounded-lg border border-gray-200 bg-white shadow-lg">
                                    @foreach ($countries as $country)
                                        <button type="button"
                                            data-country-option
                                            data-search="{{ \Illuminate\Support\Str::lower($country->name) }}"
                                            x-show="!search.trim() || $el.dataset.search.includes(search.trim().toLowerCase())"
                                            @click="selectCountry({ id: {{ $country->id }}, name: @js($country->name) })"
                                            class="block w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-emerald-50">
                                            {{ collect([$country->flag, $country->name])->filter()->join(' ') }}
                                        </button>
                                    @endforeach
                                    <p x-show="filteredCountries.length === 0" class="px-4 py-3 text-sm text-gray-500">No countries found.</p>
                                </div>
                            </div>
                            @error('country_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div wire:key="listing-state-picker-{{ $country_id ?: 'none' }}">
                            <label class="block font-medium text-sm text-gray-700 mb-2">State *</label>
                            <div class="relative" x-data="{
                                open: false,
                                search: @js($states->firstWhere('id', $state_id)?->name ?? ''),
                                selectedStateId: @js($state_id),
                                states: @js($states->map(fn ($state) => [
                                    'id' => $state->id,
                                    'name' => $state->name,
                                ])->values()),
                                get filteredStates() {
                                    const query = this.search.trim().toLowerCase();
                                    return this.states.filter(state => state.name.toLowerCase().includes(query));
                                },
                                selectState(state) {
                                    this.selectedStateId = state.id;
                                    this.search = state.name;
                                    this.open = false;
                                    this.$wire.set('state_id', state.id);
                                }
                            }" @click.outside="open = false">
                                <input type="text" x-model="search"
                                    @focus="open = true; $event.target.select()"
                                    @input="open = true; if (selectedStateId !== null) { selectedStateId = null; $wire.set('state_id', null); }"
                                    @keydown.escape="open = false"
                                    @keydown.enter.prevent="if (filteredStates.length) selectState(filteredStates[0])"
                                    autocomplete="off" placeholder="Search for a state"
                                    class="w-full rounded-lg border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    role="combobox" aria-autocomplete="list" :aria-expanded="open.toString()">
                                <div x-show="open" x-cloak class="absolute z-40 mt-1 max-h-56 w-full overflow-auto rounded-lg border border-gray-200 bg-white shadow-lg">
                                    @foreach ($states as $state)
                                        <button type="button"
                                            data-state-option
                                            data-search="{{ \Illuminate\Support\Str::lower($state->name) }}"
                                            x-show="!search.trim() || $el.dataset.search.includes(search.trim().toLowerCase())"
                                            @click="selectState({ id: {{ $state->id }}, name: @js($state->name) })"
                                            class="block w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-emerald-50">
                                            {{ $state->name }}
                                        </button>
                                    @endforeach
                                    <p x-show="states.length === 0" class="px-4 py-3 text-sm text-gray-500">No states available for this country.</p>
                                    <p x-show="states.length > 0 && filteredStates.length === 0" class="px-4 py-3 text-sm text-gray-500">No states match your search.</p>
                                </div>
                            </div>
                            @error('state_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">City/LGA *</label>
                            <input wire:model.live="city" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            @error('city') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
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

                <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-6 text-sm text-emerald-900">
                    <h3 class="font-semibold mb-2">Free property listings</h3>
                    <p>Submitting a property is free. Paid promotion options are available after your listing is created.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md sticky top-24">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button type="button" wire:click="saveDraft" class="w-full py-4 border border-emerald-600 text-emerald-700 hover:bg-emerald-50 font-semibold rounded-lg flex items-center justify-center gap-2 transition-all">
                            <i class="ri-save-line"></i> Save as Draft
                        </button>
                        <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg flex items-center justify-center gap-2 transition-all">
                            <i class="ri-check-line"></i> Submit Listing
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