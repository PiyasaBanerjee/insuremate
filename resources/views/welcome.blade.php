@extends('layouts.app')

@section('content')
    <style>
        .hero-animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #5a67d8, #4c51bf);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
            overflow: hidden;
            color: white;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hero-blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            top: -200px;
            left: -100px;
            animation: floatBlob 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .hero-blob-2 {
            top: auto;
            bottom: -200px;
            left: auto;
            right: -100px;
            width: 500px;
            height: 500px;
            animation-delay: -10s;
            animation-duration: 25s;
        }

        @keyframes floatBlob {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(50px, 30px) scale(1.1);
            }

            100% {
                transform: translate(-30px, 50px) scale(0.9);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="py-5 mb-5 hero-animated-bg">
        <div class="hero-blob"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="container text-center position-relative z-1 py-5">
            <div class="row justify-content-center py-5">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h1 class="display-3 fw-bold mb-4 fade-in-up" style="letter-spacing: -1px;">Protect What Matters Most
                    </h1>
                    <p class="lead mb-5 opacity-90 fade-in-up delay-1" style="font-size: 1.25rem; font-weight: 300;">
                        Compare and buy the best insurance plans for your family's future.
                        Simple, transparent, and affordable coverage.
                    </p>
                    <div class="d-flex gap-3 justify-content-center fade-in-up delay-2">
                        <a href="#categories"
                            class="btn btn-light btn-lg fw-semibold text-primary px-5 py-3 shadow-sm rounded-pill"
                            style="font-size: 1.1rem;">Get Started</a>
                        <a href="{{ route('contact') }}"
                            class="btn btn-outline-light btn-lg fw-semibold px-5 py-3 shadow-sm rounded-pill"
                            style="font-size: 1.1rem;">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mb-5">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-2 text-dark">Why Choose InsureMate?</h2>
                <p class="text-muted">We make insurance easy, reliable, and paperless.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-lift">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-window-stack fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Easy Comparison</h5>
                        <p class="text-muted mb-0">Compare plans from top insurers side-by-side to find the best coverage
                            for your needs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-lift">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-lightning-charge fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Instant Renewal</h5>
                        <p class="text-muted mb-0">Renew your policy in seconds with our streamlined, paperless process.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-lift">
                    <div class="card-body">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-file-earmark-medical fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Fast Claims</h5>
                        <p class="text-muted mb-0">File claims online and track their status in real-time with our
                            transparent system.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .categories-premium-section {
            background-color: #f8fafc;
            position: relative;
            overflow: hidden;
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        .categories-glow-bg {
            position: absolute;
            width: 80vw;
            height: 80vh;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.03) 30%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            pointer-events: none;
            animation: slowPulse 15s ease-in-out infinite alternate;
        }
        @keyframes slowPulse {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            100% { transform: translate(-45%, -55%) scale(1.1); opacity: 1; }
        }
        .premium-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 2;
        }
        .premium-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            background: rgba(255, 255, 255, 0.9);
        }
        .premium-card:hover::before {
            opacity: 1;
        }
        .premium-icon-container {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .premium-card:hover .premium-icon-container {
            transform: scale(1.08) translateY(-2px);
        }
        .premium-badge {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 5px 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.5);
        }
        .premium-badge.glowing {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
            color: #065f46 !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .premium-badge.standard {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            color: #475569 !important;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        .section-title-premium {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .section-subtitle-premium {
            font-size: 1.1rem;
            color: #64748b;
        }
    </style>

    <!-- Categories Section -->
    <div class="categories-premium-section" id="categories">
        <div class="categories-glow-bg"></div>
        <div class="container position-relative z-1">
            <div class="d-flex justify-content-between align-items-end mb-4 pb-2">
                <div>
                    <h2 class="section-title-premium">Explore Our Plans</h2>
                    <p class="section-subtitle-premium mb-0">Select a category to view available insurance plans.</p>
                </div>
            </div>

            <div class="row g-4 pt-4">
                @if(isset($categories) && count($categories) > 0)
                    @php
                        $categoryData = [
                            'life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3382/3382103.png', 'badge' => 'Save up to 15%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                            'health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2966/2966327.png', 'badge' => 'Save up to 25%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                            'car-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3202/3202926.png', 'badge' => 'Best Price Guaranteed', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                            'two-wheeler-insurance' => ['icon' => 'data:image/png;base64,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', 'badge' => 'Save up to 85%', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                            'travel-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2060/2060284.png', 'badge' => 'Instant Policy Issuance'],
                            'investment-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933116.png', 'badge' => 'Life Cover Included'],
                            'family-health-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135810.png', 'badge' => 'Family Saver Plan'],
                            'term-life-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/1055/1055100.png', 'badge' => 'Low Premium Plans'],
                            'employee-group-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135694.png', 'badge' => 'Exclusive Corporate Rates'],
                            'home-insurance' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/619/619153.png', 'badge' => 'Comprehensive Coverage'],
                            'retirement-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/3050/3050474.png', 'badge' => 'Guaranteed Pension', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46'],
                            'guaranteed-return-plans' => ['icon' => 'https://cdn-icons-png.flaticon.com/512/2933/2933100.png', 'badge' => 'Assured Returns', 'badge_bg' => '#d1fae5', 'badge_color' => '#065f46']
                        ];
                    @endphp
                    @foreach($categories as $category)
                        @php
                            $catSettings = $categoryData[$category->slug] ?? [
                                'icon' => 'https://cdn-icons-png.flaticon.com/512/3373/3373151.png',
                                'color' => 'primary',
                                'badge' => 'Best Seller'
                            ];
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 mt-2">
                            <div class="card h-100 premium-card text-center text-decoration-none">
                                
                                <!-- Premium Glass Badge -->
                                <div class="position-absolute w-100 text-center" style="top: -12px; z-index: 10;">
                                    @php
                                        $isDiscount = str_contains(strtolower($catSettings['badge']), 'save') || str_contains(strtolower($catSettings['badge']), 'guarantee') || str_contains(strtolower($catSettings['badge']), 'return');
                                        $badgeClass = $isDiscount ? 'premium-badge glowing rounded-pill' : 'premium-badge standard rounded-pill';
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $catSettings['badge'] }}</span>
                                </div>

                                <div class="card-body p-4 pt-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="mb-4 mt-2 premium-icon-container">
                                        <img src="{{ $catSettings['icon'] }}" alt="{{ $category->name }}"
                                            style="height: 60px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));">
                                    </div>
                                    <h6 class="card-title fw-bold mb-1" style="color: #1e293b; font-size: 1.05rem; letter-spacing: -0.2px;">{{ $category->name }}</h6>
                                    <a href="{{ route('frontend.category', $category->slug) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">No insurance categories available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div class="bg-dark text-white rounded-4 p-5 text-center">
            <h2 class="fw-bold mb-3">Ready to get insured?</h2>
            <p class="lead text-light opacity-75 mb-4">Join thousands of satisfied customers who trust us with their future.
            </p>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Create an Account</a>
            @endif
        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection