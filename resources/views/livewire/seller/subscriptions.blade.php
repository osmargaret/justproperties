<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.seller-sidebar')

      <div id="subscription-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">Subscription &amp; Billing</h2>
        </div>

        <div class="bg-gradient-to-r from-emerald-50 to-green-100 rounded-lg p-6 border border-emerald-600 mb-8">
          <div class="flex items-center justify-between mb-4">
            <span class="text-xl font-bold text-emerald-600">Professional Plan</span>
            <span class="bg-emerald-600 text-white text-xs px-3 py-1 rounded-full">Active</span>
          </div>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div><span class="text-gray-500 text-sm block">Billing Cycle</span><span class="font-medium">Monthly</span></div>
            <div><span class="text-gray-500 text-sm block">Next Billing</span><span class="font-medium">April 15, 2026</span></div>
            <div><span class="text-gray-500 text-sm block">Amount</span><span class="font-medium">₦12,000/month</span></div>
            <div><span class="text-gray-500 text-sm block">Listings Used</span><span class="font-medium">3 of 5</span></div>
          </div>
          <div class="mb-2"><div class="h-2 bg-gray-200 rounded-full"><div class="h-2 bg-emerald-600 rounded-full w-3/5"></div></div></div>
          <div class="text-right text-xs text-gray-500">3 listings remaining this month</div>
          <div class="flex gap-4 mt-4">
            <button class="flex-1 py-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 hover:shadow-lg rounded-lg font-medium hover:bg-emerald-50">Change Plan</button>
            <button class="flex-1 py-2 border border-gray-300 text-gray-500 rounded-lg font-medium hover:bg-gray-100">Cancel</button>
          </div>
        </div>

        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-bank-card-line text-emerald-600"></i> Payment Methods</h3>
          <div class="space-y-3 mb-4">
            <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
              <span class="font-medium">Visa ending in 4242</span>
              <span class="text-emerald-600 text-sm">Default</span>
              <button class="ml-auto text-sm text-gray-500 hover:text-emerald-600">Edit</button>
            </div>
            <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
              <span class="font-medium">GTBank - 0123456789</span>
              <button class="ml-auto text-sm text-gray-500 hover:text-emerald-600">Edit</button>
            </div>
          </div>
          <button class="px-4 py-2 border border-gray-200 rounded-lg font-medium hover:bg-gray-50"><i class="ri-add-line mr-1"></i> Add Payment Method</button>
        </div>

        <div>
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-history-line text-emerald-600"></i> Billing History</h3>
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Date</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Description</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Amount</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Status</th>
                <th class="text-left py-3 text-gray-500 font-medium text-sm">Invoice</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-gray-100">
                <td class="py-3">Mar 15, 2026</td>
                <td class="py-3">Professional Plan - Monthly</td>
                <td class="py-3">₦12,000</td>
                <td class="py-3"><span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">Paid</span></td>
                <td class="py-3"><button class="text-emerald-600 text-sm"><i class="ri-download-line mr-1"></i>PDF</button></td>
              </tr>
              <tr class="border-b border-gray-100">
                <td class="py-3">Feb 15, 2026</td>
                <td class="py-3">Professional Plan - Monthly</td>
                <td class="py-3">₦12,000</td>
                <td class="py-3"><span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">Paid</span></td>
                <td class="py-3"><button class="text-emerald-600 text-sm"><i class="ri-download-line mr-1"></i>PDF</button></td>
              </tr>
              <tr>
                <td class="py-3">Jan 15, 2026</td>
                <td class="py-3">Professional Plan - Monthly</td>
                <td class="py-3">₦12,000</td>
                <td class="py-3"><span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">Paid</span></td>
                <td class="py-3"><button class="text-emerald-600 text-sm"><i class="ri-download-line mr-1"></i>PDF</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>