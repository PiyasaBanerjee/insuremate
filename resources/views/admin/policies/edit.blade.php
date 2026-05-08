@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-pencil-square fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Edit Policy</h2>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <span
                        class="text-muted fw-bold font-monospace bg-light px-2 py-1 rounded small border">#POL-{{ str_pad($policy->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-muted small">Update policy parameters and status</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.policies.show', $policy) }}"
            class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
            style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
            <i class="bi bi-arrow-left me-2"></i> Back to Policy
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 premium-card position-relative h-100">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 p-md-5">

                    @if($errors->any())
                        <div
                            class="alert custom-alert bg-danger bg-opacity-10 border-0 text-danger rounded-4 p-4 fade-in-up mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                                <h6 class="fw-bold mb-0">Please fix the following errors:</h6>
                            </div>
                            <ul class="mb-0 small fw-medium text-danger text-opacity-75 ps-4">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.policies.update', $policy) }}" method="POST" id="editPolicyForm">
                        @csrf
                        @method('PUT')

                        <!-- Client & Plan details -->
                        <div class="form-section mb-5">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-person-badge text-primary me-2"></i> Primary Details
                                </h5>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label fw-bold small text-uppercase text-muted">Client /
                                        User</label>
                                    <div class="position-relative">
                                        <span
                                            class="position-absolute top-50 translate-middle-y ms-3 z-3 text-muted pointer-events-none">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <select
                                            class="form-select form-select-lg modern-select @error('user_id') is-invalid @enderror"
                                            id="user_id" name="user_id" required style="padding-left: 2.5rem;">
                                            <option value="">Select a user...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id', $policy->user_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="plan_id"
                                        class="form-label fw-bold small text-uppercase text-muted">Insurance Plan</label>
                                    <div class="position-relative">
                                        <span
                                            class="position-absolute top-50 translate-middle-y ms-3 z-3 text-muted pointer-events-none">
                                            <i class="bi bi-shield-check"></i>
                                        </span>
                                        <select
                                            class="form-select form-select-lg modern-select @error('plan_id') is-invalid @enderror"
                                            id="plan_id" name="plan_id" required style="padding-left: 2.5rem;">
                                            <option value="" data-price="">Select a plan...</option>
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->id }}" data-price="{{ $plan->base_premium }}" {{ old('plan_id', $policy->plan_id) == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->name }} (${{ number_format($plan->base_premium, 2) }}/yr)
                                                </option>
                                            @endforeach
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="premium_amount"
                                        class="form-label fw-bold small text-uppercase text-muted">Premium Amount
                                        ($)</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control form-control-lg modern-input pe-4 @error('premium_amount') is-invalid @enderror"
                                            id="premium_amount" name="premium_amount"
                                            value="{{ old('premium_amount', $policy->premium_amount) }}" required
                                            style="padding-left: 2.5rem;">
                                    </div>
                                    <div class="form-text small mt-1 text-muted"><i class="bi bi-info-circle me-1"></i>
                                        Manual overrides allowed.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold small text-uppercase text-muted">Current
                                        Status</label>
                                    <div class="position-relative">
                                        <span
                                            class="position-absolute ms-3 top-50 translate-middle-y z-3 pointer-events-none d-flex"
                                            id="statusIcon">
                                            <span class="rounded-circle bg-secondary"
                                                style="width: 10px; height: 10px;"></span>
                                        </span>
                                        <select
                                            class="form-select form-select-lg modern-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required style="padding-left: 2.5rem;">
                                            <option value="pending" {{ old('status', $policy->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="active" {{ old('status', $policy->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="expired" {{ old('status', $policy->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                                            <option value="cancelled" {{ old('status', $policy->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coverage Period -->
                        <div class="form-section mb-4 pt-2">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-calendar3-range text-primary me-2"></i> Coverage Period
                                </h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-bold small text-uppercase text-muted">Start
                                        Date</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-calendar-event"></i>
                                        </span>
                                        <input type="date"
                                            class="form-control form-control-lg modern-input pe-4 @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date"
                                            value="{{ old('start_date', \Carbon\Carbon::parse($policy->start_date)->format('Y-m-d')) }}"
                                            required style="padding-left: 2.5rem;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label fw-bold small text-uppercase text-muted">End
                                        Date</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-calendar-check"></i>
                                        </span>
                                        <input type="date"
                                            class="form-control form-control-lg modern-input pe-4 @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date', \Carbon\Carbon::parse($policy->end_date)->format('Y-m-d')) }}"
                                            required style="padding-left: 2.5rem;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top mt-5">
                            <a href="{{ route('admin.policies.show', $policy) }}"
                                class="btn custom-btn-ghost px-4 py-2 rounded-pill fw-bold text-secondary flex-grow-0">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn custom-btn-primary px-5 py-2 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 flex-grow-0"
                                id="submitBtn">
                                <span>Save Changes</span>
                                <i class="bi bi-check2 fs-5"></i>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="submitSpinner"></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Info sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm premium-sidebar-card relative overflow-hidden h-100"
                style="border-radius: 16px;">
                <div
                    class="card-body p-4 p-md-5 d-flex flex-column h-100 justify-content-between text-center bg-light bg-opacity-50">
                    <div>
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center border shadow-sm mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-pencil-square text-primary display-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Editing Policy</h5>
                        <p class="text-muted small lh-lg">
                            You are modifying an existing policy record. Changing the Plan or Coverage Dates after issuance
                            will immediately affect the user's coverage status and dashboard representations.
                        </p>
                    </div>

                    <div class="mt-4 pt-4 border-top text-start">
                        <p class="text-muted small fw-bold text-uppercase mb-2">Original Creation Details</p>
                        <div class="d-flex align-items-center text-muted small mb-1">
                            <i class="bi bi-clock me-2"></i> Created: {{ $policy->created_at->format('M d, Y h:i A') }}
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-arrow-repeat me-2"></i> Last Updated:
                            {{ $policy->updated_at->format('M d, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card Layout */
        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 10px rgba(0, 0, 0, 0.01);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-top-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 50%, #8b5cf6 100%);
            border-radius: 20px 20px 0 0;
        }

        .premium-sidebar-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        /* Inputs */
        .modern-input,
        .modern-select {
            background-color: #f9faff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 0.95rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            appearance: none;
        }

        .modern-input:focus,
        .modern-select:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .modern-input.is-invalid,
        .modern-select.is-invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .modern-input.is-invalid:focus,
        .modern-select.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        .modern-input:focus:not(.is-invalid),
        .modern-select:focus:not(.is-invalid) {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .modern-select {
            cursor: pointer;
        }

        /* Buttons */
        .custom-btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .custom-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
            color: white;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        }

        .custom-btn-ghost {
            background: transparent;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .custom-btn-ghost:hover {
            background: #f1f5f9;
            color: #0f172a !important;
        }

        .hover-elevate {
            transition: all 0.2s ease;
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.4s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pointer-events-none {
            pointer-events: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic Premium Amount Autofill (only updates if explicitly changed)
            const planSelect = document.getElementById('plan_id');
            const premiumInput = document.getElementById('premium_amount');

            planSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');

                if (price) {
                    // Animate value insertion
                    premiumInput.classList.add('bg-success', 'bg-opacity-10', 'text-success');
                    setTimeout(() => {
                        premiumInput.classList.remove('bg-success', 'bg-opacity-10', 'text-success');
                    }, 400);

                    premiumInput.value = price;
                }
            });

            // Status indicator color change
            const statusSelect = document.getElementById('status');
            const statusIcon = document.getElementById('statusIcon').querySelector('span');

            const updateStatusColor = () => {
                statusIcon.className = 'rounded-circle '; // reset
                const val = statusSelect.value;
                if (val === 'active') statusIcon.classList.add('bg-success');
                else if (val === 'pending') statusIcon.classList.add('bg-warning');
                else if (val === 'expired') statusIcon.classList.add('bg-secondary');
                else if (val === 'cancelled') statusIcon.classList.add('bg-danger');
            };

            statusSelect.addEventListener('change', updateStatusColor);
            updateStatusColor(); // Init

            // Loading spinner
            const form = document.getElementById('editPolicyForm');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');

            form.addEventListener('submit', function () {
                if (form.checkValidity()) {
                    submitBtn.classList.add('opacity-75', 'pe-none');
                    spinner.classList.remove('d-none');
                    submitBtn.querySelector('i').classList.add('d-none');
                }
            });
        });
    </script>
@endsection