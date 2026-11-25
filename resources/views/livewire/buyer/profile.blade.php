<div>
    <main class="white-header mx-auto mb-8 mt-[90px] max-w-7xl px-4">
        @include('layouts.profile-header')

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[300px_1fr]">
            @include('layouts.partials.role-sidebar')

            <section class="rounded-xl bg-white p-6 shadow-md">
                <nav class="mb-6 flex flex-wrap gap-6 border-b border-gray-200" aria-label="Profile sections">
                    @foreach (['basic' => 'Profile', 'notifications' => 'Notifications', 'verification' => 'Verification', 'security' => 'Security'] as $tab => $label)
                        <button type="button" wire:click="switchTab('{{ $tab }}')" class="border-b-2 px-1 py-4 text-sm font-medium {{ $activeTab === $tab ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </nav>

                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif

                @if ($activeTab === 'basic')
                    <div class="space-y-8">
                        <section>
                            <h1 class="mb-2 text-2xl font-semibold">Profile information</h1>
                            <p class="mb-5 text-sm text-gray-500">{{ auth()->user()->name }} · {{ auth()->user()->email }}</p>
                            <form wire:submit="updateProfile" class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="tel" wire:model="phone" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">WhatsApp</label>
                                    <input type="tel" wire:model="whatsapp" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Website</label>
                                    <input type="url" wire:model="website" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Facebook</label>
                                    <input type="url" wire:model="facebook" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Twitter</label>
                                    <input type="url" wire:model="twitter" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Instagram</label>
                                    <input type="url" wire:model="instagram" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">YouTube</label>
                                    <input type="url" wire:model="youtube" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">LinkedIn</label>
                                    <input type="url" wire:model="linkedin" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Address</label>
                                    <textarea wire:model="address" rows="3" class="w-full rounded-lg border border-gray-200 px-4 py-3"></textarea>
                                    @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Save profile</button>
                                </div>
                            </form>
                        </section>
                    </div>
                @endif

                @if ($activeTab === 'notifications')
                    <section>
                        <h1 class="mb-2 text-2xl font-semibold">Notification preferences</h1>
                        <p class="mb-6 text-sm text-gray-500">Choose which property alerts and blog newsletters you receive by email and in your Notifications inbox.</p>
                        <form wire:submit="updateNotificationPreferences" class="space-y-8">
                            <div>
                                <h2 class="mb-3 text-lg font-semibold">Property alerts</h2>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @forelse ($propertyAlertCategories as $category)
                                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-4">
                                            <input type="checkbox" value="{{ $category->id }}" wire:model="propertyAlertCategoryIds" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500">No property categories are available.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div>
                                <h2 class="mb-3 text-lg font-semibold">Blog newsletter</h2>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @forelse ($blogCategories as $category)
                                        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-4">
                                            <input type="checkbox" value="{{ $category->id }}" wire:model="blogCategoryIds" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500">No blog categories are available.</p>
                                    @endforelse
                                </div>
                            </div>
                            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Save notification preferences</button>
                        </form>
                    </section>
                @endif

                @if ($activeTab === 'verification')
                    <section>
                        <h1 class="mb-4 text-2xl font-semibold">Verification</h1>
                        @if (auth()->user()->verified_at)
                            <p class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">Your account is verified.</p>
                        @elseif (auth()->user()->moderations()->where('status', 'pending')->exists())
                            <p class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">Your verification request is pending review.</p>
                        @else
                            <form wire:submit="submitVerification" class="space-y-5">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">Government ID number</label>
                                        <input type="text" wire:model="govt_id_number" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                        @error('govt_id_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">Government ID expiry</label>
                                        <input type="date" wire:model="govt_id_expiry" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                        @error('govt_id_expiry') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">Government ID file</label>
                                        <input type="file" wire:model="govt_id_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                                        @error('govt_id_file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">Address proof</label>
                                        <input type="file" wire:model="address_proof_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                                        @error('address_proof_file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700">Facial image</label>
                                        <input type="file" wire:model="facial_image" accept=".jpg,.jpeg,.png" class="w-full">
                                        @error('facial_image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Submit verification</button>
                            </form>
                        @endif
                    </section>
                @endif

                @if ($activeTab === 'security')
                    <section>
                        <h1 class="mb-2 text-2xl font-semibold">Security</h1>
                        <p class="mb-6 text-sm text-gray-500">Update your password and keep your account secure.</p>
                        <form wire:submit="updatePassword" class="max-w-md space-y-4">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Current password</label>
                                <input type="password" wire:model="current_password" autocomplete="current-password" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">New password</label>
                                <input type="password" wire:model="new_password" autocomplete="new-password" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                                @error('new_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Confirm new password</label>
                                <input type="password" wire:model="new_password_confirmation" autocomplete="new-password" class="w-full rounded-lg border border-gray-200 px-4 py-3">
                            </div>
                            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white">Update password</button>
                        </form>
                    </section>
                @endif
            </section>
        </div>
    </main>
</div>
