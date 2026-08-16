<x-buyer.page title="Saved blog posts" description="Articles you bookmarked from the blog.">
    <ul class="space-y-3">
        <li class="p-4 border border-gray-200 rounded-lg flex justify-between gap-4">
            <div>
                <a href="{{ route('post') }}" class="font-medium text-gray-900 hover:text-emerald-600">How to verify a seller on Propatis</a>
                <div class="text-xs text-gray-500 mt-1">Saved 3 days ago · static</div>
            </div>
            <button type="button" class="text-sm text-gray-500 hover:text-red-600 shrink-0">Remove</button>
        </li>
        <li class="p-4 border border-gray-200 rounded-lg flex justify-between gap-4">
            <div>
                <a href="{{ route('post') }}" class="font-medium text-gray-900 hover:text-emerald-600">Short-let checklist for first-time hosts</a>
                <div class="text-xs text-gray-500 mt-1">Saved last week · static</div>
            </div>
            <button type="button" class="text-sm text-gray-500 hover:text-red-600 shrink-0">Remove</button>
        </li>
    </ul>
</x-buyer.page>
