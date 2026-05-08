@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-file-earmark-medical fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Policy Reference</h2>
                <div class="d-flex align-items-center gap-2">
                    <span
                        class="text-muted fw-bold font-monospace bg-light px-2 py-1 rounded small border">#POL-{{ str_pad($policy->id, 5, '0', STR_PAD_LEFT) }}</span>
                    @php
                        $statusClasses = [
                            'active' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25',
                            'expired' => 'bg-secondary bg-opacity-10 text-secondary border-secondary border-opacity-25',
                            'pending' => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 text-dark',
                            'cancelled' => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25'
                        ];
                        $badgeClass = $statusClasses[$policy->status] ?? $statusClasses['pending'];
                    @endphp
                    <span class="badge rounded-pill fw-bold border px-2 py-1 {{ $badgeClass }}">
                        <span class="position-relative d-inline-block me-1 rounded-circle"
                            style="width: 6px; height: 6px; top: -1px; background-color: currentColor;"></span>
                        {{ ucfirst($policy->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.policies.index') }}"
                class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
                style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
                <i class="bi bi-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('admin.policies.edit', $policy) }}"
                class="btn btn-dark shadow-sm px-4 rounded-pill hover-elevate">
                <i class="bi bi-pencil-square me-2"></i> Edit Policy
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-3"></i>
        <div class="fw-medium">{{ session('success') }}</div>
    </div>
    @endif

    <div class="row g-4 mb-5">
        <!-- Main Left Column -->
        <div class="col-lg-8">

            <!-- Coverage Details Card -->
            <div class="card border-0 premium-card position-relative mb-4">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-4 mb-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="bi bi-shield-check text-primary me-2 fs-4"></i> Coverage Overview
                        </h5>
                        <div class="text-primary bg-primary bg-opacity-10 px-3 py-1 rounded-pill fw-bold text-uppercase small"
                            style="letter-spacing: 0.5px;">
                            Plan Attributes
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100 border border-light transition-hover">
                                <div class="text-muted small fw-bold text-uppercase mb-2"><i
                                        class="bi bi-box-seam me-1"></i> Insurance Plan</div>
                                <h4 class="fw-bold text-dark mb-2">
                                    {{ $policy->plan ? $policy->plan->name : 'Unknown Plan' }}</h4>
                                @if($policy->plan && $policy->plan->category)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border rounded-pill px-2">
                                        {{ $policy->plan->category->name }} Category
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 h-100 border border-light transition-hover">
                                <div class="text-muted small fw-bold text-uppercase mb-2"><i
                                        class="bi bi-piggy-bank me-1"></i> Financials</div>
                                <div class="d-flex justify-content-between align-items-end mb-2">
                                    <div>
                                        <h4 class="fw-bold text-primary mb-0">
                                            ${{ number_format($policy->premium_amount, 2) }}</h4>
                                        <span class="text-muted small">Total Premium</span>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="fw-bold text-dark mb-0">${{ number_format($policy->coverage_amount, 2) }}
                                        </h5>
                                        <span class="text-muted small">Max Coverage</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Core Dates -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="row text-center g-3">
                            <div class="col-sm-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1"><i
                                        class="bi bi-play-circle me-1"></i> Start Date</div>
                                <div class="fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($policy->start_date)->format('M d, Y') }}</div>
                            </div>
                            <div class="col-sm-4 position-relative">
                                <!-- Divider line on larger screens -->
                                <div class="d-none d-sm-block position-absolute top-50 start-0 translate-middle-y w-1"
                                    style="height: 30px; border-left: 2px dashed #e2e8f0;"></div>

                                <div class="text-muted small fw-bold text-uppercase mb-1"><i
                                        class="bi bi-stop-circle me-1"></i> End Date</div>
                                <div class="fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($policy->end_date)->format('M d, Y') }}</div>

                                <!-- Divider line on larger screens -->
                                <div class="d-none d-sm-block position-absolute top-50 end-0 translate-middle-y w-1"
                                    style="height: 30px; border-left: 2px dashed #e2e8f0;"></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1"><i
                                        class="bi bi-arrow-repeat me-1"></i> Next Renewal</div>
                                @if($policy->next_renewal_date)
                                    <div class="fw-bold text-primary">
                                        {{ \Carbon\Carbon::parse($policy->next_renewal_date)->format('M d, Y') }}</div>
                                @else
                                    <div class="fw-bold text-muted">N/A</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Time remaining progress bar -->
                    @if($policy->status === 'active')
                        @php
                            $start = \Carbon\Carbon::parse($policy->start_date);
                            $end = \Carbon\Carbon::parse($policy->end_date);
                            $totalDays = $start->diffInDays($end);
                            $daysPassed = $start->diffInDays(now());

                            // Prevent division by zero and cap at 100%
                            $percentage = $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : 100;

                            // Color coding based on time left
                            $progressColor = 'bg-primary';
                            if ($percentage > 85)
                                $progressColor = 'bg-warning';
                            if ($percentage > 95)
                                $progressColor = 'bg-danger';
                        @endphp
                        <div class="mt-4 pt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-medium">Policy Timetable</span>
                                <span class="text-dark small fw-bold">{{ $percentage }}% Elapsed</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px; background-color: #f1f5f9;">
                                <div class="progress-bar {{ $progressColor }} rounded-pill" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Sidebar Column -->
        <div class="col-lg-4 d-flex flex-column gap-4">

            <!-- User Information Card -->
            <div class="card border-0 shadow-sm premium-sidebar-card relative overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4 border-bottom bg-light bg-opacity-50">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-person-badge text-secondary me-2"></i> Client Information
                    </h6>
                </div>
                <div class="card-body p-4 bg-white text-center">
                    <div class="avatar-lg rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-3 shadow-sm mx-auto mb-3"
                        style="width: 80px; height: 80px; background: linear-gradient(135deg, #6366f1, #3b82f6);">
                        {{ strtoupper(substr($policy->user ? $policy->user->name : '?', 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $policy->user ? $policy->user->name : 'Unknown User' }}</h5>
                    <p class="text-muted small mb-3">{{ $policy->user ? $policy->user->email : 'No email associated' }}</p>

                    @if($policy->user)
                        <a href="{{ route('admin.users.edit', $policy->user->id) }}"
                            class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm pointer-custom hover-elevate">
                            View Full Profile
                        </a>
                    @endif
                </div>

                @if($policy->user && $policy->user->phone)
                    <div class="card-footer bg-white border-top p-3 d-flex align-items-center justify-content-between">
                        <span class="text-muted small fw-medium"><i class="bi bi-telephone ms-1 me-2"></i> Contact</span>
                        <span class="text-dark fw-bold small">{{ $policy->user->phone }}</span>
                    </div>
                @endif
            </div>

            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm premium-sidebar-card relative overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4 border-bottom bg-light bg-opacity-50">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-lightning-charge text-secondary me-2"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body p-3 bg-white">
                    <div class="list-group list-group-flush border-0">
                        <a href="{{ route('admin.policies.edit', $policy) }}"
                            class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center text-dark hover-soft">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="fw-medium">Edit Policy Details</div>
                        </a>

                        @if($policy->status === 'active')
                            <form action="{{ route('admin.policies.resend', $policy) }}" method="POST" class="m-0 p-0 w-100">
                                @csrf
                                <button type="submit"
                                    class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center text-dark hover-soft w-100 text-start">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                        <i class="bi bi-envelope-paper"></i>
                                    </div>
                                    <div class="fw-medium">Resend Document</div>
                                </button>
                            </form>
                        @endif

                        @if($policy->status === 'pending')
                            <!-- Example action to approve -->
                            <button
                                class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center text-success hover-soft w-100 text-start">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="fw-medium">Approve Policy</div>
                            </button>
                        @endif

                        <!-- Only show destructive actions based on state -->
                        @if($policy->status !== 'cancelled')
                            <button type="button"
                                class="list-group-item list-group-item-action border-0 rounded-3 d-flex align-items-center text-danger hover-soft text-start mt-2 border-top pt-3">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3">
                                    <i class="bi bi-x-octagon"></i>
                                </div>
                                <div class="fw-medium">Cancel Policy</div>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Premium Card Layouts */
        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 10px rgba(0, 0, 0, 0.01);
        }

        .card-top-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 50%, #8b5cf6 100%);
            border-radius: 20px 20px 0 0;
        }

        .premium-sidebar-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        /* Hover Effects */
        .hover-elevate {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
        }

        .hover-soft {
            transition: background-color 0.2s ease;
        }

        .hover-soft:hover {
            background-color: #f8fafc;
        }

        .transition-hover {
            transition: all 0.3s ease;
        }

        .transition-hover:hover {
            background-color: #fff !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0 !important;
            transform: translateY(-2px);
        }

        /* Progress Override */
        .progress-bar {
            transition: width 1s ease-in-out;
        }
    </style>
@endsection