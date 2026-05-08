@extends('layouts.admin')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="cat-icon-badge">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>
            <div>
                <h2 class="cat-page-title mb-1">Insurance Categories</h2>
                <p class="cat-page-subtitle mb-0">Manage and organize all available insurance types</p>
            </div>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn cat-btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Category
        </a>
    </div>

    {{-- ── Success Alert ── --}}
    @if(session('success'))
        <div class="alert cat-alert-success d-flex align-items-center gap-3 mb-4 rounded-4 border-0 p-3 ps-4 fade-in-up"
            role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    {{-- ── Main Card Table ── --}}
    <div class="cat-card">

        {{-- Table Toolbar --}}
        <div class="cat-toolbar">
            <div class="cat-toolbar-left">
                <span class="cat-total-badge">
                    <span id="visibleCount">{{ count($categories) }}</span> Categories
                </span>
            </div>
            <div class="cat-toolbar-right">
                {{-- Search --}}
                <div class="cat-search-wrap">
                    <i class="bi bi-search cat-search-icon"></i>
                    <input type="text" id="catSearch" class="cat-search-input" placeholder="Search categories...">
                </div>
                {{-- Status Filter --}}
                <select id="catFilter" class="cat-filter-select">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="cat-table-wrap">
            <table class="cat-table" id="catTable">
                <thead class="cat-thead">
                    <tr>
                        <th class="cat-th" style="width: 32px;">
                            <span class="cat-th-text">#</span>
                        </th>
                        <th class="cat-th">
                            <span class="cat-th-text">Category Name</span>
                        </th>
                        <th class="cat-th">
                            <span class="cat-th-text">Description</span>
                        </th>
                        <th class="cat-th" style="width: 110px;">
                            <span class="cat-th-text">Status</span>
                        </th>
                        <th class="cat-th" style="width: 60px; text-align: right;">
                            <span class="cat-th-text">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="catTbody">
                    @forelse($categories as $index => $category)
                        <tr class="cat-row" data-name="{{ strtolower($category->name) }}"
                            data-status="{{ $category->is_active ? 'active' : 'inactive' }}">

                            {{-- Index --}}
                            <td class="cat-td cat-td-index">{{ $index + 1 }}</td>

                            {{-- Name --}}
                            <td class="cat-td">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="cat-row-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div>
                                        <div class="cat-name">{{ $category->name }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Description --}}
                            <td class="cat-td">
                                <span class="cat-desc">{{ Str::limit($category->description, 65) }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="cat-td">
                                @if($category->is_active)
                                    <span class="cat-badge cat-badge-active">
                                        <span class="cat-badge-dot"></span> Active
                                    </span>
                                @else
                                    <span class="cat-badge cat-badge-inactive">
                                        <span class="cat-badge-dot"></span> Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="cat-td" style="text-align: right;">
                                <div class="dropdown">
                                    <button class="cat-action-btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end cat-dropdown shadow-sm">
                                        <li>
                                            <a class="dropdown-item cat-dropdown-item"
                                                href="{{ route('admin.categories.edit', $category) }}">
                                                <i class="bi bi-pencil"></i> Edit Category
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" value="{{ $category->name }}">
                                                <input type="hidden" name="description" value="{{ $category->description }}">
                                                <input type="hidden" name="is_active"
                                                    value="{{ $category->is_active ? 0 : 1 }}">
                                                <button type="submit"
                                                    class="dropdown-item cat-dropdown-item {{ $category->is_active ? 'text-warning' : 'text-success' }}">
                                                    @if($category->is_active)
                                                        <i class="bi bi-pause-circle"></i> Deactivate
                                                    @else
                                                        <i class="bi bi-play-circle"></i> Activate
                                                    @endif
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="cat-empty-row">
                                <div class="cat-empty-state">
                                    <div class="cat-empty-icon">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </div>
                                    <h6 class="cat-empty-title">No categories found</h6>
                                    <p class="cat-empty-sub">Get started by creating your first insurance category.</p>
                                    <a href="{{ route('admin.categories.create') }}" class="btn cat-btn-primary btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Add Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="cat-table-footer">
            <span class="cat-footer-text">Showing <span id="footerCount">{{ count($categories) }}</span> of
                {{ count($categories) }} categories</span>
        </div>
    </div>

    <style>
        /* ── Variables ── */
        :root {
            --cat-brand: #4f46e5;
            --cat-brand-light: rgba(79, 70, 229, 0.08);
            --cat-border: #e8edf3;
            --cat-bg: #f8fafc;
            --cat-text: #0f172a;
            --cat-muted: #64748b;
            --cat-radius: 16px;
            --cat-radius-sm: 10px;
        }

        /* ── Header ── */
        .cat-icon-badge {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--cat-brand-light);
            color: var(--cat-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .cat-page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--cat-text);
            letter-spacing: -0.5px;
        }

        .cat-page-subtitle {
            font-size: 0.9rem;
            color: var(--cat-muted);
        }

        /* ── Primary Button ── */
        .cat-btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            border: none;
            border-radius: var(--cat-radius-sm);
            padding: 0.6rem 1.4rem;
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.28);
            transition: all 0.2s ease;
        }

        .cat-btn-primary:hover {
            transform: translateY(-1px);
            color: #fff;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.38);
        }

        /* ── Alert ── */
        .cat-alert-success {
            background: rgba(25, 135, 84, 0.07);
        }

        /* ── Main Card ── */
        .cat-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--cat-border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05), 0 1px 4px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* ── Toolbar ── */
        .cat-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--cat-border);
            background: #fdfdfe;
        }

        .cat-toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cat-total-badge {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--cat-brand);
            background: var(--cat-brand-light);
            padding: 4px 12px;
            border-radius: 999px;
        }

        /* ── Search ── */
        .cat-search-wrap {
            position: relative;
        }

        .cat-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cat-muted);
            font-size: 0.8rem;
            pointer-events: none;
        }

        .cat-search-input {
            padding: 0.45rem 0.9rem 0.45rem 2rem;
            border: 1.5px solid var(--cat-border);
            border-radius: var(--cat-radius-sm);
            background: var(--cat-bg);
            color: var(--cat-text);
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 200px;
        }

        .cat-search-input:focus {
            border-color: var(--cat-brand);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            background: #fff;
        }

        .cat-filter-select {
            padding: 0.45rem 2rem 0.45rem 0.8rem;
            border: 1.5px solid var(--cat-border);
            border-radius: var(--cat-radius-sm);
            background: var(--cat-bg);
            color: var(--cat-muted);
            font-size: 0.85rem;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            transition: border-color 0.2s;
        }

        .cat-filter-select:focus {
            border-color: var(--cat-brand);
            outline: none;
        }

        /* ── Table ── */
        .cat-table-wrap {
            overflow-x: auto;
        }

        .cat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .cat-thead {
            background: #fafbfc;
        }

        .cat-th {
            padding: 12px 20px;
            border-bottom: 1px solid var(--cat-border);
            text-align: left;
        }

        .cat-th-text {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--cat-muted);
        }

        /* ── Row ── */
        .cat-row {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .cat-row:last-child {
            border-bottom: none;
        }

        .cat-row:hover {
            background: #f8f9ff;
        }

        .cat-td {
            padding: 16px 20px;
            vertical-align: middle;
            color: var(--cat-text);
        }

        .cat-td-index {
            color: var(--cat-muted);
            font-size: 0.82rem;
            font-weight: 500;
        }

        /* ── Row icon ── */
        .cat-row-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--cat-brand-light);
            color: var(--cat-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .cat-name {
            font-weight: 600;
            color: var(--cat-text);
            font-size: 0.92rem;
        }

        .cat-desc {
            color: var(--cat-muted);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* ── Status Badges ── */
        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .cat-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cat-badge-active {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .cat-badge-active .cat-badge-dot {
            background: #10b981;
        }

        .cat-badge-inactive {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .cat-badge-inactive .cat-badge-dot {
            background: #94a3b8;
        }

        /* ── Action Button ── */
        .cat-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--cat-border);
            background: #fff;
            color: var(--cat-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .cat-action-btn:hover {
            background: var(--cat-bg);
            border-color: #cbd5e1;
            color: var(--cat-text);
        }

        /* ── Dropdown ── */
        .cat-dropdown {
            border: 1px solid var(--cat-border);
            border-radius: 12px;
            padding: 6px;
            min-width: 160px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
        }

        .cat-dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--cat-text);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s;
        }

        .cat-dropdown-item:hover {
            background: var(--cat-bg);
            color: var(--cat-text);
        }

        .cat-dropdown-item i {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* ── Empty State ── */
        .cat-empty-row {
            padding: 60px 20px;
        }

        .cat-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 8px;
        }

        .cat-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--cat-bg);
            color: var(--cat-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .cat-empty-title {
            font-weight: 700;
            color: var(--cat-text);
            margin: 0;
        }

        .cat-empty-sub {
            font-size: 0.85rem;
            color: var(--cat-muted);
            margin: 0 0 12px;
        }

        /* ── Table Footer ── */
        .cat-table-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--cat-border);
            background: #fdfdfe;
        }

        .cat-footer-text {
            font-size: 0.8rem;
            color: var(--cat-muted);
            font-weight: 500;
        }

        /* Hidden row on search */
        .cat-row-hidden {
            display: none;
        }
    </style>

    @push('admin_scripts')
        <script>
            const searchInput = document.getElementById('catSearch');
            const filterSelect = document.getElementById('catFilter');
            const rows = document.querySelectorAll('.cat-row');
            const visibleCountEl = document.getElementById('visibleCount');
            const footerCountEl = document.getElementById('footerCount');

            function filterTable() {
                const query = searchInput.value.toLowerCase().trim();
                const status = filterSelect.value;
                let count = 0;

                rows.forEach(row => {
                    const name = row.dataset.name || '';
                    const rowStatus = row.dataset.status || '';
                    const matchName = name.includes(query);
                    const matchStatus = status === 'all' || rowStatus === status;

                    if (matchName && matchStatus) {
                        row.classList.remove('cat-row-hidden');
                        count++;
                    } else {
                        row.classList.add('cat-row-hidden');
                    }
                });

                visibleCountEl.textContent = count;
                footerCountEl.textContent = count;
            }

            searchInput.addEventListener('input', filterTable);
            filterSelect.addEventListener('change', filterTable);
        </script>
    @endpush

@endsection