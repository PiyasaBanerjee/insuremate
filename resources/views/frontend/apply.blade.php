@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Apply for {{ $plan->name }}</div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5 class="alert-heading fw-bold">Plan Summary: {{ $plan->name }}</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Premium:</strong> ₹{{ number_format($plan->base_premium, 2) }} / year
                                </div>
                                <div class="col-md-4">
                                    <strong>Coverage:</strong> ₹{{ number_format($plan->coverage_amount, 2) }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Duration:</strong> {{ $plan->duration_years }} Years
                                </div>
                            </div>

                            @if(is_array($plan->benefits) && count($plan->benefits) > 0)
                                <hr>
                                <h6 class="fw-bold">Included Benefits:</h6>
                                <div class="row">
                                    @foreach($plan->benefits as $benefit)
                                        <div class="col-md-6 mb-2">
                                            <i class="bi bi-check2-circle text-success me-1"></i>
                                            {{ is_array($benefit) ? (isset($benefit['description']) ? trim($benefit['description']) : trim(implode(' ', $benefit))) : trim($benefit) }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(is_array($plan->features) && count($plan->features) > 0)
                                <hr>
                                <h6 class="fw-bold">Key Features:</h6>
                                <div class="row">
                                    @foreach($plan->features as $feature)
                                        <div class="col-md-6 mb-2">
                                            <i class="bi bi-star text-warning me-1"></i>
                                            {{ is_array($feature) ? (isset($feature['description']) ? trim($feature['description']) : trim(implode(' ', $feature))) : trim($feature) }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('plan.apply.submit', $plan) }}" class="needs-validation"
                            novalidate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nominee Name</label>
                                <input type="text" name="nominee_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nominee Relationship</label>
                                <select name="nominee_relation" class="form-control" required>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Child">Child</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Sibling">Sibling</option>
                                </select>
                            </div>

                            <hr>
                            <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
                                <div>
                                    <h5 class="mb-1 fw-bold text-dark">Total Payable Amount</h5>
                                    <p class="text-muted small mb-0"><i class="bi bi-shield-check text-success"></i> Secured
                                        via Stripe 256-bit encryption</p>
                                </div>
                                <h4 class="text-primary fw-bold mb-0">₹{{ number_format($plan->base_premium, 2) }}</h4>
                            </div>

                            <button type="submit"
                                class="btn btn-dark btn-lg w-100 d-flex align-items-center justify-content-center gap-2 shadow"
                                style="background: #635bff; border-color: #635bff; font-weight: 600; padding: 14px;">
                                <i class="bi bi-credit-card ms-1"></i> Proceed to Secure Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Form Validation Script -->
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection