<x-admin.page
    title="Categories &amp; field definitions"
    description="Edit listing/blog categories and the dynamic fields (category_settings) used on seller listing forms."
>
    @if (session('status'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid min-w-0 grid-cols-1 lg:grid-cols-[240px_minmax(0,1fr)] gap-8">
        <div class="min-w-0">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Categories</h3>
            <div class="rounded-xl border border-gray-200 overflow-hidden">
                @forelse ($categories as $cat)
                    <button
                        type="button"
                        wire:click="$set('selectedCategoryId', {{ $cat->id }})"
                        class="w-full text-left px-4 py-3 text-sm border-b border-gray-100 last:border-0 transition
                            {{ (int) $selectedCategoryId === (int) $cat->id ? 'bg-emerald-50 text-emerald-900 font-medium' : 'text-gray-700 hover:bg-gray-50' }}"
                    >
                        <span class="block truncate">{{ $cat->name }}</span>
                        <span class="block text-xs text-gray-400 mt-0.5 truncate">{{ $cat->settings_count }} fields · {{ $cat->slug }}</span>
                    </button>
                @empty
                    <p class="px-4 py-6 text-sm text-gray-500">No categories found. Run <code class="text-xs bg-gray-100 px-1 rounded">php artisan db:seed --class=CategoriesSeeder</code>.</p>
                @endforelse
            </div>
        </div>

        <div class="min-w-0 space-y-8">
            @if ($selectedCategory)
                <div class="min-w-0 rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Category</h3>
                    <p class="text-sm text-gray-500 mb-4">Slug is fixed for routing and seeds; display name can change.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 min-w-0">
                        <div class="min-w-0">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Slug</label>
                            <input
                                type="text"
                                readonly
                                value="{{ $categorySlug }}"
                                class="w-full min-w-0 px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-600"
                            />
                        </div>
                        <div class="min-w-0">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Display name</label>
                            <div class="flex flex-wrap gap-2">
                                <input
                                    type="text"
                                    wire:model.live="categoryName"
                                    class="min-w-0 flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                />
                                <button
                                    type="button"
                                    wire:click="saveCategoryMeta"
                                    class="shrink-0 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0 rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-wrap items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900">Fields</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Edit in a modal · options = one label per line</p>
                        </div>
                        <button
                            type="button"
                            wire:click="openAddModal"
                            class="shrink-0 px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800"
                        >
                            Add field
                        </button>
                    </div>

                    <ul class="divide-y divide-gray-100">
                        @if ($selectedCategory->settings->isEmpty())
                            <li class="px-4 sm:px-6 py-8 text-center text-sm text-gray-500">
                                No field definitions yet. Use “Add field” or run the categories seeder.
                            </li>
                        @endif
                        @foreach ($selectedCategory->settings as $setting)
                            <li class="px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-3 min-w-0" wire:key="setting-row-{{ $setting->id }}">
                                <div class="min-w-0 flex-1">
                                    <p class="font-mono text-xs text-gray-500 truncate">{{ $setting->key }}</p>
                                    <p class="font-medium text-gray-900 truncate">{{ $setting->label }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5">{{ $setting->data_type }}</span>
                                        @if ($setting->is_required)
                                            <span class="text-red-600">· required</span>
                                        @endif
                                        <span class="text-gray-400">· sort {{ $setting->sort_order }}</span>
                                    </p>
                                </div>
                                <div class="flex shrink-0 gap-2">
                                    <button
                                        type="button"
                                        wire:click="openEditModal({{ $setting->id }})"
                                        class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="deleteSetting({{ $setting->id }})"
                                        wire:confirm="Delete this field definition?"
                                        class="px-3 py-1.5 rounded-lg border border-red-200 text-sm font-medium text-red-700 hover:bg-red-50"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-sm text-gray-500">Select a category to edit its fields.</p>
            @endif
        </div>
    </div>

    {{-- Edit field modal --}}
    @if ($showEditModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 overscroll-contain"
            wire:click.self="closeEditModal"
            wire:key="edit-modal-backdrop"
        >
            <div
                class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-xl bg-white p-6 shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="edit-field-title"
                @click.stop
            >
                <button
                    type="button"
                    wire:click="closeEditModal"
                    class="absolute right-4 top-4 rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Close"
                >
                    <i class="ri-close-line text-xl"></i>
                </button>
                <h3 id="edit-field-title" class="text-lg font-semibold text-gray-900 pr-10 mb-1">Edit field</h3>
                <p class="text-xs font-mono text-gray-500 mb-6 break-all">{{ $editKey }}</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Label <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.live="editLabel" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" />
                        @error('editLabel') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Data type</label>
                        <select wire:model.live="editDataType" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                            @foreach ($dataTypeOptions as $dt)
                                <option value="{{ $dt }}">{{ $dt }}</option>
                            @endforeach
                        </select>
                        @error('editDataType') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" wire:model.live="editRequired" class="rounded border-gray-300 text-emerald-600" />
                            Required
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sort order</label>
                        <input type="number" wire:model.live="editSort" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" min="0" />
                        @error('editSort') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Options (one per line)</label>
                        <textarea wire:model.live="editOptionsLines" rows="5" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono" placeholder="For enum / multi_enum"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Validation JSON</label>
                        <textarea wire:model.live="editValidationJson" rows="4" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono" placeholder="{ }"></textarea>
                        @error('editValidationJson') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap justify-end gap-2 border-t border-gray-100 pt-4">
                    <button type="button" wire:click="closeEditModal" class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" wire:click="saveEditModal" class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Add field modal --}}
    @if ($showAddModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 overscroll-contain"
            wire:click.self="closeAddModal"
            wire:key="add-modal-backdrop"
        >
            <div
                class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-xl bg-white p-6 shadow-xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="add-field-title"
                @click.stop
            >
                <button
                    type="button"
                    wire:click="closeAddModal"
                    class="absolute right-4 top-4 rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Close"
                >
                    <i class="ri-close-line text-xl"></i>
                </button>
                <h3 id="add-field-title" class="text-lg font-semibold text-gray-900 pr-10 mb-6">Add field</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Key <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.live="newKey" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm font-mono" placeholder="e.g. parking_spaces" />
                        @error('newKey') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Label <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.live="newLabel" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" />
                        @error('newLabel') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Data type</label>
                        <select wire:model.live="newDataType" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                            @foreach ($dataTypeOptions as $dt)
                                <option value="{{ $dt }}">{{ $dt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sort order</label>
                        <input type="number" wire:model.live="newSortOrder" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" min="0" />
                        @error('newSortOrder') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" wire:model.live="newRequired" class="rounded border-gray-300 text-emerald-600" />
                            Required
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Options (one per line)</label>
                        <textarea wire:model.live="newOptionsLines" rows="4" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono" placeholder="For enum / multi_enum"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap justify-end gap-2 border-t border-gray-100 pt-4">
                    <button type="button" wire:click="closeAddModal" class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" wire:click="addSetting" class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700">
                        Create field
                    </button>
                </div>
            </div>
        </div>
    @endif
</x-admin.page>
