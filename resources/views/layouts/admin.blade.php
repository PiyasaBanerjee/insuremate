<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InsureMate') }} - Admin Portal</title>

    <!-- Preconnect URLs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts (Inter for clean SaaS look) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Chart.js for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --admin-bg: #f5f7fb;
            --admin-sidebar-bg: #0f172a;
            --admin-sidebar-hover: rgba(255, 255, 255, 0.08);
            --admin-sidebar-active: rgba(99, 102, 241, 0.15);
            --admin-accent: #6366f1;
            --admin-text-main: #1e293b;
            --admin-text-muted: #64748b;
            --admin-border: #e2e8f0;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text-main);
            overflow-x: hidden;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--admin-sidebar-bg);
            background-image: linear-gradient(180deg, #0a0f1d 0%, #1e1b4b 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.05), 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .admin-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-brand i {
            color: #818cf8;
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .sidebar-menu {
            flex-grow: 1;
            padding: 1.5rem 1rem;
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            margin-right: 1rem;
            font-size: 1.15rem;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #f8fafc;
            background: var(--admin-sidebar-hover);
        }

        .sidebar-link:hover i {
            color: #94a3b8;
        }

        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, transparent 100%);
            border-left-color: var(--admin-accent);
            box-shadow: inset 3px 0 10px -3px rgba(99, 102, 241, 0.5);
        }

        .sidebar-link.active i {
            color: #818cf8;
            filter: drop-shadow(0 0 6px rgba(129, 140, 248, 0.6));
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            font-weight: 700;
            margin: 1.5rem 0 0.75rem 1rem;
        }

        /* Main Content Wrapper */
        .admin-main-wrapper {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
            max-width: calc(100vw - var(--sidebar-width));
        }

        /* Top Navbar */
        .admin-topbar {
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 4px 20px -10px rgba(0, 0, 0, 0.05);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .topbar-icon-btn {
            background: none;
            border: none;
            color: var(--admin-text-muted);
            position: relative;
            font-size: 1.25rem;
            transition: color 0.2s ease;
            padding: 0;
        }

        .topbar-icon-btn:hover {
            color: var(--admin-text-main);
        }

        .topbar-icon-btn .badge-dot {
            position: absolute;
            top: 0px;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .admin-profile-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: none;
            border: none;
            color: var(--admin-text-main);
            font-weight: 500;
            text-decoration: none;
        }

        .admin-profile-dropdown .dropdown-toggle::after {
            display: none;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
            border: 2px solid #fff;
        }

        .dropdown-menu-custom {
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            margin-top: 0.5rem !important;
        }

        .dropdown-item-custom {
            border-radius: 6px;
            padding: 0.6rem 1rem;
            color: var(--admin-text-main);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item-custom:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        /* Page Content */
        .admin-content {
            padding: 2.5rem 2rem;
            flex-grow: 1;
            overflow-x: hidden;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Smooth Fade In */
        .fade-in-content {
            animation: fadeIn 0.4s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-elevate {
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }

        .dropdown-menu-custom {
            animation: dropdownFade 0.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            transform-origin: top right;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-main-wrapper {
                margin-left: 0;
            }
        }

        @stack('admin_styles')

        /* ── Notification Panel ── */
        .notif-dropdown {
            position: relative;
        }

        .notif-count-badge {
            position: absolute;
            top: -5px;
            right: -7px;
            background: #ef4444;
            color: #fff;
            font-size: 0.62rem;
            font-weight: 800;
            min-width: 17px;
            height: 17px;
            border-radius: 999px;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            line-height: 1;
        }

        .notif-panel {
            width: 360px;
            padding: 0;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            margin-top: 10px !important;
        }

        .notif-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }

        .notif-header-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
        }

        .notif-header-badge {
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .notif-scroll {
            max-height: 380px;
            overflow-y: auto;
            background: #fff;
        }

        .notif-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .notif-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .notif-section-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #94a3b8;
            padding: 8px 18px 4px;
            background: #fafbfc;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 18px;
            border-bottom: 1px solid #f8fafc;
            text-decoration: none;
            color: inherit;
            transition: background 0.15s ease;
            position: relative;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: #f8f9ff;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .notif-icon-blue {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .notif-icon-indigo {
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
        }

        .notif-icon-green {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .notif-icon-red {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .notif-icon-amber {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .notif-body {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-size: 0.84rem;
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-sub {
            font-size: 0.74rem;
            color: #64748b;
            margin-top: 2px;
        }

        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4f46e5;
            flex-shrink: 0;
            margin-top: 6px;
        }

        .notif-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 36px 20px;
            gap: 6px;
        }

        .notif-empty-icon {
            font-size: 2rem;
            color: #10b981;
        }

        .notif-empty-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .notif-empty-sub {
            font-size: 0.78rem;
            color: #64748b;
        }

        .notif-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 18px;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
            gap: 8px;
        }

        .notif-footer-link {
            font-size: 0.78rem;
            font-weight: 600;
            color: #4f46e5;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: opacity 0.2s;
        }

        .notif-footer-link:hover {
            opacity: 0.75;
            color: #4f46e5;
        }
    </style>
</head>

<body>

    <!-- Fixed Sidebar -->
    <aside class="admin-sidebar">
        <a href="{{ url('/') }}" class="admin-brand">
            <i class="bi bi-shield-check"></i>
            <span>InsureMate <span
                    style="font-size: 0.7rem; color: #818cf8; vertical-align: top; margin-left:2px;">PRO</span></span>
        </a>

        <div class="sidebar-menu">
            <div class="sidebar-section-title">Overview</div>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <div class="sidebar-section-title">Management</div>
            <a href="{{ route('admin.users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manage Users
            </a>
            <a href="{{ route('admin.agents.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Manage Agents
                @php $pendingAgents = \App\Models\Agent::where('status','pending')->count(); @endphp
                @if($pendingAgents > 0)
                    <span style="margin-left:auto;background:#ef4444;color:white;border-radius:50px;font-size:0.7rem;padding:1px 7px;font-weight:700;">{{ $pendingAgents }}</span>
                @endif
            </a>
            <a href="{{ route('admin.policies.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.policies.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i> Policies
            </a>
            <a href="{{ route('admin.claims.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.claims.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-pulse"></i> Claims
            </a>
            <a href="{{ route('admin.plans.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Insurance Plans
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>

            <div class="sidebar-section-title">Operations</div>
            <a href="{{ route('admin.payments.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Payments
            </a>
            <a href="{{ route('admin.tickets.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-detailed"></i> Support Tickets
            </a>
            <a href="{{ route('admin.contacts.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-dots"></i> Contact Messages
            </a>
        </div>
    </aside>

    <!-- Main Wrapper Container -->
    <div class="admin-main-wrapper">

        <!-- Top Navbar -->
        <header class="admin-topbar">
            <div>
                <!-- Could add breadcrumbs or page title here dynamically if needed -->
            </div>

            <div class="topbar-right">
                {{-- ── Notification Bell ── --}}
                <div class="dropdown notif-dropdown">
                    <button class="topbar-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        id="notifBellBtn">
                        <i class="bi bi-bell"></i>
                        @if(($totalNotifCount ?? 0) > 0)
                            <span class="notif-count-badge">{{ min($totalNotifCount ?? 0, 99) }}</span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-end notif-panel" aria-labelledby="notifBellBtn">
                        {{-- Header --}}
                        <div class="notif-header">
                            <span class="notif-header-title">Notifications</span>
                            @if(($totalNotifCount ?? 0) > 0)
                                <span class="notif-header-badge">{{ $totalNotifCount }} new</span>
                            @endif
                        </div>

                        <div class="notif-scroll">

                            {{-- Unanswered Tickets --}}
                            @if(isset($newTickets) && $newTickets->count())
                                <div class="notif-section-label"><i class="bi bi-headset me-1"></i> Unanswered Tickets</div>
                                @foreach($newTickets as $t)
                                    <a href="{{ route('admin.tickets.show', $t) }}" class="notif-item">
                                        <div class="notif-icon notif-icon-blue"><i class="bi bi-ticket-detailed"></i></div>
                                        <div class="notif-body">
                                            <div class="notif-title">{{ Str::limit($t->subject, 36) }}</div>
                                            <div class="notif-sub">{{ $t->user?->name ?? 'Unknown' }} &middot;
                                                {{ $t->created_at->diffForHumans() }}</div>
                                        </div>
                                        <span class="notif-dot"></span>
                                    </a>
                                @endforeach
                            @endif

                            {{-- New Contact Messages --}}
                            @if(isset($newContacts) && $newContacts->count())
                                <div class="notif-section-label"><i class="bi bi-envelope-open me-1"></i> New Messages</div>
                                @foreach($newContacts as $c)
                                    <a href="{{ route('admin.contacts.index') }}" class="notif-item">
                                        <div class="notif-icon notif-icon-indigo"><i class="bi bi-chat-left-text"></i></div>
                                        <div class="notif-body">
                                            <div class="notif-title">{{ $c->name }} — {{ Str::limit($c->subject, 26) }}</div>
                                            <div class="notif-sub">{{ $c->email }} &middot;
                                                {{ $c->created_at->diffForHumans() }}</div>
                                        </div>
                                        <span class="notif-dot"></span>
                                    </a>
                                @endforeach
                            @endif

                            {{-- New Users --}}
                            @if(isset($newUsers) && $newUsers->count())
                                <div class="notif-section-label"><i class="bi bi-person-plus me-1"></i> New Registrations
                                </div>
                                @foreach($newUsers as $u)
                                    <a href="{{ route('admin.users.index') }}" class="notif-item">
                                        <div class="notif-icon notif-icon-green"><i class="bi bi-person-circle"></i></div>
                                        <div class="notif-body">
                                            <div class="notif-title">{{ $u->name }} joined</div>
                                            <div class="notif-sub">{{ $u->email }} &middot;
                                                {{ $u->created_at->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif

                            {{-- Failed Payments --}}
                            @if(isset($failedPayments) && $failedPayments->count())
                                <div class="notif-section-label"><i class="bi bi-exclamation-triangle me-1"></i> Failed
                                    Payments</div>
                                @foreach($failedPayments as $p)
                                    <a href="{{ route('admin.payments.index') }}" class="notif-item">
                                        <div class="notif-icon notif-icon-red"><i class="bi bi-credit-card"></i></div>
                                        <div class="notif-body">
                                            <div class="notif-title">₹{{ number_format($p->amount, 2) }} payment failed</div>
                                            <div class="notif-sub">{{ $p->user?->name ?? 'Unknown' }} &middot;
                                                {{ $p->created_at->diffForHumans() }}</div>
                                        </div>
                                        <span class="notif-dot" style="background:#ef4444;"></span>
                                    </a>
                                @endforeach
                            @endif

                            {{-- All clear --}}
                            @if(($totalNotifCount ?? 0) === 0)
                                <div class="notif-empty">
                                    <div class="notif-empty-icon"><i class="bi bi-check-circle"></i></div>
                                    <div class="notif-empty-title">All caught up!</div>
                                    <div class="notif-empty-sub">No pending notifications right now.</div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="notif-footer">
                            <a href="{{ route('admin.tickets.index') }}" class="notif-footer-link">
                                View all tickets <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            <a href="{{ route('admin.contacts.index') }}" class="notif-footer-link">
                                View messages <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dropdown admin-profile-dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-avatar">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="d-none d-md-block">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item dropdown-item-custom" href="{{ url('/') }}">
                                <i class="bi bi-house-door me-2 text-muted"></i> Return to Site
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-light">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item dropdown-item-custom text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Injection -->
        <main class="admin-content fade-in-content">
            @if (session('status') || session('success') || session('error'))
                <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"
                    role="alert">
                    <i class="bi {{ session('error') ? 'bi-exclamation-triangle' : 'bi-check-circle' }} me-2"></i>
                    {{ session('status') ?? session('success') ?? session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('admin_scripts')
</body>

</html>