<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir Client Management System || Cross Sell</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('admin_page/js/bootstrap.min.js') }}"></script>
</head>
<body class="page-cross-sell-index">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">

            @include('includes.header')

            <div class="outter-wp">
                @php
                    $searchTerm = trim((string) request('search', ''));
                    $pageTotalAmount = 0;

                    foreach ($clients as $summaryClient) {
                        $summaryInsurance = ($summaryClient->financialData->life ?? 0)
                            + ($summaryClient->financialData->health ?? 0)
                            + ($summaryClient->financialData->pa ?? 0)
                            + ($summaryClient->financialData->critical ?? 0)
                            + ($summaryClient->financialData->motor ?? 0)
                            + ($summaryClient->financialData->general ?? 0);

                        $summaryInvestments = ($summaryClient->financialData->fd ?? 0)
                            + ($summaryClient->financialData->mf ?? 0)
                            + ($summaryClient->financialData->pms ?? 0);

                        $summaryTax = ($summaryClient->financialData->income_tax ?? 0)
                            + ($summaryClient->financialData->gst ?? 0)
                            + ($summaryClient->financialData->tds ?? 0)
                            + ($summaryClient->financialData->pt ?? 0)
                            + ($summaryClient->financialData->vat ?? 0)
                            + ($summaryClient->financialData->roc ?? 0)
                            + ($summaryClient->financialData->cma ?? 0);

                        $summaryOthers = ($summaryClient->financialData->accounting ?? 0)
                            + ($summaryClient->financialData->others ?? 0);

                        $pageTotalAmount += ($summaryInsurance + $summaryInvestments + $summaryTax + $summaryOthers);
                    }

                    $totalClients = method_exists($clients, 'total') ? $clients->total() : $clients->count();
                @endphp

                <section class="cross-hero">
                    <div class="cross-hero__text">
                        <div class="cross-hero__badge">
                            <i class="fa fa-line-chart"></i>
                            Revenue Workspace
                        </div>
                        <h1>Cross Sell Overview</h1>
                        <p>Track category-wise opportunity and review client-level totals in one consolidated view.</p>
                        <div class="cross-hero__actions">
                            <a class="btn btn-primary" href="{{ route('dashboard') }}">
                                <i class="fa fa-home"></i> Dashboard
                            </a>
                            @if($searchTerm !== '')
                                <a class="btn btn-ghost" href="{{ route('financial_data.index') }}">
                                    <i class="fa fa-times-circle"></i> Clear Search
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="cross-hero__stats">
                        <div class="cross-stat">
                            <div class="stat-label">Clients</div>
                            <div class="stat-value">{{ number_format($totalClients) }}</div>
                        </div>
                        <div class="cross-stat">
                            <div class="stat-label">This Page Total</div>
                            <div class="stat-value">{{ number_format($pageTotalAmount) }}</div>
                        </div>
                        <div class="cross-stat accent">
                            <div class="stat-label">Search</div>
                            <div class="stat-value">{{ $searchTerm !== '' ? 'Filtered' : 'All Data' }}</div>
                        </div>
                    </div>
                </section>

                @if (session('success'))
                    <div class="alert alert-success cross-alert">
                        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger cross-alert">
                        <i class="fa fa-exclamation-circle me-1"></i> {{ session('error') }}
                    </div>
                @endif

                <section class="cross-panel">
                    <div class="cross-panel__head">
                        <div class="cross-panel__heading">
                            <div class="cross-panel__title">
                                <i class="fa fa-table"></i>
                                Client Cross Sell Matrix
                            </div>
                            <div class="cross-panel__sub">Insurance, Investments, Taxation and Service totals</div>
                            <div class="cross-panel__meta">{{ number_format($clients->count()) }} records on this page</div>
                        </div>

                        <form method="GET" action="{{ route('financial_data.index') }}" class="cross-search">
                            <div class="cross-search__input">
                                <i class="fa fa-search"></i>
                                <input type="text" name="search" id="searchInput" placeholder="Search clients..." value="{{ $search }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm cross-search__btn">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive cross-table-wrap">
                        <table class="table cross-table">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Insurance</th>
                                    <th>Investments</th>
                                    <th>Taxation & Compliance</th>
                                    <th>Other Services</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                    @php
                                        $insurance = ($client->financialData->life ?? 0) +
                                                     ($client->financialData->health ?? 0) +
                                                     ($client->financialData->pa ?? 0) +
                                                     ($client->financialData->critical ?? 0) +
                                                     ($client->financialData->motor ?? 0) +
                                                     ($client->financialData->general ?? 0);

                                        $investments = ($client->financialData->fd ?? 0) +
                                                       ($client->financialData->mf ?? 0) +
                                                       ($client->financialData->pms ?? 0);

                                        $tax = ($client->financialData->income_tax ?? 0) +
                                               ($client->financialData->gst ?? 0) +
                                               ($client->financialData->tds ?? 0) +
                                               ($client->financialData->pt ?? 0) +
                                               ($client->financialData->vat ?? 0) +
                                               ($client->financialData->roc ?? 0) +
                                               ($client->financialData->cma ?? 0);

                                        $others = ($client->financialData->accounting ?? 0) +
                                                  ($client->financialData->others ?? 0);

                                        $total = $insurance + $investments + $tax + $others;
                                    @endphp
                                    <tr>
                                        <td class="client-name"><strong>{{ $client->client_name }}</strong></td>
                                        <td>{{ number_format($insurance) }}</td>
                                        <td>{{ number_format($investments) }}</td>
                                        <td>{{ number_format($tax) }}</td>
                                        <td>{{ number_format($others) }}</td>
                                        <td class="total-amount"><strong>{{ number_format($total) }}</strong></td>
                                        <td>
                                            <a href="{{ route('financial_data.edit', $client->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fa fa-info-circle me-1"></i> No client data found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="cross-pagination">
                    {{ $clients->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

</body>
</html>
