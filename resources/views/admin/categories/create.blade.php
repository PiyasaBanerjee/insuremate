@extends('layouts.admin')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="cc-icon-badge">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>
            <div>
                <h2 class="cc-page-title mb-1">Create New Category</h2>
                <p class="cc-page-subtitle mb-0">Add and configure a new insurance category</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn cc-back-btn d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>

    {{-- ── Validation Errors ── --}}
    @if ($errors->any())
        <div class="alert cc-alert-error d-flex align-items-start gap-3 mb-4 rounded-4 border-0 p-4">
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
    <div class="cc-form-card">
        <form method="POST" action="{{ route('admin.categories.store') }}" id="createCatForm">
            @csrf

            {{-- ── SECTION 1: Basic Information ── --}}
            <div class="cc-section">
                <div class="cc-section-header">
                    <div class="cc-section-icon" style="background: rgba(79,70,229,0.08); color: #4f46e5;">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div>
                        <h5 class="cc-section-title">Basic Information</h5>
                        <p class="cc-section-sub">Category name and description</p>
                    </div>
                </div>

                <div class="cc-fields-stack">
                    {{-- Category Name --}}
                    <div class="cc-field">
                        <label class="cc-label" for="name">
                            <i class="bi bi-tag"></i>
                            Category Name
                            <span class="cc-required">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="cc-input"
                            placeholder="e.g. Life Insurance, Health Insurance..." value="{{ old('name') }}" required>
                        @error('name')
                            <span class="cc-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="cc-field">
                        <label class="cc-label" for="description">
                            <i class="bi bi-file-text"></i>
                            Description
                        </label>
                        <textarea name="description" id="description" class="cc-input cc-textarea" rows="4"
                            placeholder="Briefly describe what this insurance category covers and who it's designed for...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="cc-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="cc-divider"></div>

            {{-- ── SECTION 2: Details ── --}}
            <div class="cc-section">
                <div class="cc-section-header">
                    <div class="cc-section-icon" style="background: rgba(16,185,129,0.08); color: #059669;">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="cc-section-title">Category Details</h5>
                        <p class="cc-section-sub">Benefits and premium information for this category</p>
                    </div>
                </div>

                <div class="cc-fields-stack">
                    {{-- Benefits --}}
                    <div class="cc-field">
                        <label class="cc-label" for="benefits">
                            <i class="bi bi-check2-circle"></i>
                            Benefits
                            <span class="cc-label-hint">(What customers gain)</span>
                        </label>
                        <textarea name="benefits" id="benefits" class="cc-input cc-textarea" rows="4"
                            placeholder="e.g. Tax Benefits, Life Cover, Cashless Hospitalization, Accidental Coverage...">{{ old('benefits') }}</textarea>
                        @error('benefits')
                            <span class="cc-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Premium Info --}}
                    <div class="cc-field">
                        <label class="cc-label" for="premium_info">
                            <i class="bi bi-currency-dollar"></i>
                            Premium Info
                            <span class="cc-label-hint">(Pricing guidance)</span>
                        </label>
                        <textarea name="premium_info" id="premium_info" class="cc-input cc-textarea" rows="4"
                            placeholder="e.g. Starting from ₹500/month, Annual plans available, flexible EMI options...">{{ old('premium_info') }}</textarea>
                        @error('premium_info')
                            <span class="cc-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="cc-divider"></div>

            {{-- ── SECTION 3: Status ── --}}
            <div class="cc-section">
                <div class="cc-section-header">
                    <div class="cc-section-icon" style="background: rgba(245,158,11,0.08); color: #d97706;">
                        <i class="bi bi-toggle-on"></i>
                    </div>
                    <div>
                        <h5 class="cc-section-title">Visibility</h5>
                        <p class="cc-section-sub">Control whether this category is active on the platform</p>
                    </div>
                </div>

                <div class="cc-toggle-row">
                    <div>
                        <div class="cc-toggle-label">Category Status</div>
                        <div class="cc-toggle-hint">Active categories are visible to customers and can have plans assigned.
                        </div>
                    </div>
                    <label class="cc-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <span class="cc-switch-slider"></span>
                    </label>
                </div>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="cc-actions">
                <a href="{{ route('admin.categories.index') }}" class="btn cc-btn-cancel">
                    <i class="bi bi-x me-1"></i> Cancel
                </a>
                <button type="submit" class="btn cc-btn-submit" id="submitBtn">
                    <i class="bi bi-check-lg me-1"></i>
                    <span id="submitText">Create Category</span>
                </button>
            </div>

        </form>
    </div>

    <style>
        :root {
            --cc-brand: #4f46e5;
            --cc-brand-light: rgba(79, 70, 229, 0.08);
            --cc-border: #e2e8f0;
            --cc-bg: #f8fafc;
            --cc-text: #0f172a;
            --cc-muted: #64748b;
            --cc-label: #374151;
            --cc-radius: 14px;
            --cc-radius-sm: 10px;
        }

        /* ── Header ── */
        .cc-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--cc-brand-light);
            color: var(--cc-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .cc-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--cc-text);
            letter-spacing: -0.5px;
        }

        .cc-page-subtitle {
            font-size: 0.92rem;
            color: var(--cc-muted);
        }

        .cc-back-btn {
            background: #fff;
            border: 1px solid var(--cc-border);
            color: var(--cc-muted);
            border-radius: var(--cc-radius-sm);
            padding: 0.5rem 1.1rem;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .cc-back-btn:hover {
            background: var(--cc-bg);
            color: var(--cc-text);
            border-color: #cbd5e1;
        }

        /* ── Alert ── */
        .cc-alert-error {
            background: rgba(220, 53, 69, 0.06);
        }

        /* ── Main Card ── */
        .cc-form-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--cc-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05), 0 1px 4px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* ── Section ── */
        .cc-section {
            padding: 36px 40px;
        }

        .cc-section-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 28px;
        }

        .cc-section-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .cc-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--cc-text);
            margin: 0 0 2px;
            letter-spacing: -0.2px;
        }

        .cc-section-sub {
            font-size: 0.83rem;
            color: var(--cc-muted);
            margin: 0;
        }

        .cc-divider {
            height: 1px;
            background: var(--cc-border);
            margin: 0 40px;
        }

        /* ── Fields ── */
        .cc-fields-stack {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .cc-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .cc-label {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--cc-label);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cc-label i {
            font-size: 0.78rem;
            opacity: 0.7;
        }

        .cc-required {
            color: #ef4444;
            margin-left: 2px;
        }

        .cc-label-hint {
            font-weight: 400;
            color: var(--cc-muted);
            margin-left: 2px;
            font-size: 0.8rem;
        }

        /* ── Inputs ── */
        .cc-input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1.5px solid var(--cc-border);
            border-radius: var(--cc-radius-sm);
            background: var(--cc-bg);
            color: var(--cc-text);
            font-size: 0.92rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            outline: none;
        }

        .cc-input:focus {
            border-color: var(--cc-brand);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .cc-input::placeholder {
            color: #a9b4c3;
        }

        .cc-textarea {
            resize: vertical;
            min-height: 100px;
            line-height: 1.65;
        }

        /* ── Field Error ── */
        .cc-field-error {
            font-size: 0.78rem;
            color: #ef4444;
            font-weight: 500;
        }

        /* ── Toggle Row ── */
        .cc-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            background: var(--cc-bg);
            border: 1.5px solid var(--cc-border);
            border-radius: var(--cc-radius);
            padding: 18px 24px;
        }

        .cc-toggle-label {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--cc-text);
            margin-bottom: 4px;
        }

        .cc-toggle-hint {
            font-size: 0.82rem;
            color: var(--cc-muted);
        }

        /* Toggle switch */
        .cc-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .cc-switch input[type="checkbox"] {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .cc-switch input[type="hidden"] {
            display: none;
        }

        .cc-switch-slider {
            position: absolute;
            inset: 0;
            background: #cbd5e1;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .cc-switch-slider::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            left: 3px;
            top: 3px;
            transition: transform 0.2s ease;
        }

        .cc-switch input[type="checkbox"]:checked+.cc-switch-slider {
            background: var(--cc-brand);
        }

        .cc-switch input[type="checkbox"]:checked+.cc-switch-slider::before {
            transform: translateX(22px);
        }

        /* ── Actions ── */
        .cc-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding: 24px 40px;
            border-top: 1px solid var(--cc-border);
            background: var(--cc-bg);
        }

        .cc-btn-cancel {
            background: #fff;
            border: 1.5px solid var(--cc-border);
            color: var(--cc-muted);
            border-radius: var(--cc-radius-sm);
            padding: 0.62rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .cc-btn-cancel:hover {
            background: var(--cc-bg);
            color: var(--cc-text);
            border-color: #cbd5e1;
        }

        .cc-btn-submit {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            border: none;
            border-radius: var(--cc-radius-sm);
            padding: 0.62rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
        }

        .cc-btn-submit:hover {
            transform: translateY(-1px);
            color: #fff;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .cc-btn-submit:active {
            transform: translateY(0);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .cc-section {
                padding: 24px 20px;
            }

            .cc-divider {
                margin: 0 20px;
            }

            .cc-actions {
                padding: 20px;
                flex-direction: column-reverse;
            }

            .cc-btn-cancel,
            .cc-btn-submit {
                width: 100%;
                text-align: center;
            }

            .cc-toggle-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    @push('admin_scripts')
        <script>
            // Submit loading state
            document.getElementById('createCatForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                const txt = document.getElementById('submitText');
                btn.disabled = true;
                txt.textContent = 'Creating...';
            });
        </script>
    @endpush

@endsection