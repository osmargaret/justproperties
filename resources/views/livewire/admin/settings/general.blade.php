<x-admin.page title="General settings" description="Content generation defaults for the platform.">
    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif

    <form wire:submit="save" class="max-w-xl space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">Content generation</label>
            <select wire:model="generation_mode" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                <option value="manual">Manual</option>
                <option value="ai">AI</option>
            </select>
            @error('generation_mode') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Manual timeframe (hours)</label>
            <input type="number" wire:model="manual_timeframe_hours" min="1" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
            @error('manual_timeframe_hours') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">Minimum word count</label>
                <input type="number" wire:model="min_word_count" min="50" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
                @error('min_word_count') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Maximum word count</label>
                <input type="number" wire:model="max_word_count" min="50" class="mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm" />
                @error('max_word_count') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Save</button>
    </form>
</x-admin.page>
