<div class="auth-card">
    <!-- Left Panel - Branding -->
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

    <!-- Right Panel - Sign Up Form -->
    <div class="form-panel">
        <div class="form-header">
            <h2>Create Account</h2>
            <p>Already have an account? <a href="#" onclick="alert('Redirect to login (Demo)')">Sign in</a></p>
        </div>

        <!-- Alert Message (hidden by default) -->
        <div id="alertMessage" style="display: none;"></div>

        <!-- Social Signup -->
        <div class="social-signup">
            <button class="social-btn google" onclick="socialSignup('google')">
                <i class="ri-google-fill"></i>
                Google
            </button>
            <button class="social-btn facebook" onclick="socialSignup('facebook')">
                <i class="ri-facebook-fill"></i>
                Facebook
            </button>
            <button class="social-btn apple" onclick="socialSignup('apple')">
                <i class="ri-apple-fill"></i>
                Apple
            </button>
        </div>

        <!-- Divider -->
        <div class="divider">
            <span>OR</span>
        </div>

        <!-- Sign Up Form -->
        <form id="signupForm" onsubmit="handleSubmit(event)">
            <!-- Name Fields -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="ri-user-line"></i>
                        First Name
                    </label>
                    <div class="input-group">
                        <i class="ri-user-line input-icon"></i>
                        <input type="text" class="form-input" id="firstName" placeholder="John" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="ri-user-line"></i>
                        Last Name
                    </label>
                    <div class="input-group">
                        <i class="ri-user-line input-icon"></i>
                        <input type="text" class="form-input" id="lastName" placeholder="Doe" required>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-mail-line"></i>
                    Email Address
                </label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input type="email" class="form-input" id="email" placeholder="john.doe@example.com" required>
                </div>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-phone-line"></i>
                    Phone Number
                </label>
                <div class="input-group">
                    <i class="ri-phone-line input-icon"></i>
                    <input type="tel" class="form-input" id="phone" placeholder="0801 234 5678" required>
                </div>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-map-pin-line"></i>
                    Location
                </label>
                <div class="input-group">
                    <i class="ri-map-pin-line input-icon"></i>
                    <select class="form-input" id="location" required style="appearance: none;">
                        <option value="">Select your location</option>
                        <option value="lagos">Lagos</option>
                        <option value="abuja">Abuja</option>
                        <option value="rivers">Rivers</option>
                        <option value="oyo">Oyo</option>
                        <option value="kano">Kano</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-lock-line"></i>
                    Password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input type="password" class="form-input" id="password" placeholder="Create a password"
                        required onkeyup="checkPasswordStrength()">
                </div>
                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar">
                        <div class="strength-segment"></div>
                        <div class="strength-segment"></div>
                        <div class="strength-segment"></div>
                        <div class="strength-segment"></div>
                    </div>
                    <span class="strength-text">Enter a password</span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-lock-line"></i>
                    Confirm Password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input type="password" class="form-input" id="confirmPassword" placeholder="Re-enter password"
                        required>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="terms">
                <input type="checkbox" id="terms" checked>
                <label for="terms">
                    I agree to the <a href="#" onclick="alert('Terms of Service (Demo)')">Terms of Service</a>
                    and
                    <a href="#" onclick="alert('Privacy Policy (Demo)')">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn" id="submitBtn">
                <i class="ri-user-add-line"></i>
                Create Account
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            <p>Already have an account? <a href="signin.html">Sign in</a></p>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Additional styles specific to signup */
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

        /* Divider */
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

        /* Account Type Selection */
        .account-type {
            margin-bottom: 1.5rem;
        }

        .type-label {
            display: block;
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.75rem;
        }

        .type-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .type-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .type-option:hover {
            border-color: #059669;
        }

        .type-option.selected {
            border-color: #059669;
            background: #f0fdf4;
        }

        .type-option input[type="radio"] {
            width: 1rem;
            height: 1rem;
            accent-color: #059669;
        }

        .type-option label {
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
        }

        /* Form Group */
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
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .form-input:focus+.input-icon {
            color: #059669;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #059669;
        }

        /* Terms and Conditions */
        .terms {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .terms input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            margin-top: 0.2rem;
            accent-color: #059669;
        }

        .terms label {
            font-size: 0.875rem;
            color: #4b5563;
            line-height: 1.5;
        }

        .terms a {
            color: #059669;
            text-decoration: none;
            font-weight: 500;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
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
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .submit-btn:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .submit-btn i {
            font-size: 1.125rem;
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .login-link p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #059669;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert.error {
            background: #fee2e2;
            color: #b91c1c;
        }

        .alert.success {
            background: #dcfce7;
            color: #059669;
        }

        .alert i {
            font-size: 1.125rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .social-signup {
                grid-template-columns: 1fr;
            }

            .type-options {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Password visibility toggle
        document.addEventListener('livewire:loaded', () => {
            @this.on('togglePassword', () => {
                const input = document.querySelector('input[type="password"], input[type="text"]');
                const icon = document.getElementById('toggleIcon');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('ri-eye-line');
                    icon.classList.add('ri-eye-off-line');
                } else {
                    input.type = 'password';
                    icon.classList.remove('ri-eye-off-line');
                    icon.classList.add('ri-eye-line');
                }
            });
        });
    </script>
@endpush
