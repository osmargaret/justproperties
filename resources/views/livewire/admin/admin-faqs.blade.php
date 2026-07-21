<x-admin.page title="FAQs" description="Manage frequently asked questions shown across the site.">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <button type="button" wire:click="openCreate" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
            Add FAQ
        </button>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Question</th>
                    <th class="px-4 py-3">Active</th>
                    <th class="px-4 py-3">On Contact Page</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($faqs as $faq)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 max-w-xs">
                            <p class="font-medium text-gray-800 truncate">{{ $faq->question }}</p>
                            <p class="mt-0.5 text-xs text-gray-400 line-clamp-2">{{ Str::limit($faq->answer, 100) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $faq->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $faq->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $faq->show_on_contact_page ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $faq->show_on_contact_page ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-3">
                                <button type="button" wire:click="openEdit({{ $faq->id }})" class="text-xs font-medium text-emerald-600 hover:underline">Edit</button>
                                <button type="button" wire:click="toggleActive({{ $faq->id }})" class="text-xs font-medium text-gray-600 hover:underline">
                                    {{ $faq->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button type="button" wire:click="delete({{ $faq->id }})" wire:confirm="Delete this FAQ?" class="text-xs font-medium text-red-600 hover:underline">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No FAQs found. Click "Add FAQ" to create one.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $faqs->links() }}</div>

    {{-- Create / Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" wire:key="faq-modal">
            <div class="w-full max-w-xl rounded-2xl bg-white p-6 shadow-2xl" @click.outside="$wire.closeModal()">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">{{ $editingId ? 'Edit FAQ' : 'New FAQ' }}</h2>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Question <span class="text-red-500">*</span></label>
                        <input wire:model="question" type="text" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="e.g. How do I list my property?" />
                        @error('question') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Answer <span class="text-red-500">*</span></label>
                        <textarea wire:model="answer" rows="5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="Provide a helpful, concise answer..."></textarea>
                        @error('answer') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-wrap items-center gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input wire:model="is_active" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600" />
                            Active
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input wire:model="show_on_contact_page" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600" />
                            Show on Contact Page
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="closeModal" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                            {{ $editingId ? 'Update FAQ' : 'Create FAQ' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-admin.page>
