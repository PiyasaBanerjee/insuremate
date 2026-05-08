@extends('layouts.admin')

@section('content')

    @php
        $methodIcons = [
            'card' => ['icon' => 'bi-credit-card-2-front', 'label' => 'Card'],
            'upi' => ['icon' => 'bi-phone', 'label' => 'UPI'],
            'netbanking' => ['icon' => 'bi-bank', 'label' => 'Net Banking'],
            'cash' => ['icon' => 'bi-cash-coin', 'label' => 'Cash'],
            'wallet' => ['icon' => 'bi-wallet2', 'label' => 'Wallet'],
        ];
    @endphp

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="py-icon-badge">
                <i class="bi bi-credit-card-2-front"></i>
            </div>
            <div>
                <h2 class="py-page-title mb-1">Payments</h2>
                <p class="py-page-subtitle mb-0">Monitor transactions, revenue, and payment activity</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.index', array_merge(request()->query(), ['export' => 'csv'])) }}"
                class="btn py-export-btn d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="row g-3 mb-4">
        {{-- Total Revenue --}}
        <div class="col-sm-6 col-xl-3">
            <div class="py-stat-card">
                <div class="py-stat-accent" style="background:#4f46e5;"></div>
                <div class="py-stat-icon" style="background:rgba(79,70,229,0.08);color:#4f46e5;">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div>
                    <div class="py-stat-num">₹{{ number_format($totalRevenue, 2) }}</div>
                    <div class="py-stat-label">Total Revenue</div>
                </div>
            </div>
        </div>
        {{-- Total Transactions --}}
        <div class="col-sm-6 col-xl-3">
            <div class="py-stat-card">
                <div class="py-stat-accent" style="background:#6366f1;"></div>
                <div class="py-stat-icon" style="background:rgba(99,102,241,0.08);color:#6366f1;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="py-stat-num">{{ $totalCount }}</div>
                    <div class="py-stat-label">Total Transactions</div>
                </div>
            </div>
        </div>
        {{-- Successful --}}
        <div class="col-sm-6 col-xl-3">
            <div class="py-stat-card">
                <div class="py-stat-accent" style="background:#10b981;"></div>
                <div class="py-stat-icon" style="background:rgba(16,185,129,0.08);color:#059669;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="py-stat-num">{{ $successCount }}</div>
                    <div class="py-stat-label">Successful</div>
                </div>
            </div>
        </div>
        {{-- Failed --}}
        <div class="col-sm-6 col-xl-3">
            <div class="py-stat-card">
                <div class="py-stat-accent" style="background:#ef4444;"></div>
                <div class="py-stat-icon" style="background:rgba(239,68,68,0.08);color:#dc2626;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="py-stat-num">{{ $failedCount }}</div>
                    <div class="py-stat-label">Failed</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Main Table Card ── --}}
    <div class="py-card">

        {{-- Filters Toolbar --}}
        <div class="py-toolbar">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="py-filter-form" id="filterForm">
                {{-- Search --}}
                <div class="py-search-wrap">
                    <i class="bi bi-search py-search-icon"></i>
                    <input type="text" name="search" class="py-search-input" placeholder="Search user, email, TXN ID..."
                        value="{{ request('search') }}">
                </div>

                {{-- Status --}}
                <select name="status" class="py-filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>

                {{-- Method --}}
                <select name="method" class="py-filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('method', 'all') === 'all' ? 'selected' : '' }}>All Methods</option>
                    @foreach($methods as $m)
                        <option value="{{ $m }}" {{ request('method') === $m ? 'selected' : '' }}>
                            {{ ucfirst($m) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="py-filter-btn">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>

                @if(request()->anyFilled(['search', 'status', 'method']))
                    <a href="{{ route('admin.payments.index') }}" class="py-clear-btn">
                        <i class="bi bi-x me-1"></i> Clear
                    </a>
                @endif
            </form>

            <div class="py-count-badge">
                {{ $payments->total() }} record{{ $payments->total() !== 1 ? 's' : '' }}
            </div>
        </div>

        {{-- Table --}}
        <div class="py-table-wrap">
            <table class="py-table">
                <thead class="py-thead">
                    <tr>
                        <th class="py-th" style="width:60px;">#</th>
                        <th class="py-th">Customer</th>
                        <th class="py-th">Policy / Plan</th>
                        <th class="py-th">Amount</th>
                        <th class="py-th">Method</th>
                        <th class="py-th">Transaction ID</th>
                        <th class="py-th">Date</th>
                        <th class="py-th" style="text-align:right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        @php
                            $mi = $methodIcons[strtolower($payment->payment_method)] ?? ['icon' => 'bi-cash', 'label' => ucfirst($payment->payment_method)];
                        @endphp
                        <tr class="py-row">
                            {{-- ID --}}
                            <td class="py-td py-td-id">#{{ $payment->id }}</td>

                            {{-- Customer --}}
                            <td class="py-td">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="py-avatar">
                                        {{ strtoupper(substr($payment->user?->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="py-user-name">{{ $payment->user?->name ?? 'Unknown' }}</div>
                                        <div class="py-user-email">{{ $payment->user?->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Policy / Plan --}}
                            <td class="py-td">
                                @if($payment->policy)
                                    <span class="py-policy-badge">{{ $payment->policy->policy_number }}</span>
                                    <div class="py-plan-name mt-1">{{ $payment->policy->plan?->name ?? '—' }}</div>
                                @else
                                    <span class="py-td-muted">N/A</span>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="py-td">
                                <span class="py-amount">₹{{ number_format($payment->amount, 2) }}</span>
                            </td>

                            {{-- Method --}}
                            <td class="py-td">
                                <div class="py-method">
                                    <i class="bi {{ $mi['icon'] }} py-method-icon"></i>
                                    {{ $mi['label'] }}
                                </div>
                            </td>

                            {{-- Transaction ID --}}
                            <td class="py-td">
                                <code class="py-txn-chip">{{ $payment->transaction_id }}</code>
                            </td>

                            {{-- Date --}}
                            <td class="py-td">
                                <div class="py-date">{{ $payment->created_at->format('d M Y') }}</div>
                                <div class="py-time">{{ $payment->created_at->format('h:i A') }}</div>
                            </td>

                            {{-- Status --}}
                            <td class="py-td" style="text-align:right;">
                                @if($payment->status === 'success')
                                    <span class="py-badge py-badge-success">
                                        <span class="py-badge-dot"></span> Success
                                    </span>
                                @elseif($payment->status === 'failed')
                                    <span class="py-badge py-badge-failed">
                                        <span class="py-badge-dot"></span> Failed
                                    </span>
                                @else
                                    <span class="py-badge py-badge-pending">
                                        <span class="py-badge-dot"></span> {{ ucfirst($payment->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-empty-cell">
                                <div class="py-empty-state">
                                    <div class="py-empty-icon"><i class="bi bi-credit-card"></i></div>
                                    <h6 class="py-empty-title">No payments found</h6>
                                    <p class="py-empty-sub">
                                        @if(request()->anyFilled(['search', 'status', 'method']))
                                            Try adjusting your filters.
                                            <a href="{{ route('admin.payments.index') }}">Clear all</a>
                                        @else
                                            Payment transactions will appear here once customers purchase plans.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($payments->hasPages())
            <div class="py-pagination">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        :root {
            --py-brand: #4f46e5;
            --py-brand-light: rgba(79, 70, 229, 0.08);
            --py-border: #e8edf3;
            --py-bg: #f8fafc;
            --py-text: #0f172a;
            --py-muted: #64748b;
            --py-radius: 16px;
            --py-radius-sm: 10px;
        }

        /* ── Header ── */
        .py-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--py-brand-light);
            color: var(--py-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .py-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--py-text);
            letter-spacing: -0.5px;
        }

        .py-page-subtitle {
            font-size: 0.9rem;
            color: var(--py-muted);
        }

        .py-export-btn {
            background: #fff;
            border: 1.5px solid var(--py-border);
            color: var(--py-muted);
            border-radius: var(--py-radius-sm);
            padding: 0.5rem 1.1rem;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .py-export-btn:hover {
            background: var(--py-bg);
            color: var(--py-text);
            border-color: #cbd5e1;
        }

        /* ── Stat Cards ── */
        .py-stat-card {
            background: #fff;
            border-radius: var(--py-radius);
            border: 1px solid var(--py-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .py-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
        }

        .py-stat-accent {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 4px 0 0 4px;
        }

        .py-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .py-stat-num {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--py-text);
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .py-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--py-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ── Main Card ── */
        .py-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--py-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* ── Toolbar ── */
        .py-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--py-border);
            background: #fdfdfe;
        }

        .py-filter-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .py-search-wrap {
            position: relative;
        }

        .py-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--py-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .py-search-input {
            padding: 0.46rem 0.9rem 0.46rem 2rem;
            border: 1.5px solid var(--py-border);
            border-radius: var(--py-radius-sm);
            background: var(--py-bg);
            color: var(--py-text);
            font-size: 0.85rem;
            outline: none;
            width: 240px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .py-search-input:focus {
            border-color: var(--py-brand);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background: #fff;
        }

        .py-filter-select {
            padding: 0.46rem 2rem 0.46rem 0.8rem;
            border: 1.5px solid var(--py-border);
            border-radius: var(--py-radius-sm);
            background: var(--py-bg);
            color: var(--py-muted);
            font-size: 0.85rem;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            transition: border-color 0.2s;
        }

        .py-filter-select:focus {
            border-color: var(--py-brand);
        }

        .py-filter-btn {
            padding: 0.46rem 1.1rem;
            background: var(--py-brand-light);
            color: var(--py-brand);
            border: 1.5px solid rgba(79, 70, 229, 0.2);
            border-radius: var(--py-radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .py-filter-btn:hover {
            background: rgba(79, 70, 229, 0.15);
        }

        .py-clear-btn {
            padding: 0.46rem 1rem;
            border: 1.5px solid var(--py-border);
            border-radius: var(--py-radius-sm);
            background: transparent;
            color: var(--py-muted);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .py-clear-btn:hover {
            background: var(--py-bg);
            color: var(--py-text);
        }

        .py-count-badge {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--py-brand);
            background: var(--py-brand-light);
            padding: 4px 12px;
            border-radius: 999px;
            white-space: nowrap;
        }

        /* ── Table ── */
        .py-table-wrap {
            overflow-x: auto;
        }

        .py-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .py-thead {
            background: #fafbfc;
        }

        .py-th {
            padding: 11px 18px;
            border-bottom: 1px solid var(--py-border);
            font-size: 0.71rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--py-muted);
            text-align: left;
            white-space: nowrap;
        }

        .py-row {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .py-row:last-child {
            border-bottom: none;
        }

        .py-row:hover {
            background: #f8f9ff;
        }

        .py-td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .py-td-id {
            color: #94a3b8;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .py-td-muted {
            color: var(--py-muted);
            font-size: 0.85rem;
        }

        /* Avatar */
        .py-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--py-brand);
            font-weight: 700;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .py-user-name {
            font-weight: 600;
            color: var(--py-text);
            font-size: 0.88rem;
        }

        .py-user-email {
            font-size: 0.76rem;
            color: var(--py-muted);
        }

        /* Policy */
        .py-policy-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(99, 102, 241, 0.08);
            color: #4f46e5;
            border: 1px solid rgba(99, 102, 241, 0.15);
            padding: 2px 9px;
            border-radius: 6px;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .py-plan-name {
            font-size: 0.78rem;
            color: var(--py-muted);
        }

        /* Amount */
        .py-amount {
            font-size: 1rem;
            font-weight: 800;
            color: var(--py-text);
            letter-spacing: -0.3px;
        }

        /* Method */
        .py-method {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--py-text);
        }

        .py-method-icon {
            font-size: 0.9rem;
            color: var(--py-brand);
        }

        /* TXN Chip */
        .py-txn-chip {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid var(--py-border);
            border-radius: 6px;
            padding: 3px 8px;
            font-size: 0.76rem;
            font-family: 'Courier New', monospace;
            word-break: break-all;
        }

        /* Date */
        .py-date {
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--py-text);
        }

        .py-time {
            font-size: 0.74rem;
            color: var(--py-muted);
        }

        /* Status badges */
        .py-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.74rem;
            font-weight: 600;
        }

        .py-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .py-badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .py-badge-success .py-badge-dot {
            background: #10b981;
        }

        .py-badge-failed {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .py-badge-failed .py-badge-dot {
            background: #ef4444;
        }

        .py-badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .py-badge-pending .py-badge-dot {
            background: #f59e0b;
        }

        /* ── Empty State ── */
        .py-empty-cell {
            padding: 64px 20px;
        }

        .py-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
        }

        .py-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--py-bg);
            color: var(--py-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 6px;
        }

        .py-empty-title {
            font-weight: 700;
            color: var(--py-text);
            margin: 0;
        }

        .py-empty-sub {
            font-size: 0.84rem;
            color: var(--py-muted);
            margin: 0;
            max-width: 380px;
        }

        /* ── Pagination ── */
        .py-pagination {
            padding: 16px 22px;
            border-top: 1px solid var(--py-border);
            background: #fdfdfe;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .py-filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .py-search-input {
                width: 100%;
            }
        }
    </style>

@endsection