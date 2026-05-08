@extends('layouts.admin')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="create-icon-badge">
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <div>
                <h2 class="create-page-title mb-1">Create New Insurance Plan</h2>
                <p class="create-page-subtitle mb-0">Add and configure a new insurance product for customers</p>
            </div>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="btn create-back-btn d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Plans
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert create-alert-error d-flex align-items-start gap-3 mb-4 rounded-4 border-0 p-4">
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

    {{-- Main Form Card --}}
    <div class="create-form-card">
        <form method="POST" action="{{ route('admin.plans.store') }}" enctype="multipart/form-data" id="createPlanForm">
            @csrf

            {{-- ── SECTION 1: Basic Information ── --}}
            <div class="create-section">
                <div class="create-section-header">
                    <div class="create-section-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div>
                        <h5 class="create-section-title">Basic Information</h5>
                        <p class="create-section-sub">Category, plan name and cover image</p>
                    </div>
                </div>

                <div class="create-fields-grid">
                    {{-- Category --}}
                    <div class="create-field">
                        <label class="create-label" for="category_id">
                            <i class="bi bi-tag me-1"></i> Insurance Category
                            <span class="create-required">*</span>
                        </label>
                        <select name="category_id" id="category_id" class="create-input create-select" required>
                            <option value="">Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Plan Name --}}
                    <div class="create-field">
                        <label class="create-label" for="name">
                            <i class="bi bi-card-text me-1"></i> Plan Name
                            <span class="create-required">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="create-input"
                            placeholder="e.g. Family Floater Supreme" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Cover Image --}}
                    <div class="create-field create-field-full">
                        <label class="create-label" for="image">
                            <i class="bi bi-image me-1"></i> Cover Image
                        </label>
                        <div class="create-file-zone" id="fileDropZone">
                            <div class="create-file-icon">
                                <i class="bi bi-cloud-arrow-up fs-2"></i>
                            </div>
                            <div class="create-file-text">
                                <span class="fw-semibold text-primary">Click to upload</span> or drag and drop
                            </div>
                            <div class="create-file-hint">PNG, JPG, WEBP up to 5MB</div>
                            <input type="file" name="image" id="image" class="create-file-input" accept="image/*">
                        </div>
                        <div class="create-file-preview d-none" id="filePreview">
                            <img src="" alt="Preview" id="previewImg" class="create-preview-img">
                            <button type="button" class="create-file-clear" id="clearFile">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </div>
                        @error('image')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="create-divider"></div>

            {{-- ── SECTION 2: Financial Details ── --}}
            <div class="create-section">
                <div class="create-section-header">
                    <div class="create-section-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <h5 class="create-section-title">Pricing & Coverage</h5>
                        <p class="create-section-sub">Premium, coverage amount and policy duration</p>
                    </div>
                </div>

                <div class="create-fields-grid create-fields-grid-3">
                    {{-- Base Premium --}}
                    <div class="create-field">
                        <label class="create-label" for="base_premium">
                            <i class="bi bi-cash-stack me-1"></i> Base Premium
                            <span class="create-required">*</span>
                        </label>
                        <div class="create-input-group">
                            <span class="create-input-prefix">$</span>
                            <input type="number" step="0.01" min="0" name="base_premium" id="base_premium"
                                class="create-input create-input-prefixed" placeholder="0.00"
                                value="{{ old('base_premium') }}" required>
                        </div>
                        @error('base_premium')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Coverage Amount --}}
                    <div class="create-field">
                        <label class="create-label" for="coverage_amount">
                            <i class="bi bi-shield-check me-1"></i> Coverage Amount
                            <span class="create-required">*</span>
                        </label>
                        <div class="create-input-group">
                            <span class="create-input-prefix">$</span>
                            <input type="number" step="0.01" min="0" name="coverage_amount" id="coverage_amount"
                                class="create-input create-input-prefixed" placeholder="0.00"
                                value="{{ old('coverage_amount') }}" required>
                        </div>
                        @error('coverage_amount')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <div class="create-field">
                        <label class="create-label" for="duration_years">
                            <i class="bi bi-calendar3 me-1"></i> Duration (Years)
                            <span class="create-required">*</span>
                        </label>
                        <div class="create-input-group">
                            <input type="number" min="1" name="duration_years" id="duration_years"
                                class="create-input create-input-suffixed" placeholder="1"
                                value="{{ old('duration_years') }}" required>
                            <span class="create-input-suffix">yrs</span>
                        </div>
                        @error('duration_years')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="create-divider"></div>

            {{-- ── SECTION 3: Plan Details ── --}}
            <div class="create-section">
                <div class="create-section-header">
                    <div class="create-section-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div>
                        <h5 class="create-section-title">Plan Details</h5>
                        <p class="create-section-sub">Benefits, features and description</p>
                    </div>
                </div>

                <div class="create-fields-stack">
                    {{-- Benefits --}}
                    <div class="create-field">
                        <label class="create-label" for="benefits">
                            <i class="bi bi-check2-circle me-1"></i> Benefits
                            <span class="create-label-hint">(Comma separated)</span>
                        </label>
                        <textarea name="benefits" id="benefits" class="create-input create-textarea" rows="3"
                            placeholder="Life Cover, Tax Benefits, Cashless Hospitalization, etc.">{{ old('benefits') }}</textarea>
                        @error('benefits')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Features --}}
                    <div class="create-field">
                        <label class="create-label" for="features">
                            <i class="bi bi-stars me-1"></i> Features
                            <span class="create-label-hint">(Comma separated)</span>
                        </label>
                        <textarea name="features" id="features" class="create-input create-textarea" rows="3"
                            placeholder="24/7 Support, Online Claims, No Waiting Period, etc.">{{ old('features') }}</textarea>
                        @error('features')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="create-field">
                        <label class="create-label" for="description">
                            <i class="bi bi-file-text me-1"></i> Description
                        </label>
                        <textarea name="description" id="description" class="create-input create-textarea" rows="4"
                            placeholder="Write a detailed description of this insurance plan, what it covers and who it's for...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="create-field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── ACTION BUTTONS ── --}}
            <div class="create-actions">
                <a href="{{ route('admin.plans.index') }}" class="btn create-btn-cancel">
                    <i class="bi bi-x me-1"></i> Cancel
                </a>
                <button type="submit" class="btn create-btn-submit" id="submitBtn">
                    <i class="bi bi-check-lg me-1"></i>
                    <span id="submitText">Create Plan</span>
                </button>
            </div>

        </form>
    </div>

    <style>
        /* ── Variables ── */
        :root {
            --cr-radius: 14px;
            --cr-radius-sm: 10px;
            --cr-border: #e2e8f0;
            --cr-bg: #f8fafc;
            --cr-brand: #4f46e5;
            --cr-brand-light: rgba(79, 70, 229, 0.08);
            --cr-brand-glow: rgba(79, 70, 229, 0.18);
            --cr-text: #0f172a;
            --cr-muted: #64748b;
            --cr-label: #374151;
            --cr-section-gap: 48px;
        }

        /* ── Page Header ── */
        .create-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--cr-brand-light);
            color: var(--cr-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .create-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--cr-text);
            letter-spacing: -0.5px;
        }

        .create-page-subtitle {
            font-size: 0.92rem;
            color: var(--cr-muted);
            font-weight: 400;
        }

        .create-back-btn {
            background: #fff;
            border: 1px solid var(--cr-border);
            color: var(--cr-muted);
            border-radius: var(--cr-radius-sm);
            padding: 0.5rem 1.1rem;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .create-back-btn:hover {
            background: var(--cr-bg);
            color: var(--cr-text);
            border-color: #cbd5e1;
        }

        /* ── Alert ── */
        .create-alert-error {
            background: rgba(220, 53, 69, 0.06);
        }

        /* ── Main Card ── */
        .create-form-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--cr-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05), 0 1px 4px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* ── Section ── */
        .create-section {
            padding: 36px 40px;
        }

        .create-section-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 28px;
        }

        .create-section-icon {
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

        .create-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--cr-text);
            margin: 0 0 2px;
            letter-spacing: -0.2px;
        }

        .create-section-sub {
            font-size: 0.83rem;
            color: var(--cr-muted);
            margin: 0;
        }

        .create-divider {
            height: 1px;
            background: var(--cr-border);
            margin: 0 40px;
        }

        /* ── Grid layouts ── */
        .create-fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .create-fields-grid-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .create-field-full {
            grid-column: 1 / -1;
        }

        .create-fields-stack {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Field & Label ── */
        .create-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .create-label {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--cr-label);
            letter-spacing: 0.1px;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .create-label i {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .create-required {
            color: #ef4444;
            margin-left: 2px;
        }

        .create-label-hint {
            font-weight: 400;
            color: var(--cr-muted);
            margin-left: 4px;
        }

        /* ── Inputs ── */
        .create-input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1.5px solid var(--cr-border);
            border-radius: var(--cr-radius-sm);
            background: var(--cr-bg);
            color: var(--cr-text);
            font-size: 0.92rem;
            font-weight: 400;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .create-input:focus {
            border-color: var(--cr-brand);
            background: #fff;
            box-shadow: 0 0 0 4px var(--cr-brand-glow);
        }

        .create-input::placeholder {
            color: #a9b4c3;
            font-weight: 400;
        }

        .create-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .create-textarea {
            resize: vertical;
            min-height: 90px;
            line-height: 1.6;
        }

        /* ── Input group with prefix/suffix ── */
        .create-input-group {
            display: flex;
            align-items: stretch;
        }

        .create-input-prefix,
        .create-input-suffix {
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
            background: #f0f4ff;
            border: 1.5px solid var(--cr-border);
            color: var(--cr-brand);
            font-weight: 600;
            font-size: 0.88rem;
        }

        .create-input-prefix {
            border-right: none;
            border-radius: var(--cr-radius-sm) 0 0 var(--cr-radius-sm);
        }

        .create-input-suffix {
            border-left: none;
            border-radius: 0 var(--cr-radius-sm) var(--cr-radius-sm) 0;
            color: var(--cr-muted);
        }

        .create-input-prefixed {
            border-radius: 0 var(--cr-radius-sm) var(--cr-radius-sm) 0;
        }

        .create-input-suffixed {
            border-radius: var(--cr-radius-sm) 0 0 var(--cr-radius-sm);
        }

        .create-input-group:focus-within .create-input-prefix,
        .create-input-group:focus-within .create-input-suffix {
            border-color: var(--cr-brand);
        }

        /* ── File Upload Zone ── */
        .create-file-zone {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 32px 24px;
            border: 2px dashed var(--cr-border);
            border-radius: var(--cr-radius);
            background: var(--cr-bg);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .create-file-zone:hover {
            border-color: var(--cr-brand);
            background: var(--cr-brand-light);
        }

        .create-file-zone.drag-over {
            border-color: var(--cr-brand);
            background: var(--cr-brand-light);
        }

        .create-file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .create-file-icon {
            color: var(--cr-muted);
            line-height: 1;
        }

        .create-file-text {
            font-size: 0.9rem;
            color: var(--cr-muted);
        }

        .create-file-hint {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        /* Image Preview */
        .create-file-preview {
            position: relative;
            display: inline-block;
        }

        .create-preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: var(--cr-radius);
            border: 1.5px solid var(--cr-border);
        }

        .create-file-clear {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            transition: background 0.2s;
        }

        .create-file-clear:hover {
            background: rgba(0, 0, 0, 0.75);
        }

        /* ── Field Error ── */
        .create-field-error {
            font-size: 0.78rem;
            color: #ef4444;
            font-weight: 500;
        }

        /* ── Actions Bar ── */
        .create-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding: 24px 40px;
            border-top: 1px solid var(--cr-border);
            background: var(--cr-bg);
        }

        .create-btn-cancel {
            background: #fff;
            border: 1.5px solid var(--cr-border);
            color: var(--cr-muted);
            border-radius: var(--cr-radius-sm);
            padding: 0.62rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .create-btn-cancel:hover {
            background: var(--cr-bg);
            color: var(--cr-text);
            border-color: #cbd5e1;
        }

        .create-btn-submit {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            border: none;
            border-radius: var(--cr-radius-sm);
            padding: 0.62rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            transition: all 0.2s ease;
        }

        .create-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: #fff;
        }

        .create-btn-submit:active {
            transform: translateY(0);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .create-section {
                padding: 24px 20px;
            }

            .create-divider {
                margin: 0 20px;
            }

            .create-actions {
                padding: 20px;
                flex-direction: column-reverse;
            }

            .create-btn-cancel,
            .create-btn-submit {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .create-fields-grid,
            .create-fields-grid-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @push('admin_scripts')
        <script>
            // Image file preview
            const fileInput = document.getElementById('image');
            const fileDropZone = document.getElementById('fileDropZone');
            const filePreview = document.getElementById('filePreview');
            const previewImg = document.getElementById('previewImg');
            const clearFile = document.getElementById('clearFile');

            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewImg.src = e.target.result;
                        fileDropZone.classList.add('d-none');
                        filePreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });

            clearFile.addEventListener('click', function () {
                fileInput.value = '';
                previewImg.src = '';
                fileDropZone.classList.remove('d-none');
                filePreview.classList.add('d-none');
            });

            // Drag-and-drop highlight
            fileDropZone.addEventListener('dragover', e => {
                e.preventDefault();
                fileDropZone.classList.add('drag-over');
            });
            fileDropZone.addEventListener('dragleave', () => fileDropZone.classList.remove('drag-over'));
            fileDropZone.addEventListener('drop', () => fileDropZone.classList.remove('drag-over'));

            // Submit button loading state
            document.getElementById('createPlanForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                const txt = document.getElementById('submitText');
                btn.disabled = true;
                txt.textContent = 'Creating...';
            });
        </script>
    @endpush

@endsection