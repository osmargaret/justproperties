<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    <!-- Profile Header -->
    @include('layouts.profile-header')

    <!-- Profile Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.partials.role-sidebar')
      
      <div class="bg-white">
        <div id="personal-tab" class="rounded-xl p-8 mb-5 shadow-md">
          <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold">Personal Information</h2>
            <button onclick="toggleEdit()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full font-medium hover:bg-gray-200">
              <i class="ri-pencil-line text-emerald-600"></i><span id="editText">Edit Profile</span>
            </button>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
              <div class="text-3xl font-bold text-emerald-600">12</div>
              <div class="text-sm text-gray-500">Properties Listed</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
              <div class="text-3xl font-bold text-emerald-600">8</div>
              <div class="text-sm text-gray-500">Active Listings</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
              <div class="text-3xl font-bold text-emerald-600">156</div>
              <div class="text-sm text-gray-500">Total Views</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
              <div class="text-3xl font-bold text-emerald-600">23</div>
              <div class="text-sm text-gray-500">Inquiries</div>
            </div>
          </div>

          <form id="profileForm">
            <div class="border-b border-gray-200 pb-8 mb-8">
              <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-information-line text-emerald-600"></i> Basic Information</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-user-line text-emerald-600 mr-1"></i> Full Name</label>
                  <input type="text" value="John Doe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-user-smile-line text-emerald-600 mr-1"></i> Display Name</label>
                  <input type="text" value="John D." disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-calendar-line text-emerald-600 mr-1"></i> Date of Birth</label>
                  <input type="date" value="1990-01-01" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-map-pin-line text-emerald-600 mr-1"></i> Location</label>
                  <input type="text" value="Ikorodu, Lagos" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
              </div>
            </div>

            <div class="border-b border-gray-200 pb-8 mb-8">
              <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-contacts-line text-emerald-600"></i> Contact Information</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-mail-line text-emerald-600 mr-1"></i> Email Address</label>
                  <input type="email" value="john.doe@example.com" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-phone-line text-emerald-600 mr-1"></i> Phone Number</label>
                  <input type="tel" value="+234 806 704 2140" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-whatsapp-line text-emerald-600 mr-1"></i> WhatsApp Number</label>
                  <input type="tel" value="+234 806 704 2140" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-global-line text-emerald-600 mr-1"></i> Website (Optional)</label>
                  <input type="url" value="https://justproperties.com/johndoe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
              </div>
            </div>

            <div class="border-b border-gray-200 pb-8 mb-8">
              <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-file-text-line text-emerald-600"></i> About Me</h3>
              <textarea disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" rows="4">Experienced real estate professional with over 5 years in the Lagos property market. Specializing in luxury homes and investment properties in Ikorodu and surrounding areas.</textarea>
            </div>

            <div>
              <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-share-line text-emerald-600"></i> Social Media Links</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-facebook-line text-emerald-600 mr-1"></i> Facebook</label>
                  <input type="url" value="https://facebook.com/johndoe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-instagram-line text-emerald-600 mr-1"></i> Instagram</label>
                  <input type="url" value="https://instagram.com/johndoe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-twitter-line text-emerald-600 mr-1"></i> Twitter</label>
                  <input type="url" value="https://twitter.com/johndoe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-linkedin-line text-emerald-600 mr-1"></i> LinkedIn</label>
                  <input type="url" value="https://linkedin.com/in/johndoe" disabled class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                </div>
              </div>
            </div>

            <div id="formActions" class="flex justify-end gap-4 mt-8 hidden">
              <button type="button" onclick="cancelEdit()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200">Cancel</button>
              <button type="button" onclick="saveChanges()" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700">Save Changes</button>
            </div>
          </form>
        </div>
        <div id="notification-tab" class="rounded-xl p-8 shadow-md">
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

      
    </div>
  </main>
</div>