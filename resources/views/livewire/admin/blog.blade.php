<x-admin.page title="Blog" description="Draft, schedule, and publish posts for the public blog.">
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 border border-gray-200 rounded-lg">
            <div>
                <div class="font-medium text-gray-900">How to verify a seller on JustProperties</div>
                <div class="text-xs text-gray-500 mt-1">Draft · last edited 2 days ago</div>
            </div>
            <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-700 w-fit">Draft</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 border border-gray-200 rounded-lg">
            <div>
                <div class="font-medium text-gray-900">Short-let checklist for first-time hosts</div>
                <div class="text-xs text-gray-500 mt-1">Published · 1.2k views</div>
            </div>
            <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 w-fit">Live</span>
        </div>
    </div>
    <a href="{{ route('blog') }}" class="inline-flex mt-6 text-sm font-medium text-emerald-600 hover:text-emerald-700">View public blog →</a>
</x-admin.page>
