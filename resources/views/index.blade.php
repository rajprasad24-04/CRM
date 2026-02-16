<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir Client Management System | Manage Clients</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Inter:400,500,600,700' rel='stylesheet' type='text/css'>

    <!-- JS -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </head>
<body class="page-clients-index">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                @php
                    $totalClients = method_exists($clients, 'total') ? $clients->total() : $clients->count();
                    $activeFilterCount = collect([
                        $search ?? '',
                        $familyCodeFilter ?? '',
                        $familyHeadFilter ?? '',
                        $clientNameFilter ?? '',
                        $mobileFilter ?? '',
                        $emailFilter ?? '',
                        $rmFilter ?? '',
                        $partnerFilter ?? '',
                    ])->filter(fn ($value) => trim((string) $value) !== '')->count();
                @endphp

                <section class="clients-hero">
                    <div class="clients-hero__text">
                        <div class="clients-hero__badge">
                            <i class="fa fa-users"></i>
                            Corporate Workspace
                        </div>
                        <h3 class="page-title">Client Management</h3>
                        <p>Manage client records, relationships, and data quality from one centralized control panel.</p>
                    </div>
                    <div class="clients-hero__stats">
                        <div class="hero-stat">
                            <span class="hero-stat__label">Total Clients</span>
                            <span class="hero-stat__value">{{ number_format($totalClients) }}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat__label">Current View</span>
                            <span class="hero-stat__value">{{ $familyFilter === '1' ? 'All' : 'Family Heads' }}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat__label">Active Filters</span>
                            <span class="hero-stat__value">{{ $activeFilterCount }}</span>
                        </div>
                    </div>
                </section>

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Controls Card -->
                <div class="controls-card">
                    <div class="controls-card__head">
                        <div class="controls-card__title">Client Controls</div>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="active">Manage Clients</li>
                        </ol>
                    </div>
                    @if (!empty($missingField))
                        <div class="alert alert-info missing-filter-alert">
                            <i class="fas fa-filter"></i>
                            Showing clients with missing data: <strong>{{ strtoupper($missingField) }}</strong>
                            <a href="{{ route('clients.index') }}" class="ms-2">Clear</a>
                        </div>
                    @endif
                    <div class="controls-row">
                        <div class="left-controls">
                            <!-- Toggle Switch -->
                            <div class="toggle-wrapper">
                                <label class="switch">
                                    <input type="checkbox" id="toggleFilterSwitch" {{ $familyFilter === '1' ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span class="toggle-label" id="toggleLabel">
                                    {{ $familyFilter === '1' ? 'Show All Clients' : 'Show Family Heads' }}
                                </span>
                            </div>

                            <!-- Search Box -->
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search by name, email, mobile..." value="{{ $search }}">
                            </div>

                            <!-- Clear Filters Button -->
                            <button class="clear-filters-btn" onclick="clearAllFilters()">
                                <i class="fas fa-times-circle"></i>
                                <span>Clear Filters</span>
                            </button>
                        </div>

                        <!-- Actions -->
                        <div class="actions-group">
                            <a class="btn create-client-btn" href="{{ route('clients.create') }}">
                                <i class="fa fa-plus"></i>
                                <span>Create Client</span>
                            </a>
                            @can('import.view')
                                <a class="btn import-btn" href="{{ route('import.form') }}">
                                    <i class="fa fa-upload"></i>
                                    <span>Import</span>
                                </a>
                            @endcan
                            <a class="btn export-btn" href="{{ route('clients.index', ['export' => 'csv', 'scope' => 'all']) }}">
                                <i class="fa fa-download"></i>
                                <span>Export CSV</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Clients Table Card -->
                <div class="table-card">
                    <div class="table-card__head">
                        <div class="table-card__title">Client Register</div>
                        <div class="table-card__meta">{{ $clients->count() }} records on this page</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th style="width: 85px;">Family Code</th>
                                <th style="width: 140px;">Family Head</th>
                                <th style="width: 140px;">Client Name</th>
                                <th style="width: 105px;">Mobile</th>
                                <th>Email</th>
                                <th style="width: 100px;">RM</th>
                                <th style="width: 100px;">Partner</th>
                                <th style="width: 50px;">Actions</th>
                            </tr>
                            <!-- Filter Row -->
                            <tr class="filter-row">
                                <th></th>
                                <th>
                                    <input type="text" class="column-filter-input" id="familyCodeFilter" 
                                           placeholder="Filter..." value="{{ $familyCodeFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <input type="text" class="column-filter-input" id="familyHeadFilter" 
                                           placeholder="Filter..." value="{{ $familyHeadFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <input type="text" class="column-filter-input" id="clientNameFilter" 
                                           placeholder="Filter..." value="{{ $clientNameFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <input type="text" class="column-filter-input" id="mobileFilter" 
                                           placeholder="Filter..." value="{{ $mobileFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <input type="text" class="column-filter-input" id="emailFilter" 
                                           placeholder="Filter..." value="{{ $emailFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <input type="text" class="column-filter-input" id="rmFilter" 
                                           placeholder="Filter..." value="{{ $rmFilter ?? '' }}"
                                           oninput="debounceFilter()">
                                </th>
                                <th>
                                    <select class="column-filter-input" id="partnerFilter" onchange="applyFilters()">
                                        <option value="">All Partners</option>
                                        <option value="valance_fernandes" {{ ($partnerFilter ?? '') == 'valance_fernandes' ? 'selected' : '' }}>Valance Fernandes</option>
                                        <option value="santosh_poojary" {{ ($partnerFilter ?? '') == 'santosh_poojary' ? 'selected' : '' }}>Santosh Poojary</option>
                                    </select>
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $startIndex = $clients->perPage() * ($clients->currentPage() - 1) + 1; @endphp
                            @foreach($clients as $index => $client)
                                <tr>
                                    <td>
                                        <a href="{{ route('client_passwords.index', $client->id) }}">
                                            {{ $startIndex + $index }}
                                        </a>
                                    </td>
                                    <td>{{ $client->family_code }}</td>
                                    <td>
                                        {{ $client->family_head }}
                                        @if (strcasecmp($client->family_head, $client->client_name) === 0)
                                            <span class="icon-badge" title="Family Head">
                                                <i class="fas fa-user-shield"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('clients.show', $client->id) }}">
                                            {{ $client->client_name }}
                                        </a>
                                    </td>
                                    <td>{{ $client->primary_mobile_number }}</td>
                                    <td>{{ $client->primary_email_number }}</td>
                                    <td>{{ optional($client->relationshipManager)->name ?? $client->rm ?? '-' }}</td>
                                    <td>{{ $client->partner ?? '-' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clients.show', $client->id) }}">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('clients.destroy', $client->id) }}" class="dropdown-item"
                                                       onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this client?')) document.getElementById('delete-form-{{ $client->id }}').submit();">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
                                                    <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:none;">
                                                        @csrf @method('DELETE')
                                                    </form>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('client_passwords.index', $client->id) }}">
                                                        <i class="fa-solid fa-lock"></i> Passwords
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($clients->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $clients->appends([
                                'search' => $search, 
                                'familyFilter' => $familyFilter,
                                'family_code' => $familyCodeFilter ?? '',
                                'family_head' => $familyHeadFilter ?? '',
                                'client_name' => $clientNameFilter ?? '',
                                'mobile' => $mobileFilter ?? '',
                                'email' => $emailFilter ?? '',
                                'rm' => $rmFilter ?? '',
                                'partner' => $partnerFilter ?? ''
                            ])->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>

            @include('includes.footer')
        </div>
    </div>

    <!-- Sidebar -->
    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

<!-- Scripts -->
<script>
    // Apply filters function
    function applyFilters() {
        const params = new URLSearchParams();
        
        const search = document.getElementById('searchInput').value.trim();
        const familyFilter = document.getElementById('toggleFilterSwitch').checked ? 1 : 0;
        const familyCode = document.getElementById('familyCodeFilter').value.trim();
        const familyHead = document.getElementById('familyHeadFilter').value.trim();
        const clientName = document.getElementById('clientNameFilter').value.trim();
        const mobile = document.getElementById('mobileFilter').value.trim();
        const email = document.getElementById('emailFilter').value.trim();
        const rm = document.getElementById('rmFilter').value.trim();
        const partner = document.getElementById('partnerFilter').value.trim();
        
        if (search) params.append('search', search);
        params.append('familyFilter', familyFilter);
        if (familyCode) params.append('family_code', familyCode);
        if (familyHead) params.append('family_head', familyHead);
        if (clientName) params.append('client_name', clientName);
        if (mobile) params.append('mobile', mobile);
        if (email) params.append('email', email);
        if (rm) params.append('rm', rm);
        if (partner) params.append('partner', partner);
        
        window.location.href = '?' + params.toString();
    }

    // Clear all filters
    function clearAllFilters() {
        window.location.href = '{{ route("clients.index") }}';
    }

    // Update toggle label and apply filter immediately
    document.getElementById('toggleFilterSwitch').addEventListener('change', function() {
        const label = document.getElementById('toggleLabel');
        label.textContent = this.checked ? 'Show All Clients' : 'Show Family Heads';
        applyFilters();
    });

    // Handle Enter key press for search and filter inputs
    function handleEnterKey(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            applyFilters();
        }
    }

    // Add Enter key listener to global search input
    document.getElementById('searchInput').addEventListener('keypress', handleEnterKey);

    // Add Enter key listener to all column filter inputs (except dropdowns)
    document.querySelectorAll('.column-filter-input').forEach(function(input) {
        if (input.tagName !== 'SELECT') {
            input.addEventListener('keypress', handleEnterKey);
        }
    });

    // Partner dropdown triggers immediate search on change
    document.getElementById('partnerFilter').addEventListener('change', applyFilters);
</script>
</body>
</html>

