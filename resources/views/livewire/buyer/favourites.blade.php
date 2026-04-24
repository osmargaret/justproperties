<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.buyer-sidebar')

      <div id="favorites-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">Saved Properties</h2>
          <span class="text-gray-500">12 properties saved</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="border border-gray-200 rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&amp;h=250&amp;fit=crop" class="w-full h-40 object-cover" />
            <div class="p-4">
              <h4 class="font-semibold mb-1">Luxury 5 Bedroom Duplex</h4>
              <p class="text-sm text-gray-500 mb-2">Lekki Phase 1</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-emerald-600">₦85M</span>
                <button class="text-red-500"><i class="ri-heart-fill"></i></button>
              </div>
            </div>
          </div>
          <div class="border border-gray-200 rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=400&amp;h=250&amp;fit=crop" class="w-full h-40 object-cover" />
            <div class="p-4">
              <h4 class="font-semibold mb-1">4 Bedroom Semi-Detached</h4>
              <p class="text-sm text-gray-500 mb-2">Ajah</p>
              <div class="flex justify-between items-center">
                <span class="font-bold text-emerald-600">₦45M</span>
                <button class="text-red-500"><i class="ri-heart-fill"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>