@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.plans.index') }}"
                    class="text-muted text-decoration-none hover-primary small fw-medium transition-all">
                    <i class="bi bi-arrow-left me-1"></i> Back to Plans
                </a>
            </div>
            <h2 class="fw-bold text-dark fs-3 mb-1" style="letter-spacing: -0.5px;">Edit Insurance Plan</h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Modify plan details, pricing, and coverage benefits</p>
        </div>
        <div class="d-flex gap-3 align-items-center">

            <button type="submit" form="editPlanForm"
                class="btn btn-primary premium-btn shadow-sm rounded-pill px-4 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-floppy-fill"></i> Save Changes
            </button>
        </div>
    </div>

    <form id="editPlanForm" method="POST" action="{{ route('admin.plans.update', $plan->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-5 pb-5">
            <!-- LEFT COLUMN: Main Configuration -->
            <div class="col-lg-8">

                <!-- SECTION 1: Basic Information -->
                <div class="card border-0 shadow-sm premium-card rounded-4 mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle-fill text-primary"></i> Basic Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control premium-input py-2"
                                    value="{{ old('name', $plan->name) }}" placeholder="e.g. LifeGuard Plus" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select premium-input py-2" required>
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $plan->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Product Description</label>
                                <textarea name="description" class="form-control premium-input" rows="4"
                                    placeholder="Briefly describe what this insurance plan covers...">{{ old('description', $plan->description) }}</textarea>
                                <div class="text-end mt-1 text-muted small"><span id="charCount">0</span>/500 characters
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Pricing & Coverage -->
                <div class="card border-0 shadow-sm premium-card rounded-4 mb-4">
                    <div
                        class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-tag-fill text-success"></i> Pricing & Coverage Limits
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Base Premium <span class="text-danger">*</span></label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text bg-light border-end-0 fw-bold text-muted">$</span>
                                    <input type="number" step="0.01" name="base_premium"
                                        class="form-control border-start-0 ps-0 text-end fw-bold text-indigo"
                                        value="{{ old('base_premium', $plan->base_premium) }}" required>
                                </div>
                                <div class="form-text text-muted small mt-2"><i class="bi bi-info-circle me-1"></i>Annual
                                    recurring base cost to the client.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Max Coverage Amount <span
                                        class="text-danger">*</span></label>
                                <div class="input-group premium-input-group">
                                    <span class="input-group-text bg-light border-end-0 fw-bold text-muted">$</span>
                                    <input type="number" step="0.01" name="coverage_amount"
                                        class="form-control border-start-0 ps-0 text-end fw-bold"
                                        value="{{ old('coverage_amount', $plan->coverage_amount) }}" required>
                                </div>
                                <div class="form-text text-muted small mt-2">Maximum payout limit for this policy class.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase"
                                    style="letter-spacing: 0.5px;">Term Duration <span class="text-danger">*</span></label>
                                <div class="input-group premium-input-group">
                                    <input type="number" name="duration_years"
                                        class="form-control border-end-0 text-end fw-bold"
                                        value="{{ old('duration_years', $plan->duration_years) }}" required>
                                    <span class="input-group-text bg-light border-start-0 text-muted">Years</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Benefits & Features (JS Tag System) -->
                <div class="card border-0 shadow-sm premium-card rounded-4 mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-stars text-warning"></i> Policy Attributes
                        </h5>
                        <p class="text-muted small mt-1 mb-0">Type a benefit and press <code>Enter</code> to add it to the
                            list.</p>
                    </div>
                    <div class="card-body p-4">
                        @php
                            // Process existing backend arrays to a JS-ready comma string
                            $benefitsArray = [];
                            if (is_array($plan->benefits)) {
                                foreach ($plan->benefits as $b) {
                                    $benefitsArray[] = is_array($b) ? (isset($b['description']) ? trim($b['description']) : trim(implode(' ', $b))) : trim($b);
                                }
                            } else {
                                $benefitsArray = $plan->benefits ? array_map('trim', explode(',', $plan->benefits)) : [];
                            }

                            $featuresArray = [];
                            if (is_array($plan->features)) {
                                foreach ($plan->features as $f) {
                                    $featuresArray[] = is_array($f) ? (isset($f['description']) ? trim($f['description']) : trim(implode(' ', $f))) : trim($f);
                                }
                            } else {
                                $featuresArray = $plan->features ? array_map('trim', explode(',', $plan->features)) : [];
                            }
                        @endphp

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase"
                                style="letter-spacing: 0.5px;">Core Benefits</label>
                            <div class="tag-input-wrapper premium-input p-2 rounded-3 d-flex flex-wrap gap-2 align-items-center"
                                id="benefitsWrapper">
                                <!-- JS Tags injected here -->
                                <input type="text" class="tag-input-field flex-grow-1 border-0 shadow-none bg-transparent"
                                    placeholder="Add a benefit..." id="benefitsInputField">
                            </div>
                            <!-- Hidden input carrying actual data for Laravel -->
                            <input type="hidden" name="benefits" id="benefitsHiddenData"
                                value="{{ implode(',', $benefitsArray) }}">
                        </div>

                        <div>
                            <label class="form-label fw-bold text-dark small text-uppercase"
                                style="letter-spacing: 0.5px;">Additional Features</label>
                            <div class="tag-input-wrapper premium-input p-2 rounded-3 d-flex flex-wrap gap-2 align-items-center"
                                id="featuresWrapper">
                                <!-- JS Tags injected here -->
                                <input type="text" class="tag-input-field flex-grow-1 border-0 shadow-none bg-transparent"
                                    placeholder="Add a feature..." id="featuresInputField">
                            </div>
                            <!-- Hidden input carrying actual data for Laravel -->
                            <input type="hidden" name="features" id="featuresHiddenData"
                                value="{{ implode(',', $featuresArray) }}">
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Media & Settings -->
            <div class="col-lg-4">

                <!-- Cover Image Upload -->
                <div class="card border-0 shadow-sm premium-card rounded-4 mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-image text-indigo"></i> Product Media
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        <!-- React-Style Drag & Drop Zone -->
                        <div class="upload-dropzone rounded-4 border border-2 border-dashed text-center position-relative transition-all"
                            id="imageDropzone">
                            <input type="file" name="image" id="imageInput" class="position-absolute w-100 h-100 opacity-0"
                                style="cursor: pointer; z-index: 10;" accept="image/*">

                            <div id="uploadPlaceholder" class="{{ $plan->image_path ? 'd-none' : 'd-block' }} py-5 px-3">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-secondary"
                                    style="width: 64px; height: 64px;">
                                    <i class="bi bi-cloud-arrow-up fs-2"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Upload New Cover</h6>
                                <p class="text-muted small mb-0 px-2">Drag & drop or click to replace image. Recommended
                                    800x600px (Max 2MB)</p>
                            </div>

                            <!-- Image Preview Render -->
                            <div id="imagePreviewContainer"
                                class="{{ $plan->image_path ? 'd-block' : 'd-none' }} w-100 h-100 p-2 position-relative">
                                <img id="imagePreview"
                                    src="{{ $plan->image_path ? asset('storage/' . $plan->image_path) : '' }}"
                                    class="img-fluid rounded-3 object-fit-cover w-100" style="max-height: 200px;"
                                    alt="Cover">

                                <div class="position-absolute top-50 start-50 translate-middle d-flex flex-column gap-2 opacity-0 hover-show-overlay w-100 h-100 justify-content-center align-items-center rounded-3"
                                    style="background: rgba(0,0,0,0.5); padding:1rem; pointer-events: none;">
                                    <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-medium shadow-sm"><i
                                            class="bi bi-arrow-repeat me-1"></i> Replace Image</span>
                                </div>
                            </div>
                        </div>
                        @if($plan->image_path)
                            <div class="text-center mt-3" id="removeBtnWrapper">
                                <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none fw-medium"
                                    id="removeImageBtn">
                                    <i class="bi bi-trash3 me-1"></i> Default to no image
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Configuration Settings -->
                <div class="card border-0 shadow-sm premium-card rounded-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-sliders text-secondary"></i> Configuration
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="fw-bold text-dark d-block mb-1">Active Status</span>
                                <span class="text-muted small">Available for new client subscriptions</span>
                            </div>
                            <div class="form-check form-switch fs-4 m-0">
                                <input type="checkbox" name="is_active" class="form-check-input switch-success shadow-sm" role="switch" value="1" {{ $plan->is_active ? 'checked' : '' }}>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

    <style>
        /* SaaS Premium Variables */
        :root {
            --focus-ring-color: rgba(99, 102, 241, 0.25);
            --border-color: #cbd5e1;
        }

        /* Typography & Core Resets */
        .text-indigo {
            color: #4f46e5;
        }

        .bg-indigo {
            background-color: #4f46e5;
        }

        .hover-primary {
            transition: color 0.2s ease;
        }

        .hover-primary:hover {
            color: #4f46e5 !important;
        }

        .transition-all {
            transition: all 0.2s ease;
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }

        /* Premium Component Layouts */
        .premium-card {
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }

        /* Form Controls Elite Styling */
        .premium-input,
        .premium-input-group .form-control,
        .premium-input-group .input-group-text {
            border-color: var(--border-color);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .premium-input-group .input-group-text {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .premium-input-group .form-control {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .premium-input-group .form-control:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .premium-input-group .input-group-text:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .premium-input:focus,
        .premium-input-group .form-control:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 4px var(--focus-ring-color);
            background-color: #fff;
        }

        .premium-input-group:focus-within .input-group-text {
            border-color: #818cf8;
            color: #4f46e5 !important;
        }

        /* Buttons */
        .premium-btn {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .premium-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4) !important;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        }

        /* Toggle Switches */
        .form-switch .form-check-input {
            width: 2.2em;
            height: 1.1em;
            cursor: pointer;
        }

        .switch-success:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        .switch-warning:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }

        /* ---------------------------------
           Upload Dropzone CSS
           --------------------------------- */
        .upload-dropzone {
            background-color: #f8fafc;
            border-color: #cbd5e1 !important;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .upload-dropzone:hover,
        .upload-dropzone.dragover {
            border-color: #818cf8 !important;
            background-color: #eef2ff;
        }

        /* Reveal overlay on hover over an existing image */
        #imageDropzone:hover .hover-show-overlay {
            opacity: 1 !important;
            background: rgba(0, 0, 0, 0.4) !important;
        }

        /* ---------------------------------
           JS Tag System CSS
           --------------------------------- */
        .tag-input-wrapper {
            min-height: 48px;
            cursor: text;
        }

        .tag-input-wrapper:focus-within {
            border-color: #818cf8;
            box-shadow: 0 0 0 4px var(--focus-ring-color);
            background-color: #fff;
        }

        .tag-chip {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .tag-chip:hover {
            background: #e2e8f0;
        }

        .tag-chip .remove-tag {
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .tag-chip .remove-tag:hover {
            color: #ef4444;
        }

        .tag-input-field:focus {
            outline: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- 1. Character Counter ---
            const descInput = document.querySelector('textarea[name="description"]');
            const countSpan = document.getElementById('charCount');
            if (descInput && countSpan) {
                countSpan.textContent = descInput.value.length;
                descInput.addEventListener('input', function () {
                    countSpan.textContent = this.value.length;
                    if (this.value.length > 500) {
                        countSpan.classList.add('text-danger', 'fw-bold');
                    } else {
                        countSpan.classList.remove('text-danger', 'fw-bold');
                    }
                });
            }

            // --- 2. Image Drag & Drop Preview System ---
            const imageInput = document.getElementById('imageInput');
            const dropzone = document.getElementById('imageDropzone');
            const placeholder = document.getElementById('uploadPlaceholder');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');
            const removeBtn = document.getElementById('removeImageBtn');

            if (imageInput && dropzone) {
                // Drag events
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
                });

                // Handle dropped or selected files
                imageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            placeholder.classList.remove('d-block');
                            placeholder.classList.add('d-none');
                            previewContainer.classList.remove('d-none');
                            previewContainer.classList.add('d-block');
                            if (removeBtn) removeBtn.closest('#removeBtnWrapper').style.display = 'block';
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Note: remove logic requires backend flag handler if you want to clear DB path without new upload. 
                // In standard Laravel scaffold passing an empty file leaves existing image.
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        imageInput.value = "";
                        previewImg.src = "";
                        previewContainer.classList.remove('d-block');
                        previewContainer.classList.add('d-none');
                        placeholder.classList.remove('d-none');
                        placeholder.classList.add('d-block');
                        this.closest('#removeBtnWrapper').style.display = 'none';
                        // Here you would optimally add a hidden input `<input type="hidden" name="remove_image" value="1">`
                        // so the backend knows to unlink the actual server file.
                    });
                }
            }


            // --- 3. Tag Input Rendering System ---
            function initTagSystem(wrapperId, inputId, hiddenId) {
                const wrapper = document.getElementById(wrapperId);
                const inputField = document.getElementById(inputId);
                const hiddenData = document.getElementById(hiddenId);
                if (!wrapper || !inputField || !hiddenData) return;

                // Load initial tags from hidden input string
                let tags = hiddenData.value ? hiddenData.value.split(',').map(t => t.trim()).filter(t => t.length > 0) : [];

                // Render tags visually
                function renderTags() {
                    // Clear existing dom chips but keep the input field
                    Array.from(wrapper.querySelectorAll('.tag-chip')).forEach(el => el.remove());

                    tags.forEach((tag, index) => {
                        const chip = document.createElement('div');
                        chip.className = 'tag-chip';
                        chip.innerHTML = `
                            <span>${tag}</span>
                            <span class="remove-tag" data-index="${index}"><i class="bi bi-x-circle-fill"></i></span>
                        `;
                        wrapper.insertBefore(chip, inputField);
                    });

                    // Update hidden payload for form submission
                    hiddenData.value = tags.join(',');
                }

                // Listen for Enter/Comma on input
                inputField.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        let val = this.value.trim();
                        if (val && !tags.includes(val)) {
                            tags.push(val);
                            renderTags();
                            this.value = '';
                        }
                    }
                    // Backspace delete latest tag
                    if (e.key === 'Backspace' && this.value === '' && tags.length > 0) {
                        tags.pop();
                        renderTags();
                    }
                });

                // Delegate click listener for 'x' removal
                wrapper.addEventListener('click', function (e) {
                    const removeBtn = e.target.closest('.remove-tag');
                    if (removeBtn) {
                        const idx = parseInt(removeBtn.getAttribute('data-index'));
                        tags.splice(idx, 1);
                        renderTags();
                    } else if (e.target === wrapper) {
                        // Click wrapper -> focus input
                        inputField.focus();
                    }
                });

                // Prevent form submit on enter inside input
                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') e.preventDefault();
                });

                // Initial render
                renderTags();
            }

            initTagSystem('benefitsWrapper', 'benefitsInputField', 'benefitsHiddenData');
            initTagSystem('featuresWrapper', 'featuresInputField', 'featuresHiddenData');

        });
    </script>
@endsection