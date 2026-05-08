@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-file-medical fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Manage Claims</h2>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Review, approve and track all insurance claims</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.claims.export') }}"
                class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate text-muted fw-medium d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Export
            </a>
            <a href="{{ route('admin.claims.create') }}"
                class="btn btn-primary premium-btn shadow-sm px-4 rounded-pill d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> New Claim
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up"
            role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-3"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Claim Overview Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Claims -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 premium-stat-card h-100 position-relative">
                <div class="stat-accent bg-primary"></div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">
                            <i class="bi bi-files fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">
                            {{ number_format($totalClaims) }}
                        </h3>
                        <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Total
                            Claims</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Claims -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 premium-stat-card h-100 position-relative">
                <div class="stat-accent bg-warning"></div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        @if($totalClaims > 0)
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill fw-bold">
                                {{ round(($pendingClaims / $totalClaims) * 100) }}%
                            </span>
                        @endif
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">
                            {{ number_format($pendingClaims) }}
                        </h3>
                        <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Pending
                            Claims</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Claims -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 premium-stat-card h-100 position-relative">
                <div class="stat-accent bg-success"></div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">
                            {{ number_format($approvedClaims) }}
                        </h3>
                        <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Approved
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Claims -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 premium-stat-card h-100 position-relative">
                <div class="stat-accent bg-danger"></div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">
                            <i class="bi bi-x-circle fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">
                            {{ number_format($rejectedClaims) }}
                        </h3>
                        <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Rejected
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="card border-0 shadow-sm premium-table-card rounded-4 overflow-hidden mb-5 fade-in-up"
        style="animation-delay: 0.1s;">
        <!-- Smart Filters Section -->
        <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4">
            <form action="{{ route('admin.claims.index') }}" method="GET" class="row g-3 align-items-center">

                <div class="col-lg-3 col-md-12">
                    <div class="input-group search-group">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 bg-light py-2 shadow-none"
                            placeholder="Search claims, users, or IDs..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 mt-md-3 mt-lg-0">
                    <select name="status"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-3 mt-md-3 mt-lg-0">
                    <select name="date_filter"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('date_filter') === 'this_week' ? 'selected' : '' }}>This Week
                        </option>
                        <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>This Month
                        </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-3 mt-md-3 mt-lg-0">
                    <select name="amount_filter"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="">All Amounts</option>
                        <option value="0-1000" {{ request('amount_filter') === '0-1000' ? 'selected' : '' }}>$0 - $1,000
                        </option>
                        <option value="1000-5000" {{ request('amount_filter') === '1000-5000' ? 'selected' : '' }}>$1,000 -
                            $5,000</option>
                        <option value="5000+" {{ request('amount_filter') === '5000+' ? 'selected' : '' }}>$5,000+</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-2 mt-md-3 mt-lg-0">
                    <select name="sort"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="amount_high" {{ request('sort') === 'amount_high' ? 'selected' : '' }}>Amount (High)
                        </option>
                        <option value="amount_low" {{ request('sort') === 'amount_low' ? 'selected' : '' }}>Amount (Low)
                        </option>
                    </select>
                </div>

                <div class="col-lg-1 col-md-1 mt-md-3 mt-lg-0">
                    <button type="submit"
                        class="btn btn-dark w-100 rounded-pill py-2 fw-medium btn-filter-submit d-flex justify-content-center align-items-center">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table premium-table mb-0 align-middle">
                    <thead class="bg-light bg-opacity-50 border-bottom border-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Claim ID</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">User Info</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Policy Ref</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-end"
                                style="letter-spacing: 0.5px;">Claim Amount</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Created Date</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Status</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-end"
                                style="letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($claims as $claim)
                            @php
                                $isHighValue = $claim->claim_amount >= 5000;
                                $isStale = $claim->status === 'pending' && \Carbon\Carbon::parse($claim->created_at)->diffInDays(now()) > 5;
                                $isNew = \Carbon\Carbon::parse($claim->created_at)->diffInDays(now()) <= 2;
                            @endphp

                            <tr
                                class="table-row-hover position-relative group {{ $isHighValue ? 'bg-danger bg-opacity-10' : '' }}">
                                <td class="px-4 py-4 border-light">
                                    <div class="d-flex flex-column gap-1">
                                        <span
                                            class="fw-bold text-dark font-monospace small bg-light px-2 py-1 rounded-2 d-inline-block text-center"
                                            style="width: max-content;">{{ $claim->claim_number ?? 'CLM-' . $claim->id }}</span>
                                        @if($isNew)
                                            <span class="badge bg-primary rounded-pill"
                                                style="font-size: 0.65rem; width: max-content;">NEW</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-light">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle text-white d-flex align-items-center justify-content-center fw-bold small shadow-sm"
                                            style="width: 35px; height: 35px; background: linear-gradient(135deg, #1e293b, #334155);">
                                            {{ strtoupper(substr($claim->user ? $claim->user->name : '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">
                                                {{ $claim->user ? $claim->user->name : 'Unknown User' }}
                                            </div>
                                            <div class="text-muted small">{{ $claim->user ? $claim->user->email : '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-light">
                                    <span class="text-secondary fw-medium small">
                                        <i class="bi bi-file-earmark-text me-1"></i>
                                        #POL-{{ str_pad($claim->policy_id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 border-light text-end">
                                    <h5 class="fw-bold mb-0 {{ $isHighValue ? 'text-danger' : 'text-dark' }}">
                                        ${{ number_format($claim->claim_amount, 2) }}
                                    </h5>
                                    @if($isHighValue)
                                        <span class="text-danger small fw-medium text-uppercase" style="font-size: 0.65rem;"><i
                                                class="bi bi-exclamation-triangle-fill"></i> High Value</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 border-light text-muted small fw-medium">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3"></i>
                                        <span>{{ \Carbon\Carbon::parse($claim->created_at)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="mt-1" style="font-size: 0.7rem;">
                                        {{ \Carbon\Carbon::parse($claim->created_at)->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-light">
                                    @php
                                        $statusClasses = [
                                            'approved' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25 shadow-sm',
                                            'pending' => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 text-dark shadow-sm',
                                            'rejected' => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25 shadow-sm'
                                        ];
                                        $badgeClass = $statusClasses[$claim->status] ?? $statusClasses['pending'];
                                    @endphp

                                    <div class="d-flex flex-column gap-1" style="width: max-content;">
                                        <span class="badge rounded-pill fw-bold border px-3 py-2 {{ $badgeClass }}">
                                            <!-- Status indicator dot -->
                                            <span class="position-relative d-inline-block me-1 rounded-circle"
                                                style="width: 6px; height: 6px; top: -1px; background-color: currentColor;"></span>
                                            {{ ucfirst($claim->status) }}
                                        </span>

                                        @if($isStale)
                                            <div class="text-danger fw-bold d-flex align-items-center mt-1"
                                                style="font-size: 0.65rem;">
                                                <i class="bi bi-alarm-fill me-1"></i> Action Required
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-light text-end">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm d-flex align-items-center gap-2 ms-auto"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Review <i class="bi bi-chevron-down small"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3">
                                            <li>
                                                <a class="dropdown-item py-2 fw-medium d-flex align-items-center gap-2 text-dark"
                                                    href="{{ route('admin.claims.show', $claim) }}">
                                                    <i class="bi bi-eye text-primary"></i> View Details
                                                </a>
                                            </li>
                                            @if($claim->status === 'pending')
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.claims.update', $claim) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit"
                                                            class="dropdown-item py-2 fw-medium d-flex align-items-center gap-2 text-success">
                                                            <i class="bi bi-check-circle-fill"></i> Approve
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.claims.update', $claim) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit"
                                                            class="dropdown-item py-2 fw-medium d-flex align-items-center gap-2 text-danger">
                                                            <i class="bi bi-x-circle-fill"></i> Reject
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-search fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No claims found</h5>
                                        <p>Try adjusting your search or filters.</p>
                                        @if(request()->anyFilled(['search', 'status', 'date_filter', 'amount_filter']))
                                            <a href="{{ route('admin.claims.index') }}"
                                                class="btn btn-link text-decoration-none border rounded-pill px-4 mt-2">Clear all
                                                filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modern Pagination -->
        @if($claims->hasPages())
            <div class="card-footer bg-white border-top border-light p-4">
                {{ $claims->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        /* Stats Cards */
        .premium-stat-card {
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
            overflow: hidden;
        }

        .premium-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1), 0 10px 15px -10px rgba(0, 0, 0, 0.05);
        }

        .stat-accent {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            z-index: 10;
        }

        /* Buttons */
        .premium-btn {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .premium-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        }

        .hover-elevate {
            transition: all 0.2s ease;
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
            background-color: #f1f5f9;
        }

        .btn-filter-submit {
            transition: all 0.2s ease;
        }

        .btn-filter-submit:hover {
            background-color: #334155;
            transform: translateY(-1px);
        }

        /* Filters Box */
        .search-group input {
            border-radius: 0 12px 12px 0;
            height: 44px;
        }

        .search-group .input-group-text {
            border-radius: 12px 0 0 12px;
            height: 44px;
        }

        .search-group input:focus {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
        }

        .search-group:focus-within .input-group-text {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
            border-right: none !important;
            color: #6366f1 !important;
        }

        .modern-select {
            height: 44px;
            border-radius: 12px;
            cursor: pointer;
        }

        .modern-select:focus {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
        }

        /* Table Design */
        .premium-table-card {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }

        .premium-table th {
            color: #64748b;
            background-color: transparent;
        }

        .premium-table td {
            color: #1e293b;
            vertical-align: middle;
        }

        .table-row-hover {
            transition: background-color 0.2s ease;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

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

        /* Custom pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px !important;
            margin: 0 4px;
            border: none;
            color: #475569;
            font-weight: 500;
            transition: all 0.2s;
        }

        .page-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .page-item.active .page-link {
            background-color: #1e293b;
            border-color: #1e293b;
            color: white;
            box-shadow: 0 4px 10px rgba(30, 41, 59, 0.3);
        }
    </style>
@endsection