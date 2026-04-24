<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.seller-sidebar')

      <div id="listings-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">My Listings</h2>
          <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700"><i class="ri-add-line mr-1"></i> New Listing</button>
        </div>
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200">
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Property</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Type</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Price</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Status</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Views</th>
              <th class="text-left py-3 text-gray-500 font-medium text-sm">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-gray-100">
              <td class="py-3 font-medium">Luxury 5 Bedroom Duplex</td>
              <td class="py-3">Landed</td>
              <td class="py-3">₦85,000,000</td>
              <td class="py-3"><span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">Active</span></td>
              <td class="py-3">1,247</td>
              <td class="py-3"><button class="text-sm text-gray-500 hover:text-emerald-600 mr-2">Edit</button><button class="text-sm text-gray-500 hover:text-emerald-600">View</button></td>
            </tr>
            <tr class="border-b border-gray-100">
              <td class="py-3 font-medium">4 Bedroom Semi-Detached</td>
              <td class="py-3">Landed</td>
              <td class="py-3">₦45,000,000</td>
              <td class="py-3"><span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">Active</span></td>
              <td class="py-3">892</td>
              <td class="py-3"><button class="text-sm text-gray-500 hover:text-emerald-600 mr-2">Edit</button><button class="text-sm text-gray-500 hover:text-emerald-600">View</button></td>
            </tr>
            <tr class="border-b border-gray-100">
              <td class="py-3 font-medium">2 Bedroom Apartment</td>
              <td class="py-3">Rent</td>
              <td class="py-3">₦1,200,000/year</td>
              <td class="py-3"><span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Pending</span></td>
              <td class="py-3">456</td>
              <td class="py-3"><button class="text-sm text-gray-500 hover:text-emerald-600 mr-2">Edit</button><button class="text-sm text-gray-500 hover:text-emerald-600">View</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>