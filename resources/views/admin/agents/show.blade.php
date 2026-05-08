@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.agents.index') }}" class="btn btn-sm"
                style="background:#f1f5f9;border:none;color:#64748b;border-radius:8px;">← Back</a>
            <div>
                <h2 class="fw-bold mb-0" style="color:#1e293b;">{{ $agent->user->name }}</h2>
                <p class="text-muted mb-0">Agent Code: <code>{{ $agent->agent_code }}</code></p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0" style="border-radius:10px;">{{ session('success') }}</div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius:14px;">
                    <div style="font-size:1.8rem;font-weight:800;color:#6366f1;">{{ $agent->commissions->count() }}</div>
                    <div class="text-muted small">Total Sales</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius:14px;">
                    <div style="font-size:1.8rem;font-weight:800;color:#16a34a;">
                        ₹{{ number_format($agent->total_earnings, 2) }}</div>
                    <div class="text-muted small">Total Earned</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius:14px;">
                    <div style="font-size:1.8rem;font-weight:800;color:#ea580c;">
                        ₹{{ number_format($agent->pending_payout, 2) }}</div>
                    <div class="text-muted small">Pending Payout</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius:14px;">
                    <div style="font-size:1.8rem;font-weight:800;color:#0284c7;">{{ $agent->commission_rate }}%</div>
                    <div class="text-muted small">Commission Rate</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">
                    <div style="padding:1.25rem 1.75rem;border-bottom:1px solid rgba(226,232,240,0.7);font-weight:700;">
                        Commission History</div>
                    <div class="table-responsive">
                        @if($agent->commissions->count())
                            <table class="table mb-0">
                                <thead style="background:#f8fafc;font-size:0.8rem;color:#64748b;">
                                    <tr>
                                        <th style="padding:0.85rem 1.5rem;">Client</th>
                                        <th style="padding:0.85rem 1.5rem;">Premium</th>
                                        <th style="padding:0.85rem 1.5rem;">Commission</th>
                                        <th style="padding:0.85rem 1.5rem;">Status</th>
                                        <th style="padding:0.85rem 1.5rem;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agent->commissions as $c)
                                        <tr style="border-bottom:1px solid rgba(226,232,240,0.5);">
                                            <td style="padding:0.85rem 1.5rem;">{{ $c->client->name }}</td>
                                            <td style="padding:0.85rem 1.5rem;">₹{{ number_format($c->premium_amount, 2) }}</td>
                                            <td style="padding:0.85rem 1.5rem;color:#16a34a;font-weight:600;">
                                                ₹{{ number_format($c->commission_amount, 2) }}</td>
                                            <td style="padding:0.85rem 1.5rem;">
                                                @if($c->status === 'paid')
                                                    <span
                                                        style="background:#ebfdf1;color:#16a34a;border-radius:50px;padding:0.25rem 0.6rem;font-size:0.78rem;font-weight:600;">Paid</span>
                                                @else
                                                    <span
                                                        style="background:#fff7ed;color:#ea580c;border-radius:50px;padding:0.25rem 0.6rem;font-size:0.78rem;font-weight:600;">Pending</span>
                                                @endif
                                            </td>
                                            <td style="padding:0.85rem 1.5rem;font-size:0.85rem;color:#64748b;">
                                                {{ $c->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5 text-muted">No commissions yet</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">
                    <div style="padding:1.25rem 1.75rem;border-bottom:1px solid rgba(226,232,240,0.7);font-weight:700;">
                        Referred Clients</div>
                    <div class="table-responsive">
                        @if($agent->clients->count())
                            <table class="table mb-0">
                                <thead style="background:#f8fafc;font-size:0.8rem;color:#64748b;">
                                    <tr>
                                        <th style="padding:0.85rem 1.5rem;">Client</th>
                                        <th style="padding:0.85rem 1.5rem;">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agent->clients as $client)
                                        <tr style="border-bottom:1px solid rgba(226,232,240,0.5);">
                                            <td style="padding:0.85rem 1.5rem;font-weight:600;">{{ $client->name }}</td>
                                            <td style="padding:0.85rem 1.5rem;font-size:0.85rem;color:#64748b;">{{ $client->email }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5 text-muted">No referred clients</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection