<div class="auth-card">
    @include('livewire.auth.partials.auth-brand', [
        'title' => 'Verify your email',
        'description' => 'We sent a secure link to your inbox. One click confirms your account so you can use Propatis.',
    ])

    <div class="form-panel">
        <div class="form-header">
            <h2>Check your inbox</h2>
            <p>We emailed a verification link to <strong>{{ auth()->user()->email }}</strong></p>
        </div>

        @if (session('status'))
            <div class="success-message" style="display: flex;">
                <i class="ri-checkbox-circle-line"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            {{ __('If you did not receive the email, we will gladly send you another.') }}
        </p>

        <button type="button" class="submit-btn" wire:click="sendVerification" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="sendVerification">
                <i class="ri-mail-send-line"></i>
                {{ __('Resend verification email') }}
            </span>
            <span wire:loading wire:target="sendVerification">{{ __('Sending…') }}</span>
        </button>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full py-3 text-center text-sm font-medium text-gray-600 hover:text-emerald-700 border border-gray-200 rounded-lg">
                {{ __('Sign out') }}
            </button>
        </form>

        <div class="login-link text-center mt-6 pt-6 border-t border-gray-200">
            <p class="text-gray-600 text-sm">
                {{ __('Wrong account?') }}
                <a href="{{ route('login') }}" class="auth-link">{{ __('Back to sign in') }}</a>
            </p>
        </div>
    </div>
</div>

@push('styles')
    @include('livewire.auth.partials.auth-form-styles')
@endpush
