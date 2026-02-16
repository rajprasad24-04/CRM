<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wealixir Client Management System | Edit Client</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

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
<body class="page-clients-edit">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            <!-- Header -->
            @include('includes.header')

            <div class="outter-wp">
                <section class="clients-edit-hero">
                    <div class="clients-edit-hero__text">
                        <div class="clients-edit-hero__badge">
                            <i class="fa fa-edit"></i>
                            Client Workspace
                        </div>
                        <h2>Edit Client</h2>
                        <p>Update client profile, contact, and relationship details with full audit-friendly structure.</p>
                    </div>
                    <div class="clients-edit-hero__crumbs">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('dashboard') }}">Home</a></li>
                            <li><a href="{{ url('clients') }}">Client List</a></li>
                            <li class="active">Edit Client</li>
                        </ol>
                    </div>
                </section>

                <!-- Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="card edit-form-card">
                    <div class="card-header">
                        <i class="fa fa-edit"></i>
                        <span>Update Client Details</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('clients.update', $client->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Account Information -->
                            <div class="section-title">
                                <i class="fa fa-briefcase"></i>
                                Account Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Account Type <span class="required">*</span></label>
                                    <select name="account_type" class="form-select" required>
                                        <option value="">Choose...</option>
                                        <option value="Active Account" {{ $client->account_type == 'Active Account' ? 'selected' : '' }}>Active Account</option>
                                        <option value="Inactive Account" {{ $client->account_type == 'Inactive Account' ? 'selected' : '' }}>Inactive Account</option>
                                        <option value="Contact/Lead" {{ $client->account_type == 'Contact/Lead' ? 'selected' : '' }}>Contact/Lead</option>
                                        <option value="Unknown" {{ $client->account_type == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Family Code <span class="required">*</span></label>
                                    <input type="text" name="family_code" class="form-control" value="{{ $client->family_code }}" required>
                                </div>
                                <div class="col-md-4">
    <label class="form-label">Client Code</label>
    <input type="text" name="client_code" class="form-control" value="{{ $client->client_code }}" placeholder="Enter client code">
</div>
                                <div class="col-md-4">
                                    <label class="form-label">Family Head <span class="required">*</span></label>
                                    <input type="text" name="family_head" class="form-control" value="{{ $client->family_head }}" required>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="section-title">
                                <i class="fa fa-user"></i>
                                Personal Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Title <span class="required">*</span></label>
                                    <select name="abbr" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="Mr." {{ $client->abbr == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                        <option value="Ms." {{ $client->abbr == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                        <option value="Mrs." {{ $client->abbr == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                        <option value="Dr." {{ $client->abbr == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                        <option value="Prof." {{ $client->abbr == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                        <option value="Other" {{ $client->abbr == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Client Name <span class="required">*</span></label>
                                    <input type="text" name="client_name" class="form-control" value="{{ $client->client_name }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Gender <span class="required">*</span></label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="male" {{ $client->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $client->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ $client->gender == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PAN Card Number <span class="required">*</span></label>
                                    <input type="text" name="pan_card_number" class="form-control" value="{{ $client->pan_card_number }}" maxlength="10" style="text-transform: uppercase;" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth <span class="required">*</span></label>
                                    <input type="date" name="dob" class="form-control" value="{{ $client->dob }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Anniversary</label>
                                    <input type="date" name="doa" class="form-control" value="{{ $client->doa }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Join</label>
                                    <input type="date" name="date_of_join" class="form-control" value="{{ $client->date_of_join }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Close Date</label>
                                    <input type="date" name="close_date" class="form-control" value="{{ $client->close_date }}">
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="section-title">
                                <i class="fa fa-phone"></i>
                                Contact Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Primary Mobile <span class="required">*</span></label>
                                    <input type="text" name="primary_mobile_number" class="form-control" maxlength="13" value="{{ $client->primary_mobile_number }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Secondary Mobile</label>
                                    <input type="text" name="secondary_mobile_number" class="form-control" maxlength="13" value="{{ $client->secondary_mobile_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Primary Email <span class="required">*</span></label>
                                    <input type="email" name="primary_email_number" class="form-control" value="{{ $client->primary_email_number }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Secondary Email</label>
                                    <input type="email" name="secondary_email_number" class="form-control" value="{{ $client->secondary_email_number }}">
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="section-title">
                                <i class="fa fa-map-marker"></i>
                                Address Information
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Address <span class="required">*</span></label>
                                    <textarea name="address" class="form-control" rows="2" required>{{ $client->address }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="required">*</span></label>
                                    <input type="text" name="city" class="form-control" value="{{ $client->city }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State <span class="required">*</span></label>
                                    <input type="text" name="state" class="form-control" value="{{ $client->state }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Zip Code <span class="required">*</span></label>
                                    <input type="text" name="zip_code" class="form-control" value="{{ $client->zip_code }}" required>
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
                                    <input type="text" name="category" class="form-control" value="{{ $client->category }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Relationship Manager</label>
                                    @if (Auth::user()->hasRole('admin'))
                                        <select name="rm_user_id" class="form-select">
                                            <option value="">Select Relationship Manager</option>
                                            @foreach ($relationshipManagers as $manager)
                                                <option value="{{ $manager->id }}" {{ $client->rm_user_id == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" name="rm_user_id" value="{{ Auth::id() }}">
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Partner</label>
                                    <select name="partner" class="form-select">
                                        <option value="">Select Partner</option>
                                        <option value="valance_fernandes" {{ $client->partner == 'valance_fernandes' ? 'selected' : '' }}>Valance Fernandes</option>
                                        <option value="santosh_poojary" {{ $client->partner == 'santosh_poojary' ? 'selected' : '' }}>Santosh Poojary</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Referred By</label>
                                    <input type="text" name="referred_by" class="form-control" value="{{ $client->referred_by }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tax Status</label>
                                    <input type="text" name="tax_status" class="form-control" value="{{ $client->tax_status }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ $client->notes }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i>
                                    <span>Cancel</span>
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    <span>Update Client</span>
                                </button>
                            </div>
                        </form>
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

    // PAN Card uppercase
    $(document).ready(function() {
        $('input[name="pan_card_number"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>

<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
</body>
</html>

