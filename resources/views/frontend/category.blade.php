@extends('layouts.app')

@section('content')
    <style>
        /* ===== Category Page Unified SaaS Redesign ===== */
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            top: -400px;
            right: -200px;
            border-radius: 50%;
            pointer-events: none;
            animation: pulse-glow 6s infinite alternate;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.1);
                opacity: 1;
            }
        }

        .category-page-wrapper {
            background-color: #f5f7fb;
            min-height: calc(100vh - 200px);
            padding-bottom: 4rem;
        }

        /* SaaS Cards & Shadows */
        .saas-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            animation: slideUpFade 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        .saas-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #4f46e5, #3b82f6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .saas-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.12), 0 4px 12px -4px rgba(0, 0, 0, 0.08);
        }

        .saas-card:hover::before {
            opacity: 1;
        }

        /* Sequential Fade In */
        .plan-item:nth-child(1) .saas-card {
            animation-delay: 0.1s;
        }

        .plan-item:nth-child(2) .saas-card {
            animation-delay: 0.2s;
        }

        .plan-item:nth-child(3) .saas-card {
            animation-delay: 0.3s;
        }

        .plan-item:nth-child(4) .saas-card {
            animation-delay: 0.4s;
        }

        .plan-item:nth-child(5) .saas-card {
            animation-delay: 0.5s;
        }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* DP Image */
        .plan-dp {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            object-fit: contain;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            padding: 4px;
        }

        /* Checklist */
        .checklist-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
        }

        .checklist-item i {
            font-size: 1rem;
            margin-top: 0.1rem;
        }

        /* Filters */
        .saas-filter-input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
            font-size: 0.875rem;
        }

        .saas-filter-input:focus {
            background: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        /* Compare Widget */
        .compare-widget {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 12px;
        }

        .compare-widget .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Styling Badges */
        .badge-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 9999px;
            padding: 0.35em 0.75em;
            font-weight: 600;
        }

        /* Custom Checkbox */
        .custom-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        /* Price display */
        .price-display {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #0f172a;
        }
    </style>

    <!-- Hero Section -->
    <div class="category-hero text-white py-5 shadow-sm">
        <div class="hero-glow"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8 animate__animated animate__fadeInUp">
                    <span class="badge bg-white text-primary rounded-pill mb-3 px-3 py-2 fw-bold shadow-sm"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <i class="bi bi-shield-check me-1"></i> PREMIUM COVERAGE
                    </span>
                    <h1 class="display-4 fw-bolder mb-2" style="letter-spacing: -1px;">{{ $category->name }}</h1>
                    <p class="lead mb-4" style="opacity: 0.9; max-width: 600px;">{{ $category->description }}</p>

                    <div class="d-flex flex-wrap gap-4 small mt-3" style="opacity: 0.85;">
                        <div class="d-flex align-items-center"><i class="bi bi-patch-check-fill me-2 fs-5"></i> IRDAI
                            Approved</div>
                        <div class="d-flex align-items-center"><i class="bi bi-lock-fill me-2 fs-5"></i> Secure Payment
                        </div>
                        <div class="d-flex align-items-center"><i class="bi bi-lightning-fill me-2 fs-5"></i> Instant Policy
                            Issuance</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="category-page-wrapper pt-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="saas-card mb-4 border-0 p-4" style="animation: none; opacity: 1; transform: none;">
                        <h6 class="fw-bold mb-3 d-flex align-items-center text-dark" style="letter-spacing: -0.5px;">
                            <i class="bi bi-sliders me-2 text-primary"></i> FILTER PLANS
                        </h6>
                        <hr class="text-muted opacity-25 mb-4">

                        <form action="{{ route('frontend.category', $category->slug) }}" method="GET">
                            <!-- Price Range -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Premium Range (₹)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_premium" class="form-control saas-filter-input"
                                            placeholder="Min ₹" value="{{ request('min_premium') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_premium" class="form-control saas-filter-input"
                                            placeholder="Max ₹" value="{{ request('max_premium') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Cover Amount -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary d-flex justify-content-between">
                                    Min Coverage
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill pb-1"><i
                                            class="bi bi-shield-plus"></i></span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"
                                        style="border-radius: 8px 0 0 8px; border-color: #e2e8f0;">₹</span>
                                    <input type="number" name="min_coverage"
                                        class="form-control saas-filter-input border-start-0 ps-0" placeholder="e.g. 500000"
                                        value="{{ request('min_coverage') }}" style="border-radius: 0 8px 8px 0;">
                                </div>
                                <input type="range" class="form-range mt-2" min="0" max="10000000" step="50000"
                                    id="coverageRange" value="{{ request('min_coverage') ?? 0 }}"
                                    oninput="document.querySelector('input[name=min_coverage]').value=this.value">
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary fw-bold shadow-sm"
                                    style="background: linear-gradient(135deg, #4f46e5, #3b82f6); border: none;">Apply
                                    Filters</button>
                                <a href="{{ route('frontend.category', $category->slug) }}"
                                    class="btn btn-light border fw-bold text-secondary">Reset Fields</a>
                            </div>
                        </form>
                    </div>

                    <!-- Compare Plans Widget -->
                    <div class="compare-widget shadow-lg p-3" id="compare-card"
                        style="display: none; transition: all 0.3s ease;">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center pb-2 pt-1 px-2">
                            <span class="fw-bold" style="letter-spacing: 0.5px;">Compare Plans</span>
                            <span class="badge bg-white text-dark rounded-pill shadow-sm" id="compare-count"
                                style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">0</span>
                        </div>
                        <div class="card-body px-2 py-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-bar-chart-fill text-white fs-5"></i>
                                </div>
                                <p class="small text-white-50 mb-0 lh-sm">Select up to 3 plans to view side-by-side.</p>
                            </div>
                            <button id="btn-compare" class="btn btn-light w-100 fw-bold border-0 shadow"
                                style="color: #0f172a;">Compare Now <i class="bi bi-arrow-right ms-1"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Plans Listing -->
                <div class="col-lg-9 col-md-8">
                    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2"
                        style="border-color: #e2e8f0 !important;">
                        <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Exploring <span
                                class="text-primary">{{ $plans->count() }}</span> Plans</h4>
                        <span class="text-muted small"><i class="bi bi-sort-down"></i> Sorted by Popularity</span>
                    </div>

                    @if($plans->isEmpty())
                        <div
                            class="alert alert-light bg-white border shadow-sm text-center py-5 rounded-4 p-4 row animate__animated animate__fadeIn">
                            <div class="col-md-6 mx-auto">
                                <i class="bi bi-search text-muted opacity-50 mb-3 d-block" style="font-size: 3rem;"></i>
                                <h5>No plans found matching your criteria</h5>
                                <p class="text-muted small mb-4">Try adjusting your filters to see more results.</p>
                                <a href="{{ route('frontend.category', $category->slug) }}"
                                    class="btn btn-outline-primary rounded-pill px-4">Clear All Filters</a>
                            </div>
                        </div>
                    @endif

                    @foreach($plans as $plan)
                        <div class="plan-item">
                            <div class="saas-card mb-4">
                                <div class="card-body p-0">
                                    <div class="row g-0 align-items-center">
                                        <!-- Left Side: Plan Info -->
                                        <div class="col-xl-8 col-lg-7 p-4">
                                            <div class="d-flex align-items-start">
                                                <div class="me-4 flex-shrink-0">
                                                    <img src="{{ $plan->image_path ? asset('storage/' . $plan->image_path) : 'https://via.placeholder.com/100' }}"
                                                        alt="{{ $plan->name }}" class="plan-dp">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h5 class="fw-bold mb-0 text-dark me-2" style="letter-spacing: -0.5px;">
                                                            {{ $plan->name }}</h5>
                                                        <span class="badge badge-gradient shadow-sm"><i
                                                                class="bi bi-award-fill me-1"></i> Best Seller</span>
                                                    </div>
                                                    <p class="text-muted small mb-3"><i
                                                            class="bi bi-person-bounding-box me-1 opacity-75"></i> Recommended
                                                        Age: 18-65 Years</p>

                                                    <div class="row mt-3">
                                                        <div class="col-md-11">
                                                            <div class="row g-2">
                                                                <!-- Structured Checklists -->
                                                                @if(is_array($plan->benefits))
                                                                    @foreach(array_slice($plan->benefits, 0, 2) as $benefit)
                                                                        <div class="col-sm-6">
                                                                            <div class="checklist-item">
                                                                                <i
                                                                                    class="bi bi-check-circle-fill text-success me-2 pb-1"></i>
                                                                                <span
                                                                                    class="lh-sm">{{ is_array($benefit) ? (isset($benefit['description']) ? trim($benefit['description']) : trim(implode(' ', $benefit))) : trim($benefit) }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                @if(is_array($plan->features))
                                                                    @foreach(array_slice($plan->features, 0, 2) as $feature)
                                                                        <div class="col-sm-6">
                                                                            <div class="checklist-item">
                                                                                <i
                                                                                    class="bi bi-check-circle-fill text-primary me-2 pb-1"></i>
                                                                                <span
                                                                                    class="lh-sm">{{ is_array($feature) ? (isset($feature['description']) ? trim($feature['description']) : trim(implode(' ', $feature))) : trim($feature) }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side: Pricing & Actions -->
                                        <div class="col-xl-4 col-lg-5 border-start bg-light"
                                            style="border-color: #f1f5f9 !important;">
                                            <div class="p-4 d-flex flex-column justify-content-center h-100 text-center">
                                                <div class="price-display mb-0">
                                                    ₹{{ number_format($plan->base_premium, 2) }}<span
                                                        style="font-size: 1rem; color: #64748b; font-weight: 500;">/yr</span>
                                                </div>
                                                <p class="small text-muted mb-4 pt-1 opacity-75">Inc. taxes & fees</p>

                                                <div class="d-grid gap-2 mb-3">
                                                    @if(Auth::guard('admin')->check())
                                                        <button type="button"
                                                            onclick="alert('You are logged in as an Admin. Please logout and login as a regular User to purchase plans.')"
                                                            class="btn btn-secondary fw-bold shadow-sm disabled rounded-pill">Admin
                                                            View</button>
                                                    @else
                                                        <a href="{{ route('plan.apply', $plan->id) }}"
                                                            class="btn btn-primary fw-bold shadow-sm rounded-pill"
                                                            style="background: linear-gradient(135deg, #4f46e5, #3b82f6); border: none;">Buy
                                                            Policy <i class="bi bi-chevron-right fs-6"
                                                                style="vertical-align: middle;"></i></a>
                                                    @endif
                                                    <a href="{{ route('frontend.plan', $plan->slug) }}"
                                                        class="btn btn-light fw-bold text-primary border shadow-sm rounded-pill hover-bg-light">View
                                                        Details</a>
                                                </div>

                                                <label
                                                    class="d-inline-flex align-items-center justify-content-center cursor-pointer p-2 rounded hover-bg-white transition"
                                                    for="compare_{{ $plan->id }}" style="cursor: pointer;">
                                                    <input class="form-check-input custom-checkbox compare-checkbox mt-0 me-2"
                                                        type="checkbox" value="{{ $plan->id }}" id="compare_{{ $plan->id }}">
                                                    <span class="small fw-bold text-secondary" style="user-select: none;">Add to
                                                        Compare</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkboxes = document.querySelectorAll('.compare-checkbox');
                const compareCard = document.getElementById('compare-card');
                const compareCount = document.getElementById('compare-count');
                const btnCompare = document.getElementById('btn-compare');

                // Animate card appearance smoothly
                function updateCompareVisibility(count) {
                    if (count >= 1) {
                        compareCard.style.display = 'block';
                        // Small animation pop on counter change
                        compareCount.style.transform = 'scale(1.2)';
                        setTimeout(() => compareCount.style.transform = 'scale(1)', 200);
                    } else {
                        compareCard.style.display = 'none';
                    }
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function () {
                        let checked = document.querySelectorAll('.compare-checkbox:checked');

                        if (checked.length > 3) {
                            this.checked = false;
                            alert('You can compare a maximum of 3 plans.');
                            return;
                        }

                        compareCount.textContent = checked.length;
                        updateCompareVisibility(checked.length);
                    });
                });

                if (btnCompare) {
                    btnCompare.addEventListener('click', function () {
                        let checked = document.querySelectorAll('.compare-checkbox:checked');
                        if (checked.length < 2) {
                            alert('Please select at least 2 plans to compare.');
                            return;
                        }
                        let ids = Array.from(checked).map(cb => cb.value).join(',');

                        // Add loading state
                        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';

                        window.location.href = "{{ route('compare') }}?plans=" + ids;
                    });
                }
            });
        </script>
    @endpush
@endsection