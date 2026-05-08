@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-person-gear fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Edit User Profile</h2>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Update account details and permissions for <span
                        class="fw-semibold text-dark">{{ $user->name }}</span></p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-light border-0 shadow-sm px-4 rounded-pill hover-elevate"
            style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); color: #475569; font-weight: 500;">
            <i class="bi bi-arrow-left me-2"></i> Back to Users
        </a>
    </div>

    <div class="row g-4 mb-5">
        <!-- Main Form Column -->
        <div class="col-lg-8">
            <div class="card border-0 premium-card position-relative h-100">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 p-md-5">

                    @if(session('success'))
                        <div class="alert custom-alert bg-success bg-opacity-10 border-0 text-success rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up"
                            role="alert">
                            <i class="bi bi-check-circle-fill fs-5 me-3"></i>
                            <div class="fw-medium">{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert custom-alert bg-danger bg-opacity-10 border-0 text-danger rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
                            <div class="fw-medium">{{ session('error') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <!-- Section: Basic Info -->
                        <div class="form-section mb-4">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-person-vcard text-primary me-2"></i> Basic Information
                                </h5>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold small text-uppercase text-muted">Full
                                    Name</label>
                                <div class="input-group input-group-modern position-relative">
                                    <span
                                        class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control form-control-lg modern-input pe-4 @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required
                                        style="padding-left: 2.5rem;">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-4 mb-3">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <label for="email" class="form-label fw-bold small text-uppercase text-muted">Email
                                        Address</label>
                                    <div class="input-group input-group-modern position-relative">
                                        <span
                                            class="input-group-text bg-transparent border-0 text-muted ps-3 position-absolute top-50 translate-middle-y z-3">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email"
                                            class="form-control form-control-lg modern-input pe-4 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required
                                            style="padding-left: 2.5rem;">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
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
                                            id="phone" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="10"
                                            pattern="[0-9]{10}" style="padding-left: 2.5rem;" placeholder="1234567890">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1 fw-medium"><i
                                                class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Role Management -->
                        <div class="form-section mt-5 pt-2">
                            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                                <h5 class="section-heading mb-0 text-dark fw-bold d-flex align-items-center">
                                    <i class="bi bi-person-workspace text-primary me-2"></i> Role & Permissions
                                </h5>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-bold small text-uppercase text-muted">Account
                                    Role</label>
                                <div class="position-relative role-selector-wrapper">
                                    <div class="position-absolute ms-3 top-50 translate-middle-y z-3 d-flex align-items-center gap-2 pointer-events-none"
                                        id="roleBadgeContainer">
                                        <span
                                            class="badge rounded-pill px-2 {{ old('role', $user->role) === 'admin' ? 'badge-admin fw-bold' : 'badge-user fw-bold' }}"
                                            id="roleBadge">
                                            {{ ucfirst(old('role', $user->role)) }}
                                        </span>
                                    </div>
                                    <select
                                        class="form-select form-select-lg modern-select @error('role') is-invalid @enderror"
                                        id="role" name="role" required style="padding-left: 4.5rem; font-weight: 500;" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                            Standard User</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            Administrator</option>
                                    </select>
                                    <i
                                        class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y me-3 text-muted pointer-events-none z-3"></i>
                                </div>

                                <div class="helper-box mt-3 p-3 rounded-4 d-flex align-items-start gap-3 border shadow-sm {{ old('role', $user->role) === 'admin' ? 'admin-mode' : '' }}"
                                    id="roleHelperBox">
                                    <i class="bi bi-info-circle-fill mt-1 fs-5 {{ old('role', $user->role) === 'admin' ? 'text-purple' : 'text-primary' }}"
                                        id="roleInfoIcon"></i>
                                    <div class="text-secondary small lh-base" id="roleDescription">
                                        @if(old('role', $user->role) === 'admin')
                                            <strong class="text-dark">Administrators</strong> have full control. They can manage
                                            all users, system settings, and oversee all insurance claims and policies.
                                        @else
                                            <strong class="text-dark">Standard Users</strong> have access to the public facing
                                            site, can view their profile and manage their active insurance policies.
                                        @endif
                                    </div>
                                </div>

                                @if(auth()->id() === $user->id)
                                    <div class="text-warning small mt-2 fw-medium d-flex align-items-center">
                                        <i class="bi bi-shield-exclamation me-1"></i> You cannot change your own role.
                                    </div>
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                @endif

                                @error('role')
                                    <div class="text-danger small mt-1 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top mt-5">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn custom-btn-ghost px-4 py-2 rounded-pill fw-bold text-secondary">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn custom-btn-primary px-5 py-2 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2"
                                id="submitBtn">
                                <span>Save Changes</span>
                                <i class="bi bi-check2-circle"></i>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"
                                    id="submitSpinner"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar / System Info Column -->
        <div class="col-lg-4 d-flex flex-column gap-4">

            <!-- Quick Actions / Meta Data Card -->
            <div class="card border-0 shadow-sm premium-sidebar-card relative overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4 border-bottom bg-light bg-opacity-50">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-info-square text-secondary me-2"></i> System Information
                    </h6>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="mb-3 border-bottom pb-3">
                        <div class="text-muted small fw-semibold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-hash me-1"></i> User ID
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark fs-5 text-monospace user-select-all"
                                id="userIdText">#USER-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <button class="btn btn-sm btn-light border-0 shadow-none text-primary"
                                onclick="copyToClipboard('#USER-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}')"
                                title="Copy ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 border-bottom pb-3">
                        <div class="text-muted small fw-semibold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-calendar-plus me-1"></i> Account Created
                        </div>
                        <div class="fw-bold text-dark">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="text-muted small">{{ $user->created_at->format('h:i A') }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small fw-semibold text-uppercase mb-1 d-flex align-items-center">
                            <i class="bi bi-clock-history me-1"></i> Last Updated
                        </div>
                        <div class="fw-bold text-dark">{{ $user->updated_at->format('M d, Y') }}</div>
                        <div class="text-muted small">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if(auth()->id() !== $user->id)
                <div class="card border border-danger border-opacity-25 shadow-sm premium-danger-card relative overflow-hidden"
                    style="border-radius: 16px; background-color: #fef2f2;">
                    <!-- Danger pulse effect -->
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="d-flex h-3 w-3 position-relative">
                            <span
                                class="animate-ping position-absolute inline-flex h-100 w-100 rounded-circle bg-danger opacity-75"></span>
                            <span class="position-relative inline-flex rounded-circle h-3 w-3 bg-danger"
                                style="width: 10px; height: 10px;"></span>
                        </span>
                    </div>

                    <div class="card-body p-4 p-md-4">
                        <h6 class="fw-bold text-danger mb-3 d-flex align-items-center fs-5">
                            <i class="bi bi-shield-slash-fill me-2 border border-danger p-2 rounded-3 bg-white shadow-sm"></i>
                            Danger Zone
                        </h6>
                        <p class="text-danger text-opacity-75 small mb-4 fw-medium lh-base">
                            Deleting this user will permanently remove their profile, policies, and claims from the system.
                            <strong>This action cannot be reversed.</strong>
                        </p>

                        <div class="mb-4">
                            <label for="deleteConfirmation" class="form-label fw-bold text-danger small text-uppercase">Type
                                "DELETE" to confirm</label>
                            <input type="text"
                                class="form-control bg-white border-danger border-opacity-25 text-danger fw-bold text-center form-control-lg"
                                id="deleteConfirmation" placeholder="DELETE" autocomplete="off">
                        </div>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-outline-danger px-4 rounded-pill w-100 fw-bold custom-btn-danger" id="deleteBtn"
                                disabled>
                                <i class="bi bi-trash3-fill me-1"></i> Permanently Delete
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Active User Warning (Can't delete self) -->
                <div class="card border border-success border-opacity-25 shadow-sm overflow-hidden"
                    style="border-radius: 16px; background-color: #f0fdf4;">
                    <div class="card-body p-4 text-center">
                        <div
                            class="bg-white border border-success d-inline-flex p-3 rounded-circle mb-3 shadow-sm text-success">
                            <i class="bi bi-person-check-fill fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-success mb-2">Current Active Session</h6>
                        <p class="text-success text-opacity-75 small mb-0 fw-medium">
                            This is your own account. You cannot change your role or delete your profile from the admin view.
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Toast for Copy -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="copyToast" class="toast align-items-center text-bg-dark border-0 rounded-pill px-2" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-medium" id="copyToastBody">
                    <i class="bi bi-check2-circle text-success me-2 fs-5"></i> Copied to clipboard!
                </div>
            </div>
        </div>
    </div>

    <!-- Page Specific Styles -->
    <style>
        /* Card Layout */
        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 10px rgba(0, 0, 0, 0.01);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .premium-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
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
        }

        .modern-input:focus,
        .modern-select:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        /* Validation State overrides */
        .modern-input.is-invalid {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .modern-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        .modern-input:focus:not(.is-invalid) {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .input-group-modern:focus-within .input-group-text i {
            color: #6366f1 !important;
            transition: color 0.3s ease;
        }

        .modern-select {
            appearance: none;
            cursor: pointer;
        }

        .modern-select:disabled {
            background-color: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
            opacity: 0.8;
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

        /* Danger Zone */
        .premium-danger-card {
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .premium-danger-card:hover {
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.2) !important;
            border-color: rgba(239, 68, 68, 0.5) !important;
        }

        .custom-btn-danger:not(:disabled):hover {
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
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

        .text-purple {
            color: #8b5cf6 !important;
        }

        .badge-user {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .badge-admin {
            background-color: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
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

        .animate-ping {
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .pointer-events-none {
            pointer-events: none;
        }
    </style>

    <!-- Page Specific Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Role Management Interactive Preview
            const roleSelect = document.getElementById('role');
            const roleDesc = document.getElementById('roleDescription');
            const roleBadge = document.getElementById('roleBadge');
            const roleHelperBox = document.getElementById('roleHelperBox');
            const roleInfoIcon = document.getElementById('roleInfoIcon');

            if (roleSelect && !roleSelect.disabled) {
                roleSelect.addEventListener('change', function () {
                    const isAdmin = this.value === 'admin';

                    if (isAdmin) {
                        roleDesc.innerHTML = '<strong class="text-dark">Administrators</strong> have full control. They can manage all users, system settings, and oversee all insurance claims and policies.';
                        roleBadge.innerText = 'Admin';
                        roleBadge.className = 'badge rounded-pill fw-bold badge-admin px-2';
                        roleHelperBox.classList.add('admin-mode');
                        roleInfoIcon.classList.remove('text-primary');
                        roleInfoIcon.classList.add('text-purple');
                    } else {
                        roleDesc.innerHTML = '<strong class="text-dark">Standard Users</strong> have access to the public facing site, can view their profile and manage their active insurance policies.';
                        roleBadge.innerText = 'User';
                        roleBadge.className = 'badge rounded-pill fw-bold badge-user px-2';
                        roleHelperBox.classList.remove('admin-mode');
                        roleInfoIcon.classList.add('text-primary');
                        roleInfoIcon.classList.remove('text-purple');
                    }
                });
            }

            // Danger Zone "DELETE" requirement logic
            const deleteInput = document.getElementById('deleteConfirmation');
            const deleteBtn = document.getElementById('deleteBtn');
            const deleteForm = document.getElementById('deleteForm');

            if (deleteInput && deleteBtn && deleteForm) {
                deleteInput.addEventListener('input', function () {
                    if (this.value === 'DELETE') {
                        deleteBtn.removeAttribute('disabled');
                        deleteBtn.classList.remove('btn-outline-danger');
                        deleteBtn.classList.add('btn-danger'); // Become solid red
                    } else {
                        deleteBtn.setAttribute('disabled', 'disabled');
                        deleteBtn.classList.add('btn-outline-danger');
                        deleteBtn.classList.remove('btn-danger');
                    }
                });

                // Prevent accidentally submitting if it isn't solid
                deleteForm.addEventListener('submit', function (e) {
                    if (deleteInput.value !== 'DELETE') {
                        e.preventDefault();
                    } else {
                        // Double check with browser alert
                        if (!confirm('Final Warning: This is a destructive action. Are you sure you want to permanently delete this user?')) {
                            e.preventDefault();
                        }
                    }
                });
            }

            // Loading Spinner on Form Edit Submit
            const editForm = document.getElementById('editUserForm');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');

            if (editForm && submitBtn && spinner) {
                editForm.addEventListener('submit', function (e) {
                    if (editForm.checkValidity()) {
                        submitBtn.classList.add('opacity-75', 'pe-none');
                        spinner.classList.remove('d-none');
                        submitBtn.querySelector('i').classList.add('d-none');
                        submitBtn.style.minWidth = submitBtn.offsetWidth + 'px'; // Prevent collapsing
                    }
                });
            }

            // Client side validation styling enhancer
            const inputs = document.querySelectorAll('.modern-input');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    // Remove is-invalid class as soon as they start typing, assuming it might be valid now
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');

                        // Try to find the nearest error text and hide it
                        const errorFeedback = this.closest('div').nextElementSibling;
                        if (errorFeedback && errorFeedback.classList.contains('text-danger')) {
                            errorFeedback.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Copy to clipboard functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                const toastEl = document.getElementById('copyToast');
                const toast = new bootstrap.Toast(toastEl, { delay: 2000 });
                toast.show();
            }, function (err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection