<div class="auth-card">
    @include('livewire.auth.partials.auth-brand', [
        'title' => 'Two-step verification',
        'description' => 'Authenticator apps add an extra layer of security when you sign in.',
    ])

    <div class="form-panel">
        <div class="form-header">
            <h2>Two-factor authentication</h2>
            <p>App-based two-factor challenge during sign-in is not enabled yet.</p>
        </div>

        <div class="success-message" style="display: flex; background: #eff6ff; color: #1d4ed8;">
            <i class="ri-information-line"></i>
            <span>{{ __('Sign in with your email and password. If you need app-based 2FA, it can be added later.') }}</span>
        </div>

        <a href="{{ route('login') }}" class="submit-btn text-center no-underline" style="display: inline-flex; width: 100%; justify-content: center;">
            <i class="ri-login-box-line"></i>
            {{ __('Go to sign in') }}
        </a>
    </div>
</div>

@push('styles')
    @include('livewire.auth.partials.auth-form-styles')
@endpush
