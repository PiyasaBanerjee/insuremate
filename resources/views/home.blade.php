@extends('layouts.app')

@push('styles')
    <style>
        /* Custom Dashboard CSS */
        .dashboard-body-bg {
            background: radial-gradient(circle at top right, rgba(237, 233, 254, 0.4) 0%, rgba(224, 231, 255, 0.3) 50%, #f8fafc 100%);
            min-height: calc(100vh - 200px);
            position: relative;
        }

        .dashboard-header-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            color: #ffffff;
        }

        .dashboard-header-shape {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.15;
            pointer-events: none;
        }

        /* Section Container Card */
        .section-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            position: relative;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
        }
        
        .section-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #3b82f6);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        /* Stats Cards */
        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }

        /* Policy Cards */
        .policy-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.03), 0 2px 6px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }

        .policy-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.06);
            border-color: #e2e8f0;
        }

        /* Glowing Pills */
        .status-pill {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .status-active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
            color: #059669;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.25);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-expiring {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.1) 100%);
            color: #d97706;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.25);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .status-inactive {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
            color: #dc2626;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.25);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Text Highlights */
        .text-gradient-purple {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(99, 102, 241, 0.2);
        }
        
        .fw-bolder {
            font-weight: 800 !important;
        }

        /* Buttons Redesign */
        .btn-policy-primary {
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            padding: 10px 24px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
            transition: all 0.3s ease;
        }

        .btn-policy-primary:hover {
            color: white;
            background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
            box-shadow: 0 6px 18px rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
        }

        .btn-policy-secondary {
            background: transparent;
            color: #64748b;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-weight: 500;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }

        .btn-policy-secondary:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .btn-policy-danger {
            background: transparent;
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            font-weight: 500;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }

        .btn-policy-danger:hover {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
            border-color: #ef4444;
        }

        /* Mini Stat Cards for Insights */
        .insight-card-purple {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0.02) 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
        }
        .insight-card-purple .insight-icon { color: #6366f1; background: rgba(99, 102, 241, 0.1); }
        
        .insight-card-blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(59, 130, 246, 0.02) 100%);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }
        .insight-card-blue .insight-icon { color: #3b82f6; background: rgba(59, 130, 246, 0.1); }
        
        .insight-card-gray {
            background: linear-gradient(135deg, rgba(100, 116, 139, 0.05) 0%, rgba(100, 116, 139, 0.02) 100%);
            border: 1px solid rgba(100, 116, 139, 0.1);
        }
        .insight-card-gray .insight-icon { color: #64748b; background: rgba(100, 116, 139, 0.1); }

        .insight-card {
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .insight-card:hover {
            transform: translateY(-4px);
        }
        
        .insight-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        /* Empty State */
        .empty-state-card {
            background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
            border: 1px dashed #cbd5e1;
            border-radius: 20px;
        }

        /* Glassmorphic Claims Card */
        .claim-card-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            transition: transform 0.3s ease;
        }

        .claim-card-glass:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.9);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header-bg pt-5 pb-5">
        <svg class="dashboard-header-shape d-none d-md-block" width="400" height="200" viewBox="0 0 400 200" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="280" cy="-20" r="150" fill="url(#paint0_linear)" />
            <defs>
                <linearGradient id="paint0_linear" x1="130" y1="-170" x2="430" y2="130" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#ffffff" stop-opacity="0.3" />
                    <stop offset="1" stop-color="#ffffff" stop-opacity="0.0" />
                </linearGradient>
            </defs>
        </svg>

        <div class="container position-relative z-1 fade-in-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle border border-3 border-white shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center border border-3 border-white shadow-sm" style="width: 80px; height: 80px;">
                                <i class="bi bi-person" style="font-size: 2.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="fw-bolder mb-1 text-white" style="font-size: 2.2rem; letter-spacing: -0.5px;">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                    <p class="text-white-50 fs-5 mb-0">Here's what's happening with your policies today.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-column align-items-md-end">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-light rounded-pill px-4 mb-2 shadow-sm d-inline-flex align-items-center">
                        <i class="bi bi-person me-2"></i> My Profile
                    </a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-light text-primary rounded-pill px-4 shadow-sm d-inline-flex align-items-center">
                        <i class="bi bi-headset me-2"></i> Support Desk
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill text-success me-2"></i> {{ session('status') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill text-success me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- 1️⃣ Stat Summary Cards -->
            <div class="row g-4 mt-2 fade-in-up delay-100">
                <!-- Total Policies -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card p-4 d-flex align-items-center h-100">
                        <div class="stat-card-icon me-3" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase mb-1" style="letter-spacing: 0.5px;">Total
                                Policies</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ $policies->count() }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Active Policies -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card p-4 d-flex align-items-center h-100">
                        <div class="stat-card-icon me-3" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                            <i class="bi bi-shield-fill-check"></i>
                        </div>
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase mb-1" style="letter-spacing: 0.5px;">
                                Active Coverage</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ $policies->where('status', 'active')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Renewal -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card p-4 d-flex align-items-center h-100">
                        <div class="stat-card-icon me-3" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase mb-1" style="letter-spacing: 0.5px;">
                                Upcoming Renewal</p>
                            <h4 class="fw-bold mb-0 text-dark">
                                @php
                                    $nextRenewal = $policies->whereNotNull('next_renewal_date')->sortBy('next_renewal_date')->first();
                                @endphp
                                {{ $nextRenewal ? $nextRenewal->next_renewal_date->format('M d, Y') : 'None' }}
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Claims Filed -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card p-4 d-flex align-items-center h-100">
                        <div class="stat-card-icon me-3" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                            <i class="bi bi-file-earmark-medical"></i>
                        </div>
                        <div>
                            <p class="text-muted small fw-semibold text-uppercase mb-1" style="letter-spacing: 0.5px;">
                                Claims Filed</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ $claims->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Body wrapper with radial gradient -->
    <div class="dashboard-body-bg pt-5 pb-5">
        <div class="container">
            
            <!-- 2️⃣ My Policies Section -->
            <div class="section-card fade-in-up delay-100" id="policies">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">My Policies</h3>
                    <a href="{{ route('landing') }}#categories"
                        class="text-primary fw-semibold text-decoration-none user-select-auto">
                        Discover Plans <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($policies->isEmpty())
                    <div class="empty-state-card p-5 text-center mt-3">
                        <i class="bi bi-shield-slash text-muted opacity-50" style="font-size: 3.5rem;"></i>
                        <h4 class="mt-3 fw-bold text-dark">No Active Policies</h4>
                        <p class="text-secondary mb-4">You do not have any insurance policies with us yet. Secure your future today.</p>
                        <a href="{{ route('landing') }}#categories" class="btn btn-policy-primary">Browse Insurance Plans</a>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($policies as $policy)
                            <div class="col-lg-6">
                                <div class="policy-card h-100 d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">{{ $policy->plan->name }}</h5>
                                            <p class="text-muted small mb-0 font-monospace">Policy No: {{ $policy->policy_number }}</p>
                                        </div>
                                        <div>
                                            @php
                                                $statusClass = 'status-inactive';
                                                if ($policy->status === 'active')
                                                    $statusClass = 'status-active';
                                                if ($policy->status === 'expiring' || ($policy->next_renewal_date && $policy->next_renewal_date->diffInDays(now()) < 30))
                                                    $statusClass = 'status-expiring';
                                            @endphp
                                            <span class="status-pill {{ $statusClass }}">
                                                <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem;"></i>
                                                {{ ucfirst($policy->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Added Border-Top & Padding for clear separation within cards -->
                                    <div class="row g-3 mt-1 mb-4 pt-3 border-top">
                                        <div class="col-6">
                                            <p class="text-muted small text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Coverage</p>
                                            <h3 class="fw-bolder text-gradient-purple mb-0 fs-2">${{ number_format($policy->coverage_amount) }}</h3>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted small text-uppercase fw-semibold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Premium</p>
                                            <h4 class="fw-bold text-dark mb-0">${{ number_format($policy->premium_amount) }} <span class="fs-6 fw-normal text-muted">/ yr</span></h4>
                                        </div>
                                        <div class="col-12 mt-3 text-end">
                                            <p class="fw-medium text-dark small mb-0">
                                                <span class="text-muted me-1">Next Renewal:</span>
                                                <i class="bi bi-calendar3 text-primary mx-1"></i>
                                                {{ $policy->next_renewal_date ? $policy->next_renewal_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-auto pt-3 d-flex gap-2 border-top">
                                        <a href="{{ route('policy.show', $policy) }}"
                                            class="btn btn-policy-primary flex-grow-1 text-center">
                                            View Details
                                        </a>
                                        <a href="{{ route('policy.renew', $policy) }}"
                                            class="btn btn-policy-secondary text-center px-4">
                                            Renew
                                        </a>
                                        @if($policy->status === 'active')
                                            <a href="{{ route('claims.create', $policy) }}" class="btn btn-policy-danger text-center">
                                                Claim
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 3️⃣ Policy Overview Insights -->
            @if($policies->isNotEmpty())
                <div class="section-card fade-in-up delay-200">
                    <h3 class="fw-bold text-dark mb-4">Policy Insights</h3>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="insight-card insight-card-purple h-100">
                                <div class="insight-icon"><i class="bi bi-shield-check"></i></div>
                                <p class="text-muted small text-uppercase fw-semibold mb-2" style="letter-spacing: 0.5px;">Total Active Coverage</p>
                                <h2 class="fw-bolder text-dark mb-0">${{ number_format($policies->where('status', 'active')->sum('coverage_amount')) }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="insight-card insight-card-blue h-100">
                                <div class="insight-icon"><i class="bi bi-cash-stack"></i></div>
                                <p class="text-muted small text-uppercase fw-semibold mb-2" style="letter-spacing: 0.5px;">Annual Premiums</p>
                                <h2 class="fw-bolder text-dark mb-0">${{ number_format($policies->where('status', 'active')->sum('premium_amount')) }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="insight-card insight-card-gray h-100">
                                <div class="insight-icon"><i class="bi bi-person-fill-check"></i></div>
                                <p class="text-muted small text-uppercase fw-semibold mb-2" style="letter-spacing: 0.5px;">Customer Since</p>
                                <h3 class="fw-bolder text-dark mb-0 mt-2">{{ Auth::user()->created_at->format('M Y') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 4️⃣ My Claims Section -->
            <div class="section-card fade-in-up delay-300">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">Recent Claims</h3>
                    <a href="{{ route('contact') }}" class="btn btn-policy-secondary py-2 px-3">Need Help?</a>
                </div>

                @if($claims->isEmpty())
                    <div class="empty-state-card p-5 text-center mt-3">
                        <div class="mb-4">
                            <i class="bi bi-file-earmark-medical text-primary opacity-25" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">No claims filed yet</h4>
                        <p class="text-secondary mb-4">Your claim history will appear here once you file a new claim for an active policy.</p>
                        @if($policies->where('status', 'active')->isNotEmpty())
                            <a href="#policies" class="btn btn-policy-primary shadow-sm"><i class="bi bi-arrow-up me-2"></i>Start a Claim from My Policies</a>
                        @endif
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($claims as $claim)
                            <div class="col-md-6 col-lg-4">
                                <div class="claim-card-glass p-4 h-100 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                                            <i class="bi bi-receipt-cutoff text-primary fs-5"></i>
                                        </div>
                                        @php
                                            $claimStatusClass = 'bg-warning text-dark';
                                            if ($claim->status === 'approved')
                                                $claimStatusClass = 'bg-success text-white shadow-sm';
                                            if ($claim->status === 'rejected')
                                                $claimStatusClass = 'bg-danger text-white shadow-sm';
                                        @endphp
                                        <span class="badge rounded-pill {{ $claimStatusClass }} px-3 py-2 fw-medium">
                                            {{ ucfirst($claim->status) }}
                                        </span>
                                    </div>

                                    <h4 class="fw-bolder text-dark mb-1">${{ number_format($claim->claim_amount) }}</h4>
                                    <p class="text-muted small mb-3">Claim No: {{ $claim->claim_number }}</p>

                                    <div class="p-3 bg-white rounded-3 border mb-4 flex-grow-1 shadow-sm">
                                        <p class="small text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.7rem;">Policy</p>
                                        <a href="{{ route('policy.show', $claim->policy) }}" class="text-dark fw-bold text-decoration-none">
                                            {{ $claim->policy->plan->name }}
                                        </a>
                                        <p class="small text-secondary mb-0 mt-2"><i class="bi bi-clock me-1"></i> Filed: {{ $claim->created_at->format('M d, Y') }}</p>
                                    </div>

                                    <a href="{{ route('claims.download', $claim) }}" class="btn btn-outline-primary w-100 rounded-3 text-center fw-medium pb-2 pt-2">
                                        <i class="bi bi-download me-2"></i> Download Receipt
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            {{-- 5️⃣ Agent / Earn Commissions Section --}}
            <div class="section-card fade-in-up delay-300" style="background: linear-gradient(135deg, #f5f3ff, #eff6ff); border: 1px solid rgba(99,102,241,0.15);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-4">
                        <div style="width:60px;height:60px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:white;flex-shrink:0;">
                            🤝
                        </div>
                        <div>
                            @if(Auth::user()->role === 'agent' && Auth::user()->agent)
                                @if(Auth::user()->agent->status === 'approved')
                                    <h4 class="fw-bold mb-1" style="color:#1e293b;">Your Agent Dashboard</h4>
                                    <p class="text-muted mb-0 small">You are an approved agent. View your commissions, referral link, and client stats.</p>
                                @else
                                    <h4 class="fw-bold mb-1" style="color:#1e293b;">Application Under Review</h4>
                                    <p class="text-muted mb-0 small">Your agent application is pending approval by an admin. We'll notify you once it's reviewed.</p>
                                @endif
                            @else
                                <h4 class="fw-bold mb-1" style="color:#1e293b;">Earn with InsureMate — Become an Agent</h4>
                                <p class="text-muted mb-0 small">Refer clients and earn <strong>10% commission</strong> on every policy purchased. Get your unique referral link instantly after approval.</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if(Auth::user()->role === 'agent' && Auth::user()->agent && Auth::user()->agent->status === 'approved')
                            <a href="{{ route('agent.dashboard') }}" class="btn btn-policy-primary px-4">
                                <i class="bi bi-speedometer2 me-2"></i> Go to Agent Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'agent' && Auth::user()->agent)
                            <button class="btn btn-policy-secondary px-4" disabled>
                                <i class="bi bi-clock me-2"></i> Pending Approval
                            </button>
                        @else
                            <a href="{{ route('agent.apply') }}" class="btn btn-policy-primary px-4">
                                <i class="bi bi-arrow-right me-2"></i> Apply Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div> {{-- End Container --}}
    </div> {{-- End Dashboard Body --}}
@endsection