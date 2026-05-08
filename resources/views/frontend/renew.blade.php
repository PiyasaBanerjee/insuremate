@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Renew Policy: {{ $policy->policy_number }}</div>

                    <div class="card-body">
                        <div class="alert alert-warning">
                            <strong>Current Expiry:</strong> {{ $policy->end_date->format('d M Y') }}<br>
                            <strong>Renewal Cost:</strong> ${{ number_format($policy->premium_amount, 2) }}
                        </div>

                        <form method="POST" action="{{ route('policy.renew.submit', $policy) }}">
                            @csrf

                            <h5>Payment Details (Dummy Gateway)</h5>
                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <input type="text" class="form-control" placeholder="4111 1111 1111 1111" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" placeholder="123" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100">Pay & Renew</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection