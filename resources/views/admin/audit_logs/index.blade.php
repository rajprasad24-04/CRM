<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir | Audit Logs</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
</head>
<body class="page-audit-logs">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp audit-shell">
                <div class="audit-hero">
                    <div>
                        <div class="audit-eyebrow">Compliance Ledger</div>
                        <h1>Audit Logs</h1>
                        <p>Track every system change with reliable, timestamped history.</p>
                        <div class="audit-meta">
                            <span><i class="fa fa-database"></i> {{ number_format($logs->total()) }} total events</span>
                            <span><i class="fa fa-clock-o"></i> Updated in real time</span>
                        </div>
                    </div>
                    <div class="audit-hero-actions">
                        <a class="btn btn-ghost" href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i> Back to Dashboard
                        </a>
                        <a class="btn btn-primary" href="{{ route('audit_logs.index', array_merge(request()->all(), ['export' => 'csv'])) }}">
                            <i class="fa fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>

                <div class="audit-panel">
                    <form method="GET" action="{{ route('audit_logs.index') }}" class="audit-filters">
                        <div class="filter-field">
                            <label>Record ID</label>
                            <div class="input-wrap">
                                <i class="fa fa-hashtag"></i>
                                <input type="text" name="record_id" placeholder="Search by ID" value="{{ request('record_id') }}">
                            </div>
                        </div>
                        <div class="filter-field">
                            <label>Date from</label>
                            <div class="input-wrap">
                                <i class="fa fa-calendar"></i>
                                <input type="date" name="date_from" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="filter-field">
                            <label>Date to</label>
                            <div class="input-wrap">
                                <i class="fa fa-calendar-check-o"></i>
                                <input type="date" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="filter-field">
                            <label>User</label>
                            <div class="input-wrap">
                                <i class="fa fa-user"></i>
                                <select name="user_id" class="form-select">
                                    <option value="">All users</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-field">
                            <label>Action</label>
                            <div class="input-wrap">
                                <i class="fa fa-bolt"></i>
                                <select name="action" class="form-select">
                                    <option value="">All actions</option>
                                    @foreach ($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                            {{ ucfirst($action) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-field">
                            <label>Model</label>
                            <div class="input-wrap">
                                <i class="fa fa-database"></i>
                                <select name="model" class="form-select">
                                    <option value="">All models</option>
                                    @foreach ($models as $model)
                                        <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>
                                            {{ class_basename($model) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Apply Filters
                            </button>
                            <a class="btn btn-ghost" href="{{ route('audit_logs.index') }}">
                                <i class="fa fa-times-circle"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>

                <div class="audit-table">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>When</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Record ID</th>
                                <th>IP</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                @php
                                    $action = strtolower($log->action);
                                    $actionClass = match ($action) {
                                        'created' => 'pill-success',
                                        'updated' => 'pill-info',
                                        'deleted' => 'pill-danger',
                                        'login' => 'pill-brand',
                                        'logout' => 'pill-muted',
                                        default => 'pill-muted',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-name">{{ $log->user?->name ?? 'System' }}</div>
                                            <div class="user-email">{{ $log->user?->email ?? 'System event' }}</div>
                                        </div>
                                    </td>
                                    <td><span class="audit-pill {{ $actionClass }}">{{ ucfirst($log->action) }}</span></td>
                                    <td>{{ class_basename($log->auditable_type) }}</td>
                                    <td>{{ $log->auditable_id }}</td>
                                    <td>{!! $log->ip_address ?? '&mdash;' !!}</td>
                                    <td>
                                        <a class="btn btn-ghost btn-sm btn-detail" href="{{ route('audit_logs.show', $log) }}">
                                            <i class="fa fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($logs->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $logs->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
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
