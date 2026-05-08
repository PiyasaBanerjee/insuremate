@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-person-plus-fill fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Add New User</h2>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Create a new user account and configure permissions.
                </p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
            style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
            <i class="bi bi-arrow-left me-2"></i> Back to Users
        </a>
    </div>

    <!-- Enhanced form container -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card border-0 premium-card position-relative form-wrapper mb-5">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 p-md-5">

                    @if(session('error'))
                        <div class="alert alert-danger custom-alert bg-danger bg-opacity-10 border-0 text-danger rounded-4 d-flex align-items-center mb-4 p-3 ps-4"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
                            <div class="fw-medium">{{ session('error') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf

                        <!-- Section: Basic Info -->
                        <div class="form-section mb-4">
                            <h5 class="section-heading mb-4 text-dark fw-bold d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i> Basic Information
                            </h5>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold small text-uppercase text-muted">Full
                                        Name</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control form-control-lg modern-input pe-4 @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required
                                            style="padding-left: 2.5rem;" autofocus>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold small text-uppercase text-muted">Email
                                        Address</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email"
                                            class="form-control form-control-lg modern-input pe-4 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="john@example.com" required style="padding-left: 2.5rem;">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold small text-uppercase text-muted">Phone
                                        Number</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control form-control-lg modern-input pe-4 @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}" placeholder="1234567890"
                                            maxlength="10" pattern="[0-9]{10}" style="padding-left: 2.5rem;">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-4">

                        <!-- Section: Security -->
                        <div class="form-section mb-4">
                            <h5 class="section-heading mb-4 text-dark fw-bold d-flex align-items-center">
                                <i class="bi bi-shield-lock text-primary me-2"></i> Security Specifications
                            </h5>

                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <label for="password"
                                        class="form-label fw-bold small text-uppercase text-muted">Password</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control form-control-lg modern-input pe-5 @error('password') is-invalid @enderror"
                                            id="password" name="password" required style="padding-left: 2.5rem;"
                                            placeholder="Create strong password">
                                        <button
                                            class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y z-3 text-decoration-none shadow-none"
                                            type="button" id="togglePasswordBtn">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <!-- Password strength line -->
                                    <div class="progress mt-2 rounded-pill bg-light" style="height: 4px; display: none;"
                                        id="passwordStrengthContainer">
                                        <div class="progress-bar rounded-pill" role="progressbar"
                                            style="width: 0%; transition: width 0.3s ease, background-color 0.3s ease;"
                                            id="passwordStrengthBar" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block" id="passwordFeedback">Must be at least 8
                                        characters</small>
                                    @error('password')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation"
                                        class="form-label fw-bold small text-uppercase text-muted">Confirm Password</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-shield-check"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-lg modern-input pe-4"
                                            id="password_confirmation" name="password_confirmation" required
                                            style="padding-left: 2.5rem;" placeholder="Repeat password">
                                        <span
                                            class="position-absolute end-0 top-50 translate-middle-y pe-3 z-3 text-success d-none"
                                            id="matchIndicator">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-4">

                        <!-- Section: Role Management -->
                        <div class="form-section mb-5">
                            <h5 class="section-heading mb-4 text-dark fw-bold d-flex align-items-center">
                                <i class="bi bi-person-workspace text-primary me-2"></i> Role Management
                            </h5>

                            <div class="mb-3">
                                <label for="role" class="form-label fw-bold small text-uppercase text-muted">System Access
                                    Level</label>
                                <div class="position-relative role-selector-wrapper">
                                    <div class="position-absolute ms-3 top-50 translate-middle-y z-3 d-flex align-items-center gap-2 pointer-events-none"
                                        id="roleBadgeContainer">
                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-2"
                                            id="roleBadge">User</span>
                                    </div>
                                    <select
                                        class="form-select form-select-lg modern-select @error('role') is-invalid @enderror"
                                        id="role" name="role" required style="padding-left: 4.5rem; font-weight: 500;">
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Standard User
                                        </option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator
                                        </option>
                                    </select>
                                    <i
                                        class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                </div>

                                <div class="helper-box mt-3 p-3 rounded-4 d-flex align-items-start gap-3 border shadow-sm"
                                    id="roleHelperBox">
                                    <i class="bi bi-info-circle-fill text-primary mt-1 fs-5" id="roleInfoIcon"></i>
                                    <div class="text-secondary small lh-base" id="roleDescription">
                                        <strong class="text-dark">Standard Users</strong> have access to the public facing
                                        site, can view their profile and manage their active insurance policies.
                                    </div>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 pb-2 border-top border-light mt-4">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn custom-btn-ghost px-4 py-2 mt-1 rounded-pill fw-bold text-secondary">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn custom-btn-primary px-5 py-2 mt-1 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2"
                                id="submitBtn">
                                <span>Create User</span>
                                <i class="bi bi-person-plus-fill"></i>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="submitSpinner"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Specific Styles -->
    <style>
        /* Card & Layout */
        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 10px rgba(0, 0, 0, 0.01);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .premium-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .card-top-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 50%, #8b5cf6 100%);
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
        }

        .modern-input:focus,
        .modern-select:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .modern-input::placeholder {
            color: #94a3b8;
        }

        .modern-select {
            appearance: none;
            cursor: pointer;
        }

        .input-group-modern:focus-within .input-group-text i {
            color: #6366f1 !important;
            transition: color 0.3s ease;
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

        .custom-btn-primary:active {
            transform: translateY(0);
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

        /* Helper Box & Badges */
        .helper-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .helper-box.admin-mode {
            background-color: #f5f3ff;
            border-color: #ede9fe;
        }

        .helper-box.admin-mode i {
            color: #8b5cf6 !important;
        }

        .badge-user {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .badge-admin {
            background-color: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        /* Section Heading */
        .section-heading {
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }

        .pointer-events-none {
            pointer-events: none;
        }
    </style>

    <!-- Page Specific Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password Toggle
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const toggleIcon = togglePasswordBtn.querySelector('i');

            togglePasswordBtn.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });

            // Password Strength & Match
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const strengthContainer = document.getElementById('passwordStrengthContainer');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const feedbackText = document.getElementById('passwordFeedback');
            const matchIndicator = document.getElementById('matchIndicator');

            passwordInput.addEventListener('input', function () {
                const val = this.value;
                if (val.length > 0) {
                    strengthContainer.style.display = 'flex';
                } else {
                    strengthContainer.style.display = 'none';
                    feedbackText.innerText = 'Must be at least 8 characters';
                    feedbackText.className = 'text-muted mt-1 d-block small';
                    checkPasswordMatch();
                    return;
                }

                let strength = 0;
                if (val.length >= 8) strength += 25;
                if (val.match(/[A-Z]/)) strength += 25;
                if (val.match(/[0-9]/)) strength += 25;
                if (val.match(/[^A-Za-z0-9]/)) strength += 25;

                strengthBar.style.width = strength + '%';

                if (strength <= 25) {
                    strengthBar.className = 'progress-bar bg-danger';
                    feedbackText.innerText = 'Weak password';
                    feedbackText.className = 'text-danger mt-1 d-block small fw-medium';
                } else if (strength <= 50) {
                    strengthBar.className = 'progress-bar bg-warning';
                    feedbackText.innerText = 'Moderate password';
                    feedbackText.className = 'text-warning mt-1 d-block small fw-medium text-dark';
                } else if (strength <= 75) {
                    strengthBar.className = 'progress-bar bg-info';
                    feedbackText.innerText = 'Good password';
                    feedbackText.className = 'text-info mt-1 d-block small fw-medium';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    feedbackText.innerText = 'Strong password';
                    feedbackText.className = 'text-success mt-1 d-block small fw-medium';
                }

                checkPasswordMatch();
            });

            passwordConfirmInput.addEventListener('input', checkPasswordMatch);

            function checkPasswordMatch() {
                if (passwordConfirmInput.value.length > 0 && passwordInput.value === passwordConfirmInput.value) {
                    matchIndicator.classList.remove('d-none');
                } else {
                    matchIndicator.classList.add('d-none');
                }
            }

            // Role Description Update
            const roleSelect = document.getElementById('role');
            const roleDesc = document.getElementById('roleDescription');
            const roleBadge = document.getElementById('roleBadge');
            const roleHelperBox = document.getElementById('roleHelperBox');

            roleSelect.addEventListener('change', function () {
                if (this.value === 'admin') {
                    roleDesc.innerHTML = '<strong class="text-dark">Administrators</strong> have full control. They can manage all users, system settings, and oversee all insurance claims and policies.';
                    roleBadge.innerText = 'Admin';
                    roleBadge.className = 'badge rounded-pill fw-bold badge-admin px-2';
                    roleHelperBox.classList.add('admin-mode');
                } else {
                    roleDesc.innerHTML = '<strong class="text-dark">Standard Users</strong> have access to the public facing site, can view their profile and manage their active insurance policies.';
                    roleBadge.innerText = 'User';
                    roleBadge.className = 'badge rounded-pill fw-bold badge-user px-2';
                    roleHelperBox.classList.remove('admin-mode');
                }
            });

            // Trigger once on load to set initial state
            roleSelect.dispatchEvent(new Event('change'));

            // Loading Spinner on Submit
            const form = document.getElementById('createUserForm');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');

            form.addEventListener('submit', function (e) {
                if (form.checkValidity()) {
                    submitBtn.classList.add('opacity-75', 'pe-none');
                    spinner.classList.remove('d-none');
                    submitBtn.querySelector('i').classList.add('d-none');
                    submitBtn.style.minWidth = submitBtn.offsetWidth + 'px';
                }
            });
        });
    </script>
@endsection