<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.buyer-sidebar')

      <div id="security-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">Security Settings</h2>
        </div>
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-lock-password-line text-emerald-600"></i> Change Password</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">Current Password</label>
              <input type="password" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Enter current password" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">New Password</label>
              <input type="password" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Enter new password" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">Confirm New Password</label>
              <input type="password" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Confirm new password" />
            </div>
          </div>
          <button class="mt-4 px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700">Update Password</button>
        </div>
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-shield-line text-emerald-600"></i> Two-Factor Authentication</h3>
          <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
            <div>
              <h4 class="font-medium">Enable 2FA</h4>
              <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
            </label>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-4 flex items-center gap-2"><i class="ri-delete-bin-line text-emerald-600"></i> Delete Account</h3>
          <p class="text-gray-500 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
          <button class="px-6 py-3 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200">Delete Account</button>
        </div>
      </div>
    </div>
  </main>
</div>