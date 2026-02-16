@php
    $userName = Auth::user()->name ?? 'Guest';
@endphp

<aside class="sidebar-menu">
    <header class="logo">
        <div class="sidebar-brand">
            <div class="sidebar-mark">W</div>
            <div>
                <div class="sidebar-title">Wealixir CMS</div>
                <div class="sidebar-subtitle">SaaS Workspace</div>
            </div>
        </div>
        <button class="sidebar-close" type="button" aria-label="Close menu">
            <span class="fa fa-times"></span>
        </button>
    </header>

    <div class="sidebar-profile">
        <div class="profile-name">{{ $userName }}</div>
        <div class="profile-meta">Premium Workspace</div>
    </div>

    <div class="menu">
        <ul id="menu">
            @can('dashboard.view')
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="nav-icon fa fa-tachometer"></span>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('clients.create')
                <li>
                    <a href="{{ route('clients.create') }}">
                        <span class="nav-icon fa fa-plus-square"></span>
                        <span>Add Clients</span>
                    </a>
                </li>
            @endcan
            @can('clients.view')
                <li>
                    <a href="{{ route('clients.index') }}">
                        <span class="nav-icon fa fa-table"></span>
                        <span>Clients List</span>
                    </a>
                </li>
            @endcan
            @can('financial_data.view')
                <li>
                    <a href="{{ route('financial_data.index') }}">
                        <span class="nav-icon fa fa-exchange"></span>
                        <span>Cross Sell</span>
                    </a>
                </li>
            @endcan
            <li>
                <a href="{{ route('internal.apps') }}">
                    <span class="nav-icon fa fa-th-large"></span>
                    <span>Internal Applications</span>
                </a>
            </li>
            @can('profile.view')
                <li>
                    <a href="{{ route('profile.edit') }}">
                        <span class="nav-icon fa fa-user"></span>
                        <span>Profile</span>
                    </a>
                </li>
            @endcan
            @role('admin')
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <span class="nav-icon fa fa-users"></span>
                        <span>User Management</span>
                    </a>
                </li>
            @endrole
            @can('audit_logs.view')
                <li>
                    <a href="{{ route('audit_logs.index') }}">
                        <span class="nav-icon fa fa-clipboard"></span>
                        <span>Audit Logs</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout">
                <span class="fa fa-sign-out"></span>
                <span>Log out</span>
            </button>
        </form>
    </div>
</aside>
