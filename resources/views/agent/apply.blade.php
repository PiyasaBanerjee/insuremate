@extends('layouts.app')

@section('content')
    <div
        style="min-height:80vh; display:flex; align-items:center; background: radial-gradient(circle at top, rgba(99,102,241,0.05), transparent 60%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div
                        style="background:white; border-radius:16px; border:1px solid rgba(226,232,240,0.8); box-shadow:0 10px 40px -5px rgba(15,23,42,0.07); overflow:hidden;">
                        <div
                            style="background:linear-gradient(135deg,#6366f1,#4f46e5); padding:2.5rem; color:white; text-align:center;">
                            <div
                                style="width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.8rem;">
                                🤝
                            </div>
                            <h2 style="font-weight:800; margin-bottom:0.5rem;">Become an InsureMate Agent</h2>
                            <p class="mb-0 opacity-75">Earn 10% commission on every policy your referred clients purchase
                            </p>
                        </div>
                        <div style="padding:2.5rem;">

                            @if(session('error'))
                                <div class="alert alert-danger border-0" style="border-radius:10px;">{{ session('error') }}
                                </div>
                            @endif

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div style="text-align:center; padding:1.5rem; background:#f8fafc; border-radius:12px;">
                                        <div style="font-size:1.5rem; margin-bottom:0.5rem;">💰</div>
                                        <div style="font-weight:700; color:#1e293b;">10% Commission</div>
                                        <div style="font-size:0.85rem; color:#64748b;">Per policy sale</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="text-align:center; padding:1.5rem; background:#f8fafc; border-radius:12px;">
                                        <div style="font-size:1.5rem; margin-bottom:0.5rem;">🔗</div>
                                        <div style="font-weight:700; color:#1e293b;">Unique Code</div>
                                        <div style="font-size:0.85rem; color:#64748b;">Shareable referral link</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="text-align:center; padding:1.5rem; background:#f8fafc; border-radius:12px;">
                                        <div style="font-size:1.5rem; margin-bottom:0.5rem;">📊</div>
                                        <div style="font-weight:700; color:#1e293b;">Live Dashboard</div>
                                        <div style="font-size:0.85rem; color:#64748b;">Track all your earnings</div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('agent.apply.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly
                                        style="background:#f8fafc;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly
                                        style="background:#f8fafc;">
                                </div>
                                <div class="mb-4">
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        By submitting, an admin will review your application and approve it, after which
                                        your unique referral code and agent dashboard will be activated.
                                    </p>
                                </div>
                                <button type="submit" class="btn btn-lg w-100"
                                    style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;border:none;border-radius:10px;font-weight:700;padding:14px;">
                                    Submit Agent Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection