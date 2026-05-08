@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-file-medical fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3 d-flex align-items-center gap-3" style="letter-spacing: -0.5px;">
                    Claim #{{ str_pad($claim->id, 4, '0', STR_PAD_LEFT) }}

                    @php
                        $statusClasses = [
                            'approved' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25',
                            'pending' => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 text-dark',
                            'rejected' => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25'
                        ];
                        $badgeClass = $statusClasses[$claim->status] ?? $statusClasses['pending'];
                    @endphp
                    <span class="badge rounded-pill fw-bold border px-3 py-1 fs-6 align-middle {{ $badgeClass }}">
                        <span class="position-relative d-inline-block me-1 rounded-circle"
                            style="width: 8px; height: 8px; top: -1px; background-color: currentColor;"></span>
                        {{ ucfirst($claim->status) }}
                    </span>
                </h2>
                <div class="text-muted small">Review, approve, or request more information for this claim</div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.claims.index') }}"
                class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
                style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
                <i class="bi bi-arrow-left me-2"></i> Back to Claims
            </a>

            @if($claim->status === 'pending')
                <div class="dropdown">
                    <button class="btn btn-dark shadow-sm px-4 rounded-pill hover-elevate d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Take Action <i class="bi bi-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3 p-2">
                        <li>
                            <form action="{{ route('admin.claims.update', $claim) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                    class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-success hover-bg-success">
                                    <i class="bi bi-check-circle-fill"></i> Approve Claim
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('admin.claims.update', $claim) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-danger hover-bg-danger">
                                    <i class="bi bi-x-circle-fill"></i> Reject Claim
                                </button>
                            </form>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li>
                            <button type="button"
                                class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-warning hover-bg-warning">
                                <i class="bi bi-question-circle-fill"></i> Request More Info
                            </button>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Main Left Column -->
        <div class="col-lg-7 col-xl-8 d-flex flex-column gap-4">

            <!-- Claim Overview Details -->
            <div class="card border-0 premium-card position-relative">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="bi bi-card-text text-primary me-2"></i> Claim Details Overview
                        </h5>
                    </div>

                    <div class="row custom-gx-5 gy-4">
                        <div class="col-md-6 border-md-end custom-pe-5">
                            <div class="mb-4 pb-2">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Claimant Information</p>
                                <div
                                    class="d-flex align-items-center gap-3 bg-light rounded-3 p-3 border border-light transition-hover">
                                    <div class="avatar-sm rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, #1e293b, #334155);">
                                        {{ strtoupper(substr($claim->user ? $claim->user->name : '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">
                                            {{ $claim->user ? $claim->user->name : 'Unknown User' }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-2">Associated Policy</p>
                                <a href="{{ route('admin.policies.show', $claim->policy_id) }}"
                                    class="text-decoration-none border rounded-3 p-3 d-flex align-items-center justify-content-between hover-soft bg-light bg-opacity-50">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1 font-monospace">
                                            #POL-{{ str_pad($claim->policy_id, 5, '0', STR_PAD_LEFT) }}</h6>
                                        <span class="text-primary small fw-medium">View Policy File <i
                                                class="bi bi-arrow-right ms-1"></i></span>
                                    </div>
                                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center text-primary"
                                        style="width: 32px; height: 32px;">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 custom-ps-5">
                            <div class="mb-4 pb-2">
                                <p class="text-muted small fw-bold text-uppercase mb-2">Submitted Date</p>
                                <div class="d-flex align-items-center text-dark">
                                    <i class="bi bi-calendar-event text-secondary me-2 fs-5"></i>
                                    <div>
                                        <div class="fw-bold">{{ $claim->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted small mt-1">{{ $claim->created_at->format('h:i A') }}
                                            ({{ $claim->created_at->diffForHumans() }})</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-2">Requested Value</p>
                                @php
                                    $isHighValue = $claim->amount >= 5000;
                                @endphp
                                <div
                                    class="p-3 rounded-3 {{ $isHighValue ? 'bg-danger bg-opacity-10 border border-danger border-opacity-25' : 'bg-light border border-light' }}">
                                    <h3 class="fw-bold mb-1 {{ $isHighValue ? 'text-danger' : 'text-primary' }}">
                                        ${{ number_format($claim->amount, 2) }}</h3>
                                    @if($isHighValue)
                                        <span class="badge bg-danger text-white rounded-pill px-2 py-1"><i
                                                class="bi bi-exclamation-triangle-fill me-1"></i> High Value Review
                                            Required</span>
                                    @else
                                        <span class="text-muted small fw-medium">Standard Processing</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <p class="text-muted small fw-bold text-uppercase mb-2">Claim Reason / Description</p>
                        <div class="p-4 bg-light rounded-3 text-dark lh-lg" style="font-size: 0.95rem;">
                            {{ $claim->reason ?: 'No extended description provided.' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Control Panel (Only if pending) -->
            @if($claim->status === 'pending')
                <div class="card border-0 premium-card position-relative overflow-hidden">
                    <div class="card-body p-4 p-md-5 bg-primary bg-opacity-10">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-4 mb-md-0 border-md-end border-primary border-opacity-25 pe-md-4">
                                <h5 class="fw-bold text-dark d-flex align-items-center mb-3">
                                    <i class="bi bi-ui-checks-grid text-primary me-2"></i> Decision Panel
                                </h5>
                                <p class="text-muted small mb-0">Record your decision regarding this claim filing. This action
                                    is irreversible and will immediately notify the client.</p>
                            </div>
                            <div class="col-md-6 ps-md-4">
                                <div class="d-flex flex-column gap-2">
                                    <form action="{{ route('admin.claims.update', $claim) }}" method="POST"
                                        class="m-0 p-0 w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                            class="btn btn-success w-100 shadow-sm rounded-pill fw-bold py-2 d-flex justify-content-center align-items-center gap-2 hover-elevate">
                                            <i class="bi bi-check-circle-fill"></i> Approve Claim Request
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.claims.update', $claim) }}" method="POST"
                                        class="m-0 p-0 w-100 mt-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                            class="btn btn-outline-danger w-100 bg-white shadow-sm rounded-pill fw-bold py-2 d-flex justify-content-center align-items-center gap-2 hover-elevate">
                                            <i class="bi bi-x-circle-fill"></i> Reject Claim
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Activity Timeline -->
            <div class="card border-0 premium-card position-relative overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="bi bi-clock-history text-secondary me-2"></i> Audit Timeline
                        </h5>
                    </div>

                    <div class="position-relative ms-3 border-start border-2 border-light pb-2">

                        @if($claim->status !== 'pending')
                            <!-- Decision Node -->
                            <div class="position-relative mb-4 ps-4">
                                <div class="position-absolute top-0 start-0 translate-middle rounded-circle border border-2 border-white d-flex align-items-center justify-content-center shadow-sm {{ $claim->status === 'approved' ? 'bg-success' : 'bg-danger' }}"
                                    style="width: 32px; height: 32px; z-index: 2;">
                                    <i
                                        class="bi {{ $claim->status === 'approved' ? 'bi-check-lg' : 'bi-x-lg' }} text-white small"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ ucfirst($claim->status) }} by Administrator</div>
                                    <div class="text-muted small mt-1">{{ $claim->updated_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Submission Node -->
                        <div class="position-relative ps-4 {{ $claim->status === 'pending' ? 'mb-2' : '' }}">
                            <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-primary border border-2 border-white d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 32px; height: 32px; z-index: 2;">
                                <i class="bi bi-file-earmark-text text-white small"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Claim Form Submitted</div>
                                <div class="text-muted small mb-2 mt-1">{{ $claim->created_at->format('M d, Y h:i A') }}
                                </div>
                                <div class="bg-light rounded-3 p-3 text-muted small border border-light d-inline-block">
                                    Initial request received via digital portal
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Right Sidebar Column -->
        <div class="col-lg-5 col-xl-4 d-flex flex-column gap-4">

            <!-- User Intelligence Card -->
            <div class="card border-0 shadow-sm premium-sidebar-card relative overflow-hidden" style="border-radius: 16px;">
                <div
                    class="card-body p-4 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-person-bounding-box text-secondary me-2"></i> Claimant Profile
                    </h6>
                    <a href="{{ route('admin.users.edit', $claim->user_id) }}"
                        class="text-primary small fw-medium text-decoration-none hover-secondary">View record</a>
                </div>

                <div class="card-body p-4 bg-white text-center border-bottom">
                    <div class="avatar-lg rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-3 shadow-sm mx-auto mb-3"
                        style="width: 72px; height: 72px; background: linear-gradient(135deg, #475569, #1e293b);">
                        {{ strtoupper(substr($claim->user ? $claim->user->name : '?', 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $claim->user ? $claim->user->name : 'Unknown User' }}</h5>
                    <p class="text-muted small mb-0">{{ $claim->user ? $claim->user->email : 'No email associated' }}</p>
                </div>

                <div class="card-body p-0">
                    <!-- Intelligence Mini Stats -->
                    <div class="row g-0 text-center">
                        <div class="col-6 p-3 border-end border-bottom">
                            <h4 class="fw-bold text-dark mb-0">—</h4>
                            <span class="text-muted text-uppercase fw-bold"
                                style="font-size: 0.65rem; letter-spacing: 0.5px;">Prior Claims</span>
                        </div>
                        <div class="col-6 p-3 border-bottom">
                            <h4 class="fw-bold text-success mb-0">—</h4>
                            <span class="text-muted text-uppercase fw-bold"
                                style="font-size: 0.65rem; letter-spacing: 0.5px;">Approval Rate</span>
                        </div>
                    </div>
                </div>

                @php
                    // Simulated Risk Score logic based on factors
                    $riskScore = 12; // Base
                    if ($claim->amount > 5000)
                        $riskScore += 45;
                    if (\Carbon\Carbon::parse($claim->created_at)->diffInDays(now()) <= 1)
                        $riskScore += 15;

                    $riskLevel = 'Low Risk';
                    $riskColor = 'success';
                    if ($riskScore > 35) {
                        $riskLevel = 'Medium Risk';
                        $riskColor = 'warning';
                    }
                    if ($riskScore > 70) {
                        $riskLevel = 'High Risk';
                        $riskColor = 'danger';
                    }
                @endphp
                <div class="card-body p-4 bg-light bg-opacity-50">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">System Risk Score</span>
                        <span class="badge bg-{{ $riskColor }} rounded-pill px-2">{{ $riskLevel }}</span>
                    </div>
                    <div class="progress shadow-sm" style="height: 6px; border-radius: 10px; background-color: #e2e8f0;">
                        <div class="progress-bar bg-{{ $riskColor }}" role="progressbar"
                            style="width: {{ min(100, $riskScore) }}%" aria-valuenow="{{ $riskScore }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            @php
                $isStale = $claim->status === 'pending' && \Carbon\Carbon::parse($claim->created_at)->diffInDays(now()) > 3;
            @endphp

            @if($isStale)
                <!-- Delayed Warning Card -->
                <div class="card border border-warning border-opacity-50 bg-warning bg-opacity-10 shadow-sm"
                    style="border-radius: 16px;">
                    <div class="card-body p-4 d-flex align-items-start gap-3">
                        <div class="text-warning fs-3 lh-1"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Delayed Review</h6>
                            <p class="text-muted small mb-0">This claim has been pending for over 3 days. It may breach service
                                level agreements if not actioned soon.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danger Zone -->
            <div class="card border border-danger border-opacity-25 bg-white shadow-sm mt-auto"
                style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-3 d-flex align-items-center">
                        <i class="bi bi-exclamation-octagon me-2"></i> Danger Zone
                    </h6>
                    <p class="text-muted small mb-4">Deleting this claim will permanently remove all associated records,
                        timelines, and uploaded documents. This action cannot be undone.</p>
                    <button type="button" class="btn btn-outline-danger w-100 rounded-pill fw-bold"
                        onclick="if(confirm('Are you absolutely sure you want to permanently delete this claim?')) { /* Logic */ alert('Mock Delete Trigerred'); }">
                        Delete Claim Permanently
                    </button>
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

        .hover-bg-success:hover {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .hover-bg-danger:hover {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .hover-bg-warning:hover {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .hover-soft {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .hover-soft:hover {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
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

        /* Custom spacing overrides for the 2 column row inside the card */
        @media (min-width: 768px) {
            .custom-pe-5 {
                padding-right: 2.5rem !important;
            }

            .custom-ps-5 {
                padding-left: 2.5rem !important;
            }
        }
    </style>
@endsection