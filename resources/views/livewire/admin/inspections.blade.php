<x-admin.page title="Inspections" description="Resolve scheduling conflicts and disputes across the platform.">
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3">Property</th>
                    <th class="px-4 py-3">Buyer</th>
                    <th class="px-4 py-3">Slot</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr>
                    <td class="px-4 py-3">Sample listing A</td>
                    <td class="px-4 py-3">buyer@example.com</td>
                    <td class="px-4 py-3">Sat 10:00</td>
                    <td class="px-4 py-3"><span class="text-amber-700 text-xs font-medium">Dispute</span></td>
                </tr>
                <tr>
                    <td class="px-4 py-3">Sample listing B</td>
                    <td class="px-4 py-3">buyer2@example.com</td>
                    <td class="px-4 py-3">Sun 14:00</td>
                    <td class="px-4 py-3"><span class="text-emerald-700 text-xs font-medium">Confirmed</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin.page>
