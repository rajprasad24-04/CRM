<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir Client Management System || Add Clients</title>
    <link rel="icon" type="image/x-icon" href="https://play-lh.googleusercontent.com/AonPe9VE8OgO2lhBpV0l7NHC561PT62ycEdEDhhVQogLAngsKBTmi2GAmREKHuXd-TM=w240-h480-rw">

    <!-- Hide URL bar on mobile -->
    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    
    <!-- Stylesheets -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <!-- JavaScript -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('admin_page/js/css3clock.js') }}"></script>
    <script src="{{ asset('admin_page/js/skycons.js') }}"></script>
</head> 
<body>
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            <!-- Header -->
            @include('includes.header')

            <!-- Breadcrumb -->
            <div class="outter-wp">
                <div class="sub-heard-part">
                    <ol class="breadcrumb m-b-0">
                        <li><a href="{{ url('dashboard') }}">Home</a></li>
                        <li><a href="{{ url('clients') }}">client list</a></li>
                        <li class="active">Create Password</li>
                    </ol>
                </div>  

                <!-- Form Section -->
                <div class="forms-main">
                    <h2>Add a New Password for {{ $client->client_name }}</h2>
                    
                    <!-- Success and Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Form for Adding Clients -->
                    <div class="graph-form">
                        <div class="form-body">

<form action="{{ route('client_passwords.store', $client->id) }}" method="POST">
    @csrf
    <div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="form-control" required>
    </div>
    
    <div class="form-group">
    <label for="user_id">User ID</label>
    <input type="text" name="user_id" id="user_id" class="form-control" required>
    </div>
    
    <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control" required>
    </div>
    
    <div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" id="notes" class="form-control"></textarea>
    </div>
    
    <button class="btn btn-default" type="submit">Save Password</button>
</form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer and Sidebar -->
            @include('includes.footer')
        </div>
    </div>
    
    @include('includes.sidebar')

    <div class="clearfix"></div>      
</div>

<script>
    </script>

@include('includes.sidebar-toggle')

<!-- Additional Scripts -->
<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
<script src="{{ asset('admin_page/js/bootstrap.min.js') }}"></script>

</body>
</html>
