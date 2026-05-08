<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InsureMate') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .footer {
            background-color: #f8f9fa;
            padding: 60px 0 30px;
            margin-top: auto;
        }

        .footer-link {
            color: #6c757d;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }

        .footer-link:hover {
            color: #0d6efd;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .navbar-brand {
            font-size: 1.35rem;
            letter-spacing: -0.5px;
            color: #0f172a !important;
        }

        .nav-link {
            font-weight: 500;
            color: #64748b;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #6366f1;
        }

        .btn-saas-primary {
            background-color: #6366f1;
            border-color: #6366f1;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-saas-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-saas-outline {
            color: #6366f1;
            border: 1px solid #6366f1;
            background: transparent;
            font-weight: 500;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-saas-outline:hover {
            background-color: #6366f1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }

        /* ── Admin Navbar Elements ── */
        .admin-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.18);
            color: #4f46e5;
            font-size: 0.73rem;
            font-weight: 700;
            padding: 4px 11px;
            border-radius: 999px;
            letter-spacing: 0.3px;
        }

        .admin-role-pill i {
            font-size: 0.78rem;
        }

        .admin-quicknav {
            display: flex;
            align-items: center;
            gap: 2px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 3px 6px;
        }

        .admin-qn-link {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 7px;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .admin-qn-link i {
            font-size: 0.85rem;
        }

        .admin-qn-link:hover {
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
        }

        main {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-shield-check me-1" style="color: #6366f1;"></i>
                    {{ config('app.name', 'InsureMate') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="insuranceDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Insurance Products
                            </a>
                            <ul class="dropdown-menu shadow-sm" aria-labelledby="insuranceDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'life-insurance') }}">Life Insurance</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'health-insurance') }}">Health Insurance</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'car-insurance') }}">Car Insurance</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'term-life-insurance') }}">Term Life
                                        Insurance</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'investment-plans') }}">Investment Plans</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'two-wheeler-insurance') }}">Two Wheeler
                                        Insurance</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'family-health-insurance') }}">Family
                                        Health</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('frontend.category', 'travel-insurance') }}">Travel Insurance</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item fw-bold text-primary"
                                        href="{{ route('landing') }}#categories">View All Categories</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                        </li>
                        @unless(Auth::guard('admin')->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                            </li>
                        @endunless
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @unless(Auth::guard('admin')->check())
                            <li class="nav-item me-2 d-none d-md-block">
                                <button type="button" class="btn btn-saas-outline mt-1" data-bs-toggle="modal"
                                    data-bs-target="#expertModal">
                                    <i class="bi bi-headset"></i> Talk to Expert
                                </button>
                            </li>
                        @else
                            {{-- Admin Quick Access Bar --}}
                            <li class="nav-item d-none d-md-flex align-items-center me-1">
                                <span class="admin-role-pill">
                                    <i class="bi bi-shield-fill-check"></i> Admin
                                </span>
                            </li>
                            <li class="nav-item d-none d-md-flex align-items-center">
                                <div class="admin-quicknav">
                                    <a href="{{ route('admin.dashboard') }}" class="admin-qn-link" title="Dashboard">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="admin-qn-link" title="Users">
                                        <i class="bi bi-people"></i>
                                        <span>Users</span>
                                    </a>
                                    <a href="{{ route('admin.tickets.index') }}" class="admin-qn-link" title="Tickets">
                                        <i class="bi bi-ticket-detailed"></i>
                                        <span>Tickets</span>
                                    </a>
                                    <a href="{{ route('admin.payments.index') }}" class="admin-qn-link" title="Payments">
                                        <i class="bi bi-credit-card"></i>
                                        <span>Payments</span>
                                    </a>
                                </div>
                            </li>
                        @endunless
                        <!-- Authentication Links -->
                        @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-saas-primary mt-1" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- Notification Bell --}}
                            @if(!Auth::guard('admin')->check())
                            <li class="nav-item dropdown me-2 d-flex align-items-center">
                                <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-top: 10px;">
                                    <i class="bi bi-bell text-secondary hover-primary" style="font-size: 1.25rem;"></i>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; margin-top: 12px; margin-left: -8px;">
                                            {{ Auth::user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="notifDropdown" style="width: 350px; border-radius: 12px; padding: 0;">
                                    <li class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
                                        <span class="fw-bold" style="color: #1e293b;"><i class="bi bi-bell-fill text-primary me-2"></i>Notifications</span>
                                        @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form action="{{ route('notifications.readAll') }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none text-primary fw-medium" style="font-size: 0.8rem;">Mark all read</button>
                                        </form>
                                        @endif
                                    </li>
                                    <div style="max-height: 380px; overflow-y: auto;">
                                        @forelse(Auth::user()->unreadNotifications as $notif)
                                            <li>
                                                <a class="dropdown-item p-3 border-bottom text-wrap notif-item" href="{{ $notif->data['action_url'] ?? '#' }}" data-id="{{ $notif->id }}" style="transition: background 0.2s;">
                                                    <div class="d-flex align-items-start">
                                                        <div class="me-3 mt-1 text-{{ $notif->data['icon_color'] ?? 'primary' }}">
                                                            <i class="bi {{ $notif->data['icon'] ?? 'bi-app-indicator' }} fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                                            <div class="text-muted mt-1" style="font-size: 0.85rem; line-height: 1.4;">{{ $notif->data['message'] ?? '' }}</div>
                                                            <div class="text-muted mt-2 fw-medium" style="font-size: 0.75rem; color: #94a3b8 !important;"><i class="bi bi-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="p-5 text-center text-muted">
                                                <i class="bi bi-bell-slash fs-1 d-block mb-3" style="color: #cbd5e1;"></i>
                                                <span class="fw-medium" style="font-size: 0.95rem; color: #64748b;">You have no new notifications</span>
                                            </li>
                                        @endforelse
                                    </div>
                                </ul>
                            </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    @if(Auth::guard('admin')->check())
                                        Admin: {{ Auth::guard('admin')->user()->name }}
                                    @else
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                                                class="rounded-circle me-2"
                                                style="width: 28px; height: 28px; object-fit: cover; border: 1px solid #e2e8f0;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2 border"
                                                style="width: 28px; height: 28px;">
                                                <i class="bi bi-person text-secondary" style="font-size: 1rem;"></i>
                                            </div>
                                        @endif
                                        {{ Auth::user()->name }}
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::guard('admin')->check())
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            {{ __('Dashboard') }}
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            {{ __('My Dashboard') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            {{ __('My Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('tickets.index') }}">
                                            {{ __('Support Tickets') }}
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                                                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-0">
            @yield('content')
        </main>

        <!-- Premium Fintech Footer -->
        <style>
            .footer-premium {
                background: linear-gradient(-45deg, #4f46e5, #6366f1, #4338ca, #3730a3);
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
                color: #e2e8f0;
                position: relative;
                overflow: hidden;
                padding-top: 5rem;
                padding-bottom: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }

            .footer-premium::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            }

            .footer-glow {
                position: absolute;
                width: 600px;
                height: 600px;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
                border-radius: 50%;
                top: -300px;
                left: -200px;
                pointer-events: none;
            }

            .footer-glass {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 16px;
                padding: 2.5rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .footer-heading {
                color: #ffffff;
                font-weight: 700;
                letter-spacing: 0.5px;
                margin-bottom: 1.5rem;
                position: relative;
                display: inline-block;
            }

            .footer-heading::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 0;
                width: 30px;
                height: 2px;
                background: #fdfba3;
                border-radius: 2px;
            }

            .footer-link-premium {
                color: #e2e8f0;
                text-decoration: none;
                transition: all 0.3s ease;
                display: block;
                margin-bottom: 0.8rem;
                font-weight: 400;
                letter-spacing: 0.2px;
                position: relative;
                width: fit-content;
            }

            .footer-link-premium::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 1px;
                background: #fdfba3;
                transition: width 0.3s ease;
            }

            .footer-link-premium:hover {
                color: #ffffff;
                transform: translateX(4px);
            }

            .footer-link-premium:hover::after {
                width: 100%;
            }

            .social-icon-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
                color: #e2e8f0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                margin-right: 0.5rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .social-icon-btn:hover {
                background: #fdfba3;
                color: #4c51bf;
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 10px 15px -3px rgba(253, 251, 163, 0.3);
            }

            .support-box {
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(4px);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .support-box:hover {
                transform: translateY(-3px);
                background: rgba(255, 255, 255, 0.15);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-color: rgba(255, 255, 255, 0.4);
            }

            .footer-brand-container {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
            }

            .footer-brand-container:hover {
                transform: translateY(-2px);
                text-shadow: 0 0 15px rgba(253, 251, 163, 0.4);
            }

            .footer-bottom-link {
                color: #e2e8f0;
                font-size: 0.85rem;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .footer-bottom-link:hover {
                color: #ffffff;
                text-decoration: underline;
                text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            }

            .trust-badge i {
                color: #6366f1;
                font-size: 1.15rem;
            }

            .trust-badge span {
                font-size: 0.85rem;
                font-weight: 600;
                letter-spacing: 0.2px;
                color: #334155;
            }
        </style>

        <footer class="footer-premium">
            <div class="footer-glow"></div>
            <div class="container position-relative z-1">

                <div class="footer-glass">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 pr-lg-5">
                            <h4 class="fw-bold mb-4" style="color: #ffffff;">
                                <div class="footer-brand-container">
                                    <i class="bi bi-shield-check" style="font-size: 1.5rem; color: #fdfba3;"></i>
                                    InsureMate
                                </div>
                            </h4>
                            <p style="color: #e2e8f0; line-height: 1.7; font-size: 0.95rem; margin-bottom: 2rem;">
                                Redefining the way you protect your future. Experience seamless, transparent, and
                                intelligent insurance comparison tailored for the modern world.
                            </p>
                            <div>
                                <a href="#" class="social-icon-btn"><i class="bi bi-linkedin"></i></a>
                                <a href="#" class="social-icon-btn"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="social-icon-btn"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="social-icon-btn"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                            <h6 class="footer-heading">Products</h6>
                            @if(isset($categories))
                                @foreach($categories->take(5) as $cat)
                                    <a href="{{ route('frontend.category', $cat->slug) }}"
                                        class="footer-link-premium">{{ $cat->name }}</a>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                            <h6 class="footer-heading">Company</h6>
                            <a href="#" class="footer-link-premium">About Us</a>
                            <a href="#" class="footer-link-premium">Careers</a>
                            <a href="#" class="footer-link-premium">Blog & Insights</a>
                            <a href="{{ route('contact') }}" class="footer-link-premium">Contact Us</a>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <h6 class="footer-heading">Support & Resources</h6>
                            <a href="{{ route('faq') }}" class="footer-link-premium"><i
                                    class="bi bi-question-circle me-2"></i>Help Center / FAQs</a>
                            <a href="{{ route('tickets.index') }}" class="footer-link-premium"><i
                                    class="bi bi-ticket-detailed me-2"></i>Raise a Support Ticket</a>

                            <div class="mt-4 p-3 rounded support-box">
                                <p class="mb-1" style="color: #e2e8f0; font-size: 0.85rem;">Need immediate assistance?
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-telephone text-primary fs-5" style="color: #fdfba3 !important;"></i>
                                    <span style="font-weight: 600; font-size: 1.1rem; color: #ffffff;">+1 (555)
                                        123-4567</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center mt-5 pt-4 border-top"
                    style="border-color: rgba(255,255,255,0.15) !important;">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0" style="color: #e2e8f0; font-size: 0.85rem;">&copy; {{ date('Y') }} InsureMate.
                            All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="footer-bottom-link me-4">Privacy Policy</a>
                        <a href="#" class="footer-bottom-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    {{-- ── Talk to Expert Modal (Premium) ── --}}
    <div class="modal fade" id="expertModal" tabindex="-1" aria-labelledby="expertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered em-dialog">
            <div class="modal-content em-content">

                <button type="button" class="em-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x"></i>
                </button>

                <div class="em-header">
                    <div class="em-icon-badge"><i class="bi bi-headset"></i></div>
                    <div>
                        <h5 class="em-title" id="expertModalLabel">Talk to an Expert</h5>
                        <p class="em-subtitle">Our advisors will call you back within 24 hours.</p>
                    </div>
                </div>

                <div class="em-body">
                    <form action="{{ route('contact.submit') }}" method="POST" id="expertForm">
                        @csrf
                        <input type="hidden" name="subject" value="Expert Consultation Request">

                        <div class="em-row">
                            <div class="em-field">
                                <label class="em-label" for="em_name"><i class="bi bi-person me-1"></i> Full
                                    Name</label>
                                <input type="text" id="em_name" name="name" class="em-input" placeholder="Your name"
                                    value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                            </div>
                            <div class="em-field">
                                <label class="em-label" for="em_email"><i class="bi bi-envelope me-1"></i> Email</label>
                                <input type="email" id="em_email" name="email" class="em-input"
                                    placeholder="you@example.com" value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                    required>
                            </div>
                        </div>

                        <div class="em-field">
                            <label class="em-label" for="em_message"><i class="bi bi-chat-text me-1"></i> Message /
                                Query</label>
                            <textarea id="em_message" name="message" class="em-textarea" rows="4"
                                placeholder="Describe how we can help you..." required></textarea>
                        </div>

                        <button type="submit" class="em-submit" id="emSubmitBtn">
                            <i class="bi bi-telephone-outbound me-2" id="emBtnIcon"></i>
                            <span id="emBtnText">Request Callback</span>
                        </button>
                    </form>

                    <div class="em-trust">
                        <span class="em-trust-item"><i class="bi bi-shield-lock-fill"></i> Encrypted</span>
                        <span class="em-trust-item"><i class="bi bi-patch-check-fill"></i> IRDAI Approved</span>
                        <span class="em-trust-item"><i class="bi bi-clock-fill"></i> 24h Response</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .em-dialog {
            max-width: 540px;
        }

        .em-content {
            border: none;
            border-radius: 20px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22), 0 0 0 1px rgba(0, 0, 0, 0.04);
            animation: emPop 0.32s cubic-bezier(0.34, 1.46, 0.64, 1) forwards;
            position: relative;
        }

        @keyframes emPop {
            from {
                opacity: 0;
                transform: scale(0.93) translateY(14px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .em-close {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 10;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.05);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .em-close:hover {
            background: #f1f5f9;
            color: #0f172a;
            transform: rotate(90deg);
        }

        .em-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 32px 32px 0;
        }

        .em-icon-badge {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            flex-shrink: 0;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.05));
            color: #4f46e5;
            border: 1px solid rgba(79, 70, 229, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .em-title {
            font-size: 1.12rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px;
            letter-spacing: -0.4px;
        }

        .em-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        .em-body {
            padding: 22px 32px 28px;
        }

        .em-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 16px;
        }

        .em-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 16px;
        }

        .em-row .em-field {
            margin-bottom: 0;
        }

        .em-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #374151;
            letter-spacing: 0.2px;
        }

        .em-input,
        .em-textarea {
            width: 100%;
            padding: 10px 13px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 11px;
            font-size: 0.88rem;
            color: #0f172a;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .em-input::placeholder,
        .em-textarea::placeholder {
            color: #adb5bd;
        }

        .em-input:focus,
        .em-textarea:focus {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .em-textarea {
            resize: vertical;
            min-height: 96px;
            line-height: 1.6;
        }

        .em-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border: none;
            border-radius: 11px;
            font-size: 0.92rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 5px 18px rgba(79, 70, 229, 0.3);
            transition: all 0.22s ease;
            letter-spacing: 0.2px;
        }

        .em-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.42);
            background: linear-gradient(135deg, #4338ca, #4f46e5);
        }

        .em-submit:active {
            transform: translateY(0);
        }

        .em-submit.loading {
            opacity: 0.78;
            pointer-events: none;
        }

        .em-trust {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 14px;
        }

        .em-trust-item {
            font-size: 0.71rem;
            font-weight: 600;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .em-trust-item i {
            color: #4f46e5;
            font-size: 0.76rem;
        }

        @media (max-width: 480px) {
            .em-row {
                grid-template-columns: 1fr;
            }

            .em-header,
            .em-body {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>

    <script>
        document.getElementById('expertForm')?.addEventListener('submit', function () {
            const btn = document.getElementById('emSubmitBtn');
            document.getElementById('emBtnIcon').className = 'bi bi-hourglass-split me-2';
            document.getElementById('emBtnText').textContent = 'Sending...';
            btn.classList.add('loading');
        });
    </script>

    @auth
        <!-- AI Chat Widget -->
        <div id="ai-chat-widget">
            <!-- Floating Toggle Button -->
            <button id="chat-toggle-btn" class="chat-toggle-btn" aria-label="Open AI Support Chat">
                <svg class="ai-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                    </path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    <circle cx="12" cy="12" r="3" fill="white" class="ai-core-pulse"></circle>
                </svg>
            </button>

            <!-- Chat Window -->
            <div id="chat-window" class="chat-window d-none">
                <!-- Header -->
                <div class="chat-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="chat-ai-avatar-header">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                <line x1="12" y1="22.08" x2="12" y2="12" />
                            </svg>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white fw-bold" style="font-size:0.95rem;">InsureMate AI</h6>
                            <small class="text-white-50" style="font-size:0.75rem;"><span class="online-dot"></span> Online
                                • Live Support</small>
                        </div>
                    </div>
                    <button id="chat-close-btn" class="btn btn-sm text-white border-0"><i class="fas fa-times"></i></button>
                </div>

                <!-- Messages Area -->
                <div id="chat-messages" class="chat-messages p-3">
                    <div class="text-center text-muted small my-2">Today</div>
                    <!-- Messages will be injected here dynamically -->
                </div>

                <!-- Input Area -->
                <div class="chat-input-area p-3 bg-white">
                    <form id="chat-form" class="position-relative">
                        <input type="text" id="chat-input" class="form-control chat-input"
                            placeholder="Type your message..." autocomplete="off">
                        <button type="submit" class="btn chat-send-btn">
                            <i class="fas fa-paper-plane text-primary"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <style>
        /* Chat Widget Styles */
        #ai-chat-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1050;
        }

        .chat-toggle-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            color: white;
            border: none;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.5);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .chat-toggle-btn::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(90deg, #4f46e5, #0ea5e9, #4f46e5);
            background-size: 200% 100%;
            border-radius: 50%;
            z-index: -1;
            animation: borderGlow 3s linear infinite;
        }

        @keyframes borderGlow {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }

        .ai-icon-svg {
            width: 32px;
            height: 32px;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.6));
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-3px) scale(1.05);
            }
        }

        .ai-core-pulse {
            animation: pulseCore 2s ease-in-out infinite alternate;
        }

        @keyframes pulseCore {
            0% {
                opacity: 0.5;
                r: 2;
                fill: #a5b4fc;
            }

            100% {
                opacity: 1;
                r: 3.5;
                fill: #ffffff;
                filter: drop-shadow(0 0 5px white);
            }
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 15px 30px rgba(124, 58, 237, 0.5);
        }

        .chat-window {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 350px;
            height: 500px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform-origin: bottom right;
            animation: chatPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes chatPop {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .chat-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f8fafc;
        }

        /* Message Bubbles */
        .msg-bubble {
            max-width: 85%;
            padding: 12px 16px;
            font-size: 0.9rem;
            line-height: 1.4;
            animation: slideIn 0.3s ease-out;
            word-wrap: break-word;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .msg-ai {
            align-self: flex-start;
            background: #ffffff;
            color: #1e293b;
            border-radius: 4px 16px 16px 16px;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.1);
            border-left: 3px solid #4f46e5;
            line-height: 1.6;
        }

        .msg-ai strong {
            color: #4f46e5;
            font-weight: 600;
        }

        .msg-ai ol,
        .msg-ai ul {
            padding-left: 1.2rem;
            margin: 4px 0;
        }

        .msg-ai li {
            margin-bottom: 3px;
        }

        .msg-user {
            align-self: flex-end;
            background: linear-gradient(135deg, #4f46e5 0%, #6d28d9 100%);
            color: white;
            border-radius: 16px 4px 16px 16px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
        }

        .msg-row-ai {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .msg-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-top: 2px;
        }

        .chat-ai-avatar-header {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .online-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #34d399;
            border-radius: 50%;
            margin-right: 4px;
        }

        .chat-input-area {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chat-input {
            border-radius: 30px;
            padding: 12px 45px 12px 20px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.3s;
        }

        .chat-input:focus {
            background: white;
            border-color: #a78bfa;
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.15);
            outline: none;
        }

        .chat-send-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-send-btn:hover {
            background: rgba(79, 70, 229, 0.1);
        }

        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 12px 16px;
            align-items: center;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background: #94a3b8;
            border-radius: 50%;
            animation: typingDot 1.4s infinite ease-in-out both;
        }

        .typing-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes typingDot {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }
    </style>

    <!-- Scripts -->
    @stack('scripts')

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chatToggleBtn = document.getElementById('chat-toggle-btn');
                const chatCloseBtn = document.getElementById('chat-close-btn');
                const chatWindow = document.getElementById('chat-window');
                const chatMessages = document.getElementById('chat-messages');
                const chatForm = document.getElementById('chat-form');
                const chatInput = document.getElementById('chat-input');

                let chatSessionId = null;
                let echoChannel = null;

                // Toggle logic
                chatToggleBtn.addEventListener('click', () => {
                    chatWindow.classList.toggle('d-none');
                    if (!chatWindow.classList.contains('d-none')) {
                        chatInput.focus();
                        scrollToBottom();
                        if (!chatSessionId) loadChatHistory();
                    }
                });

                chatCloseBtn.addEventListener('click', () => {
                    chatWindow.classList.add('d-none');
                });

                // Utils
                function scrollToBottom() {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                function parseMarkdown(text) {
                    // Convert **bold** to <strong>
                    text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
                    // Convert *italic* to <em>
                    text = text.replace(/\*(.+?)\*/g, '<em>$1</em>');
                    // Convert numbered lists: 1. ...
                    text = text.replace(/^(\d+)\.\s+(.+)$/gm, '<li>$2</li>');
                    if (text.includes('<li>')) text = '<ol>' + text + '</ol>';
                    // Convert newlines to <br>
                    text = text.replace(/\n/g, '<br>');
                    return text;
                }

                function appendMessage(sender, content, id = null) {
                    // Prevent duplicates if we already appended this message ID
                    if (id && document.querySelector(`[data-msg-id="${id}"]`)) return;

                    if (sender === 'ai') {
                        const row = document.createElement('div');
                        row.className = 'msg-row-ai';
                        if (id) row.setAttribute('data-msg-id', id);

                        const avatar = document.createElement('div');
                        avatar.className = 'msg-avatar';
                        avatar.textContent = 'AI';

                        const bubble = document.createElement('div');
                        bubble.className = 'msg-bubble msg-ai';
                        bubble.innerHTML = parseMarkdown(content);

                        row.appendChild(avatar);
                        row.appendChild(bubble);
                        chatMessages.appendChild(row);
                    } else {
                        const div = document.createElement('div');
                        div.className = 'msg-bubble msg-user';
                        div.textContent = content;
                        if (id) div.setAttribute('data-msg-id', id);
                        chatMessages.appendChild(div);
                    }
                    scrollToBottom();
                }

                // Init history and socket
                function loadChatHistory() {
                    fetch('{{ route('chat.history') }}', {
                        headers: { 'Accept': 'application/json' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.messages && data.messages.length > 0) {
                                data.messages.forEach(msg => appendMessage(msg.sender, msg.content, msg.id));

                                // Set session and subscribe to Echo channel based on the first loaded message
                                chatSessionId = data.messages[0].chat_session_id;
                                listenToEchoChannel(chatSessionId);
                            }
                        });
                }

                function listenToEchoChannel(sessionId) {
                    if (echoChannel) return; // already listening

                    if (window.Echo) {
                        echoChannel = window.Echo.private(`chat.session.${sessionId}`)
                            .listen('MessageSent', (e) => {
                                // If it's the AI responding, append it. (User messages appended optimistically on send)
                                if (e.message.sender === 'ai') {
                                    removeTypingIndicator();
                                    appendMessage('ai', e.message.content, e.message.id);
                                }
                            });
                    } else {
                        console.warn("Laravel Echo not initialized. Real-time updates disabled.");
                    }
                }

                // Typing Indicator
                function showTypingIndicator() {
                    const id = 'typing-indicator-elem';
                    if (document.getElementById(id)) return;

                    const div = document.createElement('div');
                    div.id = id;
                    div.className = 'msg-bubble msg-ai typing-indicator';
                    div.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
                    chatMessages.appendChild(div);
                    scrollToBottom();
                }

                function removeTypingIndicator() {
                    const el = document.getElementById('typing-indicator-elem');
                    if (el) el.remove();
                }

                // Send Message
                chatForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const content = chatInput.value.trim();
                    if (!content) return;

                    // Optimistic UI update
                    appendMessage('user', content);
                    chatInput.value = '';
                    showTypingIndicator();

                    // CSRF Token
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ message: content })
                    })
                        .then(res => res.json())
                        .then(data => {
                            // Fallback: If AI message is returned in HTTP response, append it
                            if (data.ai_message) {
                                removeTypingIndicator();
                                appendMessage('ai', data.ai_message, data.message_id);
                            }

                            // Start listening if this is the very first message creating a session
                            if (!chatSessionId) {
                                // Re-load history to grab the fresh Session ID to bind the socket
                                setTimeout(loadChatHistory, 500);
                            }
                        })
                        .catch(err => {
                            removeTypingIndicator();
                            console.error("Chat send failed", err);
                        });
                });
            });
        </script>
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifItems = document.querySelectorAll('.notif-item');
            notifItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    const url = this.getAttribute('href');
                    if(url === '#') return;
                    
                    e.preventDefault();
                    const notifId = this.getAttribute('data-id');
                    
                    fetch('/notifications/' + notifId + '/read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    }).then(() => {
                        window.location.href = url;
                    }).catch(() => {
                        window.location.href = url;
                    });
                });
            });
        });
    </script>
</body>

</html>