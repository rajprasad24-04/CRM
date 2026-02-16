<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir | Edit User</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
</head>
<body class="page-clients-form">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp container-fluid">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="active">Edit</li>
                    </ol>
                    <h3 class="inner-tittle">Edit User</h3>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                        Update Login
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>
                                <div>
                                    <div>Please fix the errors below.</div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">New password (optional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm new password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" {{ $currentRole === $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Permissions</label>
                                    <div class="permission-groups">
                                        @foreach ($permissionGroups as $group => $groupPermissions)
                                            <div class="permission-group">
                                                <div class="permission-group-title">{{ $group }}</div>
                                                <div class="permission-grid">
                                                    @foreach ($groupPermissions as $permission)
                                                        <label class="permission-item">
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                                                {{ in_array($permission, old('permissions', $currentPermissions)) ? 'checked' : '' }}>
                                                            <span>{{ str_replace('_', ' ', $permission) }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
