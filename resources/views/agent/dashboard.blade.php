@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #f0f4ff;
        }

        .agent-wrapper {
            padding: 3rem 0 5rem;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 15px -5px rgba(15, 23, 42, 0.07);
            padding: 1.75rem;
            text-align: center;
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 1rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
        }

        .stat-card .stat-label {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .agent-card {
            background: white;
            border-radius: 14px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 15px -5px rgba(15, 23, 42, 0.07);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .agent-card-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 1rem;
            color: #1e293b;
        }

        .agent-table {
            width: 100%;
        }

        .agent-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 1rem 1.75rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .agent-table td {
            padding: 1rem 1.75rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            font-size: 0.93rem;
        }

        .agent-table tbody tr:last-child td {
            border-bottom: none;
        }

        .agent-table tbody tr:hover {
            background: #f8faff;
        }

        .referral-box {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 14px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .referral-code {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 700;
            font-family: monospace;
            font-size: 1.4rem;
            letter-spacing: 2px;
            display: inline-block;
            margin: 0.75rem 0;
        }

        .referral-link-box {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            word-break: break-all;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
        }

        .badge-pill-green {
            background: #ebfdf1;
            color: #16a34a;
            border-radius: 50px;
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-pill-orange {
            background: #fff7ed;
            color: #ea580c;
            border-radius: 50px;
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-pill-gray {
            background: #f1f5f9;
            color: #475569;
            border-radius: 50px;
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="agent-wrapper">
        <div class="container">
            {{-- Agent Header --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h1 style="font-size:1.8rem; font-weight:800; color:#1e293b; margin:0;">
                        👋 Welcome back, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-muted mt-1 mb-0">Agent Dashboard — {{ now()->format('l, d F Y') }}</p>
                </div>
                <span class="badge bg-success" style="padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem;">
                    ✅ Approved Agent
                </span>
            </div>

            {{-- Referral Box --}}
            <div class="referral-box">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-link-45deg fs-4"></i>
                    <h5 class="mb-0 fw-bold">Your Referral System</h5>
                </div>
                <p class="mb-1 opacity-75">Share your unique code or link to earn commissions on every policy sold!</p>
                <div><span class="referral-code">{{ $agent->agent_code }}</span></div>
                <div class="referral-link-box">
                    <span id="refLink">{{ $referralLink }}</span>
                    <button onclick="navigator.clipboard.writeText('{{ $referralLink }}'); this.innerText='✓ Copied!';"
                        class="btn btn-sm"
                        style="background: rgba(255,255,255,0.2); color:white; border:none; white-space:nowrap;">
                        Copy Link
                    </button>
                </div>
            </div>

            {{-- Stats --}}
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#e0e7ff; color:#6366f1;">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="stat-value">{{ $totalSales }}</div>
                        <div class="stat-label">Total Sales</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#dcfce7; color:#16a34a;">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="stat-value">₹{{ number_format($totalEarned, 0) }}</div>
                        <div class="stat-label">Total Earned</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#ffedd5; color:#ea580c;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-value">₹{{ number_format($pendingPayout, 0) }}</div>
                        <div class="stat-label">Pending Payout</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#e0f2fe; color:#0284c7;">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-value">{{ $clients->count() }}</div>
                        <div class="stat-label">Total Clients</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Commission History --}}
                <div class="col-lg-7">
                    <div class="agent-card">
                        <div class="agent-card-header">
                            <span><i class="bi bi-list-check me-2 text-indigo-500" style="color:#6366f1;"></i>Commission
                                History</span>
                        </div>
                        <div class="table-responsive">
                            @if($recentCommissions->count() > 0)
                                <table class="agent-table">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Policy</th>
                                            <th>Commission</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentCommissions as $c)
                                            <tr>
                                                <td>
                                                    <div style="font-weight:600; color:#1e293b;">{{ $c->client->name }}</div>
                                                    <div style="font-size:0.82rem; color:#94a3b8;">
                                                        {{ $c->created_at->format('M d, Y') }}</div>
                                                </td>
                                                <td>{{ $c->policy->policy_number ?? '-' }}</td>
                                                <td><strong
                                                        style="color:#16a34a;">₹{{ number_format($c->commission_amount, 2) }}</strong>
                                                </td>
                                                <td>
                                                    @if($c->status === 'paid')
                                                        <span class="badge-pill-green">Paid</span>
                                                    @else
                                                        <span class="badge-pill-orange">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No commissions yet. Share your referral link to get started!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Client List --}}
                <div class="col-lg-5">
                    <div class="agent-card">
                        <div class="agent-card-header">
                            <span><i class="bi bi-people me-2" style="color:#6366f1;"></i>My Clients</span>
                        </div>
                        <div class="table-responsive">
                            @if($clients->count() > 0)
                                <table class="agent-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Policies</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td>
                                                    <div style="font-weight:600;">{{ $client->name }}</div>
                                                    <div style="font-size:0.82rem; color:#94a3b8;">{{ $client->email }}</div>
                                                </td>
                                                <td>{{ $client->policies_count }}</td>
                                                <td style="font-size:0.85rem; color:#64748b;">
                                                    {{ $client->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-person-plus fs-2 d-block mb-2"></i>
                                    No clients yet. Share your link!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection