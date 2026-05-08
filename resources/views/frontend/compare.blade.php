@extends('layouts.app')

@section('content')
    <style>
        /* ===== Compare Page Unified SaaS Redesign ===== */
        .category-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-glow {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            top: -400px;
            right: -200px;
            border-radius: 50%;
            pointer-events: none;
            animation: pulse-glow 6s infinite alternate;
        }

        @keyframes pulse-glow {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        .category-page-wrapper {
            background-color: #f5f7fb;
            min-height: calc(100vh - 200px);
            padding-bottom: 4rem;
        }

        /* SaaS Compare Container */
        .compare-container {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            overflow: hidden;
            animation: slideUpFade 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideUpFade {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Compare Table Redesign */
        .compare-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Row styling */
        .compare-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .compare-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Alternating row tint */
        .compare-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }
        .compare-table tbody tr:nth-child(even):hover {
            background-color: #f1f5f9;
        }

        /* Header Cells */
        .compare-header-cell {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
            background-color: #ffffff;
            border-right: 1px solid #f1f5f9;
        }
        .compare-header-cell:last-child {
            border-right: none;
        }
        .title-cell {
            width: 220px;
            background-color: #f8fafc;
            border-right: 2px solid #e2e8f0;
            text-align: left;
            padding: 1.5rem;
            font-weight: 700;
            color: #475569;
            vertical-align: middle;
        }

        /* Plan DP */
        .plan-dp {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            object-fit: contain;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            padding: 4px;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        .compare-header-cell:hover .plan-dp {
            transform: translateY(-3px);
        }

        /* Cells */
        .compare-cell {
            padding: 1.5rem;
            border-right: 1px solid #f1f5f9;
            vertical-align: top;
            color: #334155;
        }
        .compare-cell:last-child {
            border-right: none;
        }

        /* Badges */
        .badge-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 9999px;
            padding: 0.35em 0.85em;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        /* Highlight Plan */
        .highlight-plan {
            position: relative;
        }
        .highlight-plan::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .highlight-ribbon {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 4px 14px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
            white-space: nowrap;
            z-index: 10;
        }

        /* Price */
        .price-compare {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }
        
        .price-annual {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Checklist */
        .checklist-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: #475569;
            text-align: left;
            line-height: 1.4;
        }
        .checklist-item i {
            font-size: 1.1rem;
            margin-top: 0.1rem;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
        }

        /* Button */
        .btn-gradient {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(79, 70, 229, 0.3);
            color: white;
        }
    </style>

    <!-- Hero Section -->
    <div class="category-hero text-white py-5 shadow-sm">
        <div class="hero-glow"></div>
        <div class="container position-relative text-center animate__animated animate__fadeInUp" style="z-index: 2;">
            <span class="badge bg-white bg-opacity-25 text-white rounded-pill mb-3 px-3 py-2 fw-bold shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px; backdrop-filter: blur(4px);">
                <i class="bi bi-intersect me-1"></i> SIDE-BY-SIDE ANALYSIS
            </span>
            <h1 class="display-4 fw-bolder mb-3" style="letter-spacing: -1px;">Compare Plans</h1>
            <p class="lead mb-4 mx-auto" style="opacity: 0.9; max-width: 650px;">Evaluate features, benefits, and pricing structures directly to find the perfect coverage for your needs.</p>
            
            <div class="d-flex justify-content-center flex-wrap gap-4 small mt-2" style="opacity: 0.85;">
                <div class="d-flex align-items-center"><i class="bi bi-patch-check-fill me-2 fs-5"></i> Transparent Pricing</div>
                <div class="d-flex align-items-center"><i class="bi bi-shield-shaded me-2 fs-5"></i> Unbiased Comparison</div>
                <div class="d-flex align-items-center"><i class="bi bi-lightning-fill me-2 fs-5"></i> Instant Policy Approval</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="category-page-wrapper pt-5">
        <div class="container">
            @if($plans->isEmpty())
                <div class="alert alert-light bg-white border shadow-sm text-center py-5 rounded-4 p-4 mx-auto animate__animated animate__fadeIn" style="max-width: 600px;">
                    <i class="bi bi-distribute-horizontal text-muted opacity-50 mb-3 d-block" style="font-size: 3.5rem;"></i>
                    <h4 class="fw-bold mb-3 text-dark">No plans selected for comparison</h4>
                    <p class="text-muted small mb-4">Please return to the categories list, check the "Add to Compare" boxes on your desired plans, and click "Compare Now".</p>
                    <a href="{{ route('home') }}#categories" class="btn btn-primary btn-gradient rounded-pill px-5 fw-bold shadow-sm">Browse Products</a>
                </div>
            @else
                <!-- Back Button top -->
                <div class="mb-4">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" class="btn btn-sm btn-light border text-secondary fw-bold shadow-sm rounded-pill hover-bg-white px-3">
                        <i class="bi bi-arrow-left me-1"></i> Back to Listing
                    </a>
                </div>

                <!-- Comparison Container -->
                <div class="compare-container">
                    <div class="table-responsive">
                        <table class="compare-table">
                            <thead>
                                <tr>
                                    <th class="title-cell border-top-0">Policy Breakdown</th>
                                    
                                    @foreach($plans as $index => $plan)
                                        <th class="compare-header-cell">
                                            
                                            <img src="{{ $plan->image_path ? asset('storage/' . $plan->image_path) : 'https://via.placeholder.com/100' }}" alt="{{ $plan->name }}" class="plan-dp mx-auto d-block">
                                            
                                            <h5 class="fw-bold text-dark mb-2" style="letter-spacing: -0.5px;">{{ $plan->name }}</h5>
                                            
                                            <div class="mb-1">
                                                <span class="badge badge-gradient text-white"><i class="bi bi-award-fill me-1"></i> Best Seller</span>
                                            </div>
                                            <div class="small text-muted opacity-75 mt-2">
                                                <span class="badge bg-light text-secondary border">{{ $plan->category->name }}</span>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Pricing Row -->
                                <tr>
                                    <td class="title-cell"><i class="bi bi-tags text-primary me-2"></i> Premium (Annual)</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell text-center current-price-cell">
                                            <div class="price-compare text-primary">₹{{ number_format($plan->base_premium, 2) }}</div>
                                            <div class="price-annual mb-1">per year</div>
                                            <div class="small text-muted opacity-50" style="font-size: 0.7rem;">Inc. taxes & fees</div>
                                        </td>
                                    @endforeach
                                </tr>
                                
                                <!-- Coverage Row -->
                                <tr>
                                    <td class="title-cell"><i class="bi bi-shield-plus text-success me-2"></i> Max Coverage</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell text-center">
                                            <span class="fw-bold text-dark fs-5">₹{{ number_format($plan->coverage_amount, 2) }}</span>
                                        </td>
                                    @endforeach
                                </tr>
                                
                                <!-- Term Row -->
                                <tr>
                                    <td class="title-cell"><i class="bi bi-hourglass-split text-warning me-2"></i> Term Duration</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell text-center">
                                            <span class="fw-bold fs-6">{{ $plan->duration_years }} Years</span>
                                        </td>
                                    @endforeach
                                </tr>
                                
                                <!-- Features Row -->
                                <tr>
                                    <td class="title-cell"><i class="bi bi-stars text-info me-2"></i> Key Features</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell bg-white">
                                            @if(is_array($plan->features) && count($plan->features) > 0)
                                                <div class="d-flex flex-column gap-1">
                                                    @foreach($plan->features as $feature)
                                                        <div class="checklist-item">
                                                            <i class="bi bi-star-fill text-warning me-2"></i>
                                                            <span>{{ is_array($feature) ? (isset($feature['description']) ? trim($feature['description']) : trim(implode(' ', $feature))) : trim($feature) }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center text-muted opacity-50 fst-italic py-3">-</div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                                <!-- Benefits Row -->
                                <tr>
                                    <td class="title-cell"><i class="bi bi-heart-pulse text-danger me-2"></i> Core Benefits</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell bg-white">
                                            @if(is_array($plan->benefits) && count($plan->benefits) > 0)
                                                <div class="d-flex flex-column gap-1">
                                                    @foreach($plan->benefits as $benefit)
                                                        <div class="checklist-item">
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <span>{{ is_array($benefit) ? (isset($benefit['description']) ? trim($benefit['description']) : trim(implode(' ', $benefit))) : trim($benefit) }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center text-muted opacity-50 fst-italic py-3">-</div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                                <!-- Action Row -->
                                <tr>
                                    <td class="title-cell rounded-bottom-start border-bottom-0"><i class="bi bi-cursor text-secondary me-2"></i> Action</td>
                                    @foreach($plans as $plan)
                                        <td class="compare-cell text-center border-bottom-0 bg-white p-4">
                                            <div class="d-grid gap-2">
                                                @if(Auth::guard('admin')->check())
                                                    <button type="button"
                                                        onclick="alert('You are logged in as an Admin. Purchasing is disabled.')"
                                                        class="btn btn-secondary rounded-pill disabled shadow-sm fw-bold">Admin View</button>
                                                @else
                                                    <a href="{{ route('plan.apply', $plan->id) }}"
                                                        class="btn btn-primary btn-gradient rounded-pill fw-bold shadow-sm">Buy Policy <i class="bi bi-chevron-right ms-1" style="font-size: 0.8rem;"></i></a>
                                                @endif
                                                <a href="{{ route('frontend.plan', $plan->slug) }}"
                                                    class="btn btn-light border text-primary fw-bold rounded-pill hover-bg-light shadow-sm mt-1">View Details</a>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection