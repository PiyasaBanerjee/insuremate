@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
            <i class="bi bi-shield-check fs-4"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Manage Policies</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">View and manage all active user policies</p>
        </div>
    </div>
    <a href="{{ route('admin.policies.create') }}" class="btn btn-primary premium-btn shadow-sm px-4 rounded-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Add Policy
    </a>
</div>

@if (session('success'))
<div class="alert alert-success bg-success bg-opacity-10 border-0 text-success rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up" role="alert">
    <i class="bi bi-check-circle-fill fs-5 me-3"></i>
    <div class="fw-medium">{{ session('success') }}</div>
</div>
@endif

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <!-- Total Policies -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 premium-stat-card h-100 position-relative">
            <div class="stat-accent" style="background: linear-gradient(135deg, #6366f1, #a855f7);"></div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrap bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="bi bi-file-earmark-text fs-5"></i>
                    </div>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">{{ number_format($totalPolicies) }}</h3>
                    <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Total Policies</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Policies -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 premium-stat-card h-100 position-relative">
            <div class="stat-accent" style="background: linear-gradient(135deg, #10b981, #34d399);"></div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrap bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="bi bi-shield-check fs-5"></i>
                    </div>
                    @if($totalPolicies > 0)
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-bold">
                            {{ round(($activePolicies / $totalPolicies) * 100) }}%
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">{{ number_format($activePolicies) }}</h3>
                    <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Active Policies</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiring Soon -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 premium-stat-card h-100 position-relative">
            <div class="stat-accent" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);"></div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrap bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="bi bi-hourglass-split fs-5"></i>
                    </div>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">{{ number_format($expiringSoon) }}</h3>
                    <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Expiring Soon</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 premium-stat-card h-100 position-relative">
            <div class="stat-accent" style="background: linear-gradient(135deg, #14b8a6, #2dd4bf);"></div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrap bg-info bg-opacity-10 text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <i class="bi bi-currency-dollar fs-5"></i>
                    </div>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1 display-6" style="letter-spacing: -1px;">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-muted mb-0 fw-medium small text-uppercase" style="letter-spacing: 0.5px;">Recurring Value</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="card border-0 shadow-sm premium-table-card rounded-4 overflow-hidden mb-5 fade-in-up" style="animation-delay: 0.1s;">
    <!-- Filter Bar -->
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4">
        <form action="{{ route('admin.policies.index') }}" method="GET" class="row g-3 align-items-center">
            
            <div class="col-lg-5 col-md-12">
                <div class="input-group search-group">
                    <span class="input-group-text bg-light border-0 ps-3 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 bg-light py-2 shadow-none" placeholder="Search policies, users, or IDs..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <select name="status" class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-5">
                <select name="date_filter" class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="this_week" {{ request('date_filter') === 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-3">
                <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-medium btn-filter-submit">
                    Filter
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
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Policy Ref</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">User</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Plan coverage</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Start Date</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">End Date</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="letter-spacing: 0.5px;">Status</th>
                        <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-end" style="letter-spacing: 0.5px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($policies as $policy)
                        <tr class="table-row-hover position-relative group">
                            <td class="px-4 py-3 border-light">
                                <span class="fw-bold text-dark font-monospace small bg-light px-2 py-1 rounded-2">#POL-{{ str_pad($policy->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-4 py-3 border-light">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded-circle text-white d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 35px; height: 35px; background: linear-gradient(135deg, #6366f1, #a855f7);">
                                        {{ strtoupper(substr($policy->user ? $policy->user->name : '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $policy->user ? $policy->user->name : 'Unknown User' }}</div>
                                        <div class="text-muted small">{{ $policy->user ? $policy->user->email : '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 border-light">
                                <div class="fw-bold text-dark">{{ $policy->plan ? $policy->plan->name : 'Unknown Plan' }}</div>
                                @if($policy->plan)
                                    <div class="text-muted small">${{ number_format($policy->premium_amount, 2) }} / {{ $policy->plan->duration_years }} year(s)</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 border-light text-muted small fw-medium">
                                {{ \Carbon\Carbon::parse($policy->start_date)->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 border-light">
                                @php
                                    $endDate = \Carbon\Carbon::parse($policy->end_date);
                                    $daysRemaining = now()->diffInDays($endDate, false);
                                    $isExpiringSoon = $daysRemaining >= 0 && $daysRemaining <= 30 && $policy->status === 'active';
                                @endphp
                                
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small fw-medium {{ $isExpiringSoon ? 'text-warning' : 'text-muted' }}">
                                        {{ $endDate->format('M d, Y') }}
                                    </span>
                                    @if($isExpiringSoon)
                                        <i class="bi bi-exclamation-circle-fill text-warning" title="Expiring in {{ $daysRemaining }} days"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 border-light">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-success bg-opacity-10 text-success border-success border-opacity-25',
                                        'expired' => 'bg-secondary bg-opacity-10 text-secondary border-secondary border-opacity-25',
                                        'pending' => 'bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 text-dark',
                                        'cancelled' => 'bg-danger bg-opacity-10 text-danger border-danger border-opacity-25'
                                    ];
                                    $badgeClass = $statusClasses[$policy->status] ?? $statusClasses['pending'];
                                @endphp
                                <span class="badge rounded-pill fw-bold border px-3 py-2 {{ $badgeClass }}">
                                    <!-- Status indicator dot -->
                                    <span class="position-relative d-inline-block me-1 rounded-circle" style="width: 6px; height: 6px; top: -1px; background-color: currentColor;"></span>
                                    {{ ucfirst($policy->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border-light text-end">
                                <a href="{{ route('admin.policies.show', $policy) }}" class="btn btn-sm btn-light border shadow-sm rounded-pill fw-medium px-3 text-dark hover-elevate">
                                    <i class="bi bi-eye me-1 text-muted"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-search fs-1"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No policies found</h5>
                                    <p>Try adjusting your search or filters.</p>
                                    @if(request()->anyFilled(['search', 'status', 'date_filter']))
                                        <a href="{{ route('admin.policies.index') }}" class="btn btn-link text-decoration-none border rounded-pill px-4 mt-2">Clear all filters</a>
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
    @if($policies->hasPages())
        <div class="card-footer bg-white border-top-0 p-4">
            {{ $policies->links('pagination::bootstrap-5') }}
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
        background-color: #f8fafc;
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
        color: #334155;
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
    
    /* Custom pagination styling hook */
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
        background-color: #6366f1;
        color: white;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }
</style>
@endsection