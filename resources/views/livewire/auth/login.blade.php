<div class="auth-card">
    <div class="brand-panel">
        <div class="brand-content">
            <div class="logo">
                <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png"
                    alt="Propatis">
                <span>Propatis</span>
            </div>

            <div class="brand-text">
                <h1>Welcome Back!</h1>
                <p>The easiest way to buy, sell, or rent properties directly from owners in Nigeria.</p>
            </div>

            <ul class="features">
                <li>
                    <i class="ri-check-line"></i>
                    <span>Direct contact with verified property owners</span>
                </li>
                <li>
                    <i class="ri-check-line"></i>
                    <span>No agent fees or hidden charges</span>
                </li>
                <li>
                    <i class="ri-check-line"></i>
                    <span>500+ active listings across Lagos</span>
                </li>
                <li>
                    <i class="ri-check-line"></i>
                    <span>24/7 customer support</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-header">
            <h2>Sign In</h2>
            <p>New here? <a href="{{ route('register') }}">Create an account</a></p>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn google" wire:click="socialLogin('google')">
                <i class="ri-google-fill"></i>
                Google
            </button>
            <button type="button" class="social-btn facebook" wire:click="socialLogin('facebook')">
                <i class="ri-facebook-fill"></i>
                Facebook
            </button>
            <button type="button" class="social-btn apple" wire:click="socialLogin('apple')">
                <i class="ri-apple-fill"></i>
                Apple
            </button>
        </div>

        <div class="divider">
            <span>OR</span>
        </div>

        @if (session('status'))
            <div class="success-message" style="display: flex;">
                <i class="ri-checkbox-circle-line"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit="login">
            <div class="form-group">
                <label class="form-label" for="login-email">
                    <i class="ri-mail-line"></i>
                    Email Address
                </label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input id="login-email" type="email" class="form-input" wire:model="email" autocomplete="username"
                        placeholder="you@example.com" required>
                </div>
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label class="form-label" for="login-password">
                    <i class="ri-lock-line"></i>
                    Password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input id="login-password" class="form-input" wire:model="password" autocomplete="current-password"
                        placeholder="Enter your password" required
                        x-bind:type="show ? 'text' : 'password'">
                    <button type="button" class="password-toggle" @click.prevent="show = !show" aria-label="Toggle password">
                        <i class="ri-eye-line" x-show="!show"></i>
                        <i class="ri-eye-off-line" x-show="show" x-cloak></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" wire:model="remember" id="rememberMe">
                    <span>Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                @else
                    <span class="forgot-password text-gray-400 cursor-not-allowed">Forgot password?</span>
                @endif
            </div>

            <button type="submit" class="submit-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">
                    <i class="ri-login-box-line"></i>
                    Sign In
                </span>
                <span wire:loading wire:target="login">Signing in…</span>
            </button>
        </form>

        <div class="signup-link">
            <p>New to Propatis? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .social-login {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .social-btn:hover {
            border-color: #059669;
            background: #f0fdf4;
            transform: translateY(-2px);
        }

        .social-btn i {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        .social-btn.google i {
            color: #DB4437;
        }

        .social-btn.facebook i {
            color: #4267B2;
        }

        .social-btn.apple i {
            color: #000000;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #9ca3af;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-label i {
            color: #059669;
            margin-right: 0.25rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #9ca3af;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.25rem;
        }

        .password-toggle:hover {
            color: #059669;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: #059669;
        }

        .remember-me span {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .forgot-password {
            color: #059669;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: #059669;
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .submit-btn:hover {
            background: #047857;
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .signup-link p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
        }

        .success-message {
            background: #dcfce7;
            color: #059669;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 768px) {
            .social-login {
                grid-template-columns: 1fr;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
@endpush
