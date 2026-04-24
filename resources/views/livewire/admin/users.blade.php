<x-admin.page title="Users" description="Browse and moderate registered buyer and seller accounts.">
    <p class="text-gray-600 text-sm mb-6">Static preview data. Connect your database to list real users.</p>
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">Ada Okafor</td>
                    <td class="px-4 py-3 text-gray-600">ada@example.com</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs">Seller</span></td>
                    <td class="px-4 py-3"><a href="{{ route('admin.users.show', ['user' => 1]) }}" class="text-emerald-600 font-medium hover:underline">View</a></td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">Chidi Eze</td>
                    <td class="px-4 py-3 text-gray-600">chidi@example.com</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs">Buyer</span></td>
                    <td class="px-4 py-3"><a href="{{ route('admin.users.show', ['user' => 2]) }}" class="text-emerald-600 font-medium hover:underline">View</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin.page>
