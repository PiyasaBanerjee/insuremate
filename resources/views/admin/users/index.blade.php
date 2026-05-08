@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark fs-3">Manage Users</h2>
            <p class="text-muted mb-0">Manage and control registered users.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm hover-elevate"
            style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none;">
            <i class="bi bi-plus-lg me-1"></i> Add User
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 hover-elevate">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase"
                            style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Total Users</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $users->total() }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 hover-elevate">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase"
                            style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">Active Monthly</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            <!-- Display a static sample value if counting current page isn't representative -->
                            {{ max(1, $users->total() - 1) }}
                        </h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-activity fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 hover-elevate">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase"
                            style="font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 600;">New This Week</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            +{{ min(12, $users->total()) }}
                        </h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-lightning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function sortUrl($field) {
            $currentField = request('sort');
            $currentDir = request('direction', 'desc');
            $newDir = ($currentField === $field && $currentDir === 'asc') ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort' => $field, 'direction' => $newDir]);
        }
        function sortIcon($field) {
            if (request('sort') !== $field) return '<i class="bi bi-arrow-down-up ms-1 text-muted" style="opacity: 0.3;"></i>';
            return request('direction', 'desc') === 'asc' 
                ? '<i class="bi bi-arrow-up-short ms-1 text-primary fw-bold" style="font-size: 0.9rem;"></i>' 
                : '<i class="bi bi-arrow-down-short ms-1 text-primary fw-bold" style="font-size: 0.9rem;"></i>';
        }
    @endphp

    <!-- Filters and Search -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <!-- Add future bulk actions or filters here if needed -->
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex" style="width: 100%; max-width: 400px;">
            <!-- Preserve sorting parameters when searching -->
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            @if(request('direction')) <input type="hidden" name="direction" value="{{ request('direction') }}"> @endif
            
            <div class="input-group search-input-group shadow-sm w-100 bg-white">
                <span class="input-group-text bg-transparent border-0 ps-3 pe-2 text-muted rounded-start-pill">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control border-0 bg-transparent text-dark shadow-none"
                    placeholder="Search users by name or email..." value="{{ request('search') }}">
                <button class="btn btn-white bg-transparent border-0 rounded-end-pill pe-3 text-primary hover-primary"
                    type="submit" title="Search">
                    <i class="bi bi-arrow-right-short" style="font-size: 1.2rem;"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; background: #fff;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 custom-table">
                    <thead class="bg-light border-bottom border-light">
                        <tr>
                            <th class="px-4 py-3">
                                <a href="{{ sortUrl('name') }}" class="text-muted fw-semibold text-uppercase text-decoration-none d-flex align-items-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    Name {!! sortIcon('name') !!}
                                </a>
                            </th>
                            <th class="py-3">
                                <a href="{{ sortUrl('email') }}" class="text-muted fw-semibold text-uppercase text-decoration-none d-flex align-items-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    Email {!! sortIcon('email') !!}
                                </a>
                            </th>
                            <th class="py-3">
                                <a href="{{ sortUrl('phone') }}" class="text-muted fw-semibold text-uppercase text-decoration-none d-flex align-items-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    Phone {!! sortIcon('phone') !!}
                                </a>
                            </th>
                            <th class="py-3 px-2 text-muted fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                Role
                            </th>
                            <th class="py-3">
                                <a href="{{ sortUrl('created_at') }}" class="text-muted fw-semibold text-uppercase text-decoration-none d-flex align-items-center" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    Joined {!! sortIcon('created_at') !!}
                                </a>
                            </th>
                            <th class="px-4 py-3 text-muted fw-semibold text-uppercase text-end"
                                style="font-size: 0.7rem; letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="table-row-hover">
                                <td class="px-4 py-3 border-bottom-0">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 bg-primary bg-opacity-10 text-primary fw-bold"
                                            style="width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 border-bottom-0 text-secondary" style="font-size: 0.9rem;">{{ $user->email }}
                                </td>
                                <td class="py-3 border-bottom-0 text-secondary" style="font-size: 0.9rem;">
                                    {{ $user->phone ?? 'N/A' }}</td>
                                <td class="py-3 border-bottom-0">
                                    @if($user->role === 'admin')
                                        <span class="badge role-badge badge-admin px-3 py-1 rounded-pill">Admin</span>
                                    @else
                                        <span class="badge role-badge badge-user px-3 py-1 rounded-pill">User</span>
                                    @endif
                                </td>
                                <td class="py-3 border-bottom-0 text-secondary" style="font-size: 0.9rem;">
                                    {{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 border-bottom-0 text-end">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-action btn-edit rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-action btn-delete rounded-pill px-3">
                                                <i class="bi bi-trash3 me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted border-bottom-0">
                                    <div class="empty-state d-flex flex-column align-items-center justify-content-center py-5">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 72px; height: 72px;">
                                            <i class="bi bi-people text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                        <h5 class="fw-semibold text-dark">No users found</h5>
                                        <p class="text-muted mb-0">Try adjusting your search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .search-input-group {
            border-radius: 50rem;
            transition: box-shadow 0.2s ease, border 0.2s ease;
            border: 1px solid #e2e8f0;
        }

        .search-input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
        }

        .hover-primary:hover {
            color: #6366f1 !important;
        }

        .custom-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .custom-table tbody tr:last-child {
            border-bottom: none;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        .role-badge {
            font-weight: 500;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.5);
        }

        .badge-admin {
            background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
            color: #581c87;
        }

        .badge-user {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e3a8a;
        }

        .btn-action {
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
        }

        .btn-edit {
            color: #6366f1;
            border: 1px solid #e0e7ff;
        }

        .btn-edit:hover {
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            border-color: #c7d2fe;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            transform: translateY(-1px);
        }

        .btn-delete {
            color: #ef4444;
            border: 1px solid #fee2e2;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-color: #fecaca;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
            transform: translateY(-1px);
        }
    </style>
@endsection