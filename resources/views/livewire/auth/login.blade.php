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

    <!-- Right Panel - Form -->
    <div class="form-panel">
        <div class="form-header">
            <h2>Sign In</h2>
            <p>Don't have an account? <a href="#" onclick="alert('Redirect to sign up (Demo)')">Sign up</a></p>
        </div>

        <!-- Social Login -->
        <div class="social-login">
            <button class="social-btn google" onclick="socialLogin('google')">
                <i class="ri-google-fill"></i>
                Google
            </button>
            <button class="social-btn facebook" onclick="socialLogin('facebook')">
                <i class="ri-facebook-fill"></i>
                Facebook
            </button>
            <button class="social-btn apple" onclick="socialLogin('apple')">
                <i class="ri-apple-fill"></i>
                Apple
            </button>
        </div>

        <!-- Divider -->
        <div class="divider">
            <span>OR</span>
        </div>

        <!-- Error Message (hidden by default) -->
        <div class="error-message" id="errorMessage" style="display: none;">
            <i class="ri-error-warning-line"></i>
            <span id="errorText">Invalid email or password</span>
        </div>

        <!-- Success Message (hidden by default) -->
        <div class="success-message" id="successMessage" style="display: none;">
            <i class="ri-checkbox-circle-line"></i>
            <span id="successText">Login successful! Redirecting...</span>
        </div>

        <!-- Login Form -->
        <form id="loginForm" onsubmit="handleSubmit(event)">
            <!-- Email Field -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-mail-line"></i>
                    Email Address
                </label>
                <div class="input-group">
                    <i class="ri-mail-line input-icon"></i>
                    <input type="email" class="form-input" id="email" placeholder="you@example.com"
                        value="john.doe@example.com" required>
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label class="form-label">
                    <i class="ri-lock-line"></i>
                    Password
                </label>
                <div class="input-group">
                    <i class="ri-lock-line input-icon"></i>
                    <input type="password" class="form-input" id="password" placeholder="Enter your password"
                        value="password123" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="ri-eye-line" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Form Options -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe" checked>
                    <span>Remember me</span>
                </label>
                <a href="#" class="forgot-password" onclick="alert('Password reset (Demo)')">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn" id="submitBtn">
                <i class="ri-login-box-line"></i>
                Sign In
            </button>
        </form>

        <!-- Sign Up Link -->
        <div class="signup-link">
            <p>New to JustProperties? <a href="signup.html" onclick="alert('Redirect to sign up (Demo)')">Create an
                    account</a>

            </p>
        </div>
    </div>
</div>
@push('styles')
    <style>
        /* Additional styles specific to signin */
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

        /* Form */
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
            transition: color 0.3s ease;
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

        /* Form Options */
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
            cursor: pointer;
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

        /* Sign Up Link */
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

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Error Message */
        .error-message {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .error-message i {
            font-size: 1.125rem;
        }

        /* Success Message */
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

        /* Loading State */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 1.5rem;
            height: 1.5rem;
            margin: -0.75rem 0 0 -0.75rem;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .social-login {
                grid-template-columns: 1fr;
            }

            .social-btn {
                padding: 1rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .form-options {
                flex-direction: column;
                align-items: flex-start;
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
