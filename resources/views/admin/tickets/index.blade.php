@extends('layouts.admin')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="st-icon-badge">
                <i class="bi bi-headset"></i>
            </div>
            <div>
                <h2 class="st-page-title mb-1">Support Tickets</h2>
                <p class="st-page-subtitle mb-0">Manage and respond to customer support requests</p>
            </div>
        </div>
    </div>

    {{-- ── Success Alert ── --}}
    @if (session('success'))
        <div class="alert st-alert-success d-flex align-items-center gap-3 mb-4 rounded-4 border-0 p-3 ps-4 fade-in-up"
            role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="row g-3 mb-4">
        {{-- Total --}}
        <div class="col-sm-6 col-xl-3">
            <div class="st-stat-card st-stat-total">
                <div class="st-stat-icon-wrap">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div class="st-stat-content">
                    <div class="st-stat-number">{{ $totalCount }}</div>
                    <div class="st-stat-label">Total Tickets</div>
                </div>
                <div class="st-stat-accent st-accent-total"></div>
            </div>
        </div>
        {{-- Open --}}
        <div class="col-sm-6 col-xl-3">
            <div class="st-stat-card st-stat-open">
                <div class="st-stat-icon-wrap st-icon-open">
                    <i class="bi bi-envelope-open"></i>
                </div>
                <div class="st-stat-content">
                    <div class="st-stat-number">{{ $openCount }}</div>
                    <div class="st-stat-label">Open</div>
                </div>
                <div class="st-stat-accent st-accent-open"></div>
            </div>
        </div>
        {{-- Pending --}}
        <div class="col-sm-6 col-xl-3">
            <div class="st-stat-card st-stat-pending">
                <div class="st-stat-icon-wrap st-icon-pending">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="st-stat-content">
                    <div class="st-stat-number">{{ $pendingCount }}</div>
                    <div class="st-stat-label">Pending / Resolved</div>
                </div>
                <div class="st-stat-accent st-accent-pending"></div>
            </div>
        </div>
        {{-- Closed --}}
        <div class="col-sm-6 col-xl-3">
            <div class="st-stat-card st-stat-closed">
                <div class="st-stat-icon-wrap st-icon-closed">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="st-stat-content">
                    <div class="st-stat-number">{{ $closedCount }}</div>
                    <div class="st-stat-label">Closed</div>
                </div>
                <div class="st-stat-accent st-accent-closed"></div>
            </div>
        </div>
    </div>

    {{-- ── Main Card ── --}}
    <div class="st-card">

        {{-- Filters Bar --}}
        <div class="st-toolbar">
            <form action="{{ route('admin.tickets.index') }}" method="GET" class="st-filter-form" id="filterForm">
                <div class="st-search-wrap">
                    <i class="bi bi-search st-search-icon"></i>
                    <input type="text" name="search" class="st-search-input" placeholder="Search by user or subject..."
                        value="{{ request('search') }}">
                </div>
                <select name="status" class="st-filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <button type="submit" class="st-filter-btn">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.tickets.index') }}" class="st-clear-btn">
                        <i class="bi bi-x me-1"></i> Clear
                    </a>
                @endif
            </form>
            <div class="st-showing-badge">
                {{ $tickets->count() }} ticket{{ $tickets->count() !== 1 ? 's' : '' }}
            </div>
        </div>

        {{-- Table --}}
        <div class="st-table-wrap">
            <table class="st-table">
                <thead class="st-thead">
                    <tr>
                        <th class="st-th" style="width:60px;">#</th>
                        <th class="st-th">User</th>
                        <th class="st-th">Subject</th>
                        <th class="st-th" style="width:130px;">Status</th>
                        <th class="st-th" style="width:140px;">Submitted</th>
                        <th class="st-th" style="width:130px; text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="st-row">
                            {{-- ID --}}
                            <td class="st-td st-td-id">#{{ $ticket->id }}</td>

                            {{-- User --}}
                            <td class="st-td">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="st-avatar">
                                        {{ strtoupper(substr($ticket->user?->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="st-user-name">{{ $ticket->user?->name ?? 'Unknown User' }}</div>
                                        <div class="st-user-email">{{ $ticket->user?->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Subject --}}
                            <td class="st-td">
                                <span class="st-subject">{{ Str::limit($ticket->subject, 55) }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="st-td">
                                @php
                                    $statusMap = [
                                        'open' => ['label' => 'Open', 'class' => 'st-badge-open'],
                                        'pending' => ['label' => 'Pending', 'class' => 'st-badge-pending'],
                                        'resolved' => ['label' => 'Resolved', 'class' => 'st-badge-resolved'],
                                        'closed' => ['label' => 'Closed', 'class' => 'st-badge-closed'],
                                    ];
                                    $s = $statusMap[$ticket->status] ?? ['label' => ucfirst($ticket->status), 'class' => 'st-badge-closed'];
                                @endphp
                                <span class="st-badge {{ $s['class'] }}">
                                    <span class="st-badge-dot"></span> {{ $s['label'] }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="st-td">
                                <div class="st-date">{{ $ticket->created_at->format('d M Y') }}</div>
                                <div class="st-time">{{ $ticket->created_at->format('h:i A') }}</div>
                            </td>

                            {{-- Action --}}
                            <td class="st-td" style="text-align:right;">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn st-view-btn">
                                    <i class="bi bi-eye me-1"></i> View &amp; Reply
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="st-empty-cell">
                                <div class="st-empty-state">
                                    <div class="st-empty-icon">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <h6 class="st-empty-title">No support tickets found</h6>
                                    <p class="st-empty-sub">
                                        @if(request()->anyFilled(['search', 'status']))
                                            Try adjusting your search or filters.
                                        @else
                                            Customer support queries will appear here.
                                        @endif
                                    </p>
                                    @if(request()->anyFilled(['search', 'status']))
                                        <a href="{{ route('admin.tickets.index') }}" class="btn st-clear-btn-lg">Clear filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        {{-- @if($tickets->hasPages())
        <div class="st-table-footer">
            {{ $tickets->links('pagination::bootstrap-5') }}
        </div>
        @endif --}}
    </div>

    <style>
        :root {
            --st-brand: #4f46e5;
            --st-brand-light: rgba(79, 70, 229, 0.08);
            --st-border: #e8edf3;
            --st-bg: #f8fafc;
            --st-text: #0f172a;
            --st-muted: #64748b;
            --st-radius: 16px;
            --st-radius-sm: 10px;
        }

        /* ── Header ── */
        .st-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--st-brand-light);
            color: var(--st-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .st-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--st-text);
            letter-spacing: -0.5px;
        }

        .st-page-subtitle {
            font-size: 0.9rem;
            color: var(--st-muted);
        }

        /* ── Alert ── */
        .st-alert-success {
            background: rgba(25, 135, 84, 0.07);
        }

        /* ── Stat Cards ── */
        .st-stat-card {
            background: #fff;
            border-radius: var(--st-radius);
            border: 1px solid var(--st-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .st-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
        }

        .st-stat-accent {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 4px 0 0 4px;
        }

        .st-accent-total {
            background: #4f46e5;
        }

        .st-accent-open {
            background: #3b82f6;
        }

        .st-accent-pending {
            background: #f59e0b;
        }

        .st-accent-closed {
            background: #10b981;
        }

        .st-stat-icon-wrap {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--st-brand-light);
            color: var(--st-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .st-icon-open {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .st-icon-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .st-icon-closed {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .st-stat-number {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--st-text);
            line-height: 1;
            letter-spacing: -1px;
        }

        .st-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--st-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ── Main card ── */
        .st-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--st-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* ── Toolbar ── */
        .st-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--st-border);
            background: #fdfdfe;
        }

        .st-filter-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .st-search-wrap {
            position: relative;
        }

        .st-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--st-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .st-search-input {
            padding: 0.46rem 0.9rem 0.46rem 2rem;
            border: 1.5px solid var(--st-border);
            border-radius: var(--st-radius-sm);
            background: var(--st-bg);
            color: var(--st-text);
            font-size: 0.85rem;
            outline: none;
            width: 240px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .st-search-input:focus {
            border-color: var(--st-brand);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background: #fff;
        }

        .st-filter-select {
            padding: 0.46rem 2rem 0.46rem 0.8rem;
            border: 1.5px solid var(--st-border);
            border-radius: var(--st-radius-sm);
            background: var(--st-bg);
            color: var(--st-muted);
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

        .st-filter-select:focus {
            border-color: var(--st-brand);
        }

        .st-filter-btn {
            padding: 0.46rem 1.1rem;
            background: var(--st-brand-light);
            color: var(--st-brand);
            border: 1.5px solid rgba(79, 70, 229, 0.2);
            border-radius: var(--st-radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .st-filter-btn:hover {
            background: rgba(79, 70, 229, 0.15);
        }

        .st-clear-btn {
            padding: 0.46rem 1rem;
            background: transparent;
            color: var(--st-muted);
            border: 1.5px solid var(--st-border);
            border-radius: var(--st-radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .st-clear-btn:hover {
            background: var(--st-bg);
            color: var(--st-text);
        }

        .st-showing-badge {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--st-brand);
            background: var(--st-brand-light);
            padding: 4px 12px;
            border-radius: 999px;
        }

        /* ── Table ── */
        .st-table-wrap {
            overflow-x: auto;
        }

        .st-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .st-thead {
            background: #fafbfc;
        }

        .st-th {
            padding: 11px 18px;
            border-bottom: 1px solid var(--st-border);
            text-align: left;
            font-size: 0.71rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--st-muted);
        }

        .st-row {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .st-row:last-child {
            border-bottom: none;
        }

        .st-row:hover {
            background: #f8f9ff;
        }

        .st-td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .st-td-id {
            color: #94a3b8;
            font-size: 0.82rem;
            font-weight: 600;
        }

        /* Avatar */
        .st-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--st-brand);
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .st-user-name {
            font-weight: 600;
            color: var(--st-text);
            font-size: 0.88rem;
        }

        .st-user-email {
            font-size: 0.76rem;
            color: var(--st-muted);
        }

        .st-subject {
            font-weight: 600;
            color: var(--st-text);
        }

        /* Status badges */
        .st-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.74rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .st-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .st-badge-open {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .st-badge-open .st-badge-dot {
            background: #3b82f6;
        }

        .st-badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .st-badge-pending .st-badge-dot {
            background: #f59e0b;
        }

        .st-badge-resolved {
            background: rgba(139, 92, 246, 0.1);
            color: #7c3aed;
        }

        .st-badge-resolved .st-badge-dot {
            background: #8b5cf6;
        }

        .st-badge-closed {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .st-badge-closed .st-badge-dot {
            background: #10b981;
        }

        /* Date/time */
        .st-date {
            font-size: 0.85rem;
            color: var(--st-text);
            font-weight: 500;
        }

        .st-time {
            font-size: 0.74rem;
            color: var(--st-muted);
        }

        /* View button */
        .st-view-btn {
            padding: 6px 14px;
            background: var(--st-brand-light);
            color: var(--st-brand);
            border: 1.5px solid rgba(79, 70, 229, 0.2);
            border-radius: var(--st-radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .st-view-btn:hover {
            background: var(--st-brand);
            color: #fff;
            border-color: var(--st-brand);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        }

        /* ── Empty State ── */
        .st-empty-cell {
            padding: 64px 20px;
        }

        .st-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
        }

        .st-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--st-bg);
            color: var(--st-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .st-empty-title {
            font-weight: 700;
            color: var(--st-text);
            margin: 0;
        }

        .st-empty-sub {
            font-size: 0.85rem;
            color: var(--st-muted);
            margin: 0 0 12px;
        }

        .st-clear-btn-lg {
            padding: 0.5rem 1.4rem;
            border: 1.5px solid var(--st-border);
            border-radius: var(--st-radius-sm);
            color: var(--st-muted);
            background: var(--st-bg);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
        }

        /* ── Footer ── */
        .st-table-footer {
            padding: 16px 22px;
            border-top: 1px solid var(--st-border);
            background: #fdfdfe;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .st-filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .st-search-input {
                width: 100%;
            }
        }
    </style>

@endsection