@extends('layouts.app')

@section('content')

    {{-- ── Hero Header ── --}}
    <section class="cu-hero">
        <div class="cu-hero-inner">
            <div class="cu-hero-badge">
                <i class="bi bi-headset me-2"></i> Customer Support
            </div>
            <h1 class="cu-hero-title">How can we help you?</h1>
            <p class="cu-hero-subtitle">
                Our team is here to assist with all your insurance questions, claims, and policy needs.<br>
                Expect a response within 24 hours.
            </p>
        </div>
    </section>

    {{-- ── Main Section ── --}}
    <section class="cu-main">
        <div class="cu-container">

            {{-- Success Toast --}}
            @if(session('success'))
                <div class="cu-success-alert" role="alert">
                    <div class="cu-success-inner">
                        <i class="bi bi-check-circle-fill cu-success-icon"></i>
                        <div>
                            <div class="cu-success-title">Message Sent Successfully!</div>
                            <div class="cu-success-sub">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="cu-grid">

                {{-- ── LEFT: Contact Info Card ── --}}
                <aside class="cu-info-col">

                    {{-- Contact Card --}}
                    <div class="cu-info-card">
                        <div class="cu-info-header">
                            <div class="cu-info-icon-wrap">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h3 class="cu-info-title">Get in Touch</h3>
                                <p class="cu-info-subtitle">We're available Monday–Saturday, 9AM–7PM IST</p>
                            </div>
                        </div>

                        <div class="cu-contact-items">
                            <div class="cu-contact-item">
                                <div class="cu-ci-icon" style="background:rgba(79,70,229,0.1);color:#4f46e5;">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="cu-ci-body">
                                    <div class="cu-ci-label">Phone</div>
                                    <a href="tel:+15551234567" class="cu-ci-value">+1 (555) 123-4567</a>
                                </div>
                            </div>

                            <div class="cu-contact-item">
                                <div class="cu-ci-icon" style="background:rgba(16,185,129,0.1);color:#059669;">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="cu-ci-body">
                                    <div class="cu-ci-label">Email</div>
                                    <a href="mailto:support@insuremate.com" class="cu-ci-value">support@insuremate.com</a>
                                </div>
                            </div>

                            <div class="cu-contact-item">
                                <div class="cu-ci-icon" style="background:rgba(245,158,11,0.1);color:#d97706;">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="cu-ci-body">
                                    <div class="cu-ci-label">Office</div>
                                    <div class="cu-ci-value">123 Insurance Blvd,<br>Policy City, 10012</div>
                                </div>
                            </div>

                            <div class="cu-contact-item">
                                <div class="cu-ci-icon" style="background:rgba(59,130,246,0.1);color:#2563eb;">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div class="cu-ci-body">
                                    <div class="cu-ci-label">Business Hours</div>
                                    <div class="cu-ci-value">Mon – Sat: 9AM – 7PM IST<br>Sun: Closed</div>
                                </div>
                            </div>
                        </div>

                        {{-- What to Expect Timeline --}}
                        <div class="cu-timeline">
                            <div class="cu-timeline-title">What to expect</div>
                            <div class="cu-timeline-steps">
                                <div class="cu-timeline-step">
                                    <div class="cu-step-dot cu-dot-1">1</div>
                                    <div class="cu-step-body">
                                        <div class="cu-step-title">Submit your message</div>
                                        <div class="cu-step-sub">Fill the form and hit Send</div>
                                    </div>
                                </div>
                                <div class="cu-timeline-step">
                                    <div class="cu-step-dot cu-dot-2">2</div>
                                    <div class="cu-step-body">
                                        <div class="cu-step-title">We review your query</div>
                                        <div class="cu-step-sub">Our team reads within hours</div>
                                    </div>
                                </div>
                                <div class="cu-timeline-step">
                                    <div class="cu-step-dot cu-dot-3">3</div>
                                    <div class="cu-step-body">
                                        <div class="cu-step-title">Get a response within 24h</div>
                                        <div class="cu-step-sub">Via email or phone call</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Social Links --}}
                        <div class="cu-social-row" style="margin-top:auto;">
                            <span class="cu-social-label">Follow us</span>
                            <div class="cu-social-icons">
                                <a href="#" class="cu-social-btn" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                                <a href="#" class="cu-social-btn" title="Twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="cu-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="cu-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    {{-- Support ticket nudge --}}
                    <div class="cu-ticket-nudge">
                        <i class="bi bi-ticket-detailed cu-nudge-icon"></i>
                        <div>
                            <div class="cu-nudge-title">Already a customer?</div>
                            <div class="cu-nudge-sub">
                                <a href="{{ route('tickets.create') }}" class="cu-nudge-link">Open a support ticket</a>
                                for faster resolution.
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- ── RIGHT: Message Form Card ── --}}
                <div class="cu-form-col">
                    <div class="cu-form-card">
                        <div class="cu-form-header">
                            <h2 class="cu-form-title">Send us a Message</h2>
                            <p class="cu-form-subtitle">Fill in the details below and our team will get back to you within
                                24 hours.</p>
                        </div>

                        <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                            @csrf

                            {{-- Name + Email row --}}
                            <div class="cu-field-row">
                                <div class="cu-field">
                                    <label class="cu-label" for="name">
                                        <i class="bi bi-person me-1"></i> Full Name
                                    </label>
                                    <input type="text" id="name" name="name"
                                        class="cu-input {{ $errors->has('name') ? 'cu-input-error' : '' }}"
                                        placeholder="Ankit Ghosh" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="cu-field-err">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="cu-field">
                                    <label class="cu-label" for="email">
                                        <i class="bi bi-envelope me-1"></i> Email Address
                                    </label>
                                    <input type="email" id="email" name="email"
                                        class="cu-input {{ $errors->has('email') ? 'cu-input-error' : '' }}"
                                        placeholder="you@example.com" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="cu-field-err">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="cu-field">
                                <label class="cu-label" for="subject">
                                    <i class="bi bi-chat-square-text me-1"></i> Subject
                                </label>
                                <input type="text" id="subject" name="subject"
                                    class="cu-input {{ $errors->has('subject') ? 'cu-input-error' : '' }}"
                                    placeholder="How can we help you?" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <span class="cu-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="cu-field">
                                <label class="cu-label" for="message">
                                    <i class="bi bi-pencil me-1"></i> Message
                                </label>
                                <textarea id="message" name="message"
                                    class="cu-textarea {{ $errors->has('message') ? 'cu-input-error' : '' }}" rows="5"
                                    placeholder="Tell us more about your query or concern...">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="cu-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="cu-submit-btn" id="submitBtn">
                                <i class="bi bi-send-fill me-2" id="btnIcon"></i>
                                <span id="btnText">Send Message</span>
                            </button>
                        </form>
                    </div>

                    {{-- ── Trust Badges ── --}}
                    <div class="cu-trust-row">
                        <div class="cu-trust-badge">
                            <i class="bi bi-shield-lock-fill"></i> 256-bit Encrypted
                        </div>
                        <div class="cu-trust-badge">
                            <i class="bi bi-patch-check-fill"></i> IRDAI Approved
                        </div>
                        <div class="cu-trust-badge">
                            <i class="bi bi-lightning-charge-fill"></i> Instant Policy Support
                        </div>
                        <div class="cu-trust-badge">
                            <i class="bi bi-lock-fill"></i> Privacy Protected
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        :root {
            --cu-brand: #4f46e5;
            --cu-brand-dark: #3730a3;
            --cu-text: #0f172a;
            --cu-muted: #64748b;
            --cu-border: #e2e8f0;
            --cu-bg: #f8fafc;
            --cu-radius: 20px;
            --cu-radius-sm: 12px;
        }

        /* ── Hero ── */
        .cu-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            padding: 80px 24px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cu-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 60% 50%, rgba(99, 102, 241, 0.25) 0%, transparent 65%);
            pointer-events: none;
        }

        .cu-hero-inner {
            position: relative;
            z-index: 1;
            max-width: 640px;
            margin: 0 auto;
        }

        .cu-hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #c7d2fe;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 20px;
            backdrop-filter: blur(8px);
        }

        .cu-hero-title {
            font-size: clamp(2rem, 5vw, 2.8rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
            margin-bottom: 16px;
            line-height: 1.15;
        }

        .cu-hero-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.7;
            margin: 0;
        }

        /* ── Main Layout ── */
        .cu-main {
            background: var(--cu-bg);
            padding: 40px 24px 80px;
        }

        .cu-container {
            max-width: 1140px;
            margin: 0 auto;
        }

        /* ── Success Alert ── */
        .cu-success-alert {
            margin-bottom: 28px;
            animation: fadeInDown 0.4s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cu-success-inner {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(16, 185, 129, 0.08);
            border: 1.5px solid rgba(16, 185, 129, 0.25);
            border-radius: var(--cu-radius-sm);
            padding: 16px 20px;
        }

        .cu-success-icon {
            font-size: 1.3rem;
            color: #10b981;
            margin-top: 1px;
        }

        .cu-success-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--cu-text);
        }

        .cu-success-sub {
            font-size: 0.82rem;
            color: var(--cu-muted);
            margin-top: 2px;
        }

        /* ── Grid ── */
        .cu-grid {
            display: grid;
            grid-template-columns: 2fr 3fr;
            gap: 36px;
            align-items: stretch;
        }

        .cu-info-col,
        .cu-form-col {
            display: flex;
            flex-direction: column;
        }

        /* ── Info Card ── */
        .cu-info-card {
            background: linear-gradient(145deg,
                    rgba(15, 23, 42, 0.88) 0%,
                    rgba(30, 27, 75, 0.82) 100%);
            border-radius: var(--cu-radius);
            padding: 36px 32px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.18), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            color: #fff;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cu-info-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 28px;
        }

        .cu-info-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .cu-info-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
        }

        .cu-info-subtitle {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        /* Contact Items */
        .cu-contact-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 28px;
        }

        .cu-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .cu-ci-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .cu-ci-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 3px;
        }

        .cu-ci-value {
            font-size: 0.88rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            text-decoration: none;
        }

        .cu-ci-value:hover {
            color: #c7d2fe;
        }

        /* ── Timeline ── */
        .cu-timeline {
            margin-bottom: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .cu-timeline-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 14px;
        }

        .cu-timeline-steps {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cu-timeline-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .cu-step-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .cu-dot-1 {
            background: rgba(79, 70, 229, 0.25);
            color: #a5b4fc;
        }

        .cu-dot-2 {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .cu-dot-3 {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .cu-step-body {
            padding-top: 2px;
        }

        .cu-step-title {
            font-size: 0.83rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        .cu-step-sub {
            font-size: 0.74rem;
            color: rgba(255, 255, 255, 0.38);
            margin-top: 1px;
        }

        /* Social */
        .cu-social-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .cu-social-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cu-social-icons {
            display: flex;
            gap: 8px;
        }

        .cu-social-btn {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .cu-social-btn:hover {
            background: rgba(99, 102, 241, 0.25);
            color: #c7d2fe;
            border-color: rgba(99, 102, 241, 0.3);
        }

        /* Ticket Nudge */
        .cu-ticket-nudge {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #fff;
            border-radius: var(--cu-radius-sm);
            border: 1px solid var(--cu-border);
            padding: 16px 18px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-top: 16px;
        }

        .cu-nudge-icon {
            font-size: 1.3rem;
            color: var(--cu-brand);
            margin-top: 2px;
            flex-shrink: 0;
        }

        .cu-nudge-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--cu-text);
            margin-bottom: 3px;
        }

        .cu-nudge-sub {
            font-size: 0.8rem;
            color: var(--cu-muted);
        }

        .cu-nudge-link {
            color: var(--cu-brand);
            font-weight: 600;
            text-decoration: none;
        }

        .cu-nudge-link:hover {
            text-decoration: underline;
        }

        /* ── Form Card ── */
        .cu-form-card {
            background: #fff;
            border-radius: var(--cu-radius);
            border: 1px solid var(--cu-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            padding: 36px 40px;
            flex: 1;
        }

        .cu-form-header {
            margin-bottom: 28px;
        }

        .cu-form-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--cu-text);
            margin-bottom: 6px;
            letter-spacing: -0.4px;
        }

        .cu-form-subtitle {
            font-size: 0.88rem;
            color: var(--cu-muted);
            margin: 0;
            line-height: 1.6;
        }

        /* Field Row */
        .cu-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .cu-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .cu-field-row .cu-field {
            margin-bottom: 0;
        }

        /* Labels */
        .cu-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            letter-spacing: 0.2px;
        }

        /* Inputs */
        .cu-input,
        .cu-textarea {
            width: 100%;
            padding: 12px 14px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: var(--cu-radius-sm);
            color: var(--cu-text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            outline: none;
        }

        .cu-input::placeholder,
        .cu-textarea::placeholder {
            color: #adb5bd;
        }

        .cu-input:focus,
        .cu-textarea:focus {
            border-color: var(--cu-brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .cu-input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .cu-textarea {
            resize: vertical;
            min-height: 130px;
            line-height: 1.65;
        }

        .cu-field-err {
            font-size: 0.77rem;
            color: #ef4444;
            font-weight: 500;
        }

        /* Submit Button */
        .cu-submit-btn {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border: none;
            border-radius: var(--cu-radius-sm);
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: all 0.25s ease;
            letter-spacing: 0.2px;
        }

        .cu-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.4);
            background: linear-gradient(135deg, #4338ca, #4f46e5);
        }

        .cu-submit-btn:active {
            transform: translateY(0);
        }

        .cu-submit-btn.loading {
            opacity: 0.8;
            pointer-events: none;
        }

        /* Trust Badges */
        .cu-trust-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 20px 0 0;
            justify-content: center;
        }

        .cu-trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid var(--cu-border);
            color: var(--cu-muted);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .cu-trust-badge i {
            color: var(--cu-brand);
            font-size: 0.82rem;
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .cu-grid {
                grid-template-columns: 1fr;
            }

            .cu-info-col {
                order: 2;
            }

            .cu-form-col {
                order: 1;
            }
        }

        @media (max-width: 640px) {
            .cu-hero {
                padding: 60px 20px 80px;
            }

            .cu-form-card {
                padding: 24px 20px;
            }

            .cu-field-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('btnText');
            const icon = document.getElementById('btnIcon');
            btn.classList.add('loading');
            icon.className = 'bi bi-hourglass-split me-2';
            text.textContent = 'Sending...';
        });
    </script>

@endsection