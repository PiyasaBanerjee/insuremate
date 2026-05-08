@extends('layouts.admin')

@section('content')

    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -1px;">Welcome back,
                {{ Auth::user()->name ?? 'Admin' }}!
            </h2>
            <p class="text-muted mb-0 mb-3">Here's what's happening with InsureMate today.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.policies.index') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm"
                    style="background:#6366f1; border-color:#6366f1;"><i class="bi bi-plus-lg me-1"></i> Add Policy</a>
                <a href="{{ route('admin.claims.index') }}"
                    class="btn btn-sm btn-light border px-3 rounded-pill text-muted"><i class="bi bi-file-text me-1"></i>
                    View Claims</a>
            </div>
        </div>
        <div>
            <div class="text-end">
                <p class="text-muted mb-1 small text-uppercase fw-bold" style="letter-spacing: 1px;">System Status</p>
                <span
                    class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-25">
                    <i class="bi bi-check-circle-fill me-1"></i> All Systems Operational
                </span>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <style>
        .premium-stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
        }

        .premium-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            border-color: #cbd5e1;
        }

        .stat-icon-wrap {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-right: 1.25rem;
        }

        .stat-icon-primary {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }

        .stat-icon-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-icon-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-content {
            flex-grow: 1;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-trend {
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .trend-up {
            color: #10b981;
        }

        .trend-down {
            color: #ef4444;
        }

        .premium-stat-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #e2e8f0;
            transition: all 0.3s ease;
        }

        .card-primary::before {
            background: #6366f1;
        }

        .card-success::before {
            background: #10b981;
        }

        .card-warning::before {
            background: #f59e0b;
        }

        /* Chart Canvas Cards */
        .chart-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            height: 100%;
        }

        .chart-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>

    <div class="row g-4 mb-5">
        <!-- Users Stat -->
        <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none d-block h-100">
                <div class="premium-stat-card card-primary fade-in-content h-100" style="animation-delay: 0.1s;">
                    <div class="stat-icon-wrap stat-icon-primary">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($totalUsers ?? 0) }}</div>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Revenue Stat -->
        <div class="col-md-3">
            <div class="premium-stat-card card-success fade-in-content h-100" style="animation-delay: 0.2s;">
                <div class="stat-icon-wrap stat-icon-success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">${{ number_format($totalRevenue ?? 0, 2) }}</div>
                    <p class="stat-label">Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Agent Earnings Stat -->
        <div class="col-md-3">
            <a href="{{ route('admin.agents.index') }}" class="text-decoration-none d-block h-100">
                <div class="premium-stat-card card-primary fade-in-content h-100" style="animation-delay: 0.3s; border-left: 4px solid #8b5cf6;">
                    <div class="stat-icon-wrap" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">${{ number_format($totalAgentEarnings ?? 0, 2) }}</div>
                        <p class="stat-label">Agent Payouts</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Claims Stat -->
        <div class="col-md-3">
            <a href="{{ route('admin.claims.index') }}" class="text-decoration-none d-block h-100">
                <div class="premium-stat-card card-warning fade-in-content h-100" style="animation-delay: 0.4s;">
                    <div class="stat-icon-wrap stat-icon-warning">
                        <i class="bi bi-clipboard-pulse"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($pendingClaims ?? 0) }}</div>
                        <p class="stat-label">Pending Claims</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row g-4 mb-4">
        <!-- User Growth Line Chart -->
        <div class="col-lg-8">
            <div class="chart-card fade-in-content" style="animation-delay: 0.4s;">
                <div class="chart-title">
                    <span>User Growth Overview</span>
                    <button class="btn btn-sm btn-light border text-muted"><i class="bi bi-download"></i> Export</button>
                </div>
                <div style="height: 300px; width: 100%;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Policies Bar Chart -->
        <div class="col-lg-4">
            <div class="chart-card fade-in-content" style="animation-delay: 0.5s;">
                <div class="chart-title">
                    <span>Policy Sales</span>
                </div>
                <div style="height: 300px; width: 100%; display: flex; align-items: center;">
                    <canvas id="policySalesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="chart-card fade-in-content" style="animation-delay: 0.6s;">
                <div class="chart-title mb-4">
                    <span>Recent Policy Sales</span>
                    <a href="{{ route('admin.policies.index') }}" class="btn btn-sm btn-light border text-primary">View All <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-top">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem; padding: 1rem;">Policy No</th>
                                <th class="text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem; padding: 1rem;">Customer</th>
                                <th class="text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem; padding: 1rem;">Plan</th>
                                <th class="text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem; padding: 1rem;">Premium</th>
                                <th class="text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem; padding: 1rem;">Maturity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPolicies as $policy)
                                <tr>
                                    <td class="fw-bold text-dark px-3 mt-1" style="font-size: 0.85rem; padding: 1rem;">#{{ $policy->policy_number }}</td>
                                    <td style="padding: 1rem;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px; font-weight: 600; font-size: 0.9rem;">
                                                {{ strtoupper(substr($policy->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $policy->user->name ?? 'Unknown User' }}</div>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{ $policy->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span class="badge bg-indigo bg-opacity-10 text-indigo px-3 py-2 rounded-pill border border-indigo border-opacity-25" style="color: #6366f1;">
                                            {{ $policy->plan->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="fw-bold text-success">${{ number_format($policy->premium_amount, 2) }}</div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="text-dark">{{ $policy->end_date->format('M d, Y') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No recent policies found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('admin_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Defaults
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748b';
            Chart.defaults.scale.grid.color = 'rgba(226, 232, 240, 0.5)';

            // 1. User Growth Line Chart
            const userCtx = document.getElementById('userGrowthChart').getContext('2d');

            // Create an elegant blue gradient for the line chart fill
            const gradientBlue = userCtx.createLinearGradient(0, 0, 0, 400);
            gradientBlue.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
            gradientBlue.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(userCtx, {
                type: 'line',
                data: {
                    labels: ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb'],
                    datasets: [{
                        label: 'New Users',
                        data: [65, 78, 90, 115, 142, 185], // Mock data scaling up
                        borderColor: '#6366f1', // Primary brand color
                        backgroundColor: gradientBlue,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Smooth curves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 13, family: 'Inter' },
                            bodyFont: { size: 14, weight: 'bold', family: 'Inter' },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            ticks: { padding: 10 }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                            ticks: { padding: 10 }
                        }
                    },
                    animation: {
                        x: { duration: 1000, easing: 'easeOutQuart' },
                        y: { duration: 1000, easing: 'easeOutQuart' }
                    }
                }
            });

            // 2. Policy Sales Bar Chart
            const policyCtx = document.getElementById('policySalesChart').getContext('2d');
            new Chart(policyCtx, {
                type: 'bar',
                data: {
                    labels: ['Health', 'Life', 'Auto', 'Home'],
                    datasets: [{
                        label: 'Policies Sold',
                        data: [120, 190, 80, 45], // Mock data
                        backgroundColor: [
                            '#10b981', // Success green 
                            '#6366f1', // Indigo
                            '#f59e0b', // Warning orange
                            '#8b5cf6'  // Purple
                        ],
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 13, family: 'Inter' },
                            bodyFont: { size: 14, weight: 'bold', family: 'Inter' },
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            display: false, // Hide Y axis entirely for clean minimal look
                            beginAtZero: true
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endpush