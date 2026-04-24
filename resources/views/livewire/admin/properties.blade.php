<x-admin.page title="Properties" description="Moderate and feature listings across the marketplace.">
    <p class="text-gray-600 text-sm mb-6">Static sample rows. Wire this table to your Property model when ready.</p>
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">4-bed duplex · Gberigbe</td>
                    <td class="px-4 py-3 text-gray-600">Completed</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs">Pending</span></td>
                    <td class="px-4 py-3"><a href="{{ route('admin.properties.show', ['property' => 101]) }}" class="text-emerald-600 font-medium hover:underline">Open</a></td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">Half plot · Odogunyan</td>
                    <td class="px-4 py-3 text-gray-600">Landed</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs">Live</span></td>
                    <td class="px-4 py-3"><a href="{{ route('admin.properties.show', ['property' => 102]) }}" class="text-emerald-600 font-medium hover:underline">Open</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin.page>
