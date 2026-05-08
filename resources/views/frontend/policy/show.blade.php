@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Policy Details</h5>
                        <span class="badge bg-light text-primary">{{ $policy->policy_number }}</span>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6 border-end">
                                <h6 class="text-uppercase text-muted fw-bold small">Policy Information</h6>
                                <hr class="mt-1 mb-3">

                                <dl class="row">
                                    <dt class="col-sm-4">Status:</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge bg-{{ $policy->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($policy->status) }}
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4">Start Date:</dt>
                                    <dd class="col-sm-8">{{ $policy->start_date->format('d M, Y') }}</dd>

                                    <dt class="col-sm-4">End Date:</dt>
                                    <dd class="col-sm-8">{{ $policy->end_date->format('d M, Y') }}</dd>

                                    <dt class="col-sm-4">Next Renewal:</dt>
                                    <dd class="col-sm-8">
                                        {{ $policy->next_renewal_date ? $policy->next_renewal_date->format('d M, Y') : 'N/A' }}
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-uppercase text-muted fw-bold small">Plan Details</h6>
                                <hr class="mt-1 mb-3">

                                <h4>{{ $policy->plan->name }}</h4>
                                <p class="text-muted small">{{ $policy->plan->category->name }}</p>

                                <dl class="row">
                                    <dt class="col-sm-4">Coverage:</dt>
                                    <dd class="col-sm-8 fw-bold">${{ number_format($policy->coverage_amount, 2) }}</dd>

                                    <dt class="col-sm-4">Premium:</dt>
                                    <dd class="col-sm-8">${{ number_format($policy->premium_amount, 2) }} / Year</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Included Benefits</h6>
                                        @if(is_array($policy->plan->benefits) && count($policy->plan->benefits) > 0)
                                            <div class="row mt-2">
                                                @foreach($policy->plan->benefits as $benefit)
                                                    <div class="col-md-6">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        {{ trim($benefit) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted small mb-0">No specific benefits listed.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Dashboard</a>

                            <a href="{{ route('policy.download', $policy) }}" class="btn btn-secondary">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Download Policy
                            </a>

                            <a href="{{ route('claims.create', $policy) }}" class="btn btn-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i> File a Claim
                            </a>

                            @if($policy->status == 'active')
                                <a href="{{ route('policy.renew', $policy) }}" class="btn btn-warning">
                                    <i class="bi bi-arrow-repeat me-1"></i> Renew Policy
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection