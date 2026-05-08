@extends('layouts.admin')

@section('content')

    @php
        $statusMap = [
            'open' => ['label' => 'Open', 'class' => 'sd-status-open', 'icon' => 'bi-envelope-open'],
            'pending' => ['label' => 'Pending', 'class' => 'sd-status-pending', 'icon' => 'bi-hourglass-split'],
            'resolved' => ['label' => 'Resolved', 'class' => 'sd-status-resolved', 'icon' => 'bi-check2-circle'],
            'closed' => ['label' => 'Closed', 'class' => 'sd-status-closed', 'icon' => 'bi-x-circle'],
        ];
        $s = $statusMap[$ticket->status] ?? ['label' => ucfirst($ticket->status), 'class' => 'sd-status-closed', 'icon' => 'bi-dash-circle'];
        $userName = $ticket->user?->name ?? 'Unknown User';
        $userEmail = $ticket->user?->email ?? '';
        $userInit = strtoupper(substr($userName, 0, 1));
    @endphp

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.tickets.index') }}" class="sd-back-link">
                    <i class="bi bi-arrow-left"></i> Tickets
                </a>
                <span class="sd-breadcrumb-sep">/</span>
                <span class="sd-breadcrumb-current">#{{ $ticket->id }}</span>
            </div>
            <h2 class="sd-page-title mb-1">{{ $ticket->subject }}</h2>
            <div class="d-flex align-items-center gap-3 flex-wrap mt-1">
                <span class="sd-ticket-meta"><i class="bi bi-hash"></i> Ticket #{{ $ticket->id }}</span>
                <span class="sd-ticket-meta"><i class="bi bi-clock"></i>
                    {{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                <span class="sd-ticket-meta"><i class="bi bi-calendar3"></i>
                    {{ $ticket->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <span class="sd-status-pill {{ $s['class'] }}">
            <i class="bi {{ $s['icon'] }} me-1"></i> {{ $s['label'] }}
        </span>
    </div>

    {{-- ── Success Alert ── --}}
    @if (session('success'))
        <div class="alert sd-alert-success d-flex gap-3 align-items-center mb-4 rounded-4 border-0 p-3 ps-4">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <span class="fw-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ── 2-Column Layout ── --}}
    <div class="sd-layout">

        {{-- ═══ LEFT: Conversation Thread ═══ --}}
        <div class="sd-conversation-col">

            {{-- Conversation Card --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-chat-left-text sd-card-header-icon"></i>
                        <span class="sd-card-header-title">Conversation Thread</span>
                    </div>
                    <span class="sd-msg-count">1 message</span>
                </div>

                <div class="sd-thread">

                    {{-- ── Customer Message Bubble ── --}}
                    <div class="sd-message sd-message-user">
                        <div class="sd-msg-avatar sd-avatar-user">
                            {{ $userInit }}
                        </div>
                        <div class="sd-msg-body">
                            <div class="sd-msg-header-row">
                                <span class="sd-msg-sender">{{ $userName }}</span>
                                <span class="sd-msg-label">Customer</span>
                            </div>
                            <div class="sd-bubble sd-bubble-user">
                                {{ $ticket->message }}
                            </div>
                            <div class="sd-msg-time">
                                <i class="bi bi-clock me-1"></i>
                                {{ $ticket->created_at->format('d M Y \a\t h:i A') }}
                            </div>
                        </div>
                    </div>

                    {{-- ── Divider ── --}}
                    <div class="sd-thread-divider">
                        <span>Admin Response Area</span>
                    </div>

                    @if($ticket->hasReply())
                        {{-- ── Admin Reply Bubble ── --}}
                        <div class="sd-message sd-message-admin">
                            <div class="sd-msg-body" style="align-items: flex-end;">
                                <div class="sd-msg-header-row" style="justify-content: flex-end;">
                                    <span class="sd-msg-label">Admin</span>
                                    <span class="sd-msg-sender">Support Team</span>
                                </div>
                                <div class="sd-bubble sd-bubble-admin">
                                    {{ $ticket->admin_reply }}
                                </div>
                                <div class="sd-msg-time" style="justify-content: flex-end;">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $ticket->replied_at?->format('d M Y \a\t h:i A') ?? $ticket->updated_at->format('d M Y \a\t h:i A') }}
                                </div>
                            </div>
                            <div class="sd-msg-avatar sd-avatar-admin">
                                <i class="bi bi-headset"></i>
                            </div>
                        </div>
                    @else
                        {{-- ── No admin reply yet ── --}}
                        <div class="sd-no-reply">
                            <i class="bi bi-reply-all sd-no-reply-icon"></i>
                            <p class="sd-no-reply-text">No admin reply added yet. Use the reply box below to respond.</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ── Reply Box ── --}}
            <div class="sd-card mt-3">
                <div class="sd-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-send sd-card-header-icon"></i>
                        <span class="sd-card-header-title">Reply to Customer</span>
                    </div>
                </div>
                <div class="sd-reply-body">
                    <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" id="replyForm">
                        @csrf
                        @method('PUT')

                        @if($ticket->hasReply())
                            {{-- ── LOCKED: reply already sent ── --}}
                            <div class="sd-reply-locked mb-4">
                                <div class="sd-lock-icon"><i class="bi bi-lock-fill"></i></div>
                                <div>
                                    <div class="sd-lock-title">Reply Already Sent</div>
                                    <div class="sd-lock-sub">Admin can only send one reply per ticket. You can still update the ticket status below.</div>
                                </div>
                            </div>
                        @else
                            {{-- ── Reply textarea ── --}}
                            <div class="sd-field mb-4">
                                <label class="sd-label" for="reply_message">
                                    <i class="bi bi-chat-square-text me-1"></i> Your Reply
                                </label>
                                <textarea id="reply_message" name="reply_message"
                                    class="sd-textarea" rows="5"
                                    placeholder="Type your response to the customer here...">{{ old('reply_message') }}</textarea>
                                @error('reply_message')
                                    <span style="font-size:0.78rem;color:#ef4444;font-weight:500;">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Status + Submit Row --}}
                        <div class="sd-action-row">
                            <div class="sd-field" style="flex:1;">
                                <label class="sd-label" for="status">
                                    <i class="bi bi-tag me-1"></i> Update Status
                                </label>
                                <select name="status" id="status" class="sd-select">
                                    <option value="open"     {{ $ticket->status === 'open'     ? 'selected' : '' }}>Open</option>
                                    <option value="pending"  {{ $ticket->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed"   {{ $ticket->status === 'closed'   ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="sd-submit-group">
                                @if($ticket->hasReply())
                                    <button type="submit" class="btn sd-btn-submit sd-btn-status" id="submitBtn">
                                        <i class="bi bi-check-lg me-1"></i>
                                        <span id="submitText">Update Status</span>
                                    </button>
                                @else
                                    <button type="submit" class="btn sd-btn-submit" id="submitBtn">
                                        <i class="bi bi-send-fill me-1"></i>
                                        <span id="submitText">Send Reply</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        {{-- ═══ RIGHT: Ticket Sidebar ═══ --}}
        <div class="sd-sidebar-col">

            {{-- User Info Card --}}
            <div class="sd-card mb-3">
                <div class="sd-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle sd-card-header-icon"></i>
                        <span class="sd-card-header-title">Customer Info</span>
                    </div>
                </div>
                <div class="sd-sidebar-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="sd-sidebar-avatar">{{ $userInit }}</div>
                        <div>
                            <div class="sd-sidebar-name">{{ $userName }}</div>
                            <div class="sd-sidebar-email">{{ $userEmail }}</div>
                        </div>
                    </div>
                    @if($ticket->user)
                        <div class="sd-meta-row">
                            <span class="sd-meta-label">Member Since</span>
                            <span class="sd-meta-value">{{ $ticket->user->created_at->format('M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Ticket Details Card --}}
            <div class="sd-card mb-3">
                <div class="sd-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle sd-card-header-icon"></i>
                        <span class="sd-card-header-title">Ticket Details</span>
                    </div>
                </div>
                <div class="sd-sidebar-body">
                    <div class="sd-meta-row">
                        <span class="sd-meta-label">Ticket ID</span>
                        <span class="sd-meta-value">#{{ $ticket->id }}</span>
                    </div>
                    <div class="sd-meta-row">
                        <span class="sd-meta-label">Current Status</span>
                        <span class="sd-status-pill sd-status-pill-sm {{ $s['class'] }}">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <div class="sd-meta-row">
                        <span class="sd-meta-label">Submitted</span>
                        <span class="sd-meta-value">{{ $ticket->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="sd-meta-row">
                        <span class="sd-meta-label">Last Updated</span>
                        <span class="sd-meta-value">{{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="sd-meta-row">
                        <span class="sd-meta-label">Time Open</span>
                        <span class="sd-meta-value">{{ $ticket->created_at->diffForHumans(null, true) }}</span>
                    </div>
                </div>
            </div>

            {{-- Back button --}}
            <a href="{{ route('admin.tickets.index') }}" class="btn sd-btn-back w-100">
                <i class="bi bi-arrow-left me-1"></i> Back to All Tickets
            </a>

        </div>

    </div>

    <style>
        :root {
            --sd-brand: #4f46e5;
            --sd-brand-light: rgba(79, 70, 229, 0.08);
            --sd-border: #e8edf3;
            --sd-bg: #f8fafc;
            --sd-text: #0f172a;
            --sd-muted: #64748b;
            --sd-radius: 16px;
            --sd-radius-sm: 10px;
        }

        /* ── Breadcrumb / header ── */
        .sd-back-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--sd-brand);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: opacity 0.2s;
        }

        .sd-back-link:hover {
            opacity: 0.75;
            color: var(--sd-brand);
        }

        .sd-breadcrumb-sep {
            color: #cbd5e1;
            font-size: 0.9rem;
        }

        .sd-breadcrumb-current {
            font-size: 0.82rem;
            color: var(--sd-muted);
            font-weight: 500;
        }

        .sd-page-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--sd-text);
            letter-spacing: -0.4px;
            line-height: 1.2;
        }

        .sd-ticket-meta {
            font-size: 0.78rem;
            color: var(--sd-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Status Pills ── */
        .sd-status-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sd-status-pill-sm {
            padding: 3px 10px;
            font-size: 0.74rem;
        }

        .sd-status-open {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .sd-status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .sd-status-resolved {
            background: rgba(139, 92, 246, 0.1);
            color: #7c3aed;
        }

        .sd-status-closed {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        /* ── Alert ── */
        .sd-alert-success {
            background: rgba(25, 135, 84, 0.07);
        }

        /* ── 2-Column Layout ── */
        .sd-layout {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .sd-conversation-col {
            flex: 1 1 0;
            min-width: 0;
        }

        .sd-sidebar-col {
            width: 280px;
            flex-shrink: 0;
        }

        /* ── Card ── */
        .sd-card {
            background: #fff;
            border-radius: var(--sd-radius);
            border: 1px solid var(--sd-border);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .sd-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--sd-border);
            background: #fdfdfe;
        }

        .sd-card-header-icon {
            color: var(--sd-brand);
            font-size: 0.95rem;
        }

        .sd-card-header-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--sd-text);
        }

        .sd-msg-count {
            font-size: 0.74rem;
            font-weight: 600;
            color: var(--sd-muted);
            background: var(--sd-bg);
            border: 1px solid var(--sd-border);
            padding: 2px 9px;
            border-radius: 999px;
        }

        /* ── Thread ── */
        .sd-thread {
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── Message ── */
        .sd-message {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .sd-msg-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--sd-brand);
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sd-avatar-user {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--sd-brand);
        }

        .sd-msg-body {
            flex: 1;
            min-width: 0;
        }

        .sd-msg-header-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .sd-msg-sender {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--sd-text);
        }

        .sd-msg-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--sd-muted);
            background: var(--sd-bg);
            border: 1px solid var(--sd-border);
            padding: 1px 8px;
            border-radius: 999px;
        }

        /* Bubbles */
        .sd-bubble {
            padding: 14px 16px;
            border-radius: 4px 14px 14px 14px;
            font-size: 0.9rem;
            line-height: 1.65;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .sd-bubble-user {
            background: var(--sd-bg);
            border: 1px solid var(--sd-border);
            color: var(--sd-text);
        }

        .sd-bubble-admin {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border: 1px solid rgba(99, 102, 241, 0.15);
            color: #1e1b4b;
            border-radius: 14px 4px 14px 14px;
        }

        .sd-msg-time {
            font-size: 0.72rem;
            color: var(--sd-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
        }

        /* Thread divider */
        .sd-thread-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--sd-muted);
            font-size: 0.74rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .sd-thread-divider::before,
        .sd-thread-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--sd-border);
        }

        /* No reply placeholder */
        .sd-no-reply {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            text-align: center;
            gap: 8px;
        }

        .sd-no-reply-icon {
            font-size: 1.8rem;
            color: #cbd5e1;
        }

        .sd-no-reply-text {
            font-size: 0.82rem;
            color: var(--sd-muted);
            margin: 0;
        }

        /* ── Reply Box ── */
        .sd-reply-body {
            padding: 24px 20px;
        }

        .sd-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sd-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
        }

        .sd-textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            background: var(--sd-bg);
            color: var(--sd-text);
            font-size: 0.92rem;
            line-height: 1.6;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .sd-textarea:focus {
            border-color: var(--sd-brand);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .sd-textarea::placeholder {
            color: #a9b4c3;
        }

        .sd-select {
            padding: 0.6rem 2rem 0.6rem 0.9rem;
            border: 1.5px solid var(--sd-border);
            border-radius: var(--sd-radius-sm);
            background: var(--sd-bg);
            color: var(--sd-text);
            font-size: 0.88rem;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color 0.2s;
        }

        .sd-select:focus {
            border-color: var(--sd-brand);
        }

        .sd-action-row {
            display: flex;
            align-items: flex-end;
            gap: 16px;
        }

        .sd-submit-group {
            flex-shrink: 0;
        }

        .sd-btn-submit {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            border: none;
            border-radius: var(--sd-radius-sm);
            padding: 0.65rem 1.8rem;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sd-btn-submit:hover {
            transform: translateY(-1px);
            color: #fff;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        /* ── Sidebar ── */
        .sd-sidebar-body {
            padding: 18px 20px;
        }

        .sd-sidebar-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--sd-brand);
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sd-sidebar-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--sd-text);
        }

        .sd-sidebar-email {
            font-size: 0.78rem;
            color: var(--sd-muted);
        }

        .sd-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .sd-meta-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sd-meta-label {
            font-size: 0.78rem;
            color: var(--sd-muted);
            font-weight: 500;
        }

        .sd-meta-value {
            font-size: 0.8rem;
            color: var(--sd-text);
            font-weight: 600;
        }

        /* ── Back button ── */
        .sd-btn-back {
            background: #fff;
            border: 1.5px solid var(--sd-border);
            color: var(--sd-muted);
            border-radius: var(--sd-radius-sm);
            padding: 0.6rem 1.2rem;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sd-btn-back:hover {
            background: var(--sd-bg);
            color: var(--sd-text);
            border-color: #cbd5e1;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .sd-layout {
                flex-direction: column;
            }

            .sd-sidebar-col {
                width: 100%;
            }

            .sd-action-row {
                flex-direction: column;
                align-items: stretch;
            }

            .sd-btn-submit {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    @push('admin_scripts')
        <script>
            document.getElementById('replyForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                const txt = document.getElementById('submitText');
                btn.disabled = true;
                txt.textContent = 'Saving...';
            });
        </script>
    @endpush

@endsection