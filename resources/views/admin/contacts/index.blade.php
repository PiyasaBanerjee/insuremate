@extends('layouts.admin')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="cm-icon-badge">
                <i class="bi bi-envelope-open-text"></i>
            </div>
            <div>
                <h2 class="cm-page-title mb-1">Contact Messages</h2>
                <p class="cm-page-subtitle mb-0">View and manage customer inquiries and contact requests</p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn cm-back-btn d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    {{-- ── Success Alert ── --}}
    @if (session('success'))
        <div class="alert cm-alert-success d-flex align-items-center gap-3 mb-4 rounded-4 border-0 p-3 ps-4" role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <span class="fw-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="cm-stat-card">
                <div class="cm-stat-accent" style="background:#4f46e5;"></div>
                <div class="cm-stat-icon" style="background:rgba(79,70,229,0.08);color:#4f46e5;">
                    <i class="bi bi-envelope"></i>
                </div>
                <div>
                    <div class="cm-stat-num">{{ $totalCount }}</div>
                    <div class="cm-stat-label">Total Messages</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="cm-stat-card">
                <div class="cm-stat-accent" style="background:#3b82f6;"></div>
                <div class="cm-stat-icon" style="background:rgba(59,130,246,0.08);color:#3b82f6;">
                    <i class="bi bi-calendar-day"></i>
                </div>
                <div>
                    <div class="cm-stat-num">{{ $todayCount }}</div>
                    <div class="cm-stat-label">Today</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="cm-stat-card">
                <div class="cm-stat-accent" style="background:#10b981;"></div>
                <div class="cm-stat-icon" style="background:rgba(16,185,129,0.08);color:#059669;">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div>
                    <div class="cm-stat-num">{{ $thisWeekCount }}</div>
                    <div class="cm-stat-label">This Week</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Main Inbox Card ── --}}
    <div class="cm-card">

        {{-- Toolbar --}}
        <div class="cm-toolbar">
            <form action="{{ route('admin.contacts.index') }}" method="GET" class="cm-filter-form">
                <div class="cm-search-wrap">
                    <i class="bi bi-search cm-search-icon"></i>
                    <input type="text" name="search" class="cm-search-input" placeholder="Search name, email, or subject..."
                        value="{{ request('search') }}">
                </div>
                <button type="submit" class="cm-filter-btn">
                    <i class="bi bi-funnel me-1"></i> Search
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.contacts.index') }}" class="cm-clear-btn">
                        <i class="bi bi-x me-1"></i> Clear
                    </a>
                @endif
            </form>
            <div class="cm-count-badge">
                {{ $messages->total() }} message{{ $messages->total() !== 1 ? 's' : '' }}
            </div>
        </div>

        {{-- Inbox List --}}
        <div class="cm-inbox">
            @forelse($messages as $msg)
                <div class="cm-inbox-row" data-bs-toggle="collapse" data-bs-target="#msg-{{ $msg->id }}" aria-expanded="false"
                    style="cursor:pointer;">

                    {{-- Avatar --}}
                    <div class="cm-avatar">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>

                    {{-- Sender Info --}}
                    <div class="cm-sender">
                        <div class="cm-sender-name">{{ $msg->name }}</div>
                        <div class="cm-sender-email">
                            <a href="mailto:{{ $msg->email }}" class="cm-email-link" onclick="event.stopPropagation()">
                                {{ $msg->email }}
                            </a>
                        </div>
                    </div>

                    {{-- Subject + Preview --}}
                    <div class="cm-subject-col">
                        <div class="cm-subject">{{ $msg->subject }}</div>
                        <div class="cm-preview">{{ Str::limit($msg->message, 70) }}</div>
                    </div>

                    {{-- Date + Action --}}
                    <div class="cm-meta-col">
                        <div class="cm-date">{{ $msg->created_at->format('d M Y') }}</div>
                        <div class="cm-time">{{ $msg->created_at->format('h:i A') }}</div>
                    </div>

                    {{-- 3-dot Action --}}
                    <div class="cm-action-col" onclick="event.stopPropagation()">
                        <div class="dropdown">
                            <button class="cm-dot-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end cm-dropdown shadow-sm">
                                <li>
                                    <button class="dropdown-item cm-dropdown-item" type="button"
                                        onclick="document.getElementById('msg-{{ $msg->id }}').classList.toggle('show')">
                                        <i class="bi bi-eye"></i> View Message
                                    </button>
                                </li>
                                <li>
                                    <a class="dropdown-item cm-dropdown-item" href="mailto:{{ $msg->email }}">
                                        <i class="bi bi-reply"></i> Reply via Email
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST"
                                        onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item cm-dropdown-item text-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Expand: Full Message --}}
                <div class="collapse cm-expand" id="msg-{{ $msg->id }}">
                    <div class="cm-expand-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="cm-avatar cm-avatar-lg">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                            <div class="flex-1">
                                <div class="cm-expand-header">
                                    <span class="cm-expand-name">{{ $msg->name }}</span>
                                    <span class="cm-expand-email">{{ $msg->email }}</span>
                                    <span class="cm-expand-date">{{ $msg->created_at->format('d M Y \a\t h:i A') }}</span>
                                </div>
                                <div class="cm-expand-subject">Re: {{ $msg->subject }}</div>
                                <div class="cm-expand-message">{{ $msg->message }}</div>
                                <div class="mt-3">
                                    <a href="mailto:{{ $msg->email }}" class="btn cm-reply-btn">
                                        <i class="bi bi-reply-fill me-1"></i> Reply via Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="cm-empty-state">
                    <div class="cm-empty-icon"><i class="bi bi-inbox"></i></div>
                    <h6 class="cm-empty-title">No messages found</h6>
                    <p class="cm-empty-sub">
                        @if(request()->filled('search'))
                            No messages match your search. <a href="{{ route('admin.contacts.index') }}">Clear filters</a>
                        @else
                            Customer contact form submissions will appear here.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($messages->hasPages())
            <div class="cm-pagination">
                {{ $messages->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        :root {
            --cm-brand: #4f46e5;
            --cm-brand-light: rgba(79, 70, 229, 0.08);
            --cm-border: #e8edf3;
            --cm-bg: #f8fafc;
            --cm-text: #0f172a;
            --cm-muted: #64748b;
            --cm-radius: 16px;
            --cm-radius-sm: 10px;
        }

        /* ── Header ── */
        .cm-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--cm-brand-light);
            color: var(--cm-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .cm-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--cm-text);
            letter-spacing: -0.5px;
        }

        .cm-page-subtitle {
            font-size: 0.9rem;
            color: var(--cm-muted);
        }

        .cm-back-btn {
            background: #fff;
            border: 1px solid var(--cm-border);
            color: var(--cm-muted);
            border-radius: var(--cm-radius-sm);
            padding: 0.5rem 1.1rem;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .cm-back-btn:hover {
            background: var(--cm-bg);
            color: var(--cm-text);
            border-color: #cbd5e1;
        }

        /* ── Alert ── */
        .cm-alert-success {
            background: rgba(25, 135, 84, 0.07);
        }

        /* ── Stat Cards ── */
        .cm-stat-card {
            background: #fff;
            border-radius: var(--cm-radius);
            border: 1px solid var(--cm-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.2s;
        }

        .cm-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.09);
        }

        .cm-stat-accent {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 4px 0 0 4px;
        }

        .cm-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .cm-stat-num {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--cm-text);
            line-height: 1;
            letter-spacing: -1px;
        }

        .cm-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--cm-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ── Main Card ── */
        .cm-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--cm-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* ── Toolbar ── */
        .cm-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--cm-border);
            background: #fdfdfe;
        }

        .cm-filter-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cm-search-wrap {
            position: relative;
        }

        .cm-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cm-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .cm-search-input {
            padding: 0.46rem 0.9rem 0.46rem 2rem;
            border: 1.5px solid var(--cm-border);
            border-radius: var(--cm-radius-sm);
            background: var(--cm-bg);
            color: var(--cm-text);
            font-size: 0.85rem;
            outline: none;
            width: 260px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .cm-search-input:focus {
            border-color: var(--cm-brand);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background: #fff;
        }

        .cm-filter-btn {
            padding: 0.46rem 1.1rem;
            background: var(--cm-brand-light);
            color: var(--cm-brand);
            border: 1.5px solid rgba(79, 70, 229, 0.2);
            border-radius: var(--cm-radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cm-filter-btn:hover {
            background: rgba(79, 70, 229, 0.15);
        }

        .cm-clear-btn {
            padding: 0.46rem 1rem;
            background: transparent;
            color: var(--cm-muted);
            border: 1.5px solid var(--cm-border);
            border-radius: var(--cm-radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .cm-clear-btn:hover {
            background: var(--cm-bg);
            color: var(--cm-text);
        }

        .cm-count-badge {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cm-brand);
            background: var(--cm-brand-light);
            padding: 4px 12px;
            border-radius: 999px;
            white-space: nowrap;
        }

        /* ── Inbox Rows ── */
        .cm-inbox {
            display: flex;
            flex-direction: column;
        }

        .cm-inbox-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 22px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .cm-inbox-row:last-of-type {
            border-bottom: none;
        }

        .cm-inbox-row:hover {
            background: #f8f9ff;
        }

        /* Avatar */
        .cm-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--cm-brand);
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cm-avatar-lg {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }

        /* Sender */
        .cm-sender {
            flex: 0 0 160px;
            min-width: 0;
        }

        .cm-sender-name {
            font-weight: 700;
            color: var(--cm-text);
            font-size: 0.88rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cm-sender-email {
            font-size: 0.76rem;
            color: var(--cm-muted);
            margin-top: 2px;
        }

        .cm-email-link {
            color: var(--cm-brand);
            text-decoration: none;
        }

        .cm-email-link:hover {
            text-decoration: underline;
        }

        /* Subject col */
        .cm-subject-col {
            flex: 1;
            min-width: 0;
        }

        .cm-subject {
            font-weight: 600;
            color: var(--cm-text);
            font-size: 0.88rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cm-preview {
            font-size: 0.8rem;
            color: var(--cm-muted);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Meta col */
        .cm-meta-col {
            flex: 0 0 90px;
            text-align: right;
        }

        .cm-date {
            font-size: 0.8rem;
            color: var(--cm-text);
            font-weight: 500;
        }

        .cm-time {
            font-size: 0.72rem;
            color: var(--cm-muted);
        }

        /* Action col */
        .cm-action-col {
            flex-shrink: 0;
        }

        .cm-dot-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--cm-border);
            background: #fff;
            color: var(--cm-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .cm-dot-btn:hover {
            background: var(--cm-bg);
            border-color: #cbd5e1;
            color: var(--cm-text);
        }

        /* Dropdown */
        .cm-dropdown {
            border: 1px solid var(--cm-border);
            border-radius: 12px;
            padding: 6px;
            min-width: 160px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
        }

        .cm-dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--cm-text);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s;
            width: 100%;
            background: transparent;
            border: none;
            text-align: left;
            text-decoration: none;
        }

        .cm-dropdown-item:hover {
            background: var(--cm-bg);
            color: var(--cm-text);
        }

        .cm-dropdown-item i {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* Expand Panel */
        .cm-expand {
            background: #fafbff;
            border-bottom: 1px solid #f1f5f9;
        }

        .cm-expand-body {
            padding: 20px 22px 20px 82px;
        }

        .cm-expand-header {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 6px;
        }

        .cm-expand-name {
            font-weight: 700;
            color: var(--cm-text);
            font-size: 0.9rem;
        }

        .cm-expand-email {
            font-size: 0.8rem;
            color: var(--cm-brand);
        }

        .cm-expand-date {
            font-size: 0.76rem;
            color: var(--cm-muted);
            margin-left: auto;
        }

        .cm-expand-subject {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--cm-text);
            margin-bottom: 10px;
        }

        .cm-expand-message {
            font-size: 0.9rem;
            line-height: 1.7;
            color: #334155;
            background: #fff;
            border: 1px solid var(--cm-border);
            border-radius: 10px;
            padding: 14px 16px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .cm-reply-btn {
            background: var(--cm-brand-light);
            color: var(--cm-brand);
            border: 1.5px solid rgba(79, 70, 229, 0.2);
            border-radius: var(--cm-radius-sm);
            padding: 0.5rem 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .cm-reply-btn:hover {
            background: var(--cm-brand);
            color: #fff;
            border-color: var(--cm-brand);
            transform: translateY(-1px);
        }

        /* Empty State */
        .cm-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 64px 24px;
            gap: 8px;
        }

        .cm-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--cm-bg);
            color: var(--cm-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .cm-empty-title {
            font-weight: 700;
            color: var(--cm-text);
            margin: 0;
        }

        .cm-empty-sub {
            font-size: 0.85rem;
            color: var(--cm-muted);
            margin: 0;
        }

        /* Pagination */
        .cm-pagination {
            padding: 16px 22px;
            border-top: 1px solid var(--cm-border);
            background: #fdfdfe;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cm-sender {
                flex: 0 0 120px;
            }

            .cm-meta-col {
                display: none;
            }

            .cm-expand-body {
                padding: 16px 20px;
            }
        }

        @media (max-width: 576px) {
            .cm-sender {
                display: none;
            }
        }
    </style>

@endsection