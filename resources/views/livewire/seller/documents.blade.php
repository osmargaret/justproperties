<div>
  <main class="white-header max-w-7xl mx-auto px-4 mt-[90px] mb-8">
    @include('layouts.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
      @include('layouts.seller-sidebar')

      <div id="documents-tab" class="bg-white rounded-xl p-8 shadow-md">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
          <h2 class="text-2xl font-semibold">Verified Documents</h2>
        </div>
        <div class="mb-8">
          <h3 class="text-lg font-semibold mb-4 flex items-center gap-2"><i class="ri-shield-check-line text-emerald-600"></i> Verification Status</h3>
          <div class="flex items-center gap-4 p-4 bg-emerald-50 border border-emerald-600 rounded-lg">
            <i class="ri-verified-badge-fill text-3xl text-emerald-600"></i>
            <div>
              <h4 class="font-semibold mb-1">Identity Verified</h4>
              <p class="text-sm text-gray-500">Your identity has been verified. You can now list properties with the "Verified Owner" badge.</p>
            </div>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-4 flex items-center gap-2"><i class="ri-upload-line text-emerald-600"></i> Upload Documents</h3>
          <p class="text-gray-500 text-sm mb-4">Upload government-issued ID, proof of address, or property documents to increase trust with buyers.</p>
          <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50">
            <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
            <p class="text-gray-500">Click to upload or drag and drop</p>
            <p class="text-gray-400 text-sm">PDF, JPEG, PNG (Max 10MB)</p>
          </div>
          <div class="mt-4 space-y-2">
            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
              <i class="ri-file-pdf-line text-emerald-600"></i>
              <span class="flex-1 text-sm">Government ID - Passport.pdf</span>
              <span class="text-emerald-600 text-sm">Verified</span>
              <i class="ri-check-line text-emerald-600"></i>
            </div>
            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
              <i class="ri-file-image-line text-emerald-600"></i>
              <span class="flex-1 text-sm">Utility Bill - March 2026.jpg</span>
              <span class="text-yellow-600 text-sm">Pending</span>
              <i class="ri-time-line text-yellow-600"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>