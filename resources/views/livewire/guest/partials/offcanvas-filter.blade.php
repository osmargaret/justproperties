<!-- Compact Sticky Filter Bar -->
<div class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-16 sm:top-20 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between gap-3">
            
            <!-- Left: Filter Trigger Button & Quick Search -->
            <div class="flex items-center gap-3 flex-1">
                <button type="button" onclick="openFilterDrawer()" class="inline-flex items-center gap-2.5 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl text-sm transition-all shadow-xs hover:shadow-md cursor-pointer whitespace-nowrap">
                    <i class="ri-options-line text-lg"></i>
                    <span>Filter Properties</span>
                    @php
                        $activeCount = count($this->appliedFilters['selectedTypes'] ?? []) 
                            + count($this->appliedFilters['selectedFeatures'] ?? []) 
                            + count($this->appliedFilters['selectedTitles'] ?? []) 
                            + count($this->appliedFilters['cities'] ?? [])
                            + (!empty($this->appliedFilters['state_id']) ? 1 : 0)
                            + (!empty($this->appliedFilters['minPrice']) || !empty($this->appliedFilters['maxPrice']) ? 1 : 0)
                            + (!empty($this->appliedFilters['selectedBedrooms']) && $this->appliedFilters['selectedBedrooms'] !== 'any' ? 1 : 0)
                            + (!empty($this->appliedFilters['selectedBathrooms']) && $this->appliedFilters['selectedBathrooms'] !== 'any' ? 1 : 0)
                            + (!empty($this->appliedFilters['selectedKitchens']) && $this->appliedFilters['selectedKitchens'] !== 'any' ? 1 : 0);
                    @endphp
                    @if($activeCount > 0)
                        <span class="inline-flex items-center justify-center w-5 h-5 bg-emerald-800 text-emerald-100 text-xs font-bold rounded-full">{{ $activeCount }}</span>
                    @endif
                </button>

                <!-- Quick Search Box -->
                <div class="relative flex-1 max-w-sm hidden sm:block">
                    <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Quick search location, title, keyword..." class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 bg-gray-50/50 transition">
                </div>
            </div>

            <!-- Right: Properties Count & Quick Sort -->
            <div class="flex items-center gap-4">
                <p class="text-sm text-gray-500 hidden md:block">
                    Showing <span class="font-semibold text-gray-900">{{ $this->properties->total() }}</span> properties
                </p>
                <div class="flex items-center gap-2">
                    <label for="sortBySelect" class="text-xs text-gray-500 font-medium hidden lg:inline-block">Sort by:</label>
                    <select id="sortBySelect" wire:model.live="sortBy" class="px-3 py-2 border border-gray-200 rounded-xl text-gray-700 text-sm outline-none focus:border-emerald-500 bg-white cursor-pointer shadow-xs">
                        <option value="newest">Newest First</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- Active Filter Badges / Chips -->
        @if($activeCount > 0 || !empty($this->appliedFilters['search']))
            <div class="flex items-center gap-2 pt-3 flex-wrap text-xs">
                <span class="text-gray-400 font-medium mr-1">Active Filters:</span>

                @if(!empty($this->appliedFilters['search']))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Keyword: {{ $this->appliedFilters['search'] }}
                    </span>
                @endif

                @if(!empty($this->appliedFilters['state_id']))
                    @php $st = $this->states->firstWhere('id', $this->appliedFilters['state_id']); @endphp
                    @if($st)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                            State: {{ $st->name }}
                        </span>
                    @endif
                @endif

                @foreach($this->appliedFilters['cities'] as $ct)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        City: {{ $ct }}
                    </span>
                @endforeach

                @foreach($this->appliedFilters['selectedTypes'] as $tp)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Type: {{ $tp }}
                    </span>
                @endforeach

                @if(!empty($this->appliedFilters['minPrice']) || !empty($this->appliedFilters['maxPrice']))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Price: ₦{{ number_format($this->appliedFilters['minPrice'] ?? 0) }} - ₦{{ number_format($this->appliedFilters['maxPrice'] ?? 0) }}
                    </span>
                @endif

                @if(!empty($this->appliedFilters['selectedBedrooms']) && $this->appliedFilters['selectedBedrooms'] !== 'any')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Beds: {{ $this->appliedFilters['selectedBedrooms'] }}+
                    </span>
                @endif

                @if(!empty($this->appliedFilters['selectedBathrooms']) && $this->appliedFilters['selectedBathrooms'] !== 'any')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Baths: {{ $this->appliedFilters['selectedBathrooms'] }}+
                    </span>
                @endif

                @if(!empty($this->appliedFilters['selectedKitchens']) && $this->appliedFilters['selectedKitchens'] !== 'any')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        Kitchens: {{ $this->appliedFilters['selectedKitchens'] }}+
                    </span>
                @endif

                @foreach($this->appliedFilters['selectedFeatures'] as $ft)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-full font-medium">
                        {{ $ft }}
                    </span>
                @endforeach

                <button type="button" wire:click="resetFilters" class="text-emerald-600 hover:text-emerald-700 font-semibold underline ml-2 cursor-pointer">
                    Clear All
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Off-Canvas Backdrop -->
<div id="filterBackdrop" onclick="closeFilterDrawer()" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs z-50 transition-opacity duration-300 opacity-0 pointer-events-none" wire:ignore.self></div>

<!-- Off-Canvas Slide-Over Drawer -->
<div id="filterDrawer" class="fixed inset-y-0 right-0 max-w-full flex w-full sm:w-[480px] z-50 transform transition-transform duration-300 ease-in-out translate-x-full" wire:ignore.self>
    <div class="w-full bg-white h-full shadow-2xl flex flex-col justify-between overflow-hidden">
        
        <!-- Drawer Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-stone-50/80">
            <div>
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="ri-filter-3-line text-emerald-600"></i> Filter Properties
                </h2>
                <p class="text-xs text-gray-500">Customize search fields for {{ $this->category?->name ?? 'properties' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" wire:click="resetFilters" onclick="closeFilterDrawer()" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 underline cursor-pointer">
                    Reset All
                </button>
                <button type="button" onclick="closeFilterDrawer()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-200 transition-colors cursor-pointer">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Drawer Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- 1. Location (Country, State, City) -->
            <div class="space-y-4 pb-5 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="ri-map-pin-line text-emerald-600"></i> Location
                </h3>

                <!-- Country -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Country</label>
                    <div class="relative" x-data="{
                        open: false,
                        search: @js($this->countries->firstWhere('id', $country_id)?->name ?? ''),
                        selectedCountryId: @js($country_id),
                        countries: @js($this->countries->map(fn ($country) => [
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
                            @input="open = true; if (selectedCountryId !== null) { selectedCountryId = null; $wire.set('country_id', ''); }"
                            @keydown.escape="open = false"
                            @keydown.enter.prevent="if (filteredCountries.length) selectCountry(filteredCountries[0])"
                            autocomplete="off" placeholder="Search for a country"
                            class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-emerald-500 focus:outline-none"
                            role="combobox" aria-autocomplete="list" :aria-expanded="open.toString()">
                        <div x-show="open" x-cloak class="absolute z-50 mt-1 max-h-56 w-full overflow-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                            @foreach ($this->countries as $country)
                                <button type="button"
                                    data-country-option
                                    data-search="{{ \Illuminate\Support\Str::lower($country->name) }}"
                                    x-show="!search.trim() || $el.dataset.search.includes(search.trim().toLowerCase())"
                                    @click="selectCountry({ id: {{ $country->id }}, name: @js($country->name) })"
                                    class="block w-full px-3.5 py-2.5 text-left text-sm text-gray-700 hover:bg-emerald-50">
                                    {{ collect([$country->flag, $country->name])->filter()->join(' ') }}
                                </button>
                            @endforeach
                            <p x-show="filteredCountries.length === 0" class="px-3.5 py-2.5 text-sm text-gray-500">No countries found.</p>
                        </div>
                    </div>
                </div>

                <!-- State -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">State</label>
                    <div wire:key="offcanvas-state-picker-{{ $country_id ?: 'none' }}" class="relative" x-data="{
                        open: false,
                        search: @js($this->states->firstWhere('id', $state_id)?->name ?? ''),
                        selectedStateId: @js($state_id),
                        states: @js($this->states->map(fn ($state) => [
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
                        },
                        clearState() {
                            this.selectedStateId = '';
                            this.search = '';
                            this.open = false;
                            this.$wire.set('state_id', '');
                        }
                    }" @click.outside="open = false">
                        <input type="text" x-model="search"
                            @focus="open = true; $event.target.select()"
                            @input="open = true; if (selectedStateId !== '') { selectedStateId = ''; $wire.set('state_id', ''); }"
                            @keydown.escape="open = false"
                            @keydown.enter.prevent="if (filteredStates.length) selectState(filteredStates[0])"
                            autocomplete="off" placeholder="Search states or choose all"
                            class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 focus:border-emerald-500 focus:outline-none"
                            role="combobox" aria-autocomplete="list" :aria-expanded="open.toString()">
                        <div x-show="open" x-cloak class="absolute z-50 mt-1 max-h-56 w-full overflow-auto rounded-xl border border-gray-200 bg-white shadow-lg">
                            <button type="button" @click="clearState()" class="block w-full px-3.5 py-2.5 text-left text-sm text-gray-500 hover:bg-gray-50">All States</button>
                            @foreach ($this->states as $state)
                                <button type="button"
                                    data-state-option
                                    data-search="{{ \Illuminate\Support\Str::lower($state->name) }}"
                                    x-show="!search.trim() || $el.dataset.search.includes(search.trim().toLowerCase())"
                                    @click="selectState({ id: {{ $state->id }}, name: @js($state->name) })"
                                    class="block w-full px-3.5 py-2.5 text-left text-sm text-gray-700 hover:bg-emerald-50">
                                    {{ $state->name }}
                                </button>
                            @endforeach
                            <p x-show="states.length === 0" class="px-3.5 py-2.5 text-sm text-gray-500">No states available for this country.</p>
                            <p x-show="states.length > 0 && filteredStates.length === 0" class="px-3.5 py-2.5 text-sm text-gray-500">No states match your search.</p>
                        </div>
                    </div>
                </div>

                <!-- City / Area (inline tag input) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">City / Neighborhood</label>
                    <div class="relative">
                        <div id="cityInputContainer" onclick="document.getElementById('cityInput').focus()" class="flex flex-wrap items-center gap-1.5 px-3 py-2 border border-gray-200 rounded-xl bg-white focus-within:border-emerald-500 focus-within:ring-1 focus-within:ring-emerald-500 min-h-[42px] transition cursor-text">
                            <div id="cityTags" class="flex flex-wrap items-center gap-1.5">
                                @foreach($cities as $ct)
                                    <span data-value="{{ $ct }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-medium">
                                        <span>{{ $ct }}</span>
                                        <button type="button" wire:click="removeCityTag('{{ $ct }}')" class="hover:text-emerald-950 font-bold ml-0.5 cursor-pointer text-sm leading-none">&times;</button>
                                    </span>
                                @endforeach
                            </div>
                            <input id="cityInput" type="text" placeholder="{{ count($cities) > 0 ? 'Add city...' : 'Type city & press Enter...' }}" class="flex-1 min-w-[130px] bg-transparent text-sm text-gray-700 outline-none border-none p-0 focus:outline-none focus:ring-0 placeholder:text-gray-400" />
                        </div>
                        <ul id="citySuggestions" class="absolute left-0 right-0 bg-white border border-gray-200 mt-1 rounded-xl shadow-lg max-h-44 overflow-auto hidden z-40 divide-y divide-gray-50"></ul>
                    </div>
                </div>
            </div>

            <!-- 2. Property Type (Dynamic from Category Field) -->
            @if($this->typeField && !empty($this->typeField->options))
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-building-4-line text-emerald-600"></i> Property Type
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        @foreach($this->typeField->options as $typeOption)
                            <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                                <input type="checkbox" wire:model="selectedTypes" value="{{ $typeOption }}" class="accent-emerald-600 rounded">
                                <span>{{ $typeOption }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 2b. Charge Frequency (Dynamic from Category Field) -->
            @if($this->rentFrequencyField && !empty($this->rentFrequencyField->options))
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-time-line text-emerald-600"></i> Charge Frequency
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        @foreach($this->rentFrequencyField->options as $freqOption)
                            <label class="flex items-center gap-2 p-2.5 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer font-medium text-gray-700">
                                <input type="checkbox" wire:model="selectedRentFrequencies" value="{{ $freqOption }}" class="accent-emerald-600 rounded">
                                <span>{{ $freqOption }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 3. Price Range (₦) -->
            <div class="space-y-3 pb-5 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="ri-money-naira-circle-line text-emerald-600"></i> Price Range (₦)
                </h3>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Min Price</label>
                        <input type="text" wire:model="minPrice" placeholder="₦ Min" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Max Price</label>
                        <input type="text" wire:model="maxPrice" placeholder="₦ Max" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 4. Rooms Section (Bedrooms, Bathrooms & Kitchens - Shown only if present in category settings) -->
            @if($this->hasRoomsSection)
                <div class="space-y-4 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-hotel-bed-line text-emerald-600"></i> Rooms & Accommodations
                    </h3>
                    
                    <!-- Bedrooms -->
                    @if($this->hasBedrooms)
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Bedrooms</label>
                            <div class="flex gap-2 text-xs">
                                <button type="button" wire:click="$set('selectedBedrooms', 'any')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === 'any' || $selectedBedrooms === '' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">Any</button>
                                <button type="button" wire:click="$set('selectedBedrooms', '1')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === '1' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">1+</button>
                                <button type="button" wire:click="$set('selectedBedrooms', '2')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === '2' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">2+</button>
                                <button type="button" wire:click="$set('selectedBedrooms', '3')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === '3' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">3+</button>
                                <button type="button" wire:click="$set('selectedBedrooms', '4')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === '4' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">4+</button>
                                <button type="button" wire:click="$set('selectedBedrooms', '5')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBedrooms === '5' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">5+</button>
                            </div>
                        </div>
                    @endif

                    <!-- Bathrooms -->
                    @if($this->hasBathrooms)
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Bathrooms</label>
                            <div class="flex gap-2 text-xs">
                                <button type="button" wire:click="$set('selectedBathrooms', 'any')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBathrooms === 'any' || $selectedBathrooms === '' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">Any</button>
                                <button type="button" wire:click="$set('selectedBathrooms', '1')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBathrooms === '1' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">1+</button>
                                <button type="button" wire:click="$set('selectedBathrooms', '2')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBathrooms === '2' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">2+</button>
                                <button type="button" wire:click="$set('selectedBathrooms', '3')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBathrooms === '3' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">3+</button>
                                <button type="button" wire:click="$set('selectedBathrooms', '4')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedBathrooms === '4' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">4+</button>
                            </div>
                        </div>
                    @endif

                    <!-- Kitchens -->
                    @if($this->hasKitchens)
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kitchens</label>
                            <div class="flex gap-2 text-xs">
                                <button type="button" wire:click="$set('selectedKitchens', 'any')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedKitchens === 'any' || $selectedKitchens === '' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">Any</button>
                                <button type="button" wire:click="$set('selectedKitchens', '1')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedKitchens === '1' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">1+</button>
                                <button type="button" wire:click="$set('selectedKitchens', '2')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedKitchens === '2' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">2+</button>
                                <button type="button" wire:click="$set('selectedKitchens', '3')" class="flex-1 py-2 border rounded-xl font-medium cursor-pointer {{ $selectedKitchens === '3' ? 'bg-emerald-600 text-white border-emerald-600 font-bold' : 'border-gray-200 hover:border-emerald-500 text-gray-700' }}">3+</button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- 5. Features & Amenities (Dynamic from Category Settings) -->
            @if($this->hasFeatures && !empty($this->featuresField?->options))
                <div class="space-y-3 pb-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-checkbox-multiple-line text-emerald-600"></i> Features & Amenities
                    </h3>
                    <div class="grid grid-cols-2 gap-2.5 text-xs">
                        @foreach($this->featuresField->options as $featureOption)
                            <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                                <input type="checkbox" wire:model="selectedFeatures" value="{{ $featureOption }}" class="accent-emerald-600 rounded">
                                <span>{{ $featureOption }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 6. Property Title / Document (Dynamic from Category Settings) -->
            @if($this->hasTitles && !empty($this->titleField?->options))
                <div class="space-y-3 pb-5">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ri-file-shield-line text-emerald-600"></i> Property Title / Document
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        @foreach($this->titleField->options as $titleOption)
                            <label class="flex items-center gap-2 p-2 border border-gray-200 hover:border-emerald-500 rounded-xl cursor-pointer text-gray-700">
                                <input type="checkbox" wire:model="selectedTitles" value="{{ $titleOption }}" class="accent-emerald-600 rounded">
                                <span>{{ $titleOption }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Drawer Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center gap-3">
            <button type="button" wire:click="resetFilters" onclick="closeFilterDrawer()" class="w-1/3 py-3 px-4 border border-gray-300 text-gray-700 font-semibold rounded-xl text-sm hover:bg-gray-100 transition text-center cursor-pointer">
                Clear Filters
            </button>
            <button type="button" wire:click="applyFilters" onclick="closeFilterDrawer()" class="w-2/3 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                <i class="ri-search-line text-base"></i>
                <span>Apply Filters</span>
            </button>
        </div>

    </div>
</div>

<!-- Vanilla JavaScript for Off-Canvas Drawer & City Input -->
<script>
    window.isFilterDrawerOpen = window.isFilterDrawerOpen || false;

    function openFilterDrawer() {
        window.isFilterDrawerOpen = true;
        syncFilterDrawerState();
    }

    function closeFilterDrawer() {
        window.isFilterDrawerOpen = false;
        syncFilterDrawerState();
    }

    function syncFilterDrawerState() {
        const drawer = document.getElementById('filterDrawer');
        const backdrop = document.getElementById('filterBackdrop');
        if (!drawer || !backdrop) return;

        if (window.isFilterDrawerOpen) {
            drawer.classList.remove('translate-x-full');
            drawer.classList.add('translate-x-0');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            document.body.classList.add('overflow-hidden');
        } else {
            drawer.classList.remove('translate-x-0');
            drawer.classList.add('translate-x-full');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFilterDrawer();
        }
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', () => {
            syncFilterDrawerState();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const SUGGESTIONS = ['Lekki', 'Ikeja', 'Ikoyi', 'Victoria Island', 'Ajah', 'Surulere', 'Yaba', 'Gbagada', 'Ikorodu', 'Epe', 'Sangotedo'];

        const cityInput = document.getElementById('cityInput');
        const suggestionsEl = document.getElementById('citySuggestions');
        const tagsEl = document.getElementById('cityTags');

        if (!cityInput || !suggestionsEl || !tagsEl) return;

        function updatePlaceholder() {
            if (tagsEl.children.length > 0) {
                cityInput.placeholder = 'Add city...';
            } else {
                cityInput.placeholder = 'Type city & press Enter...';
            }
        }

        function renderSuggestions(filtered) {
            suggestionsEl.innerHTML = '';
            if (!filtered.length) {
                suggestionsEl.classList.add('hidden');
                return;
            }
            for (const s of filtered) {
                const li = document.createElement('li');
                li.className = 'px-3.5 py-2 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-900 cursor-pointer font-medium transition';
                li.textContent = s;
                li.onclick = (e) => {
                    e.stopPropagation();
                    addTag(s);
                    cityInput.value = '';
                    suggestionsEl.classList.add('hidden');
                    cityInput.focus();
                };
                suggestionsEl.appendChild(li);
            }
            suggestionsEl.classList.remove('hidden');
        }

        function addTag(value) {
            value = value.trim();
            if (!value) return;
            @this.call('addCityTag', value);
            cityInput.value = '';
            updatePlaceholder();
        }

        cityInput.addEventListener('focus', () => {
            const q = (cityInput.value || '').trim().toLowerCase();
            const filtered = q ? SUGGESTIONS.filter(s => s.toLowerCase().includes(q)) : SUGGESTIONS;
            renderSuggestions(filtered);
        });

        cityInput.addEventListener('input', (e) => {
            const q = (e.target.value || '').trim().toLowerCase();
            const filtered = q ? SUGGESTIONS.filter(s => s.toLowerCase().includes(q)) : SUGGESTIONS;
            renderSuggestions(filtered);
        });

        cityInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTag(cityInput.value || '');
                cityInput.value = '';
                suggestionsEl.classList.add('hidden');
            } else if (e.key === 'Escape') {
                suggestionsEl.classList.add('hidden');
            }
        });

        document.addEventListener('click', (e) => {
            const container = document.getElementById('cityInputContainer');
            if (container && !container.contains(e.target) && !suggestionsEl.contains(e.target)) {
                suggestionsEl.classList.add('hidden');
            }
        });
    });
</script>
