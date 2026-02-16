@php
    $userName = Auth::user()->name ?? 'Guest';
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

<header class="app-topbar">
    <div class="topbar-left">
        <a href="#" class="sidebar-icon">
            <span class="fa fa-bars"></span>
        </a>
        <div class="brand-block">
            <span class="brand-title">Wealixir</span>
            <span class="brand-subtitle">Client Management System</span>
        </div>
    </div>
    <div class="topbar-right">
        <div class="topbar-search">
            <span class="fa fa-search"></span>
            <input type="text" placeholder="Search clients, reports, or tags">
        </div>
        <div class="user-chip">
            <div class="user-avatar">{{ $initials }}</div>
            <div class="user-meta">
                <span class="user-name">{{ $userName }}</span>
                <span class="user-role">Workspace Admin</span>
            </div>
        </div>
    </div>
</header>
