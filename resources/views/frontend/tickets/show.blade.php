@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                @php
                    $statusMap = [
                        'open' => ['label' => 'Open', 'color' => '#2563eb', 'bg' => 'rgba(59,130,246,0.1)'],
                        'pending' => ['label' => 'Pending', 'color' => '#d97706', 'bg' => 'rgba(245,158,11,0.1)'],
                        'resolved' => ['label' => 'Resolved', 'color' => '#7c3aed', 'bg' => 'rgba(139,92,246,0.1)'],
                        'closed' => ['label' => 'Closed', 'color' => '#059669', 'bg' => 'rgba(16,185,129,0.1)'],
                    ];
                    $s = $statusMap[$ticket->status] ?? ['label' => ucfirst($ticket->status), 'color' => '#64748b', 'bg' => '#f1f5f9'];
                    $userInit = strtoupper(substr(auth()->user()->name, 0, 1));
                @endphp

                {{-- ── Header ── --}}
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <a href="{{ route('tickets.index') }}" class="usd-back-link">
                                <i class="bi bi-arrow-left"></i> My Tickets
                            </a>
                            <span style="color:#cbd5e1;">/</span>
                            <span style="font-size:0.82rem;color:#64748b;">#{{ $ticket->id }}</span>
                        </div>
                        <h2 class="usd-title mb-1">{{ $ticket->subject }}</h2>
                        <span class="usd-meta"><i class="bi bi-clock me-1"></i>Submitted
                            {{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <span class="usd-status-pill" style="background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                        {{ $s['label'] }}
                    </span>
                </div>

                {{-- ── Conversation Card ── --}}
                <div class="usd-card mb-3">
                    <div class="usd-card-header">
                        <i class="bi bi-chat-left-text me-2 usd-header-icon"></i>
                        <span class="usd-card-title">Conversation</span>
                    </div>
                    <div class="usd-thread">

                        {{-- ── Your Message ── --}}
                        <div class="usd-msg usd-msg-user">
                            <div class="usd-avatar usd-avatar-user">{{ $userInit }}</div>
                            <div class="usd-msg-body">
                                <div class="usd-sender-row">
                                    <span class="usd-sender-name">You</span>
                                    <span class="usd-sender-badge">Customer</span>
                                </div>
                                <div class="usd-bubble usd-bubble-user">{{ $ticket->message }}</div>
                                <div class="usd-time"><i
                                        class="bi bi-clock me-1"></i>{{ $ticket->created_at->format('d M Y \a\t h:i A') }}
                                </div>
                            </div>
                        </div>

                        {{-- ── Admin Reply ── --}}
                        @if($ticket->admin_reply)
                            <div class="usd-thread-divider"><span>Support Response</span></div>

                            <div class="usd-msg usd-msg-admin">
                                <div class="usd-msg-body" style="align-items:flex-end;">
                                    <div class="usd-sender-row" style="justify-content:flex-end;">
                                        <span class="usd-sender-badge">Admin</span>
                                        <span class="usd-sender-name">InsureMate Support</span>
                                    </div>
                                    <div class="usd-bubble usd-bubble-admin">{{ $ticket->admin_reply }}</div>
                                    <div class="usd-time" style="text-align:right;">
                                        <i
                                            class="bi bi-clock me-1"></i>{{ $ticket->replied_at?->format('d M Y \a\t h:i A') ?? $ticket->updated_at->format('d M Y \a\t h:i A') }}
                                    </div>
                                </div>
                                <div class="usd-avatar usd-avatar-admin"><i class="bi bi-headset"></i></div>
                            </div>

                        @else
                            {{-- ── Awaiting Response ── --}}
                            <div class="usd-thread-divider"><span>Awaiting Response</span></div>
                            <div class="usd-awaiting">
                                <div class="usd-awaiting-icon"><i class="bi bi-hourglass-split"></i></div>
                                <p class="usd-awaiting-text">Our support team will respond to your ticket shortly. We typically
                                    reply within 24 hours.</p>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- ── Back button ── --}}
                <a href="{{ route('tickets.index') }}" class="btn usd-btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to My Tickets
                </a>

            </div>
        </div>
    </div>

    <style>
        body {
            background: #f8fafc;
        }

        .usd-back-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: #4f46e5;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .usd-back-link:hover {
            opacity: 0.75;
            color: #4f46e5;
        }

        .usd-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
        }

        .usd-meta {
            font-size: 0.78rem;
            color: #64748b;
            display: flex;
            align-items: center;
        }

        .usd-status-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* Card */
        .usd-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e8edf3;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .usd-card-header {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid #e8edf3;
            background: #fdfdfe;
        }

        .usd-header-icon {
            color: #4f46e5;
        }

        .usd-card-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* Thread */
        .usd-thread {
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Messages */
        .usd-msg {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .usd-msg-admin {
            flex-direction: row-reverse;
        }

        .usd-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .usd-avatar-user {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #4f46e5;
        }

        .usd-avatar-admin {
            background: linear-gradient(135deg, #312e81, #4f46e5);
            color: #fff;
        }

        .usd-msg-body {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .usd-sender-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .usd-sender-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
        }

        .usd-sender-badge {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 1px 8px;
            border-radius: 999px;
        }

        .usd-bubble {
            padding: 14px 16px;
            font-size: 0.9rem;
            line-height: 1.65;
            white-space: pre-wrap;
            word-break: break-word;
            max-width: 85%;
        }

        .usd-bubble-user {
            background: #f8fafc;
            border: 1px solid #e8edf3;
            border-radius: 4px 14px 14px 14px;
            color: #0f172a;
        }

        .usd-bubble-admin {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 14px 4px 14px 14px;
            color: #1e1b4b;
            align-self: flex-end;
        }

        .usd-time {
            font-size: 0.72rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
        }

        /* Divider */
        .usd-thread-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .usd-thread-divider::before,
        .usd-thread-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8edf3;
        }

        /* Awaiting */
        .usd-awaiting {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
            padding: 16px;
        }

        .usd-awaiting-icon {
            font-size: 1.8rem;
            color: #cbd5e1;
        }

        .usd-awaiting-text {
            font-size: 0.83rem;
            color: #64748b;
            margin: 0;
        }

        /* Back button */
        .usd-btn-back {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-size: 0.88rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
        }

        .usd-btn-back:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
    </style>

@endsection