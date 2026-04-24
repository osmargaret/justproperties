@props(['settings'])

@if($settings->isNotEmpty())
    <div class="sm:col-span-2 space-y-6 border-t border-gray-200 pt-6 mt-2">
        <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <i class="ri-list-settings-line text-emerald-600"></i>
            Category-specific fields
        </h4>
        <p class="text-sm text-gray-500">Driven by <code class="text-xs bg-gray-100 px-1 rounded">category_settings</code> for the selected listing category.</p>

        @foreach($settings as $field)
            <div wire:key="category-setting-{{ $field->id }}">
                <label class="block font-medium text-sm text-gray-700 mb-2">
                    {{ $field->label }}
                    @if($field->is_required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                @switch($field->data_type)
                    @case(\App\Models\CategorySetting::TYPE_ENUM)
                        <select
                            wire:model.live="dynamicAttributes.{{ $field->key }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white"
                        >
                            <option value="">{{ $field->is_required ? 'Select…' : 'Optional' }}</option>
                            @foreach($field->options ?? [] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        @break

                    @case(\App\Models\CategorySetting::TYPE_MULTI_ENUM)
                        <div class="flex flex-wrap gap-3 rounded-lg border border-gray-100 bg-gray-50 p-4">
                            @foreach($field->options ?? [] as $opt)
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        value="{{ $opt }}"
                                        wire:model.live="dynamicAttributes.{{ $field->key }}"
                                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    />
                                    <span>{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                        @break

                    @case(\App\Models\CategorySetting::TYPE_NUMBER)
                        <input
                            type="number"
                            wire:model.live="dynamicAttributes.{{ $field->key }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            @if($field->is_required) required @endif
                        />
                        @break

                    @case(\App\Models\CategorySetting::TYPE_DATE)
                        <input
                            type="date"
                            wire:model.live="dynamicAttributes.{{ $field->key }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            @if($field->is_required) required @endif
                        />
                        @break

                    @case(\App\Models\CategorySetting::TYPE_TEXTAREA)
                        <textarea
                            wire:model.live="dynamicAttributes.{{ $field->key }}"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            @if($field->is_required) required @endif
                        ></textarea>
                        @break

                    @case(\App\Models\CategorySetting::TYPE_BOOLEAN)
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" wire:model.live="dynamicAttributes.{{ $field->key }}" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" />
                            <span class="text-sm text-gray-600">Yes</span>
                        </label>
                        @break

                    @default
                        <input
                            type="text"
                            wire:model.live="dynamicAttributes.{{ $field->key }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            @if($field->is_required) required @endif
                        />
                @endswitch
            </div>
        @endforeach
    </div>
@endif
