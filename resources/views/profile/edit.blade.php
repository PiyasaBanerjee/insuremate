@extends('layouts.app')

@push('styles')
    <style>
        /* Profile Page Custom CSS */
        .profile-body-bg {
            background: radial-gradient(circle at top center, rgba(237, 233, 254, 0.5) 0%, rgba(224, 231, 255, 0.3) 40%, #f8fafc 100%);
            min-height: calc(100vh - 80px);
            /* Adjust based on navbar height */
            padding-top: 3rem;
            padding-bottom: 5rem;
        }

        /* Glassmorphic Profile Card */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #3b82f6);
            z-index: 10;
        }

        .profile-card-header {
            background: transparent;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            padding: 2rem 2.5rem 1.5rem;
        }

        .profile-card-body {
            padding: 2.5rem;
        }

        /* Avatar Styling */
        .avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .avatar-wrapper {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
        }

        .avatar-wrapper:hover {
            transform: scale(1.05);
        }

        .avatar-wrapper img,
        .avatar-wrapper .avatar-placeholder {
            cursor: zoom-in;
        }

        /* ── Lightbox ── */
        .av-lightbox {
            display: none;
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(0,0,0,0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            align-items: center; justify-content: center;
            animation: lbFadeIn 0.22s ease;
        }

        .av-lightbox.open { display: flex; }

        @keyframes lbFadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        .av-lightbox img {
            max-width: 90vw; max-height: 88vh;
            border-radius: 16px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
            animation: lbPop 0.28s cubic-bezier(0.34,1.46,0.64,1);
            cursor: zoom-out;
        }

        @keyframes lbPop {
            from { opacity: 0; transform: scale(0.88); }
            to   { opacity: 1; transform: scale(1); }
        }

        .av-lightbox-close {
            position: absolute; top: 20px; right: 24px;
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
            color: #fff; font-size: 1.2rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.18s;
        }

        .av-lightbox-close:hover { background: rgba(255,255,255,0.22); }

        .avatar-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            background-color: #ffffff;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #ffffff;
        }

        /* File Input Styling */
        .file-upload-wrapper {
            position: relative;
            width: fit-content;
            margin: 0 auto;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-btn {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .file-upload-wrapper:hover .file-upload-btn {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
        }

        /* Section Typography */
        .section-title {
            color: #1e293b;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1rem;
            letter-spacing: -0.2px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10%;
            height: 80%;
            width: 4px;
            background: #6366f1;
            border-radius: 4px;
        }

        /* Input Field Styling */
        .form-label {
            font-weight: 600;
            color: #64748b;
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            color: #1e293b;
            background-color: #fafafa;
            transition: all 0.2s ease-in-out;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.015);
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15), inset 0 1px 2px rgba(0, 0, 0, 0.02);
            color: #0f172a;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Save Button */
        .btn-profile-save {
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 32px;
            font-size: 1.05rem;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            letter-spacing: 0.3px;
        }

        .btn-profile-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
            color: white;
            background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
        }

        .btn-profile-save:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="profile-body-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">

                    <div class="profile-card fade-in-up">
                        <div class="profile-card-header">
                            <h3 class="mb-0 fw-bold" style="color: #0f172a; letter-spacing: -0.5px;">Account Profile</h3>
                            <p class="text-muted mb-0 mt-1">Manage your personal information and emergency contacts.</p>
                        </div>

                        <div class="profile-card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center"
                                    role="alert" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                                    <div>{{ session('success') }}</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Avatar Section -->
                                <div class="mb-5 text-center">
                                    <div class="avatar-container">
                                        <div class="avatar-wrapper" id="avatarWrapper">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                                    class="avatar-image" onclick="openAvatarLightbox(this.src)">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="bi bi-person text-secondary" style="font-size: 4rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Lightbox --}}
                                    <div class="av-lightbox" id="avatarLightbox" onclick="closeAvatarLightbox()">
                                        <div class="av-lightbox-close" title="Close (Esc)"><i class="bi bi-x"></i></div>
                                        <img id="avatarLightboxImg" src="" alt="Avatar enlarged">
                                    </div>

                                    <div class="file-upload-wrapper">
                                        <button type="button" class="file-upload-btn"
                                            onclick="document.getElementById('avatar').click()">
                                            <i class="bi bi-camera"></i> Change Photo
                                        </button>
                                        <input type="file" class="file-upload-input @error('avatar') is-invalid @enderror"
                                            id="avatar" name="avatar" accept="image/png, image/jpeg, image/webp, image/gif"
                                            onchange="previewAvatar(this)">
                                        <p class="text-muted small mt-2 mb-0" id="avatarFileName">Recommended size:
                                            400x400px (JPG, PNG)</p>
                                    </div>

                                    @error('avatar')
                                        <div class="text-danger small mt-2 fw-medium">
                                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <hr class="my-5 border-secondary opacity-25">

                                <!-- Basic Info Section -->
                                <h4 class="section-title">Basic Information</h4>
                                <div class="row g-4 mb-5">
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $user->name) }}" required autocomplete="name"
                                            placeholder="John Doe">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $user->email) }}" required autocomplete="email"
                                            placeholder="john@example.com">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone', $user->phone) }}" autocomplete="tel"
                                            placeholder="1234567890" maxlength="10" pattern="[0-9]{10}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Residential Address</label>
                                        <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                            name="address"
                                            placeholder="Enter your full residential address for policy documentation...">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Emergency Contact Section -->
                                <h4 class="section-title">Emergency Contact</h4>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="emergency_contact_name" class="form-label">Trustee / Contact
                                            Name</label>
                                        <input id="emergency_contact_name" type="text"
                                            class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                            name="emergency_contact_name"
                                            value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                                            placeholder="Jane Doe">
                                        @error('emergency_contact_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="emergency_contact_phone" class="form-label">Contact Phone Number</label>
                                        <input id="emergency_contact_phone" type="text"
                                            class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                            name="emergency_contact_phone"
                                            value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                                            placeholder="1234567890" maxlength="10" pattern="[0-9]{10}">
                                        @error('emergency_contact_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-5 pt-3 text-end border-top border-light">
                                    <button type="submit" class="btn btn-profile-save">
                                        <i class="bi bi-shield-check me-2"></i>Save Profile
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* ── Avatar Lightbox ── */
        function openAvatarLightbox(src) {
            document.getElementById('avatarLightboxImg').src = src;
            document.getElementById('avatarLightbox').classList.add('open');
        }

        function closeAvatarLightbox() {
            document.getElementById('avatarLightbox').classList.remove('open');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAvatarLightbox();
        });

        /* ── Avatar Preview ── */
        function previewAvatar(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                const wrapper = document.querySelector('.avatar-wrapper');
                // Replace placeholder or existing img with live preview (with lightbox click)
                wrapper.innerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-image" onclick="openAvatarLightbox(this.src)">`;
            };

            reader.readAsDataURL(file);

            // Update hint text with filename
            const hint = document.getElementById('avatarFileName');
            if (hint) {
                hint.innerHTML = `<i class="bi bi-check-circle text-success me-1"></i><strong>${file.name}</strong> selected &mdash; click <em>Save Profile</em> to apply.`;
                hint.classList.remove('text-muted');
                hint.classList.add('text-success');
            }
        }
    </script>

@endsection