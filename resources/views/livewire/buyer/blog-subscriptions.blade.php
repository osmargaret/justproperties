<x-buyer.page title="Blog subscriptions" description="Manage email updates when we publish new posts.">
    <div class="p-4 border border-gray-200 rounded-lg flex items-center justify-between gap-4">
        <div>
            <div class="font-medium text-gray-900">Weekly digest</div>
            <div class="text-sm text-gray-500 mt-1">New posts and featured listings summary</div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" checked class="sr-only peer" disabled>
            <span class="w-11 h-6 bg-emerald-600 rounded-full relative after:content-[''] after:absolute after:top-[2px] after:left-[22px] after:bg-white after:rounded-full after:h-5 after:w-5"></span>
        </label>
    </div>
    <p class="text-xs text-gray-500 mt-4">Toggle is static — connect to newsletter preferences when ready.</p>
</x-buyer.page>
