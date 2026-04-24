<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.partials.role-sidebar')

      <div id="notifications-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">Notification Settings</h2>
        </div>
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-notification-line text-emerald-600"></i> Email Notifications</h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
              <div>
                <h4 class="font-medium">New Inquiries</h4>
                <p class="text-sm text-gray-500">Get notified when someone inquires about your properties</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
              </label>
            </div>
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
              <div>
                <h4 class="font-medium">Listing Views</h4>
                <p class="text-sm text-gray-500">Daily digest of views and engagement on your listings</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
              </label>
            </div>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-whatsapp-line text-emerald-600"></i> WhatsApp Notifications</h3>
          <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
            <div>
              <h4 class="font-medium">Instant Alerts</h4>
              <p class="text-sm text-gray-500">Get instant WhatsApp alerts for urgent inquiries</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" checked class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
            </label>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>