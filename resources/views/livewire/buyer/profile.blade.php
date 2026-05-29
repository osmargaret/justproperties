<div>
   <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
     <!-- Profile Header -->
     @include('layouts.profile-header')

     <!-- Profile Grid -->
     <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
       @include('layouts.partials.role-sidebar')

       <div class="bg-white">
<!-- Tab Navigation -->
          <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-8" aria-label="Tabs">
              <button type="button" wire:click="switchTab('basic')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'basic' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                Basic Information
              </button>
              <button type="button" wire:click="switchTab('notifications')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'notifications' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                Notification Settings
              </button>
              <button type="button" wire:click="switchTab('verification')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'verification' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                Verification
              </button>
              <button type="button" wire:click="switchTab('password')" class="px-1 py-4 text-sm font-medium {{ $activeTab === 'password' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
                Password
              </button>
            </nav>
          </div>

         @if (session('status'))
           <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
         @endif
         @if (session('error'))
           <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
         @endif

<!-- Basic Information Tab -->
          @if ($activeTab === 'basic')
            <div class="rounded-xl p-8 shadow-md">
              <h2 class="text-2xl font-semibold mb-6">Personal Information</h2>

              <!-- Stats Cards -->
              <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                  <div class="text-3xl font-bold text-emerald-600">{{ auth()->user()->properties()->count() }}</div>
                  <div class="text-sm text-gray-500">Properties Listed</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                  <div class="text-3xl font-bold text-emerald-600">{{ auth()->user()->properties()->where('status', 'active')->count() }}</div>
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

              <form wire:submit="updateNotifications" class="space-y-4">
                <div class="border-b border-gray-200 pb-8 mb-8">
                  <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-information-line text-emerald-600"></i> Basic Information</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-user-line text-emerald-600 mr-1"></i> Full Name</label>
                      <input type="text" value="{{ auth()->user()->name }}"  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-mail-line text-emerald-600 mr-1"></i> Email Address</label>
                      <input type="email" value="{{ auth()->user()->email }}"  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-user-smile-line text-emerald-600 mr-1"></i> Display Name</label>
                      <input type="text" value=""  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-calendar-line text-emerald-600 mr-1"></i> Date of Birth</label>
                      <input type="date" value=""  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-map-pin-line text-emerald-600 mr-1"></i> Location</label>
                      <input type="text" value="{{ auth()->user()->country?->name }}"  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" />
                    </div>
                  </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                  <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-contacts-line text-emerald-600"></i> Contact Information</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-phone-line text-emerald-600 mr-1"></i> Phone Number</label>
                      <input type="tel" wire:model="phone" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-whatsapp-line text-emerald-600 mr-1"></i> WhatsApp Number</label>
                      <input type="tel" wire:model="whatsapp" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-global-line text-emerald-600 mr-1"></i> Website (Optional)</label>
                      <input type="url" wire:model="website" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                  </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                  <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-file-text-line text-emerald-600"></i> About Me</h3>
                  <textarea  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 cursor-not-allowed" rows="4"></textarea>
                </div>

                <div>
                  <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-share-line text-emerald-600"></i> Social Media Links</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-facebook-line text-emerald-600 mr-1"></i> Facebook</label>
                      <input type="url" wire:model="facebook" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-instagram-line text-emerald-600 mr-1"></i> Instagram</label>
                      <input type="url" wire:model="instagram" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-twitter-line text-emerald-600 mr-1"></i> Twitter</label>
                      <input type="url" wire:model="twitter" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2"><i class="ri-linkedin-line text-emerald-600 mr-1"></i> LinkedIn</label>
                      <input type="url" wire:model="linkedin" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                    </div>
                  </div>
                </div>

                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Save Changes</button>
              </form>
            </div>
          @endif

<!-- Notification Settings Tab -->
          @if ($activeTab === 'notifications')
            <div class="rounded-xl p-8 shadow-md">
              <h2 class="text-2xl font-semibold mb-6">Notification Settings</h2>

              <form wire:submit="updateNotifications" class="space-y-4">
                <div class="border-b border-gray-200 pb-8 mb-8">
                  <h3 class="text-lg font-semibold mb-6 flex items-center gap-2"><i class="ri-notification-line text-emerald-600"></i> Email Notifications</h3>
                  <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                      <div>
                        <h4 class="font-medium">New Inquiries</h4>
                        <p class="text-sm text-gray-500">Get notified when someone inquires about your properties</p>
                      </div>
                      <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="new_inquiries" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                      </label>
                    </div>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                      <div>
                        <h4 class="font-medium">Listing Views</h4>
                        <p class="text-sm text-gray-500">Daily digest of views and engagement on your listings</p>
                      </div>
                      <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="listing_views" class="sr-only peer">
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
                      <input type="checkbox" wire:model="instant_alerts" class="sr-only peer">
                      <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                  </div>
                </div>

                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Save Notification Settings</button>
              </form>
            </div>
          @endif

<!-- Verification Tab -->
          @if ($activeTab === 'verification')
            <div class="rounded-xl p-8 shadow-md">
              <h2 class="text-2xl font-semibold mb-6">Verification</h2>

              @if (auth()->user()->verified_at)
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                  Your account is verified.
                </div>
              @elseif(auth()->user()->moderations()->where('status', 'pending')->exists())
                <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                  Your verification request is pending review.
                </div>
              @else
                <form wire:submit="submitVerification" class="space-y-4">
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2">Govt ID Number</label>
                      <input type="text" wire:model="govt_id_number" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                      @error('govt_id_number') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2">Govt ID Expiry</label>
                      <input type="date" wire:model="govt_id_expiry" class="w-full px-4 py-3 border border-gray-200 rounded-lg" />
                      @error('govt_id_expiry') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                  </div>
                  <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Address</label>
                    <textarea wire:model="address" class="w-full px-4 py-3 border border-gray-200 rounded-lg" rows="3"></textarea>
                    @error('address') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2">Govt ID File</label>
                      <input type="file" wire:model="govt_id_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full" />
                      @error('govt_id_file') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2">Address Proof File</label>
                      <input type="file" wire:model="address_proof_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full" />
                      @error('address_proof_file') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 mb-2">Facial Image</label>
                      <input type="file" wire:model="facial_image" accept=".jpg,.jpeg,.png" class="w-full" />
                      @error('facial_image') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                  </div>
                  <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Submit Verification</button>
                </form>
              @endif
            </div>
          @endif

          <!-- Password Tab -->
          @if ($activeTab === 'password')
            <div class="rounded-xl p-8 shadow-md">
              <h2 class="text-2xl font-semibold mb-6">Change Password</h2>

              <form wire:submit="updatePassword" class="space-y-4 max-w-md">
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2">Current Password</label>
                  <input type="password" wire:model="current_password" class="w-full px-4 py-3 border border-gray-200 rounded-lg" autocomplete="current-password" />
                  @error('current_password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2">New Password</label>
                  <input type="password" wire:model="new_password" class="w-full px-4 py-3 border border-gray-200 rounded-lg" autocomplete="new-password" />
                  @error('new_password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                  <label class="block font-medium text-sm text-gray-700 mb-2">Confirm New Password</label>
                  <input type="password" wire:model="new_password_confirmation" class="w-full px-4 py-3 border border-gray-200 rounded-lg" autocomplete="new-password" />
                </div>
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Update Password</button>
              </form>
            </div>
          @endif
       </div>
     </div>
   </main>
 </div>