<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir | Audit Log Detail</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
</head>
<body class="page-clients-index">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('audit_logs.index') }}">Audit Logs</a></li>
                        <li class="active">Detail</li>
                    </ol>
                    <h3 class="page-title">Audit Log Detail</h3>
                </div>

                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Field</th>
                                <th>Old</th>
                                <th>New</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($diff as $row)
                                <tr>
                                    <td>{{ $row['field'] }}</td>
                                    <td>{{ is_array($row['old']) ? json_encode($row['old']) : ($row['old'] ?? '—') }}</td>
                                    <td>{{ is_array($row['new']) ? json_encode($row['new']) : ($row['new'] ?? '—') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
