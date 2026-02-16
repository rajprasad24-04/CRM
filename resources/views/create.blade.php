<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wealixir Client Management System | Add Clients</title>
    <link rel="icon" type="image/x-icon" href="https://play-lh.googleusercontent.com/AonPe9VE8OgO2lhBpV0l7NHC561PT62ycEdEDhhVQogLAngsKBTmi2GAmREKHuXd-TM=w240-h480-rw">

    <!-- Mobile Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('admin_page/js/bootstrap.min.js') }}"></script>

    </head>
<body class="page-clients-create">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            <!-- Header -->
            @include('includes.header')

            <div class="outter-wp">
                <section class="clients-create-hero">
                    <div class="clients-create-hero__text">
                        <div class="clients-create-hero__badge">
                            <i class="fa fa-user-plus"></i>
                            Client Workspace
                        </div>
                        <h2>Add New Client</h2>
                        <p>Create a complete client profile with contact, account, relationship, and compliance details.</p>
                    </div>
                    <div class="clients-create-hero__crumbs">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('dashboard') }}">Home</a></li>
                            <li><a href="{{ url('clients') }}">Client List</a></li>
                            <li class="active">Add Clients</li>
                        </ol>
                    </div>
                </section>

                <!-- Form Section -->
                <div class="forms-main create-form-shell">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong><i class="fa fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="card create-form-card">
                        <div class="card-header">
                            <i class="fa fa-user-plus"></i>
                            <span>Client Registration Form</span>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('clients.store') }}" id="clientForm">
                                @csrf

                                <!-- Account Information -->
                                <div class="section-title">
                                    <i class="fa fa-briefcase"></i>
                                    Account Information
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Account Type </label>
                                        <select name="account_type" class="form-select" >
                                            <option value="">Select Account Type</option>
                                            <option value="Active Account">Active Account</option>
                                            <option value="Inactive Account">Inactive Account</option>
                                            <option value="Contact/Lead">Contact/Lead</option>
                                            <option value="Unknown">Unknown</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Family Code </label>
                                        <input type="text" name="family_code" class="form-control" placeholder="Enter family code" >
                                    </div>
                                    <div class="col-md-4">
        <label class="form-label">Client Code</label>
        <input type="text" name="client_code" class="form-control" placeholder="Enter client code">
    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Family Head </label>
                                        <input type="text" name="family_head" class="form-control" placeholder="Enter family head name" >
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="section-title">
                                    <i class="fa fa-user"></i>
                                    Personal Information
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Title </label>
                                        <select name="abbr" class="form-select" >
                                            <option value="">Select</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Prof.">Prof.</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name </label>
                                        <input type="text" name="client_name" class="form-control" placeholder="Enter full name" >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gender </label>
                                        <select name="gender" class="form-select" >
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">PAN Card Number <span class="required">*</span></label>
                                        <input type="text" name="pan_card_number" maxlength="10" class="form-control" placeholder="ABCDE1234F" style="text-transform: uppercase;" required>
                                        <small class="form-text">Enter 10-digit PAN number</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth </label>
                                        <input type="date" name="dob" class="form-control" >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Anniversary</label>
                                        <input type="date" name="doa" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Join</label>
                                        <input type="date" name="date_of_join" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Close Date</label>
                                        <input type="date" name="close_date" class="form-control">
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="section-title">
                                    <i class="fa fa-phone"></i>
                                    Contact Information
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Primary Mobile </label>
                                        <input type="text" name="primary_mobile_number" maxlength="13" class="form-control" placeholder="+91 XXXXXXXXXX" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Secondary Mobile</label>
                                        <input type="text" name="secondary_mobile_number" maxlength="13" class="form-control" placeholder="+91 XXXXXXXXXX">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Primary Email </label>
                                        <input type="email" name="primary_email_number" class="form-control" placeholder="email@example.com" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Secondary Email</label>
                                        <input type="email" name="secondary_email_number" class="form-control" placeholder="email@example.com">
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="section-title">
                                    <i class="fa fa-map-marker"></i>
                                    Address Information
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Street Address </label>
                                        <textarea name="address" class="form-control" rows="2" placeholder="Enter complete address" ></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City </label>
                                        <input type="text" name="city" class="form-control" placeholder="Enter city" >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">State </label>
                                        <input type="text" name="state" class="form-control" placeholder="Enter state" >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Zip Code </label>
                                        <input type="text" name="zip_code" class="form-control" placeholder="Enter zip code" >
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="section-title">
                                    <i class="fa fa-info-circle"></i>
                                    Additional Information
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Category</label>
                                        <input type="text" name="category" class="form-control" placeholder="Enter category">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Relationship Manager</label>
                                        @if (Auth::user()->hasRole('admin'))
                                            <select name="rm_user_id" class="form-select">
                                                <option value="">Select Relationship Manager</option>
                                                @foreach ($relationshipManagers as $manager)
                                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                            <input type="hidden" name="rm_user_id" value="{{ Auth::id() }}">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
    <label class="form-label">Partner</label>
    <select name="partner" class="form-control">
        <option value="">Select Partner</option>
        <option value="valance_fernandes">Valance Fernandes</option>
        <option value="santosh_poojary">Santosh Poojary</option>
    </select>
</div>

                                    <div class="col-md-6">
                                        <label class="form-label">Referred By</label>
                                        <input type="text" name="referred_by" class="form-control" placeholder="Enter referrer name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tax Status</label>
                                        <input type="text" name="tax_status" class="form-control" placeholder="Enter tax status">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea name="notes" class="form-control" rows="3" placeholder="Enter any additional notes or comments..."></textarea>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <a href="{{ url('clients') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i>
                                        <span>Cancel</span>
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i>
                                        <span>Save Client</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Footer -->
            @include('includes.footer')
        </div>
    </div>
    
    @include('includes.sidebar')
    <div class="clearfix"></div>      
</div>

@include('includes.sidebar-toggle')

<!-- Scripts -->
<script>
    // Form Validation Enhancement
    $(document).ready(function() {
        // PAN Card uppercase conversion
        $('input[name="pan_card_number"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Phone number formatting
        $('input[name$="_mobile_number"]').on('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });

        // Form submission confirmation
        $('#clientForm').on('submit', function(e) {
            var btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        });
    });
</script>
</body>
</html>





