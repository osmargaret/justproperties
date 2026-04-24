<x-admin.page title="Property details" description="Moderation tools and owner contact (placeholder).">
    @if($property)
        <p class="text-sm text-gray-500 mb-4">Property ID: <span class="font-mono text-gray-800">{{ $property }}</span></p>
    @endif
    <div class="space-y-4 text-sm text-gray-600">
        <p>Gallery, description, pricing, and inspection history will render here from your database.</p>
        <div class="flex flex-wrap gap-3">
            <button type="button" class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-medium text-sm">Approve (demo)</button>
            <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm">Reject (demo)</button>
        </div>
    </div>
    <a href="{{ route('admin.properties') }}" class="inline-flex mt-6 text-sm font-medium text-emerald-600 hover:text-emerald-700">← Back to properties</a>
</x-admin.page>
