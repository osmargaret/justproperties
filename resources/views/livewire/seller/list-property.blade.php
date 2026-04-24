<div>
  
  <!-- Main Content -->
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">

  
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-900 to-emerald-600 rounded-xl p-8 mb-8 text-white flex items-center justify-between flex-wrap gap-4">
      <div>
        <h2 class="text-2xl font-bold mb-2">Welcome back, John! 👋</h2>
        <p class="text-emerald-100">List your property and reach thousands of potential buyers instantly</p>
      </div>
      <div class="bg-white/20 px-6 py-2 rounded-full font-semibold border border-white/30">
        <i class="ri-crown-line mr-2"></i> Basic Plan - 1 listing left this month

      </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-8">
      <!-- Left Column - Listing Form -->
      <div class="bg-white rounded-xl p-8 shadow-md">
        <!-- Subscription Status -->
        <div class="bg-emerald-50 border border-emerald-600 rounded-lg p-6 mb-8 flex items-center gap-4">
          <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center text-white text-2xl">
            <i class="ri-verified-badge-fill"></i>
          </div>
          <div>
            <h3 class="text-lg font-semibold">You have an active subscription!</h3>
            <p class="text-gray-500 text-sm">Basic Plan - Valid until Dec 31, 2026</p>
            <span class="inline-block bg-emerald-600 text-white text-xs px-3 py-1 rounded-full mt-1">1 listing remaining this month</span>
          </div>
        </div>

        <!-- Property Details Section -->
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <i class="ri-home-4-line text-emerald-600"></i> Property Details
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-pencil-line text-emerald-600 mr-1"></i> Property Title *
              </label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., Luxury 5 Bedroom Duplex with BQ" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-price-tag-3-line text-emerald-600 mr-1"></i> Listing category *
              </label>
              <select
                wire:model.live="listing_category_id"
                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white"
              >
                <option value="">Select category</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-money-naira-circle-line text-emerald-600 mr-1"></i> Price (₦) *
              </label>
              <input type="number" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., 85000000" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-hotel-bed-line text-emerald-600 mr-1"></i> Bedrooms *
              </label>
              <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6+</option>
              </select>
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-drop-line text-emerald-600 mr-1"></i> Bathrooms *
              </label>
              <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6+</option>
              </select>
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-ruler-line text-emerald-600 mr-1"></i> Land Size (sqm)
              </label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., 450" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">
                <i class="ri-building-line text-emerald-600 mr-1"></i> Building Size (sqm)
              </label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., 350" />
            </div>

            @php
              $activeCategory = $listing_category_id
                  ? $categories->firstWhere('id', (int) $listing_category_id)
                  : null;
            @endphp
            @include('livewire.seller.partials.category-settings-fields', [
                'settings' => $activeCategory?->settings ?? collect(),
            ])
          </div>
        </div>

        <!-- Location Section -->
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <i class="ri-map-pin-line text-emerald-600"></i> Location
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">State *</label>
              <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                <option value="lagos">Lagos</option>
                <option value="abuja">Abuja</option>
                <option value="rivers">Rivers</option>
                <option value="oyo">Oyo</option>
              </select>
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">City/LGA *</label>
              <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                <option value="">Select</option>
                <option value="ikorodu">Ikorodu</option>
                <option value="lekki">Lekki</option>
                <option value="ajah">Ajah</option>
                <option value="ikeja">Ikeja</option>
                <option value="vi">Victoria Island</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">Street Address *</label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., 123 Property Road, Off Main Street" />
            </div>
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">Neighborhood/Landmark</label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., Opposite Police Barracks, Near Shoprite" />
            </div>
          </div>
        </div>

        <!-- Description & Features -->
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <i class="ri-file-text-line text-emerald-600"></i> Description & Features
          </h3>
          <div class="space-y-6">
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">Property Description *</label>
              <textarea class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" rows="4" placeholder="Describe your property in detail..."></textarea>
            </div>
            <div class="sm:col-span-2">
              <label class="block font-medium text-sm text-gray-700 mb-2">Key Features (comma separated)</label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="e.g., Swimming Pool, 24/7 Security, BQ, Parking" />
            </div>
          </div>
        </div>

        <!-- Images Section -->
        <div class="border-b border-gray-200 pb-8 mb-8">
          <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <i class="ri-image-line text-emerald-600"></i> Property Images *
          </h3>
          <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition-all">
            <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
            <p class="text-gray-500">Click or drag images to upload</p>
            <p class="text-gray-400 text-sm mt-2">Maximum 10 images, JPEG/PNG up to 5MB each</p>
          </div>
          <div class="grid grid-cols-4 gap-4 mt-4">
            <div class="aspect-square rounded-lg overflow-hidden relative">
              <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=200&h=200&fit=crop" alt="Preview" class="w-full h-full object-cover" />
              <button class="absolute top-1 right-1 w-6 h-6 bg-black/50 rounded-full text-white flex items-center justify-center"><i class="ri-close-line text-xs"></i></button>
            </div>
            <div class="aspect-square rounded-lg overflow-hidden relative">
              <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=200&h=200&fit=crop" alt="Preview" class="w-full h-full object-cover" />
              <button class="absolute top-1 right-1 w-6 h-6 bg-black/50 rounded-full text-white flex items-center justify-center"><i class="ri-close-line text-xs"></i></button>
            </div>
            <div class="aspect-square rounded-lg overflow-hidden relative">
              <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=200&h=200&fit=crop" alt="Preview" class="w-full h-full object-cover" />
              <button class="absolute top-1 right-1 w-6 h-6 bg-black/50 rounded-full text-white flex items-center justify-center"><i class="ri-close-line text-xs"></i></button>
            </div>
            <div class="aspect-square rounded-lg bg-gray-100 flex items-center justify-center cursor-pointer">
              <i class="ri-add-line text-3xl text-gray-400"></i>
            </div>
          </div>
        </div>

        <!-- Contact Information -->
        <div>
          <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
            <i class="ri-contacts-line text-emerald-600"></i> Contact Information
          </h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">Contact Name *</label>
              <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="John Doe" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">Phone Number *</label>
              <input type="tel" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="08067042140" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">Email *</label>
              <input type="email" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="john.doe@example.com" />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-2">WhatsApp</label>
              <input type="tel" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="08067042140" />
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="space-y-8">
        <!-- Subscription Plans -->
        <div class="bg-white rounded-xl p-6 shadow-md">
          <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <i class="ri-crown-line text-emerald-600"></i> Select Your Plan
          </h3>
          <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 mb-4 bg-white">
            <option value="basic" selected>Basic - 1 listing per month</option>
            <option value="professional">Professional - 5 listings per month</option>
            <option value="business">Business - Unlimited listings</option>
          </select>
          <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 mb-4 bg-white">
            <option value="1">1 Month - ₦5,000</option>
            <option value="3">3 Months - ₦13,500 (Save 10%)</option>
            <option value="6" selected>6 Months - ₦25,500 (Save 15%)</option>
            <option value="12">12 Months - ₦42,000 (Save 30%)</option>
          </select>
          <p class="text-gray-500 text-xs mb-6">
            <i class="ri-information-line mr-1"></i> Cancel anytime. <a href="#" class="text-emerald-600">View plan details</a>
          </p>
        </div>

        <!-- Promotion Section -->
        <div class="bg-white rounded-xl p-6 shadow-md">
          <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
            <i class="ri-rocket-line text-emerald-600"></i> Boost Your Listing
          </h3>
          <p class="text-gray-500 text-xs mb-4">Select one promotion to increase visibility</p>
          <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="promo" checked class="accent-emerald-600" />
              <span class="text-sm">No promotion</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="promo" class="accent-emerald-600" />
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-emerald-600"><i class="ri-star-line"></i></div>
              <div class="flex-1">
                <div class="text-sm font-medium">Featured</div>
                <div class="text-xs text-gray-500">Top results 30 days</div>
              </div>
              <div class="font-semibold text-emerald-600">+₦3k</div>
            </label>
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="promo" class="accent-emerald-600" />
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-emerald-600"><i class="ri-flashlight-line"></i></div>
              <div class="flex-1">
                <div class="text-sm font-medium">Urgent</div>
                <div class="text-xs text-gray-500">Special badge</div>
              </div>
              <div class="font-semibold text-emerald-600">+₦2k</div>
            </label>
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="promo" class="accent-emerald-600" />
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-emerald-600"><i class="ri-whatsapp-line"></i></div>
              <div class="flex-1">
                <div class="text-sm font-medium">WhatsApp</div>
                <div class="text-xs text-gray-500">1000+ buyers</div>
              </div>
              <div class="font-semibold text-emerald-600">+₦4k</div>
            </label>
          </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-xl p-6 shadow-md sticky top-24">
          <h3 class="text-xl font-semibold mb-6 pb-4 border-b border-gray-200">Payment Summary</h3>
          <div class="space-y-3 mb-6">
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Basic Plan</span>
              <span class="font-medium">₦5,000/month</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Duration</span>
              <span class="font-medium">6 Months</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Subtotal (6 months)</span>
              <span class="font-medium">₦25,500</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">VAT (7.5%)</span>
              <span class="font-medium">₦1,913</span>
            </div>
          </div>
          <div class="flex justify-between py-4 border-t-2 border-gray-200 mb-6">
            <span class="font-bold">Total</span>
            <span class="font-bold text-2xl text-emerald-600">₦27,413</span>
          </div>
          <div class="flex gap-2 mb-6">
            <input type="text" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm" placeholder="Enter promo code" />
            <button class="px-4 py-2 bg-gray-100 rounded-lg font-medium hover:bg-gray-200">Apply</button>
          </div>
          <div class="space-y-2 mb-6">
            <label class="flex items-center gap-3 p-3 border border-emerald-500 bg-emerald-50 rounded-lg cursor-pointer">
              <input type="radio" name="payment" checked class="accent-emerald-600" />
              <span class="font-medium">Card Payment</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="payment" class="accent-emerald-600" />
              <span class="font-medium">Paystack</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500">
              <input type="radio" name="payment" class="accent-emerald-600" />
              <span class="font-medium">Bank Transfer</span>
            </label>
          </div>
          <button class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg">
            <i class="ri-lock-line"></i> Pay ₦27,413 & Submit Listing
          </button>
          <div class="flex items-center justify-center gap-2 mt-4 text-gray-500 text-xs">
            <i class="ri-shield-check-line text-emerald-600"></i> Secured by Paystack • 256-bit SSL Encrypted
          </div>
        </div>
      </div>
    </div>
  </main>
</div>