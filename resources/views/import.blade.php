<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir Client Management System | Import Clients</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600&display=swap" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </head>
<body class="page-clients-import">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-3">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li><a href="{{ route('clients.index') }}">Manage Clients</a></li>
                    <li class="active">Import Clients</li>
                </ol>

                <h3 class="page-title"><i class="fa fa-file-excel me-2 text-success"></i> Import Clients via Excel</h3>

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Import Form Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-upload me-2"></i> Upload Excel / CSV File
                    </div>
                    <div class="card-body">
                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Choose File (.xlsx, .xls, .csv)</label>
                                <input type="file" name="file" required class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle me-1"></i> Import Clients
                            </button>
                        </form>

                        <p class="mt-3 text-muted small">
                            <i class="fa fa-info-circle me-1"></i> Download sample format:
                            <a href="{{ asset('samples/clients_sample.xlsx') }}" target="_blank">Clients_Sample.xlsx</a>
                        </p>
                    </div>
                </div>
            </div>

            @include('includes.footer')
        </div>
    </div>

    <!-- Sidebar -->
    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')
</body>
</html>

