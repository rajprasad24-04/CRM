<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wealixir Client Management System | Add Financial Data</title>
    <link rel="icon" type="image/x-icon" href="https://play-lh.googleusercontent.com/AonPe9VE8OgO2lhBpV0l7NHC561PT62ycEdEDhhVQogLAngsKBTmi2GAmREKHuXd-TM=w240-h480-rw">

    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('admin_page/js/bootstrap.min.js') }}"></script>

    </head>
<body class="page-cross-sell-form">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            <!-- Header -->
            @include('includes.header')

            <!-- Breadcrumb -->
            <div class="outter-wp">
                <div class="sub-heard-part">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('dashboard') }}">Home</a></li>
                        <li><a href="{{ url('clients') }}">Client List</a></li>
                        <li class="active">Add Financial Data</li>
                    </ol>
                </div>  

                <!-- Form Section -->
                <div class="forms-main">
                    <h2 class="inner-tittle">Add Financial Data</h2>
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Financial Data Form -->
                    <form action="{{ route('client_financial_data.store', $client->id) }}" method="POST">
                        @csrf

                        <!-- Insurance -->
                        <div class="card">
                            <div class="card-header">Insurance</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Life</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="life_status" id="life_yes" value="yes" class="status-radio" data-field="life">
                                                <label for="life_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="life_status" id="life_no" value="no" class="status-radio" data-field="life">
                                                <label for="life_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="life_amount">
                                            <input type="number" name="life" class="form-control" placeholder="Enter amount" value="{{ old('life') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Health</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="health_status" id="health_yes" value="yes" class="status-radio" data-field="health">
                                                <label for="health_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="health_status" id="health_no" value="no" class="status-radio" data-field="health">
                                                <label for="health_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="health_amount">
                                            <input type="number" name="health" class="form-control" placeholder="Enter amount" value="{{ old('health') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">PA (Personal Accident)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pa_status" id="pa_yes" value="yes" class="status-radio" data-field="pa">
                                                <label for="pa_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pa_status" id="pa_no" value="no" class="status-radio" data-field="pa">
                                                <label for="pa_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="pa_amount">
                                            <input type="number" name="pa" class="form-control" placeholder="Enter amount" value="{{ old('pa') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Critical Illness</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="critical_status" id="critical_yes" value="yes" class="status-radio" data-field="critical">
                                                <label for="critical_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="critical_status" id="critical_no" value="no" class="status-radio" data-field="critical">
                                                <label for="critical_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="critical_amount">
                                            <input type="number" name="critical" class="form-control" placeholder="Enter amount" value="{{ old('critical') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Motor Insurance</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="motor_status" id="motor_yes" value="yes" class="status-radio" data-field="motor">
                                                <label for="motor_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="motor_status" id="motor_no" value="no" class="status-radio" data-field="motor">
                                                <label for="motor_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="motor_amount">
                                            <input type="number" name="motor" class="form-control" placeholder="Enter amount" value="{{ old('motor') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">General Insurance</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="general_status" id="general_yes" value="yes" class="status-radio" data-field="general">
                                                <label for="general_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="general_status" id="general_no" value="no" class="status-radio" data-field="general">
                                                <label for="general_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="general_amount">
                                            <input type="number" name="general" class="form-control" placeholder="Enter amount" value="{{ old('general') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Investments -->
                        <div class="card">
                            <div class="card-header">Investments</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Fixed Deposit (FD)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="fd_status" id="fd_yes" value="yes" class="status-radio" data-field="fd">
                                                <label for="fd_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="fd_status" id="fd_no" value="no" class="status-radio" data-field="fd">
                                                <label for="fd_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="fd_amount">
                                            <input type="number" name="fd" class="form-control" placeholder="Enter amount" value="{{ old('fd') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Mutual Funds (MF)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="mf_status" id="mf_yes" value="yes" class="status-radio" data-field="mf">
                                                <label for="mf_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="mf_status" id="mf_no" value="no" class="status-radio" data-field="mf">
                                                <label for="mf_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="mf_amount">
                                            <input type="number" name="mf" class="form-control" placeholder="Enter amount" value="{{ old('mf') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Portfolio Management Service (PMS)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pms_status" id="pms_yes" value="yes" class="status-radio" data-field="pms">
                                                <label for="pms_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pms_status" id="pms_no" value="no" class="status-radio" data-field="pms">
                                                <label for="pms_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="pms_amount">
                                            <input type="number" name="pms" class="form-control" placeholder="Enter amount" value="{{ old('pms') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Taxation & Compliance -->
                        <div class="card">
                            <div class="card-header">Taxation & Compliance</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Income Tax</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="income_tax_status" id="income_tax_yes" value="yes" class="status-radio" data-field="income_tax">
                                                <label for="income_tax_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="income_tax_status" id="income_tax_no" value="no" class="status-radio" data-field="income_tax">
                                                <label for="income_tax_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="income_tax_amount">
                                            <input type="number" name="income_tax" class="form-control" placeholder="Enter amount" value="{{ old('income_tax') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">GST</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="gst_status" id="gst_yes" value="yes" class="status-radio" data-field="gst">
                                                <label for="gst_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="gst_status" id="gst_no" value="no" class="status-radio" data-field="gst">
                                                <label for="gst_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="gst_amount">
                                            <input type="number" name="gst" class="form-control" placeholder="Enter amount" value="{{ old('gst') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">TDS</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="tds_status" id="tds_yes" value="yes" class="status-radio" data-field="tds">
                                                <label for="tds_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="tds_status" id="tds_no" value="no" class="status-radio" data-field="tds">
                                                <label for="tds_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="tds_amount">
                                            <input type="number" name="tds" class="form-control" placeholder="Enter amount" value="{{ old('tds') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Professional Tax (PT)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pt_status" id="pt_yes" value="yes" class="status-radio" data-field="pt">
                                                <label for="pt_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pt_status" id="pt_no" value="no" class="status-radio" data-field="pt">
                                                <label for="pt_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="pt_amount">
                                            <input type="number" name="pt" class="form-control" placeholder="Enter amount" value="{{ old('pt') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">VAT</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="vat_status" id="vat_yes" value="yes" class="status-radio" data-field="vat">
                                                <label for="vat_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="vat_status" id="vat_no" value="no" class="status-radio" data-field="vat">
                                                <label for="vat_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="vat_amount">
                                            <input type="number" name="vat" class="form-control" placeholder="Enter amount" value="{{ old('vat') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">ROC (Registrar of Companies)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="roc_status" id="roc_yes" value="yes" class="status-radio" data-field="roc">
                                                <label for="roc_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="roc_status" id="roc_no" value="no" class="status-radio" data-field="roc">
                                                <label for="roc_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="roc_amount">
                                            <input type="number" name="roc" class="form-control" placeholder="Enter amount" value="{{ old('roc') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">CMA (Credit Monitoring Arrangement)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="cma_status" id="cma_yes" value="yes" class="status-radio" data-field="cma">
                                                <label for="cma_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="cma_status" id="cma_no" value="no" class="status-radio" data-field="cma">
                                                <label for="cma_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="cma_amount">
                                            <input type="number" name="cma" class="form-control" placeholder="Enter amount" value="{{ old('cma') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Services -->
                        <div class="card">
                            <div class="card-header">Other Services</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Accounting</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="accounting_status" id="accounting_yes" value="yes" class="status-radio" data-field="accounting">
                                                <label for="accounting_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="accounting_status" id="accounting_no" value="no" class="status-radio" data-field="accounting">
                                                <label for="accounting_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="accounting_amount">
                                            <input type="number" name="accounting" class="form-control" placeholder="Enter amount" value="{{ old('accounting') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Others</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="others_status" id="others_yes" value="yes" class="status-radio" data-field="others">
                                                <label for="others_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="others_status" id="others_no" value="no" class="status-radio" data-field="others">
                                                <label for="others_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper" id="others_amount">
                                            <input type="number" name="others" class="form-control" placeholder="Enter amount" value="{{ old('others') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i> Save Financial Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Footer -->
            @include('includes.footer')
        </div>
    </div>
    
    @include('includes.sidebar')
    <div class="clearfix"></div>      
</div>

<!-- JavaScript for Toggle Functionality -->
<script>
    $(document).ready(function() {
        // Handle radio button changes
        $('.status-radio').on('change', function() {
            var field = $(this).data('field');
            var value = $(this).val();
            var amountWrapper = $('#' + field + '_amount');
            var amountInput = amountWrapper.find('input');
            
            if (value === 'yes') {
                amountWrapper.addClass('active');
                amountInput.prop('required', true);
            } else {
                amountWrapper.removeClass('active');
                amountInput.prop('required', false);
                amountInput.val(''); // Clear the value when No is selected
            }
        });

        // Check for old values on page load
        @if(old())
            @foreach(['life', 'health', 'pa', 'critical', 'motor', 'general', 'fd', 'mf', 'pms', 'income_tax', 'gst', 'tds', 'pt', 'vat', 'roc', 'cma', 'accounting', 'others'] as $field)
                @if(old($field))
                    $('#{{ $field }}_yes').prop('checked', true).trigger('change');
                @endif
            @endforeach
        @endif
    });

</script>

@include('includes.sidebar-toggle')

<!-- Additional Scripts -->
<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
</body>
</html>

