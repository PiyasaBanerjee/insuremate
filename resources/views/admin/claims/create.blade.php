@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-file-earmark-plus fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">File New Claim</h2>
                <div class="d-flex align-items-center gap-2 mt-1">
                    <span class="text-muted small">Initialize and record a new insurance claim manually</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.claims.index') }}" class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
            style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
            <i class="bi bi-arrow-left me-2"></i> Cancel
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

                    <form action="{{ route('admin.claims.store') }}" method="POST" id="createClaimForm">
                        @csrf

                        <!-- Identifier Details -->
                        <div class="form-section mb-5">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-diagram-3 text-primary me-2"></i> Policy Association
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
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="policy_id" class="form-label fw-bold small text-uppercase text-muted">Target
                                        Policy</label>
                                    <div class="position-relative">
                                        <span
                                            class="position-absolute top-50 translate-middle-y ms-3 z-3 text-muted pointer-events-none">
                                            <i class="bi bi-shield-check"></i>
                                        </span>
                                        <select
                                            class="form-select form-select-lg modern-select @error('policy_id') is-invalid @enderror"
                                            id="policy_id" name="policy_id" required style="padding-left: 2.5rem;" disabled>
                                            <option value="">Select user first...</option>
                                            <!-- Will be populated via JS -->
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial & Status -->
                        <div class="form-section mb-5 pt-2">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-clipboard-data text-primary me-2"></i> Financial parameters
                                </h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="claim_amount"
                                        class="form-label fw-bold small text-uppercase text-muted">Claim Value ($)</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control form-control-lg modern-input pe-4 @error('claim_amount') is-invalid @enderror"
                                            id="claim_amount" name="claim_amount" value="{{ old('claim_amount') }}" required
                                            style="padding-left: 2.5rem;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold small text-uppercase text-muted">Initial
                                        Status</label>
                                    <div class="position-relative">
                                        <span
                                            class="position-absolute ms-3 top-50 translate-middle-y z-3 pointer-events-none d-flex"
                                            id="statusIcon">
                                            <span class="rounded-circle bg-warning"
                                                style="width: 10px; height: 10px;"></span>
                                        </span>
                                        <select
                                            class="form-select form-select-lg modern-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required style="padding-left: 2.5rem;">
                                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending Assessment</option>
                                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Rapid
                                                Approve</option>
                                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                                Auto-Reject</option>
                                        </select>
                                        <i
                                            class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <label for="description"
                                        class="form-label fw-bold small text-uppercase text-muted">Claim Description</label>
                                    <textarea class="form-control modern-input @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="4" required
                                        placeholder="Describe the incident, findings, or notes regarding this claim filing...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top mt-5">
                            <button type="submit"
                                class="btn custom-btn-primary px-5 py-2 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 flex-grow-0"
                                id="submitBtn">
                                <span>Initialize Claim Record</span>
                                <i class="bi bi-arrow-right fs-5"></i>
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
                            <i class="bi bi-clipboard2-plus text-primary display-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Claim Generation</h5>
                        <p class="text-muted small lh-lg">
                            You are explicitly bypassing the client submission portal to generate a claim record. The Claim
                            ID will be automatically generated upon successful initialization.
                        </p>
                    </div>

                    <div class="mt-4 pt-4 border-top text-start">
                        <p class="text-muted small fw-bold text-uppercase mb-2"><i
                                class="bi bi-shield-exclamation me-1"></i> Operations Warning</p>
                        <p class="text-muted small mb-0">By manually entering a claim, you assert that external validation
                            processes have been executed. Audit logs will tie this claim generation to your administrator
                            account.</p>
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

        .modern-select:disabled {
            background-color: #f1f5f9;
            cursor: not-allowed;
            opacity: 0.7;
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
            // Inject JSON data for policies
            const policiesData = @json($policies);

            const userSelect = document.getElementById('user_id');
            const policySelect = document.getElementById('policy_id');
            const oldPolicyId = "{{ old('policy_id') }}";

            // Logic to link User Select -> Policy Select
            const populatePolicies = (userId) => {
                policySelect.innerHTML = '<option value="">Select target policy...</option>';

                if (!userId) {
                    policySelect.disabled = true;
                    return;
                }

                // Filter policies specific to selected user that are NOT cancelled
                const userPolicies = policiesData.filter(p => p.user_id == userId && p.status !== 'cancelled');

                if (userPolicies.length === 0) {
                    policySelect.innerHTML = '<option value="">User has no active policies</option>';
                    policySelect.disabled = true;
                    return;
                }

                policySelect.disabled = false;

                userPolicies.forEach(policy => {
                    const opt = document.createElement('option');
                    opt.value = policy.id;
                    opt.textContent = `POL-${String(policy.id).padStart(5, '0')} (${policy.status.toUpperCase()})`;
                    if (oldPolicyId && oldPolicyId == policy.id) {
                        opt.selected = true;
                    }
                    policySelect.appendChild(opt);
                });
            };

            userSelect.addEventListener('change', (e) => populatePolicies(e.target.value));

            // Trigger on load for validation failures
            if (userSelect.value) {
                populatePolicies(userSelect.value);
            }

            // Status indicator color change
            const statusSelect = document.getElementById('status');
            const statusIcon = document.getElementById('statusIcon').querySelector('span');

            const updateStatusColor = () => {
                statusIcon.className = 'rounded-circle '; // reset
                const val = statusSelect.value;
                if (val === 'approved') statusIcon.classList.add('bg-success');
                else if (val === 'pending') statusIcon.classList.add('bg-warning');
                else if (val === 'rejected') statusIcon.classList.add('bg-danger');
            };

            statusSelect.addEventListener('change', updateStatusColor);
            updateStatusColor(); // Init

            // Loading spinner
            const form = document.getElementById('createClaimForm');
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