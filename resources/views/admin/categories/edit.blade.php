@extends('layouts.admin')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="ec-icon-badge">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h2 class="ec-page-title mb-1">{{ $category->name }}</h2>
                <p class="ec-page-subtitle mb-0">Edit and manage this insurance category</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn ec-back-btn d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>

    {{-- ── Validation Errors ── --}}
    @if ($errors->any())
        <div class="alert ec-alert-error d-flex align-items-start gap-3 mb-4 rounded-4 border-0 p-4">
            <i class="bi bi-exclamation-triangle-fill fs-5 mt-1 text-danger"></i>
            <div>
                <div class="fw-semibold text-danger mb-1">Please fix the following errors:</div>
                <ul class="mb-0 ps-3 small text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ── Form Card ── --}}
    <div class="ec-form-card">
        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" id="editCatForm">
            @csrf
            @method('PUT')

            {{-- ── SECTION 1: Basic Information ── --}}
            <div class="ec-section">
                <div class="ec-section-header">
                    <div class="ec-section-icon" style="background: rgba(79,70,229,0.08); color: #4f46e5;">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div>
                        <h5 class="ec-section-title">Basic Information</h5>
                        <p class="ec-section-sub">Category name and description</p>
                    </div>
                </div>

                <div class="ec-fields-stack">
                    {{-- Category Name --}}
                    <div class="ec-field">
                        <label class="ec-label" for="name">
                            <i class="bi bi-tag"></i> Category Name
                            <span class="ec-required">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="ec-input"
                            placeholder="e.g. Life Insurance, Health Insurance..."
                            value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <span class="ec-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="ec-field">
                        <label class="ec-label" for="description">
                            <i class="bi bi-file-text"></i> Description
                        </label>
                        <textarea name="description" id="description" class="ec-input ec-textarea" rows="4"
                            placeholder="Briefly describe what this category covers...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <span class="ec-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="ec-divider"></div>

            {{-- ── SECTION 2: Category Details ── --}}
            <div class="ec-section">
                <div class="ec-section-header">
                    <div class="ec-section-icon" style="background: rgba(16,185,129,0.08); color: #059669;">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="ec-section-title">Category Details</h5>
                        <p class="ec-section-sub">Benefits and premium information</p>
                    </div>
                </div>

                <div class="ec-fields-stack">
                    {{-- Benefits --}}
                    <div class="ec-field">
                        <label class="ec-label" for="benefits">
                            <i class="bi bi-check2-circle"></i> Benefits
                            <span class="ec-label-hint">(What customers gain)</span>
                        </label>
                        <textarea name="benefits" id="benefits" class="ec-input ec-textarea" rows="4"
                            placeholder="e.g. Tax Benefits, Life Cover, Cashless Hospitalization...">{{ old('benefits', $category->benefits) }}</textarea>
                        @error('benefits')
                            <span class="ec-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Premium Info --}}
                    <div class="ec-field">
                        <label class="ec-label" for="premium_info">
                            <i class="bi bi-currency-dollar"></i> Premium Info
                            <span class="ec-label-hint">(Pricing guidance)</span>
                        </label>
                        <textarea name="premium_info" id="premium_info" class="ec-input ec-textarea" rows="4"
                            placeholder="e.g. Starting from ₹500/month, flexible EMI options...">{{ old('premium_info', $category->premium_info) }}</textarea>
                        @error('premium_info')
                            <span class="ec-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="ec-divider"></div>

            {{-- ── SECTION 3: Visibility ── --}}
            <div class="ec-section">
                <div class="ec-section-header">
                    <div class="ec-section-icon" style="background: rgba(245,158,11,0.08); color: #d97706;">
                        <i class="bi bi-toggle-on"></i>
                    </div>
                    <div>
                        <h5 class="ec-section-title">Visibility</h5>
                        <p class="ec-section-sub">Control whether this category is active on the platform</p>
                    </div>
                </div>

                <div class="ec-toggle-row">
                    <div>
                        <div class="ec-toggle-label">Category Status</div>
                        <div class="ec-toggle-hint">
                            Currently:
                            @if($category->is_active)
                                <span class="ec-status-pill ec-status-active">Active</span>
                            @else
                                <span class="ec-status-pill ec-status-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <label class="ec-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <span class="ec-switch-slider"></span>
                    </label>
                </div>

                {{-- Last Updated Meta --}}
                @if($category->updated_at)
                    <p class="ec-meta-text mt-3 mb-0">
                        <i class="bi bi-clock me-1"></i>
                        Last updated {{ $category->updated_at->diffForHumans() }} &middot;
                        {{ $category->updated_at->format('M d, Y \a\t h:i A') }}
                    </p>
                @endif
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="ec-actions">
                <a href="{{ route('admin.categories.index') }}" class="btn ec-btn-cancel">
                    <i class="bi bi-x me-1"></i> Cancel
                </a>
                <button type="submit" class="btn ec-btn-submit" id="submitBtn">
                    <i class="bi bi-check-lg me-1"></i>
                    <span id="submitText">Save Changes</span>
                </button>
            </div>

        </form>
    </div>

    <style>
        :root {
            --ec-brand: #4f46e5;
            --ec-brand-light: rgba(79,70,229,0.08);
            --ec-border: #e2e8f0;
            --ec-bg: #f8fafc;
            --ec-text: #0f172a;
            --ec-muted: #64748b;
            --ec-label: #374151;
            --ec-radius: 14px;
            --ec-radius-sm: 10px;
        }

        /* ── Header ── */
        .ec-icon-badge {
            width: 52px; height: 52px; border-radius: 14px;
            background: var(--ec-brand-light); color: var(--ec-brand);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem; flex-shrink: 0;
        }

        .ec-page-title {
            font-size: 1.75rem; font-weight: 800;
            color: var(--ec-text); letter-spacing: -0.5px;
        }

        .ec-page-subtitle { font-size: 0.92rem; color: var(--ec-muted); }

        .ec-back-btn {
            background: #fff; border: 1px solid var(--ec-border);
            color: var(--ec-muted); border-radius: var(--ec-radius-sm);
            padding: 0.5rem 1.1rem; font-size: 0.88rem; font-weight: 500;
            transition: all 0.2s ease;
        }

        .ec-back-btn:hover {
            background: var(--ec-bg); color: var(--ec-text); border-color: #cbd5e1;
        }

        /* ── Alert ── */
        .ec-alert-error { background: rgba(220,53,69,0.06); }

        /* ── Main Card ── */
        .ec-form-card {
            background: #fff; border-radius: 20px;
            border: 1px solid var(--ec-border);
            box-shadow: 0 4px 24px rgba(0,0,0,0.05), 0 1px 4px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        /* ── Section ── */
        .ec-section { padding: 36px 40px; }

        .ec-section-header {
            display: flex; align-items: flex-start; gap: 14px;
            margin-bottom: 28px;
        }

        .ec-section-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0; margin-top: 2px;
        }

        .ec-section-title {
            font-size: 1rem; font-weight: 700;
            color: var(--ec-text); margin: 0 0 2px; letter-spacing: -0.2px;
        }

        .ec-section-sub { font-size: 0.83rem; color: var(--ec-muted); margin: 0; }

        .ec-divider { height: 1px; background: var(--ec-border); margin: 0 40px; }

        /* ── Fields ── */
        .ec-fields-stack { display: flex; flex-direction: column; gap: 24px; }

        .ec-field { display: flex; flex-direction: column; gap: 6px; }

        .ec-label {
            font-size: 0.83rem; font-weight: 600; color: var(--ec-label);
            display: flex; align-items: center; gap: 6px;
        }

        .ec-label i { font-size: 0.78rem; opacity: 0.7; }
        .ec-required { color: #ef4444; margin-left: 2px; }

        .ec-label-hint {
            font-weight: 400; color: var(--ec-muted);
            margin-left: 2px; font-size: 0.8rem;
        }

        /* ── Inputs ── */
        .ec-input {
            width: 100%; padding: 0.65rem 1rem;
            border: 1.5px solid var(--ec-border);
            border-radius: var(--ec-radius-sm);
            background: var(--ec-bg); color: var(--ec-text);
            font-size: 0.92rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            outline: none;
        }

        .ec-input:focus {
            border-color: var(--ec-brand); background: #fff;
            box-shadow: 0 0 0 4px rgba(79,70,229,0.12);
        }

        .ec-input::placeholder { color: #a9b4c3; }
        .ec-textarea { resize: vertical; min-height: 100px; line-height: 1.65; }

        .ec-field-error { font-size: 0.78rem; color: #ef4444; font-weight: 500; }

        /* ── Toggle Row ── */
        .ec-toggle-row {
            display: flex; align-items: center;
            justify-content: space-between; gap: 24px;
            background: var(--ec-bg); border: 1.5px solid var(--ec-border);
            border-radius: var(--ec-radius); padding: 18px 24px;
        }

        .ec-toggle-label {
            font-size: 0.92rem; font-weight: 600;
            color: var(--ec-text); margin-bottom: 6px;
        }

        .ec-toggle-hint { font-size: 0.82rem; color: var(--ec-muted); display: flex; align-items: center; gap: 6px; }

        .ec-status-pill {
            display: inline-flex; align-items: center;
            padding: 2px 10px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 600;
        }

        .ec-status-active { background: rgba(16,185,129,0.12); color: #059669; }
        .ec-status-inactive { background: rgba(100,116,139,0.1); color: #64748b; }

        /* Toggle switch */
        .ec-switch {
            position: relative; display: inline-block;
            width: 48px; height: 26px; flex-shrink: 0;
        }

        .ec-switch input[type="checkbox"] { opacity: 0; width: 0; height: 0; }
        .ec-switch input[type="hidden"] { display: none; }

        .ec-switch-slider {
            position: absolute; inset: 0;
            background: #cbd5e1; border-radius: 999px;
            cursor: pointer; transition: background 0.2s ease;
        }

        .ec-switch-slider::before {
            content: ''; position: absolute;
            width: 20px; height: 20px; border-radius: 50%;
            background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            left: 3px; top: 3px; transition: transform 0.2s ease;
        }

        .ec-switch input[type="checkbox"]:checked + .ec-switch-slider { background: var(--ec-brand); }
        .ec-switch input[type="checkbox"]:checked + .ec-switch-slider::before { transform: translateX(22px); }

        /* ── Last Updated meta ── */
        .ec-meta-text {
            font-size: 0.78rem; color: #94a3b8; font-weight: 400;
        }

        /* ── Actions ── */
        .ec-actions {
            display: flex; align-items: center; justify-content: flex-end;
            gap: 12px; padding: 24px 40px;
            border-top: 1px solid var(--ec-border);
            background: var(--ec-bg);
        }

        .ec-btn-cancel {
            background: #fff; border: 1.5px solid var(--ec-border);
            color: var(--ec-muted); border-radius: var(--ec-radius-sm);
            padding: 0.62rem 1.5rem; font-size: 0.9rem; font-weight: 500;
            transition: all 0.2s ease;
        }

        .ec-btn-cancel:hover {
            background: var(--ec-bg); color: var(--ec-text); border-color: #cbd5e1;
        }

        .ec-btn-submit {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff; border: none; border-radius: var(--ec-radius-sm);
            padding: 0.62rem 2rem; font-size: 0.9rem; font-weight: 600;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 14px rgba(79,70,229,0.3);
            transition: all 0.2s ease;
        }

        .ec-btn-submit:hover {
            transform: translateY(-1px); color: #fff;
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
        }

        .ec-btn-submit:active { transform: translateY(0); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .ec-section { padding: 24px 20px; }
            .ec-divider { margin: 0 20px; }
            .ec-actions { padding: 20px; flex-direction: column-reverse; }
            .ec-btn-cancel, .ec-btn-submit { width: 100%; text-align: center; }
            .ec-toggle-row { flex-direction: column; align-items: flex-start; }
        }
    </style>

    @push('admin_scripts')
    <script>
        document.getElementById('editCatForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            const txt = document.getElementById('submitText');
            btn.disabled = true;
            txt.textContent = 'Saving...';
        });
    </script>
    @endpush

@endsection