<x-admin.page title="User details" description="Account overview and activity (placeholder).">
    @if($user)
        <p class="text-sm text-gray-500 mb-4">Viewing user ID: <span class="font-mono text-gray-800">{{ $user }}</span></p>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">Profile</h3>
            <p class="text-sm text-gray-600">Name, email, phone, and verification status will appear here.</p>
        </div>
        <div class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">Listings &amp; activity</h3>
            <p class="text-sm text-gray-600">Recent listings, inspections, and payments (static placeholder).</p>
        </div>
    </div>
    <a href="{{ route('admin.users') }}" class="inline-flex mt-6 text-sm font-medium text-emerald-600 hover:text-emerald-700">← Back to users</a>
</x-admin.page>
