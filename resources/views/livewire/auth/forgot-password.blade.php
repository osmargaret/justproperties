<div class="auth-card">
    @include('livewire.auth.partials.auth-brand', [
        'title' => 'Reset your password',
        'description' => 'Enter the email you used to register and we will send you a reset link.',
    ])

    <div class="form-panel">
        <div class="form-header">
            <h2>Forgot password</h2>
            <p>Remembered it? <a href="{{ route('login') }}" class="auth-link">Sign in</a></p>
        </div>

        @if (session('status'))
            <div class="success-message" style="display: flex;">
                <i class="ri-checkbox-circle-line"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit="sendResetLink">
            <div class="form-group">
                <label class="form-label" for="forgot-email">
                    <i class="ri-mail-line"></i>
                    Email address
                </label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input id="forgot-email" type="email" class="form-input" wire:model="email" autocomplete="email"
                        placeholder="you@example.com" required>
                </div>
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="sendResetLink">
                    <i class="ri-mail-send-line"></i>
                    Send reset link
                </span>
                <span wire:loading wire:target="sendResetLink">Sending…</span>
            </button>
        </form>

        <div class="login-link text-center mt-6 pt-6 border-t border-gray-200">
            <p class="text-gray-600 text-sm">No account? <a href="{{ route('register') }}" class="auth-link">Create one</a></p>
        </div>
    </div>
</div>

@push('styles')
    @include('livewire.auth.partials.auth-form-styles')
@endpush
