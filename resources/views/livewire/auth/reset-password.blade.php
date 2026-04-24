<div class="auth-card">
    @include('livewire.auth.partials.auth-brand', [
        'title' => 'Choose a new password',
        'description' => 'Pick a strong password you have not used elsewhere. You will be signed in on the next step.',
    ])

    <div class="form-panel">
        <div class="form-header">
            <h2>Set new password</h2>
            <p><a href="{{ route('login') }}" class="auth-link">Back to sign in</a></p>
        </div>

        <form wire:submit="resetPassword">
            <div class="form-group">
                <label class="form-label" for="reset-email">
                    <i class="ri-mail-line"></i>
                    Email address
                </label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input id="reset-email" type="email" class="form-input" wire:model="email" autocomplete="email"
                        placeholder="you@example.com" required>
                </div>
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label class="form-label" for="reset-password">
                    <i class="ri-lock-line"></i>
                    New password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input id="reset-password" class="form-input" wire:model="password" autocomplete="new-password"
                        placeholder="New password" required x-bind:type="show ? 'text' : 'password'">
                    <button type="button" class="password-toggle" @click.prevent="show = !show" aria-label="Toggle password">
                        <i class="ri-eye-line" x-show="!show"></i>
                        <i class="ri-eye-off-line" x-show="show" x-cloak></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" x-data="{ show2: false }">
                <label class="form-label" for="reset-password-confirmation">
                    <i class="ri-lock-line"></i>
                    Confirm password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input id="reset-password-confirmation" class="form-input" wire:model="password_confirmation"
                        autocomplete="new-password" placeholder="Confirm password" required
                        x-bind:type="show2 ? 'text' : 'password'">
                    <button type="button" class="password-toggle" @click.prevent="show2 = !show2" aria-label="Toggle password">
                        <i class="ri-eye-line" x-show="!show2"></i>
                        <i class="ri-eye-off-line" x-show="show2" x-cloak></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="submit-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="resetPassword">
                    <i class="ri-shield-check-line"></i>
                    Update password
                </span>
                <span wire:loading wire:target="resetPassword">Saving…</span>
            </button>
        </form>
    </div>
</div>

@push('styles')
    @include('livewire.auth.partials.auth-form-styles')
@endpush
