@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #f8fafc;
        }

        .tickets-page-wrapper {
            padding: 4rem 0 6rem;
            background: radial-gradient(circle at top center, rgba(99, 102, 241, 0.04) 0%, transparent 60%);
            min-height: calc(100vh - 100px);
        }

        .tickets-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .tickets-header {
            padding: 2rem 2.5rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tickets-title-wrap {
            display: flex;
            flex-direction: column;
        }

        .tickets-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .tickets-title i {
            color: #6366f1;
            font-size: 1.25rem;
        }

        .tickets-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(99, 102, 241, 0.3);
            color: white;
        }

        /* Table Styling Option B: Modern SaaS Table */
        .tickets-table-wrapper {
            padding: 0;
        }

        .saas-table {
            width: 100%;
            margin-bottom: 0;
        }

        .saas-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1.25rem 2.5rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            border-top: none;
        }

        .saas-table td {
            padding: 1.25rem 2.5rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            color: #334155;
            font-size: 0.95rem;
        }

        .saas-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .saas-table tbody tr:hover {
            background-color: rgba(248, 250, 252, 0.8);
        }

        .saas-table tbody tr:last-child td {
            border-bottom: none;
        }

        .ticket-subject {
            font-weight: 600;
            color: #1e293b;
        }

        .ticket-date {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Precision Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .status-badge.open {
            background-color: #ebfdf1;
            color: #16a34a;
            border: 1px solid rgba(34, 197, 94, 0.15);
        }

        .status-badge.pending {
            background-color: #fff7ed;
            color: #ea580c;
            border: 1px solid rgba(249, 115, 22, 0.15);
        }

        .status-badge.closed {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid rgba(100, 116, 139, 0.15);
        }

        .status-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-badge.open .status-badge-dot {
            background-color: #22c55e;
            box-shadow: 0 0 4px #22c55e;
        }

        .status-badge.pending .status-badge-dot {
            background-color: #f97316;
        }

        .status-badge.closed .status-badge-dot {
            background-color: #64748b;
        }

        /* View Action */
        .btn-view-ticket {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: #f1f5f9;
            color: #6366f1;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            text-decoration: none;
        }

        .btn-view-ticket:hover {
            background-color: #e0e7ff;
            color: #4f46e5;
            border-color: rgba(99, 102, 241, 0.2);
        }

        /* Empty State */
        .empty-tickets {
            padding: 5rem 2rem;
            text-align: center;
        }

        .empty-icon-wrap {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.05));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #6366f1;
            font-size: 2rem;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #64748b;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')
    <div class="tickets-page-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm"
                            style="border-radius: 12px; background: #ebfdf1; color: #16a34a;" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="tickets-card">
                        <div class="tickets-header">
                            <div class="tickets-title-wrap">
                                <h1 class="tickets-title">
                                    <i class="bi bi-life-preserver"></i>
                                    {{ __('My Support Tickets') }}
                                </h1>
                                <p class="tickets-subtitle">Track and manage your support requests.</p>
                            </div>
                            <a href="{{ route('tickets.create') }}" class="btn-gradient-primary">
                                <i class="bi bi-plus-lg"></i> Open New Ticket
                            </a>
                        </div>

                        <div class="tickets-table-wrapper">
                            @if($tickets->count() > 0)
                                <table class="saas-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                            @php
                                                $normalizedStatus = strtolower($ticket->status);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="ticket-subject">{{ $ticket->subject }}</div>
                                                </td>
                                                <td>
                                                    <span class="ticket-date"><i class="bi bi-calendar3 me-1"></i>
                                                        {{ $ticket->created_at->format('M d, Y') }}</span>
                                                </td>
                                                <td>
                                                    <span class="status-badge {{ $normalizedStatus }}">
                                                        <span class="status-badge-dot"></span>
                                                        {{ ucfirst($normalizedStatus) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn-view-ticket"
                                                        title="View Ticket" data-bs-toggle="tooltip">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-tickets">
                                    <div class="empty-icon-wrap">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h3 class="empty-title">No tickets found</h3>
                                    <p class="empty-text">You haven't opened any support requests yet. If you need assistance,
                                        our team is ready to help.</p>
                                    <a href="{{ route('tickets.create') }}" class="btn-gradient-primary">
                                        <i class="bi bi-plus-lg"></i> Open New Ticket
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection