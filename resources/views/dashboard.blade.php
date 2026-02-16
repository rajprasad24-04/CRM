<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wealixir Client Management System || Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body class="page-dashboard dashboard-corp">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">

            @include('includes.header')

            <div class="outter-wp container-fluid">
                @php
                    $avgValue = $tclients > 0 ? ($totalAmount / $tclients) : 0;
                    $activeRate = $tclients > 0 ? (($activeClients / $tclients) * 100) : 0;
                    $inactiveRate = $tclients > 0 ? (($inactiveClients / $tclients) * 100) : 0;
                    $yearClients = array_sum($monthlyData);
                @endphp

                <section class="corp-dash-hero">
                    <div class="corp-dash-hero__text">
                        <div class="corp-dash-badge">
                            <i class="fa fa-dashboard"></i>
                            Corporate Workspace
                        </div>
                        <h2>Dashboard Overview</h2>
                        <p>Welcome back {{ Auth::user()->name ?? 'Guest' }}. Track portfolio health, client activity, and growth from one unified panel.</p>
                    </div>
                    <div class="corp-dash-hero__stats">
                        <div class="hero-stat">
                            <div class="hero-stat__label">Total Clients</div>
                            <div class="hero-stat__value">{{ number_format($tclients) }}</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat__label">Active Rate</div>
                            <div class="hero-stat__value">{{ number_format($activeRate, 1) }}%</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat__label">Added {{ $currentYear }}</div>
                            <div class="hero-stat__value">{{ number_format($yearClients) }}</div>
                        </div>
                    </div>
                </section>

                <section class="corp-dash-grid corp-dash-grid--2">
                    <div class="corp-card">
                        <div class="corp-card__head">
                            <div class="corp-card__title"><i class="fa fa-bullhorn"></i> Latest Notices</div>
                            <a href="{{ route('internal.apps') }}" class="corp-link">View all</a>
                        </div>
                        <div class="notice-list">
                            @forelse($notices as $notice)
                                <a class="notice-item" href="{{ route('internal.apps') }}#notice-{{ $notice->id }}">
                                    <div class="notice-item-title">{{ $notice->title }}</div>
                                    <div class="notice-item-meta">
                                        @if($notice->starts_at)
                                            {{ $notice->starts_at->format('M d, Y h:i A') }}
                                        @elseif($notice->created_at)
                                            {{ $notice->created_at->format('M d, Y') }}
                                        @endif
                                        @if($notice->ends_at)
                                            <span class="notice-item-sep">|</span>
                                            Ends {{ $notice->ends_at->format('M d, Y h:i A') }}
                                        @endif
                                        <span class="notice-item-sep">|</span>
                                        <span class="notice-item-like">
                                            <i class="fa fa-thumbs-up"></i>
                                            {{ $notice->likes_count ?? 0 }}
                                        </span>
                                    </div>
                                    <div class="notice-item-excerpt">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($notice->body ?? ''), 100) }}
                                    </div>
                                </a>
                            @empty
                                <div class="notice-empty">No notices yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="corp-card">
                        <div class="corp-card__head">
                            <div class="corp-card__title"><i class="fa fa-area-chart"></i> Quick Analytics</div>
                        </div>
                        <div class="analytics-grid">
                            <div class="analytics-item">
                                <div class="analytics-label">Average Client Value</div>
                                <div class="analytics-value">&#8377; {{ number_format($avgValue, 2) }}</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label">Active Clients</div>
                                <div class="analytics-value">{{ number_format($activeClients) }}</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label">Inactive Clients</div>
                                <div class="analytics-value">{{ number_format($inactiveClients) }}</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label">Lead Pipeline</div>
                                <div class="analytics-value">{{ number_format($contactLeads) }}</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label">Inactive Rate</div>
                                <div class="analytics-value">{{ number_format($inactiveRate, 1) }}%</div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-label">Years Active</div>
                                <div class="analytics-value">{{ count($years) }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="corp-dash-grid corp-dash-grid--4">
                    <div class="kpi-card">
                        <div class="kpi-label">Total Amount</div>
                        <div class="kpi-value">&#8377; {{ number_format($totalAmount, 2) }}</div>
                        <div class="kpi-meta">Portfolio value across all services</div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-label">Insurance</div>
                        <div class="kpi-value">&#8377; {{ number_format($totalInsurance, 2) }}</div>
                        <div class="kpi-meta">Coverage value</div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-label">Investments</div>
                        <div class="kpi-value">&#8377; {{ number_format($totalInvestments, 2) }}</div>
                        <div class="kpi-meta">Investment portfolio value</div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-label">Tax + Others</div>
                        <div class="kpi-value">&#8377; {{ number_format($totalTax + $totalOthers, 2) }}</div>
                        <div class="kpi-meta">Support and compliance services</div>
                    </div>
                </section>

                <section class="corp-card missing-grid">
                    <div class="corp-card__head">
                        <div class="corp-card__title"><i class="fa fa-exclamation-triangle"></i> Missing Client Data</div>
                        <div class="corp-card__sub">Click a card to filter clients by missing field</div>
                    </div>
                    <div class="missing-cards">
                        @foreach ($missingFields as $key => $label)
                            <a class="missing-card" href="{{ route('clients.index', ['missing' => $key]) }}">
                                <div class="missing-label">{{ $label }}</div>
                                <div class="missing-value">{{ $missingCounts[$key] ?? 0 }}</div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="corp-dash-grid corp-dash-grid--2 charts-top">
                    <div class="chart-section">
                        <h3 class="chart-title">
                            <span class="chart-icon"><i class="fa fa-pie-chart"></i></span>
                            Client Account Type Distribution
                        </h3>
                        <div class="chart-container" style="height: 330px;">
                            <canvas id="accountTypeChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-section">
                        <h3 class="chart-title">
                            <span class="chart-icon"><i class="fa fa-bar-chart"></i></span>
                            Year-wise Client Growth
                        </h3>
                        <div class="chart-container" style="height: 330px;">
                            <canvas id="yearlyChart"></canvas>
                        </div>
                    </div>
                </section>

                <section class="chart-section">
                    <h3 class="chart-title">
                        <span class="chart-icon"><i class="fa fa-calendar"></i></span>
                        Monthly Client Additions - {{ $currentYear }}
                    </h3>
                    <div class="chart-container" style="height: 340px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </section>
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

<script>
    // Account Type Distribution Pie Chart
    const accountTypeCtx = document.getElementById('accountTypeChart').getContext('2d');
    const accountTypeChart = new Chart(accountTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active Accounts', 'Inactive Accounts', 'Contacts/Leads', 'Unknown'],
            datasets: [{
                data: [
                    {{ $activeClients }},
                    {{ $inactiveClients }},
                    {{ $contactLeads }},
                    {{ $unknownClients }}
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(148, 163, 184, 0.8)'
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(148, 163, 184, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        font: {
                            size: 12,
                            family: 'Plus Jakarta Sans'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Year-wise Client Growth Chart
    const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    const yearlyChart = new Chart(yearlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($years) !!},
            datasets: [{
                label: 'Clients Added',
                data: {!! json_encode($clientCounts) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.78)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(37, 99, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(15, 23, 42, 0.08)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Monthly Client Additions Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Clients Added',
                data: {!! json_encode(array_values($monthlyData)) !!},
                borderColor: 'rgba(14, 165, 233, 1)',
                backgroundColor: 'rgba(14, 165, 233, 0.14)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: 'rgba(14, 165, 233, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(15, 23, 42, 0.08)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

<!-- Additional JS -->
<script src="{{ asset('admin_page/js/vroom.js') }}"></script>
<script src="{{ asset('admin_page/js/TweenLite.min.js') }}"></script>
<script src="{{ asset('admin_page/js/CSSPlugin.min.js') }}"></script>
<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>
<script src="{{ asset('admin_page/js/bootstrap.min.js') }}"></script>

</body>
</html>
