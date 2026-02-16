<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
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
<body class="page-client-profile">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                <div class="profile-shell">
                    <div class="profile-topbar">
                        <div class="title-stack">
                            <div class="page-eyebrow">Client Profile</div>
                            <div class="page-title-lg">
                                {{ $client->abbr }} {{ $client->client_name }}
                            </div>
                            <div class="page-subtitle">
                                Family Code: <span>{{ $client->family_code }}</span>
                                <span class="dot">•</span>
                                Client Code: <span>{{ $client->client_code }}</span>
                            </div>
                        </div>
                        <div class="profile-actions">
                            <button class="btn-ghost" type="button" id="toggleFamilyBtn">
                                <i class="fas fa-users"></i> Show Family
                            </button>
                            <a class="btn-ghost" href="{{ route('clients.index') }}">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <a class="btn-primary" href="{{ route('clients.edit', $client->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>

                    <div class="profile-grid">
                        <div class="profile-card">
                            <div class="identity">
                                <div class="avatar">
                                    {{ $client->abbr ?? 'CL' }}
                                </div>
                                <div class="identity-text">
                                    <div class="name">{{ $client->abbr }} {{ $client->client_name }}</div>
                                    <div class="meta">
                                        {{ $client->account_type ?? 'Account' }}
                                        <span class="dot">•</span>
                                        {{ $client->category ?? 'Uncategorized' }}
                                    </div>
                                </div>
                            </div>

                            <div class="contact-list">
                                <div class="contact-row">
                                    <div class="label">Primary Mobile</div>
                                    <div class="value">{{ $client->primary_mobile_number }}</div>
                                </div>
                                <div class="contact-row">
                                    <div class="label">Primary Email</div>
                                    <div class="value">
                                        <a href="mailto:{{ $client->primary_email_number }}">{{ $client->primary_email_number }}</a>
                                    </div>
                                </div>
                                <div class="contact-row">
                                    <div class="label">Relationship Manager</div>
                                    <div class="value">{{ optional($client->relationshipManager)->name ?? $client->rm ?? '—' }}</div>
                                </div>
                                <div class="contact-row">
                                    <div class="label">Partner</div>
                                    <div class="value">{{ $client->partner ?? '—' }}</div>
                                </div>
                                <div class="contact-row">
                                    <div class="label">Family Head</div>
                                    <div class="value">{{ $client->family_head }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-card">
                            <div class="card-title">Personal & Account</div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="label">Gender</div>
                                    <div class="value">{{ $client->gender }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">PAN Card</div>
                                    <div class="value">{{ $client->pan_card_number }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Date of Birth</div>
                                    <div class="value">{{ $client->dob }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Anniversary</div>
                                    <div class="value">{{ $client->doa ?? '—' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Date of Join</div>
                                    <div class="value">{{ $client->date_of_join ?? '—' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Close Date</div>
                                    <div class="value">{{ $client->close_date ?? '—' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Secondary Mobile</div>
                                    <div class="value">{{ $client->secondary_mobile_number ?? '—' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Secondary Email</div>
                                    <div class="value">{{ $client->secondary_email_number ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-card span-2">
                            <div class="card-title">Address & Notes</div>
                            <div class="detail-grid address-grid">
                                <div class="detail-item">
                                    <div class="label">Address</div>
                                    <div class="value">{{ $client->address }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">City</div>
                                    <div class="value">{{ $client->city }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">State</div>
                                    <div class="value">{{ $client->state }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Zip Code</div>
                                    <div class="value">{{ $client->zip_code }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Referred By</div>
                                    <div class="value">{{ $client->referred_by ?? '—' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Tax Status</div>
                                    <div class="value">{{ $client->tax_status ?? '—' }}</div>
                                </div>
                                <div class="detail-item span-2">
                                    <div class="label">Notes</div>
                                    <div class="value">{{ $client->notes ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-card">
                            <div class="card-title">Audit</div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="label">Created Date</div>
                                    <div class="value">{{ $client->created_at }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="label">Updated Date</div>
                                    <div class="value">{{ $client->updated_at }}</div>
                                </div>
                            </div>
                            <div class="profile-footer-actions">
                                <a class="btn-ghost" href="{{ route('dashboard') }}">
                                    <i class="fas fa-chart-pie"></i> Dashboard
                                </a>
                                <a class="btn-ghost" href="{{ route('clients.index') }}">
                                    <i class="fas fa-users"></i> Clients
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="family-section" id="familySection">
                        <div class="family-header">
                            <div>
                                <div class="card-title">Family Members</div>
                                <div class="family-subtitle">
                                    Family Code: <strong>{{ $client->family_code ?? '—' }}</strong>
                                </div>
                            </div>
                            <div class="family-count">
                                {{ $familyMembers->count() }} member{{ $familyMembers->count() === 1 ? '' : 's' }}
                            </div>
                        </div>

                        @if($familyMembers->isEmpty())
                            <div class="family-empty">No family members found for this family code.</div>
                        @else
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
                                    </thead>
                                    <tbody>
                                    @foreach($familyMembers as $index => $member)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $member->family_code }}</td>
                                            <td>{{ $member->family_head }}</td>
                                            <td>
                                                <a href="{{ route('clients.show', $member->id) }}">
                                                    {{ $member->client_name }}
                                                </a>
                                            </td>
                                            <td>{{ $member->primary_mobile_number }}</td>
                                            <td>{{ $member->primary_email_number }}</td>
                                            <td>{{ optional($member->relationshipManager)->name ?? $member->rm ?? '—' }}</td>
                                            <td>{{ $member->partner ?? '—' }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

<script>
    const familyToggleBtn = document.getElementById('toggleFamilyBtn');
    const familySection = document.getElementById('familySection');

    if (familyToggleBtn && familySection) {
        familyToggleBtn.addEventListener('click', function () {
            const isHidden = familySection.classList.toggle('is-hidden');
            this.innerHTML = isHidden
                ? '<i class="fas fa-users"></i> Show Family'
                : '<i class="fas fa-users"></i> Hide Family';
        });
    }
</script>

</body>
</html>
