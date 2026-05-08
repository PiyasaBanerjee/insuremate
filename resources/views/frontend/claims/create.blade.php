@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">File a Claim for Policy: {{ $policy->policy_number }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('claims.store', $policy) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Plan</label>
                                <input type="text" class="form-control" value="{{ $policy->plan->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Claim Amount ($)</label>
                                <input type="number" step="0.01" name="amount" class="form-control"
                                    max="{{ $policy->coverage_amount }}" required>
                                <small class="text-muted">Max coverage:
                                    ${{ number_format($policy->coverage_amount, 2) }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description of Incident</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Supporting Document (PDF/Image)</label>
                                <input type="file" name="document" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Submit Claim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection