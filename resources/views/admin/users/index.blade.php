<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir | User Management</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
</head>
<body class="page-users-index">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                @php
                    $totalUsers = method_exists($users, 'total') ? $users->total() : $users->count();
                    $currentUsers = $users->getCollection();
                    $adminCount = $currentUsers->filter(function ($user) {
                        return optional($user->roles->first())->name === 'admin';
                    })->count();
                    $staffCount = $currentUsers->count() - $adminCount;
                @endphp

                <section class="users-hero">
                    <div class="users-hero__text">
                        <div class="users-hero__badge">
                            <i class="fa fa-users"></i>
                            Admin Console
                        </div>
                        <h3>User Management</h3>
                        <p>Manage platform access, roles, and account settings for your workspace team.</p>
                    </div>
                    <div class="users-hero__stats">
                        <div class="hero-stat">
                            <span class="hero-stat__label">Total Users</span>
                            <span class="hero-stat__value">{{ number_format($totalUsers) }}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat__label">Admins (Page)</span>
                            <span class="hero-stat__value">{{ $adminCount }}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat__label">Staff (Page)</span>
                            <span class="hero-stat__value">{{ $staffCount }}</span>
                        </div>
                    </div>
                </section>

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <section class="users-panel">
                    <div class="users-panel__head">
                        <div>
                            <div class="users-panel__title">Workspace Users</div>
                            <div class="users-panel__sub">Manage system logins and assigned roles</div>
                        </div>
                        <div class="users-panel__actions">
                            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                                <i class="fa fa-plus"></i>
                                <span>Create User</span>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table users-table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $index => $user)
                                @php $roleName = strtolower($user->roles->first()->name ?? 'user'); @endphp
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td class="users-table__name">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="role-badge role-badge--{{ $roleName }}">{{ ucfirst($roleName) }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-ghost" href="{{ route('admin.users.edit', $user) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No users found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                @if($users->hasPages())
                    <div class="users-pagination d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
</body>
</html>
