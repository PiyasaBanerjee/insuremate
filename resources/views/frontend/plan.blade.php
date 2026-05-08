@extends('layouts.app')

@section('content')
<style>
    :root {
        --brand-primary: #4f46e5;
        --brand-secondary: #3b82f6;
        --brand-accent: #10b981;
    }

    /* Hero Gradient & Animation */
    .premium-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        position: relative;
        overflow: hidden;
        padding: 5rem 0;
    }

    .premium-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
        animation: rotateGlow 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotateGlow {
        100% {
            transform: rotate(360deg);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delay-1 {
        animation-delay: 0.1s;
    }

    .delay-2 {
        animation-delay: 0.2s;
    }

    .delay-3 {
        animation-delay: 0.3s;
    }

    /* Elevated Premium Cards */
    .premium-card {
        background: #ffffff;
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.08), 0 4px 12px -4px rgba(0, 0, 0, 0.04);
        position: relative;
        z-index: 10;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Top Accent Border on Card */
    .premium-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
    }

    /* Soft Dividers */
    .soft-divider {
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        margin: 2rem 0;
    }

    /* Checklist UI */
    .feature-item {
        padding: 1rem;
        border-radius: 1rem;
        background: #f8fafc;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        height: 100%;
    }

    .feature-item:hover {
        background: #ffffff;
        border-color: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .icon-gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .icon-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    /* Pricing Card / Glassmorphism */
    .pricing-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.9), #ffffff);
    }

    /* Buy CTA Button */
    .btn-gradient-primary {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.39);
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.23);
        color: white;
    }

    /* Coverage Progress Bar */
    .coverage-progress {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .coverage-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--brand-secondary), var(--brand-accent));
        width: 85%;
        /* Visual representation */
        border-radius: 4px;
        position: relative;
    }

    .coverage-bar::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite linear;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }
</style>

@section('content')
    <!-- 1. Premium Hero Section -->
    <div class="premium-hero text-white mb-n5 pt-5 pb-5 rounded-bottom-4"
        style="margin-bottom: -4rem; min-height: 40vh; display: flex; align-items: center; border-radius: 0 0 2rem 2rem;">
        <div class="container position-relative z-index-1">
            <div class="row align-items-center mt-4">
                <div class="col-lg-8 fade-in-up">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill shadow-sm fw-bold border-0"
                        style="letter-spacing: 0.5px;">
                        <i class="bi bi-star-fill text-warning me-1"></i> Featured Plan
                    </span>
                    <h1 class="display-3 fw-bold mb-2" style="font-weight: 800; letter-spacing: -1px;">{{ $plan->name }}
                    </h1>
                    <p class="lead opacity-75 fs-4 fw-medium">{{ $plan->category->name }}</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 fade-in-up delay-1">
                    <p class="text-white-50 text-uppercase fw-bold ls-1 mb-1 small">Starting At</p>
                    <div class="d-inline-flex align-items-baseline">
                        <h2 class="display-4 fw-bold mb-0 me-2" style="font-weight: 800;">
                            ₹{{ number_format($plan->base_premium, 2) }}</h2>
                        <span class="fs-5 opacity-75">/ Year</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Content & Cards -->
    <div style="background-color: #f8fafc; padding-bottom: 5rem;" class="pt-5 mt-n5">
        <div class="container position-relative" style="z-index: 20; padding-top: 1rem;">
            <div class="row g-4">

                <!-- Left Column: Details -->
                <div class="col-lg-8 fade-in-up delay-2">
                    <div class="premium-card p-4 p-md-5 mb-4">
                        <h3 class="fw-bold fs-4 mb-3" style="color: #1e293b;">Plan Overview</h3>
                        <p class="text-secondary fs-5 lh-lg mb-0" style="font-weight: 400;">{{ $plan->description }}</p>

                        <div class="soft-divider"></div>

                        <!-- 3. Key Benefits Checklist -->
                        <h4 class="fw-bold fs-5 mb-4" style="color: #1e293b;">Core Benefits</h4>
                        @if(is_array($plan->benefits) && count($plan->benefits) > 0)
                            <div class="row g-3">
                                @foreach($plan->benefits as $benefit)
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <i class="bi bi-check-circle-fill icon-gradient-green fs-4 me-3 mt-1"></i>
                                            <div>
                                                <span class="fw-medium text-dark d-block"
                                                    style="font-size: 1.05rem; line-height: 1.4;">
                                                    {{ is_array($benefit) ? (isset($benefit['description']) ? trim($benefit['description']) : trim(implode(' ', $benefit))) : trim($benefit) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert bg-light border-0 text-muted rounded-3"><i class="bi bi-info-circle me-2"></i> No
                                specific benefits listed.</div>
                        @endif

                        <div class="soft-divider"></div>

                        <!-- Additional Features -->
                        <h4 class="fw-bold fs-5 mb-4" style="color: #1e293b;">Key Features & Highlights</h4>
                        @if(is_array($plan->features) && count($plan->features) > 0)
                            <div class="row g-3">
                                @foreach($plan->features as $feature)
                                    <div class="col-md-6">
                                        <div class="feature-item d-flex align-items-start">
                                            <i class="bi bi-shield-fill-check icon-gradient-warning fs-4 me-3 mt-1"></i>
                                            <div>
                                                <span class="fw-medium text-dark d-block"
                                                    style="font-size: 1.05rem; line-height: 1.4;">
                                                    {{ is_array($feature) ? (isset($feature['description']) ? trim($feature['description']) : trim(implode(' ', $feature))) : trim($feature) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert bg-light border-0 text-muted rounded-3"><i class="bi bi-info-circle me-2"></i> No
                                additional features listed.</div>
                        @endif

                        <!-- Accordion FAQ Placeholder (Optional Enhancement) -->
                        <div class="soft-divider"></div>
                        <div class="accordion accordion-flush" id="planFaq">
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent fw-bold text-dark px-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-1">
                                        <i class="bi bi-question-circle-fill text-primary me-2"></i> Why choose
                                        {{ $plan->name }}?
                                    </button>
                                </h2>
                                <div id="faq-1" class="accordion-collapse collapse" data-bs-parent="#planFaq">
                                    <div class="accordion-body text-muted px-0 pb-0 pt-2">This plan is meticulously crafted
                                        for
                                        the modern individual demanding premium security. Built with flexibility in mind, it
                                        provides the coverage you need today while dynamically adapting to your lifecycles
                                        tomorrow.</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Pricing & CTA -->
                <div class="col-lg-4 fade-in-up delay-3">
                    <div class="premium-card pricing-card p-4 mb-4 sticky-top" style="top: 2rem;">

                        <div class="text-center mb-4">
                            <span
                                class="text-uppercase fw-bold text-primary small bg-primary bg-opacity-10 px-3 py-1 rounded-pill"><i
                                    class="bi bi-lightning-charge-fill me-1"></i> Instant Issue</span>
                        </div>

                        @if($plan->image_path)
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/' . $plan->image_path) }}" alt="{{ $plan->name }}"
                                    class="img-fluid rounded-3 shadow-sm" style="max-height: 150px; object-fit: contain;">
                            </div>
                        @endif

                        <h4 class="fw-bold mb-4" style="color: #1e293b;">Policy Summary</h4>

                        <!-- Animated Progress Bar for Coverage -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-medium">Max Coverage</span>
                                <span class="fw-bold fs-5">₹{{ number_format($plan->coverage_amount, 2) }}</span>
                            </div>
                            <div class="coverage-progress shadow-sm">
                                <div class="coverage-bar"></div>
                            </div>
                            <small class="text-muted mt-2 d-block text-end opacity-75">Estimated Index Linked</small>
                        </div>

                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light">
                            <span class="text-muted fw-medium d-flex align-items-center"><i
                                    class="bi bi-calendar3 me-2 text-secondary"></i> Term Duration</span>
                            <span class="fw-bold text-dark">{{ $plan->duration_years }} Years</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4 mt-2 align-items-center">
                            <span class="text-muted fw-medium fs-5">Annual Premium</span>
                            <div class="text-end position-relative">
                                <!-- Subtle Glow Text Shadow -->
                                <span class="fw-bold text-primary display-6 d-block mb-1"
                                    style="font-weight: 800; text-shadow: 0 4px 20px rgba(79, 70, 229, 0.25);">₹{{ number_format($plan->base_premium, 2) }}</span>
                                <small class="text-muted opacity-75 d-block" style="font-size: 0.75rem;">Includes all
                                    taxes</small>
                            </div>
                        </div>

                        <div class="d-grid gap-3 mt-4">
                            @if(Auth::guard('admin')->check())
                                <button type="button"
                                    onclick="alert('You are logged in as an Admin. Please logout and login as a regular User to purchase plans.')"
                                    class="btn btn-secondary btn-lg fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center py-3 disabled">
                                    Admin (Purchasing Disabled) <i class="bi bi-shield-lock ms-2 fs-5"></i>
                                </button>
                            @elseif(Auth::guard('web')->check())
                                <button onclick="window.location='{{ route('plan.apply', $plan->id) }}'"
                                    class="btn btn-gradient-primary btn-lg fw-bold rounded-pill shadow-lg d-flex align-items-center justify-content-center py-3">
                                    Buy Policy Now <i class="bi bi-arrow-right ms-2 fs-5"></i>
                                </button>
                            @else
                                <button onclick="window.location='{{ route('login') }}'"
                                    class="btn btn-gradient-primary btn-lg fw-bold rounded-pill shadow-lg d-flex align-items-center justify-content-center py-3">
                                    Login to Purchase <i class="bi bi-lock ms-2 fs-5"></i>
                                </button>
                            @endif
                            <a href="{{ route('frontend.category', $plan->category->slug) }}"
                                class="btn btn-light btn-lg fw-bold rounded-pill text-dark border d-flex align-items-center justify-content-center mt-2">
                                <i class="bi bi-arrow-left me-2"></i> View Other Plans
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="mt-4 pt-3 text-center border-top border-light">
                            <div class="d-flex justify-content-center gap-3 text-muted" style="font-size: 0.8rem;">
                                <span class="d-flex flex-column align-items-center"><i
                                        class="bi bi-shield-lock-fill text-success fs-4 mb-1"></i> 256-bit Secure</span>
                                <span class="d-flex flex-column align-items-center"><i
                                        class="bi bi-patch-check-fill text-primary fs-4 mb-1"></i> Govt Verified</span>
                                <span class="d-flex flex-column align-items-center"><i
                                        class="bi bi-headset text-info fs-4 mb-1"></i> 24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection