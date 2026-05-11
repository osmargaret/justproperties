<div class="auth-card">
    <div class="brand-panel">
        <div class="brand-content">
            <div class="logo">
                <img src="https://public.readdy.ai/ai/img_res/ad862f59-432f-4717-90b5-32d843f1d8ac.png"
                    alt="JustProperties">
                <span>JustProperties</span>
            </div>

            <div class="brand-text">
                <h1>Join Our Community</h1>
                <p>Connect directly with property owners and find your dream property in Nigeria.</p>
            </div>

            <ul class="features">
                <li>
                    <i class="ri-check-line"></i>
                    <span>Direct contact with verified owners</span>
                </li>
                <li>
                    <i class="ri-check-line"></i>
                    <span>No agent fees or commissions</span>
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
            <h2>Create Account</h2>
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>

        <div class="social-signup">
            <button type="button" class="social-btn google" wire:click="socialSignup('google')">
                <i class="ri-google-fill"></i>
                Google
            </button>
            <button type="button" class="social-btn facebook" wire:click="socialSignup('facebook')">
                <i class="ri-facebook-fill"></i>
                Facebook
            </button>
            <button type="button" class="social-btn apple" wire:click="socialSignup('apple')">
                <i class="ri-apple-fill"></i>
                Apple
            </button>
        </div>

        <div class="divider">
            <span>OR</span>
        </div>

        @if (session('status'))
            <div class="alert success">
                <i class="ri-information-line"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit="register">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="first_name"><i class="ri-user-line"></i> First name</label>
                    <div class="input-group">
                        <i class="ri-user-line input-icon"></i>
                        <input id="first_name" type="text" class="form-input" wire:model="first_name" placeholder="John"
                            autocomplete="given-name" required>
                    </div>
                    @error('first_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="last_name"><i class="ri-user-line"></i> Last name</label>
                    <div class="input-group">
                        <i class="ri-user-line input-icon"></i>
                        <input id="last_name" type="text" class="form-input" wire:model="last_name" placeholder="Doe"
                            autocomplete="family-name" required>
                    </div>
                    @error('last_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email"><i class="ri-mail-line"></i> Email address</label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input id="email" type="email" class="form-input" wire:model="email" placeholder="john.doe@example.com"
                        autocomplete="email" required>
                </div>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="phone"><i class="ri-phone-line"></i> Phone number</label>
                <div class="input-group">
                    <i class="ri-phone-line input-icon"></i>
                    <input id="phone" type="tel" class="form-input" wire:model="phone" placeholder="0801 234 5678"
                        autocomplete="tel" required>
                </div>
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="country_id"><i class="ri-map-pin-line"></i> Country</label>
                <div class="input-group">
                    <i class="ri-map-pin-line input-icon"></i>
                    <select id="country_id" class="form-input form-select" wire:model="country_id" required
                        style="appearance: none; padding-right: 2.5rem;">
                        <option value="">Select your country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('country_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" x-data="{ show: false }">
                <label class="form-label" for="password"><i class="ri-lock-line"></i> Password</label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input id="password" class="form-input" wire:model="password" placeholder="Create a password" required
                        autocomplete="new-password" x-bind:type="show ? 'text' : 'password'">
                    <button type="button" class="password-toggle" @click.prevent="show = !show" aria-label="Toggle password">
                        <i class="ri-eye-line" x-show="!show"></i>
                        <i class="ri-eye-off-line" x-show="show" x-cloak></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" x-data="{ show2: false }">
                <label class="form-label" for="password_confirmation"><i class="ri-lock-line"></i> Confirm password</label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input id="password_confirmation" class="form-input" wire:model="password_confirmation"
                        placeholder="Re-enter password" required autocomplete="new-password"
                        x-bind:type="show2 ? 'text' : 'password'">
                    <button type="button" class="password-toggle" @click.prevent="show2 = !show2" aria-label="Toggle password">
                        <i class="ri-eye-line" x-show="!show2"></i>
                        <i class="ri-eye-off-line" x-show="show2" x-cloak></i>
                    </button>
                </div>
            </div>

            <div class="terms">
                <input type="checkbox" wire:model.boolean="terms" id="terms">
                <label for="terms">
                    I agree to the <a href="{{ route('terms-of-service') }}" target="_blank" rel="noopener">Terms of Service</a>
                    and
                    <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener">Privacy Policy</a>
                </label>
            </div>
            @error('terms')
                <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
            @enderror

            <button type="submit" class="submit-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">
                    <i class="ri-user-add-line"></i>
                    Create Account
                </span>
                <span wire:loading wire:target="register">Creating account…</span>
            </button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .social-signup {
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
            font-size: 0.95rem;
            font-weight: 500;
        }

        .social-btn:hover {
            border-color: #059669;
            background: #f0fdf4;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
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
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.95rem;
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

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 1rem 0;
        }

        .terms label {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .terms a {
            color: #059669;
            font-weight: 500;
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
            margin-bottom: 1rem;
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .login-link p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #059669;
            font-weight: 600;
        }

        .alert.success {
            background: #dcfce7;
            color: #047857;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 768px) {
            .social-signup {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
