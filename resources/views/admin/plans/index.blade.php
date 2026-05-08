@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                style="width: 48px; height: 48px;">
                <i class="bi bi-box-seam fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark fs-3" style="letter-spacing: -0.5px;">Insurance Plan Management</h2>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Create, manage and organize all available insurance
                    products</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.plans.create') }}"
                class="btn btn-primary premium-btn shadow-sm px-4 rounded-pill d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add New Plan
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success rounded-4 d-flex align-items-center mb-4 p-3 ps-4 fade-in-up"
            role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-3"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    <!-- ===== STATS SECTION: Manual Scroll Horizontal Cards ===== -->
    <div class="stats-section-wrapper position-relative mb-5">

        <!-- Left Scroll Button -->
        <button class="stats-scroll-btn stats-scroll-left" id="scrollLeft" aria-label="Scroll Left"
            onclick="document.getElementById('categoryScrollTrack').scrollBy({left: -320, behavior: 'smooth'})">
            <i class="bi bi-chevron-left"></i>
        </button>

        <!-- Full-width scrollable row -->
        <div class="stats-scroll-outer d-flex align-items-stretch" style="min-height: 180px;">

            <!-- TOTAL PLANS — pinned left -->
            <div class="stats-pinned-card">
                <div class="card border-0 h-100 position-relative shadow-md total-plans-card"
                    style="border-radius: 16px; min-height: 165px;">
                    <div class="stat-accent bg-indigo"></div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between"
                        style="background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%); border-radius: 16px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="icon-wrap bg-indigo bg-opacity-10 text-indigo rounded-3 d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 44px; height: 44px;">
                                <i class="bi bi-boxes" style="font-size: 1.2rem;"></i>
                            </div>
                            <span class="badge bg-indigo bg-opacity-10 text-indigo rounded-pill px-3 py-1 fw-semibold"
                                style="font-size: 0.7rem; border: 1px solid rgba(99,102,241,0.2);">All</span>
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold text-dark" style="font-size: 2.4rem; letter-spacing: -2px; line-height: 1;">
                                {{ number_format($totalPlans) }}
                            </div>
                            <p class="text-muted mb-0 fw-semibold mt-1"
                                style="font-size: 0.7rem; letter-spacing: 0.8px; text-transform: uppercase;">Total Insurance
                                Plans</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separator line -->
            <div class="align-self-center mx-1" style="width: 1px; min-height: 120px; background: #e2e8f0; flex-shrink: 0;">
            </div>

            <!-- SCROLLABLE CATEGORY CARDS -->
            <div class="stats-scroll-track" id="categoryScrollTrack">
                @foreach($categoryStats as $stat)
                    <div class="stats-cat-card-wrap">
                        <div class="card border-0 h-100 position-relative category-slide-card"
                            style="border-radius: 14px; min-height: 165px;">
                            <div class="stat-accent bg-{{ $stat->color }}"></div>
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="icon-wrap bg-{{ $stat->color }} bg-opacity-10 text-{{ $stat->color }} rounded-3 d-flex align-items-center justify-content-center mb-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi {{ $stat->icon }}" style="font-size: 1.15rem;"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"
                                        style="font-size: 1.6rem; letter-spacing: -1px; line-height: 1;">
                                        {{ number_format($stat->count) }}
                                    </div>
                                    <p class="text-muted mb-0 fw-semibold mt-1 text-truncate"
                                        style="font-size: 0.68rem; letter-spacing: 0.6px; text-transform: uppercase; max-width: 150px;">
                                        {{ $stat->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Scroll Button -->
        <button class="stats-scroll-btn stats-scroll-right" id="scrollRight" aria-label="Scroll Right"
            onclick="document.getElementById('categoryScrollTrack').scrollBy({left: 320, behavior: 'smooth'})">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>


    <!-- Main Content Area -->
    <div class="card border-0 shadow-sm premium-table-card rounded-4 overflow-hidden mb-5 fade-in-up"
        style="animation-delay: 0.1s;">
        <!-- Smart Filters Row -->
        <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4">
            <form action="{{ route('admin.plans.index') }}" method="GET" class="row g-3 align-items-center">

                <div class="col-lg-3 col-md-12">
                    <div class="input-group search-group">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 bg-light py-2 shadow-none"
                            placeholder="Search by plan name..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 mt-md-3 mt-lg-0">
                    <select name="category"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 mt-md-3 mt-lg-0">
                    <select name="premium_range"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="">Any Premium</option>
                        <option value="0-50" {{ request('premium_range') === '0-50' ? 'selected' : '' }}>$0 - $50</option>
                        <option value="51-100" {{ request('premium_range') === '51-100' ? 'selected' : '' }}>$51 - $100
                        </option>
                        <option value="101+" {{ request('premium_range') === '101+' ? 'selected' : '' }}>$101+</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-4 mt-md-3 mt-lg-0">
                    <select name="sort"
                        class="form-select border-0 bg-light py-2 shadow-none modern-select text-secondary fw-medium">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest Added</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Premium: High to
                            Low</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Premium: Low to High
                        </option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </div>

                <div class="col-lg-1 col-md-12 mt-md-3 mt-lg-0 d-flex justify-content-end">
                    <button type="submit"
                        class="btn btn-dark w-100 rounded-pill py-2 fw-medium btn-filter-submit d-flex justify-content-center align-items-center">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table premium-table mb-0 align-middle">
                    <thead class="bg-light bg-opacity-50 border-bottom border-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small" style="width: 40px;">
                                <input class="form-check-input" type="checkbox">
                            </th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Product</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small"
                                style="letter-spacing: 0.5px;">Category</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-center"
                                style="letter-spacing: 0.5px;">Status</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-end"
                                style="letter-spacing: 0.5px;">Base Premium</th>
                            <th class="border-0 px-4 py-3 text-uppercase text-muted fw-bold small text-end"
                                style="letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" style="border-top-color: transparent;">
                        @forelse($plans as $plan)
                            @php
                                $isHighValue = $plan->base_premium >= 100;
                                $catName = strtolower($plan->category->name);
                                $badgeClass = 'bg-secondary bg-opacity-10 text-secondary border-secondary';

                                // Category Badge Logistics
                                if (str_contains($catName, 'life')) {
                                    $badgeClass = 'bg-info bg-opacity-10 text-info border-info';
                                } elseif (str_contains($catName, 'health')) {
                                    $badgeClass = 'bg-success bg-opacity-10 text-success border-success';
                                } elseif (str_contains($catName, 'car') || str_contains($catName, 'auto')) {
                                    $badgeClass = 'bg-warning bg-opacity-10 text-warning border-warning';
                                }
                            @endphp

                            <tr class="table-row-hover position-relative pb-1">
                                <td class="px-4 py-3 border-light">
                                    <input class="form-check-input border-secondary border-opacity-25" type="checkbox"
                                        value="{{ $plan->id }}">
                                </td>
                                <td class="px-4 py-3 border-light">
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Dynamic Image Column logic -->
                                        <div class="flex-shrink-0">
                                            @if($plan->image_path)
                                                <img src="{{ asset('storage/' . $plan->image_path) }}" alt="{{ $plan->name }}"
                                                    class="shadow-sm border border-light"
                                                    style="width: 48px; height: 48px; object-fit: cover; border-radius: 12px;">
                                            @else
                                                <div class="shadow-sm border border-light d-flex align-items-center justify-content-center text-white"
                                                    style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #94a3b8, #64748b);">
                                                    <i class="bi bi-shield-check fs-5"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $plan->name }}</div>
                                            <div class="text-muted small text-truncate" style="max-width: 200px;">
                                                {{ Str::limit($plan->description, 40) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-light">
                                    <span
                                        class="badge rounded-pill fw-bold border px-3 py-1 border-opacity-25 {{ $badgeClass }}">
                                        {{ $plan->category->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border-light text-center">
                                    <div class="form-check form-switch d-flex justify-content-center m-0">
                                        <input class="form-check-input active-toggle" type="checkbox" role="switch" checked
                                            title="Toggle Active Status">
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-light text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="fw-bold fs-5 {{ $isHighValue ? 'text-indigo' : 'text-dark' }}">
                                            ${{ number_format($plan->base_premium, 2) }}
                                        </span>
                                        <span class="text-muted small">/ year</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-light text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm hover-elevate"
                                            style="width: 36px; height: 36px;" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3 p-2">
                                            <li>
                                                <a class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-dark hover-bg-light"
                                                    href="{{ route('admin.plans.edit', $plan) }}">
                                                    <i class="bi bi-pencil-square text-primary"></i> Edit Product
                                                </a>
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-dark hover-bg-light">
                                                    <i class="bi bi-copy text-secondary"></i> Duplicate
                                                </button>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider my-1">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST"
                                                    class="m-0 p-0"
                                                    onsubmit="return confirm('WARNING: Are you sure you want to delete this insurance product? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item py-2 fw-medium rounded-2 d-flex align-items-center gap-2 text-danger hover-bg-danger">
                                                        <i class="bi bi-trash3"></i> Delete Product
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 80px; height: 80px;">
                                            <i class="bi bi-box2 fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No insurance plans found</h5>
                                        <p>Try adjusting your search criteria or create a new product.</p>
                                        @if(request()->anyFilled(['search', 'category', 'premium_range']))
                                            <a href="{{ route('admin.plans.index') }}"
                                                class="btn btn-link text-decoration-none border rounded-pill px-4 mt-2">Clear all
                                                filters</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modern Pagination -->
        @if($plans->hasPages())
            <div class="card-footer bg-white border-top border-light p-4">
                {{ $plans->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        /* Stats Cards */
        .premium-stat-card,
        .category-slide-card {
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            background-color: #fff;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .category-slide-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1), 0 4px 8px -4px rgba(0, 0, 0, 0.05);
        }

        /* ===== STATS SECTION: Manual Scroll Layout ===== */
        .stats-section-wrapper {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .stats-scroll-outer {
            width: 100%;
            overflow: hidden;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            padding: 16px 48px;
            gap: 0;
        }

        /* Fixed total plans sidebar */
        .stats-pinned-card {
            flex: 0 0 220px;
            min-width: 220px;
            padding-right: 12px;
        }

        /* Scrollable category track */
        .stats-scroll-track {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: stretch;
            gap: 12px;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            /* Hide scrollbar visually */
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 4px 2px;
        }

        .stats-scroll-track::-webkit-scrollbar {
            display: none;
        }

        /* Each category card wrapper */
        .stats-cat-card-wrap {
            flex: 0 0 165px;
            min-width: 165px;
        }

        /* Scroll buttons */
        .stats-scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            transition: all 0.2s ease;
            font-size: 0.85rem;
            padding: 0;
            line-height: 1;
        }

        .stats-scroll-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #1e293b;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.13);
            transform: translateY(-50%) scale(1.06);
        }

        .stats-scroll-left {
            left: 6px;
        }

        .stats-scroll-right {
            right: 6px;
        }

        .total-plans-card {
            border: 1px solid rgba(99, 102, 241, 0.2) !important;
        }

        .total-plans-card:hover {
            transform: scale(1.02) translateY(-2px) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
        }

        .bg-indigo {
            background-color: #4f46e5;
        }

        .text-indigo {
            color: #4f46e5;
        }

        .border-indigo {
            border-color: #4f46e5;
        }

        /* Enforced Swiper Category Colors */
        .bg-info.bg-opacity-10 {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }

        .text-info {
            color: #0dcaf0 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
        }

        .bg-success.bg-opacity-10 {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .bg-warning.bg-opacity-10 {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .bg-danger.bg-opacity-10 {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-secondary.bg-opacity-10 {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .category-slide-card .icon-wrap i {
            font-size: 1.5rem !important;
        }

        /* Buttons */
        .premium-btn {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .premium-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(99, 102, 241, 0.4);
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        }

        .hover-elevate {
            transition: all 0.2s ease;
        }

        .hover-elevate:hover {
            transform: translateY(-2px);
            background-color: #f1f5f9;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }

        .btn-filter-submit {
            transition: all 0.2s ease;
        }

        .btn-filter-submit:hover {
            background-color: #334155;
            transform: translateY(-1px);
        }

        /* Filters Box */
        .search-group input {
            border-radius: 0 12px 12px 0;
            height: 44px;
        }

        .search-group .input-group-text {
            border-radius: 12px 0 0 12px;
            height: 44px;
        }

        .search-group input:focus {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
        }

        .search-group:focus-within .input-group-text {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
            border-right: none !important;
            color: #6366f1 !important;
        }

        .modern-select {
            height: 44px;
            border-radius: 12px;
            cursor: pointer;
        }

        .modern-select:focus {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 1px #818cf8 !important;
        }

        /* Table Design */
        .premium-table-card {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }

        .premium-table th {
            color: #64748b;
            background-color: transparent;
        }

        .premium-table td {
            color: #1e293b;
            vertical-align: middle;
            background-color: #fff;
        }

        .table-row-hover td {
            transition: background-color 0.2s ease;
        }

        /* Alternate row tinting logic overriden natively for custom effect */
        .table-row-hover:nth-child(even) td {
            background-color: #fafbfd;
        }

        .table-row-hover:hover td {
            background-color: #f1f5f9;
        }

        /* Toggle Switch customized */
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
            cursor: pointer;
        }

        .form-switch .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        /* Dropdown hovers */
        .hover-bg-light:hover {
            background-color: #f1f5f9;
        }

        .hover-bg-danger:hover {
            background-color: #fef2f2 !important;
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

        /* Custom pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px !important;
            margin: 0 4px;
            border: none;
            color: #475569;
            font-weight: 500;
            transition: all 0.2s;
        }

        .page-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .page-item.active .page-link {
            background-color: #1e293b;
            border-color: #1e293b;
            color: white;
            box-shadow: 0 4px 10px rgba(30, 41, 59, 0.3);
        }
    </style>

@endsection