<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InsureMate') }} - Create Secure Account</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            /* Deep Slate Fallback */
            overflow-x: hidden;
        }

        /* 1. Cinematic Full-Screen Background */
        .auth-layout {
            min-height: 100vh;
            /* Deep indigo to royal blue gradient */
            background: linear-gradient(135deg, #020617 0%, #0f172a 40%, #1e1b4b 100%);
            display: flex;
            justify-content: center;
            position: relative;
            padding: 2rem 1rem;
            z-index: 1;
        }

        /* Subtle noise overlay for texture */
        .auth-layout::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opactiy='0.05'/%3E%3C/svg%3E");
            opacity: 0.03;
            mix-blend-mode: overlay;
            pointer-events: none;
            z-index: -1;
        }

        /* Ambient Glows */
        .auth-bg-glow-1 {
            position: absolute;
            width: 70vw;
            height: 70vw;
            max-width: 800px;
            max-height: 800px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 60%);
            border-radius: 50%;
            top: -20%;
            left: -10%;
            pointer-events: none;
            z-index: -1;
            filter: blur(80px);
            animation: pulseGlow 8s infinite alternate ease-in-out;
        }

        .auth-bg-glow-2 {
            position: absolute;
            width: 60vw;
            height: 60vw;
            max-width: 600px;
            max-height: 600px;
            background: radial-gradient(circle, rgba(56, 182, 255, 0.08) 0%, transparent 60%);
            border-radius: 50%;
            bottom: -10%;
            right: -5%;
            pointer-events: none;
            z-index: -1;
            filter: blur(80px);
            animation: pulseGlow 10s infinite alternate-reverse ease-in-out;
        }

        @keyframes pulseGlow {
            0% {
                transform: scale(1) translate(0, 0);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.05) translate(20px, -20px);
                opacity: 1;
            }
        }

        /* 2. Premium Dark Glass Card */
        .auth-card-glass {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);

            /* Inner top white reflection and deep shadow */
            box-shadow:
                inset 0 1px 1px rgba(255, 255, 255, 0.1),
                0 25px 50px -12px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(255, 255, 255, 0.02) inset;

            width: 100%;
            max-width: 480px;
            /* Slightly wider for register form */
            padding: 2.5rem 2.2rem;
            position: relative;
            z-index: 10;

            animation: authFadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        /* Subtle gradient border glow via pseudo-element */
        .auth-card-glass::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 25px;
            background: linear-gradient(135deg, rgba(167, 139, 250, 0.4), transparent 30%, transparent 70%, rgba(96, 165, 250, 0.3));
            z-index: -1;
            opacity: 0.5;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            padding: 1px;
        }

        .auth-card-wrapper {
            width: 100%;
            max-width: 480px;
            /* Aligned with card */
            margin: 2rem auto;
            animation: cardFloat 8s ease-in-out infinite alternate;
        }

        @keyframes cardFloat {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-6px);
            }
        }

        @keyframes authFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 3. Top Branding & Elevated Typography */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .auth-shield-icon {
            width: 50px;
            height: 50px;
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: inset 0 0 0 1px rgba(129, 140, 248, 0.2), 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .auth-title-divider {
            width: 40px;
            height: 3px;
            border-radius: 3px;
            background: linear-gradient(90deg, #818cf8, #38bdf8);
            margin-bottom: 0.75rem;
            animation: growWidth 0.8s ease-out forwards;
            animation-delay: 0.3s;
            transform: scaleX(0);
            transform-origin: center;
        }

        @keyframes growWidth {
            to {
                transform: scaleX(1);
            }
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 0;
            line-height: 1.6;
            font-weight: 400;
        }

        /* 4. Input Fields Micro-Polish */
        .auth-form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .auth-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .auth-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .auth-input-icon {
            position: absolute;
            left: 1.1rem;
            color: #64748b;
            font-size: 1.1rem;
            transition: color 0.3s ease, transform 0.3s ease;
            pointer-events: none;
            z-index: 2;
        }

        .auth-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            font-size: 0.95rem;
            color: #f8fafc;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .auth-input::placeholder {
            color: #475569;
        }

        .auth-input:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: #818cf8;
            outline: none;
            transform: scale(1.01);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .auth-input:focus+.auth-input-icon {
            color: #818cf8;
            transform: scale(1.1);
        }

        .auth-password-toggle {
            position: absolute;
            right: 0.8rem;
            background: transparent;
            border: none;
            color: #64748b;
            padding: 0.4rem;
            cursor: pointer;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            border-radius: 8px;
            z-index: 2;
        }

        .auth-password-toggle:hover {
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.05);
        }

        input[type="password"].auth-input,
        input[type="text"].auth-input.password-input {
            padding-right: 2.8rem;
        }

        /* 5. Password Strength Indicator */
        .password-strength-container {
            margin-top: 0.5rem;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
            display: none;
            /* Hidden by default */
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        /* 6. Powerful Primary Button */
        .auth-btn-primary {
            width: 100%;
            background: linear-gradient(90deg, #7c3aed, #3b82f6);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            margin-top: 1.5rem;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.2);
        }

        .auth-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: left 0.6s ease;
        }

        .auth-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.3);
            background: linear-gradient(90deg, #8b5cf6, #60a5fa);
            color: white;
        }

        .auth-btn-primary:hover::before {
            left: 100%;
        }

        .auth-btn-primary .bi-arrow-right {
            transition: transform 0.3s ease;
        }

        .auth-btn-primary:hover .bi-arrow-right {
            transform: translateX(5px);
        }

        /* Loading State */
        .spinner-border-sm {
            display: none;
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        .btn-loading .spinner-border-sm {
            display: inline-block;
        }

        .btn-loading .btn-text,
        .btn-loading .bi-arrow-right {
            opacity: 0.8;
        }

        /* 7. Secondary Links */
        .auth-footer-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .auth-link {
            color: #818cf8;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            margin-left: 0.25rem;
        }

        .auth-link:hover {
            color: #a5b4fc;
            text-decoration: underline;
        }

        /* 8. Enhanced Glass Pill Trust Badges */
        .auth-trust-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.75rem;
        }

        .auth-trust-pill {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #94a3b8;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            letter-spacing: 0.2px;
            backdrop-filter: blur(4px);
            transition: background 0.3s ease;
        }

        .auth-trust-pill:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .trust-dot {
            width: 6px;
            height: 6px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
            animation: trustPulse 2s infinite;
        }

        @keyframes trustPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Validation Errors */
        .auth-error-feedback {
            color: #f87171;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: block;
        }

        .is-invalid-input {
            border-color: rgba(248, 113, 113, 0.5) !important;
            background-color: rgba(248, 113, 113, 0.05) !important;
        }

        .is-invalid-input:focus {
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15) !important;
        }

        @media (max-width: 480px) {
            .auth-card-glass {
                padding: 2rem 1.5rem;
            }

            .auth-trust-badges {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-layout">
        <!-- Abstract Cinematic Glows -->
        <div class="auth-bg-glow-1"></div>
        <div class="auth-bg-glow-2"></div>

        <div class="auth-card-wrapper">
            <div class="auth-card-glass">
                <!-- Branding Header -->
                <div class="auth-header">
                    <div class="auth-shield-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h1 class="auth-title">Create Your Secure Account</h1>
                    <div class="auth-title-divider"></div>
                    <p class="auth-subtitle">Start managing your policies with InsureMate.</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <input type="hidden" name="ref_code" value="{{ $refCode ?? '' }}">

                    {{-- Referral Banner --}}
                    @if(!empty($refCode))
                        <div
                            style="background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.3);border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem;">
                            <i class="bi bi-person-check-fill" style="color:#818cf8;font-size:1.1rem;"></i>
                            <span style="color:#c7d2fe;font-size:0.88rem;">You were referred by an agent. <strong
                                    style="color:#818cf8;">You're in!</strong></span>
                        </div>
                    @endif

                    <!-- Full Name -->
                    <div class="auth-form-group">
                        <label for="name" class="auth-label">{{ __('Full Name') }}</label>
                        <div class="auth-input-wrapper">
                            <input id="name" type="text" class="auth-input @error('name') is-invalid-input @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="John Doe">
                            <i class="bi bi-person auth-input-icon"></i>
                        </div>
                        @error('name')
                            <span class="auth-error-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-label">{{ __('Email Address') }}</label>
                        <div class="auth-input-wrapper">
                            <input id="email" type="email" class="auth-input @error('email') is-invalid-input @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="name@example.com">
                            <i class="bi bi-envelope auth-input-icon"></i>
                        </div>
                        @error('email')
                            <span class="auth-error-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">{{ __('Password') }}</label>
                        <div class="auth-input-wrapper">
                            <input id="password" type="password"
                                class="auth-input password-input @error('password') is-invalid-input @enderror"
                                name="password" required autocomplete="new-password" placeholder="••••••••">
                            <i class="bi bi-lock auth-input-icon"></i>
                            <button type="button" class="auth-password-toggle toggle-btn" data-target="password"
                                aria-label="Toggle password visibility" tabindex="-1">
                                <i class="bi bi-eye-slash toggle-icon"></i>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="password-strength-container" id="strengthContainer">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        @error('password')
                            <span class="auth-error-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="auth-form-group mb-4">
                        <label for="password-confirm" class="auth-label">{{ __('Confirm Password') }}</label>
                        <div class="auth-input-wrapper">
                            <input id="password-confirm" type="password" class="auth-input password-input"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••">
                            <i class="bi bi-check-circle auth-input-icon"></i>
                            <button type="button" class="auth-password-toggle toggle-btn" data-target="password-confirm"
                                aria-label="Toggle password visibility" tabindex="-1">
                                <i class="bi bi-eye-slash toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn-primary" id="registerBtn">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="btn-text">{{ __('Create Account Securely') }}</span>
                        <i class="bi bi-arrow-right ml-2 btn-icon"></i>
                    </button>

                    <!-- Login Link -->
                    <div class="auth-footer-link">
                        Already have an account? <a href="{{ route('login') }}" class="auth-link">Login</a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="auth-trust-badges">
                        <div class="auth-trust-pill">
                            <div class="trust-dot"></div>
                            256-Bit Encrypted
                        </div>
                        <div class="auth-trust-pill">
                            <div class="trust-dot"></div>
                            IRDAI Approved
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Password Visibility
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('.toggle-icon');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            });

            // Password Strength Meter
            const passwordInput = document.getElementById('password');
            const strengthContainer = document.getElementById('strengthContainer');
            const strengthBar = document.getElementById('strengthBar');

            if (passwordInput && strengthContainer && strengthBar) {
                passwordInput.addEventListener('input', function () {
                    const val = this.value;
                    if (val.length > 0) {
                        strengthContainer.style.display = 'block';
                    } else {
                        strengthContainer.style.display = 'none';
                        return;
                    }

                    let strength = 0;
                    if (val.length >= 8) strength += 1;
                    if (val.match(/[A-Z]/)) strength += 1;
                    if (val.match(/[0-9]/)) strength += 1;
                    if (val.match(/[^a-zA-Z\d]/)) strength += 1;

                    if (strength <= 1) {
                        // Weak
                        strengthBar.style.width = '33%';
                        strengthBar.style.backgroundColor = '#f87171';
                    } else if (strength === 2 || strength === 3) {
                        // Medium
                        strengthBar.style.width = '66%';
                        strengthBar.style.backgroundColor = '#fbbf24';
                    } else if (strength >= 4) {
                        // Strong
                        strengthBar.style.width = '100%';
                        strengthBar.style.backgroundColor = '#10b981';
                    }
                });
            }

            // Loading state on form submit
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');

            if (registerForm && registerBtn) {
                registerForm.addEventListener('submit', function () {
                    if (this.checkValidity()) {
                        registerBtn.classList.add('btn-loading');
                        setTimeout(() => {
                            registerBtn.setAttribute('disabled', 'disabled');
                        }, 50);
                    }
                });
            }
        });
    </script>
</body>

</html>