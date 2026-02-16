<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wealixir Client Management System | Edit Financial Data</title>
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
                        <li><a href="{{ url('financial-data') }}">Cross Sell</a></li>
                        <li class="active">Edit Financial Data</li>
                    </ol>
                </div>  

                <!-- Form Section -->
                <div class="forms-main">
                    <h2 class="inner-tittle">Edit Financial Data</h2>
                    
                    <!-- Success and Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
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

                    <!-- Financial Data Form -->
                    <form action="{{ route('client_financial_data.update', [$client->id, $financialData->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Insurance -->
                        <div class="card">
                            <div class="card-header">Insurance</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Life</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="life_status" id="life_yes" value="yes" class="status-radio" data-field="life" {{ old('life_status', $financialData->life ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="life_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="life_status" id="life_no" value="no" class="status-radio" data-field="life" {{ old('life_status', $financialData->life ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="life_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('life', $financialData->life) ? 'active' : '' }}" id="life_amount">
                                            <input type="number" name="life" class="form-control" placeholder="Enter amount" value="{{ old('life', $financialData->life) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Health</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="health_status" id="health_yes" value="yes" class="status-radio" data-field="health" {{ old('health_status', $financialData->health ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="health_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="health_status" id="health_no" value="no" class="status-radio" data-field="health" {{ old('health_status', $financialData->health ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="health_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('health', $financialData->health) ? 'active' : '' }}" id="health_amount">
                                            <input type="number" name="health" class="form-control" placeholder="Enter amount" value="{{ old('health', $financialData->health) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">PA (Personal Accident)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pa_status" id="pa_yes" value="yes" class="status-radio" data-field="pa" {{ old('pa_status', $financialData->pa ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="pa_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pa_status" id="pa_no" value="no" class="status-radio" data-field="pa" {{ old('pa_status', $financialData->pa ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="pa_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('pa', $financialData->pa) ? 'active' : '' }}" id="pa_amount">
                                            <input type="number" name="pa" class="form-control" placeholder="Enter amount" value="{{ old('pa', $financialData->pa) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Critical Illness</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="critical_status" id="critical_yes" value="yes" class="status-radio" data-field="critical" {{ old('critical_status', $financialData->critical ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="critical_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="critical_status" id="critical_no" value="no" class="status-radio" data-field="critical" {{ old('critical_status', $financialData->critical ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="critical_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('critical', $financialData->critical) ? 'active' : '' }}" id="critical_amount">
                                            <input type="number" name="critical" class="form-control" placeholder="Enter amount" value="{{ old('critical', $financialData->critical) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Motor Insurance</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="motor_status" id="motor_yes" value="yes" class="status-radio" data-field="motor" {{ old('motor_status', $financialData->motor ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="motor_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="motor_status" id="motor_no" value="no" class="status-radio" data-field="motor" {{ old('motor_status', $financialData->motor ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="motor_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('motor', $financialData->motor) ? 'active' : '' }}" id="motor_amount">
                                            <input type="number" name="motor" class="form-control" placeholder="Enter amount" value="{{ old('motor', $financialData->motor) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">General Insurance</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="general_status" id="general_yes" value="yes" class="status-radio" data-field="general" {{ old('general_status', $financialData->general ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="general_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="general_status" id="general_no" value="no" class="status-radio" data-field="general" {{ old('general_status', $financialData->general ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="general_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('general', $financialData->general) ? 'active' : '' }}" id="general_amount">
                                            <input type="number" name="general" class="form-control" placeholder="Enter amount" value="{{ old('general', $financialData->general) }}">
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
                                                <input type="radio" name="fd_status" id="fd_yes" value="yes" class="status-radio" data-field="fd" {{ old('fd_status', $financialData->fd ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="fd_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="fd_status" id="fd_no" value="no" class="status-radio" data-field="fd" {{ old('fd_status', $financialData->fd ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="fd_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('fd', $financialData->fd) ? 'active' : '' }}" id="fd_amount">
                                            <input type="number" name="fd" class="form-control" placeholder="Enter amount" value="{{ old('fd', $financialData->fd) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Mutual Funds (MF)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="mf_status" id="mf_yes" value="yes" class="status-radio" data-field="mf" {{ old('mf_status', $financialData->mf ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="mf_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="mf_status" id="mf_no" value="no" class="status-radio" data-field="mf" {{ old('mf_status', $financialData->mf ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="mf_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('mf', $financialData->mf) ? 'active' : '' }}" id="mf_amount">
                                            <input type="number" name="mf" class="form-control" placeholder="Enter amount" value="{{ old('mf', $financialData->mf) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Portfolio Management Service (PMS)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pms_status" id="pms_yes" value="yes" class="status-radio" data-field="pms" {{ old('pms_status', $financialData->pms ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="pms_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pms_status" id="pms_no" value="no" class="status-radio" data-field="pms" {{ old('pms_status', $financialData->pms ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="pms_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('pms', $financialData->pms) ? 'active' : '' }}" id="pms_amount">
                                            <input type="number" name="pms" class="form-control" placeholder="Enter amount" value="{{ old('pms', $financialData->pms) }}">
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
                                                <input type="radio" name="income_tax_status" id="income_tax_yes" value="yes" class="status-radio" data-field="income_tax" {{ old('income_tax_status', $financialData->income_tax ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="income_tax_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="income_tax_status" id="income_tax_no" value="no" class="status-radio" data-field="income_tax" {{ old('income_tax_status', $financialData->income_tax ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="income_tax_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('income_tax', $financialData->income_tax) ? 'active' : '' }}" id="income_tax_amount">
                                            <input type="number" name="income_tax" class="form-control" placeholder="Enter amount" value="{{ old('income_tax', $financialData->income_tax) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">GST</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="gst_status" id="gst_yes" value="yes" class="status-radio" data-field="gst" {{ old('gst_status', $financialData->gst ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="gst_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="gst_status" id="gst_no" value="no" class="status-radio" data-field="gst" {{ old('gst_status', $financialData->gst ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="gst_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('gst', $financialData->gst) ? 'active' : '' }}" id="gst_amount">
                                            <input type="number" name="gst" class="form-control" placeholder="Enter amount" value="{{ old('gst', $financialData->gst) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">TDS</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="tds_status" id="tds_yes" value="yes" class="status-radio" data-field="tds" {{ old('tds_status', $financialData->tds ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="tds_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="tds_status" id="tds_no" value="no" class="status-radio" data-field="tds" {{ old('tds_status', $financialData->tds ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="tds_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('tds', $financialData->tds) ? 'active' : '' }}" id="tds_amount">
                                            <input type="number" name="tds" class="form-control" placeholder="Enter amount" value="{{ old('tds', $financialData->tds) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Professional Tax (PT)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="pt_status" id="pt_yes" value="yes" class="status-radio" data-field="pt" {{ old('pt_status', $financialData->pt ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="pt_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="pt_status" id="pt_no" value="no" class="status-radio" data-field="pt" {{ old('pt_status', $financialData->pt ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="pt_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('pt', $financialData->pt) ? 'active' : '' }}" id="pt_amount">
                                            <input type="number" name="pt" class="form-control" placeholder="Enter amount" value="{{ old('pt', $financialData->pt) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">VAT</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="vat_status" id="vat_yes" value="yes" class="status-radio" data-field="vat" {{ old('vat_status', $financialData->vat ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="vat_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="vat_status" id="vat_no" value="no" class="status-radio" data-field="vat" {{ old('vat_status', $financialData->vat ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="vat_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('vat', $financialData->vat) ? 'active' : '' }}" id="vat_amount">
                                            <input type="number" name="vat" class="form-control" placeholder="Enter amount" value="{{ old('vat', $financialData->vat) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">ROC (Registrar of Companies)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="roc_status" id="roc_yes" value="yes" class="status-radio" data-field="roc" {{ old('roc_status', $financialData->roc ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="roc_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="roc_status" id="roc_no" value="no" class="status-radio" data-field="roc" {{ old('roc_status', $financialData->roc ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="roc_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('roc', $financialData->roc) ? 'active' : '' }}" id="roc_amount">
                                            <input type="number" name="roc" class="form-control" placeholder="Enter amount" value="{{ old('roc', $financialData->roc) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">CMA (Credit Monitoring Arrangement)</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="cma_status" id="cma_yes" value="yes" class="status-radio" data-field="cma" {{ old('cma_status', $financialData->cma ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="cma_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="cma_status" id="cma_no" value="no" class="status-radio" data-field="cma" {{ old('cma_status', $financialData->cma ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="cma_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('cma', $financialData->cma) ? 'active' : '' }}" id="cma_amount">
                                            <input type="number" name="cma" class="form-control" placeholder="Enter amount" value="{{ old('cma', $financialData->cma) }}">
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
                                                <input type="radio" name="accounting_status" id="accounting_yes" value="yes" class="status-radio" data-field="accounting" {{ old('accounting_status', $financialData->accounting ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="accounting_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="accounting_status" id="accounting_no" value="no" class="status-radio" data-field="accounting" {{ old('accounting_status', $financialData->accounting ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="accounting_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('accounting', $financialData->accounting) ? 'active' : '' }}" id="accounting_amount">
                                            <input type="number" name="accounting" class="form-control" placeholder="Enter amount" value="{{ old('accounting', $financialData->accounting) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-wrapper">
                                        <label class="form-label">Others</label>
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" name="others_status" id="others_yes" value="yes" class="status-radio" data-field="others" {{ old('others_status', $financialData->others ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                                <label for="others_yes">Yes</label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" name="others_status" id="others_no" value="no" class="status-radio" data-field="others" {{ old('others_status', $financialData->others ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                                <label for="others_no">No</label>
                                            </div>
                                        </div>
                                        <div class="number-input-wrapper {{ old('others', $financialData->others) ? 'active' : '' }}" id="others_amount">
                                            <input type="number" name="others" class="form-control" placeholder="Enter amount" value="{{ old('others', $financialData->others) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i> Update Financial Data
                            </button>
                            <a href="{{ route('financial_data.index') }}" class="btn btn-secondary">Cancel</a>
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
    });

    </script>

@include('includes.sidebar-toggle')

<!-- Additional Scripts -->
<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
</body>
</html>

