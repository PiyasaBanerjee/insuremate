@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color:#1e293b;">Manage Agents</h2>
                <p class="text-muted mb-0">Review applications and oversee agent performance</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm" style="border-radius:10px;">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
            <div style="background:#f8fafc; padding:1rem 1.5rem; border-bottom:1px solid rgba(226,232,240,0.8);">
                <div class="row">
                    <div class="col-md-3 text-center border-end">
                        <div style="font-size:1.5rem; font-weight:800; color:#6366f1;">{{ $agents->total() }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">Total Agents</div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div style="font-size:1.5rem; font-weight:800; color:#16a34a;">
                            {{ $agents->where('status', 'approved')->count() }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">Approved</div>
                    </div>
                    <div class="col-md-3 text-center border-end">
                        <div style="font-size:1.5rem; font-weight:800; color:#ea580c;">
                            {{ $agents->where('status', 'pending')->count() }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">Pending</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div style="font-size:1.5rem; font-weight:800; color:#475569;">
                            {{ $agents->where('status', 'rejected')->count() }}</div>
                        <div style="font-size:0.8rem; color:#64748b;">Rejected</div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Agent</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Code</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Status</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Sales</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Total Earned</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Pending Payout</th>
                            <th
                                style="padding:1rem 1.5rem; font-size:0.8rem; text-transform:uppercase; color:#64748b; font-weight:600;">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agents as $agent)
                            <tr style="border-bottom: 1px solid rgba(226,232,240,0.6);">
                                <td style="padding:1rem 1.5rem;">
                                    <div style="font-weight:600; color:#1e293b;">{{ $agent->user->name }}</div>
                                    <div style="font-size:0.82rem; color:#94a3b8;">{{ $agent->user->email }}</div>
                                </td>
                                <td style="padding:1rem 1.5rem;">
                                    <code
                                        style="background:#f1f5f9; padding:0.2rem 0.6rem; border-radius:6px; font-size:0.9rem;">{{ $agent->agent_code }}</code>
                                </td>
                                <td style="padding:1rem 1.5rem;">
                                    @if($agent->status === 'approved')
                                        <span
                                            style="background:#ebfdf1;color:#16a34a;border-radius:50px;padding:0.3rem 0.75rem;font-size:0.8rem;font-weight:600;">Approved</span>
                                    @elseif($agent->status === 'pending')
                                        <span
                                            style="background:#fff7ed;color:#ea580c;border-radius:50px;padding:0.3rem 0.75rem;font-size:0.8rem;font-weight:600;">Pending</span>
                                    @else
                                        <span
                                            style="background:#f1f5f9;color:#475569;border-radius:50px;padding:0.3rem 0.75rem;font-size:0.8rem;font-weight:600;">Rejected</span>
                                    @endif
                                </td>
                                <td style="padding:1rem 1.5rem;">{{ $agent->commissions_count }}</td>
                                <td style="padding:1rem 1.5rem; color:#16a34a; font-weight:600;">
                                    ₹{{ number_format($agent->total_earnings, 2) }}</td>
                                <td style="padding:1rem 1.5rem; color:#ea580c; font-weight:600;">
                                    ₹{{ number_format($agent->pending_payout, 2) }}</td>
                                <td style="padding:1rem 1.5rem;">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('admin.agents.show', $agent) }}" class="btn btn-sm"
                                            style="background:#f1f5f9;color:#6366f1;border:none;border-radius:8px;">
                                            View
                                        </a>
                                        @if($agent->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.agents.approve', $agent) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm"
                                                    style="background:#ebfdf1;color:#16a34a;border:none;border-radius:8px;">Approve</button>
                                            </form>
                                        @endif
                                        @if($agent->status !== 'rejected')
                                            <form method="POST" action="{{ route('admin.agents.reject', $agent) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm"
                                                    style="background:#fee2e2;color:#dc2626;border:none;border-radius:8px;">Reject</button>
                                            </form>
                                        @endif
                                        @if($agent->pending_payout > 0)
                                            <form method="POST" action="{{ route('admin.agents.mark_paid', $agent) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm"
                                                    style="background:#e0e7ff;color:#4f46e5;border:none;border-radius:8px;">Mark
                                                    Paid</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-2 d-block mb-2"></i>
                                    No agent applications yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($agents->hasPages())
                <div style="padding:1rem 1.5rem; border-top:1px solid rgba(226,232,240,0.7);">
                    {{ $agents->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection