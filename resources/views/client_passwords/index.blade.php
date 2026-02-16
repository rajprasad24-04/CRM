<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Passwords for {{ $client->client_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="https://play-lh.googleusercontent.com/AonPe9VE8OgO2lhBpV0l7NHC561PT62ycEdEDhhVQogLAngsKBTmi2GAmREKHuXd-TM=w240-h480-rw">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:700,500,400,300,100italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin_page/css/icon-font.min.css') }}" type="text/css" />
    
    <!-- Custom JS and jQuery -->
    <script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('admin_page/js/custom.js') }}"></script>

    </head>
<body class="page-client-passwords-index">
    <div class="page-container">
        <div class="left-content">
            <div class="inner-content">
                <!-- Include Header -->
                @include('includes.header')

                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb m-b-0">
                            <li><a href="{{ route('dashboard') }}">Home</a></li>
                            <li><a href="{{ route('clients.show', ['id' => $client->id]) }}">Client Details</a></li>
                            <li class="active">Client Passwords</li>
                        </ol>
                    </div>

                    <div class="graph-visual tables-main">
                        <h3 class="inner-tittle two">Client Passwords for {{ $client->client_name }}</h3>

                        <!-- Add New Password Button -->
                        <button type="button" class="create-client-btn">
                            <a href="{{ route('client_passwords.create', $client->id) }}">
                                <i class="fas fa-plus"></i> Add a New Password
                            </a>
                        </button>

                        @if ($passwords->isEmpty())
                            <p>No passwords found for this client.</p>
                        @else
                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>User ID</th>
                                        <th>Password</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($passwords as $password)
                                        <tr>
                                            <td>{{ $password->title }}</td>
                                            <td>{{ $password->user_id }}</td>
                                            <td>
                                                <span id="password-{{ $password->id }}">********</span>
                                                <button onclick="copyPassword({{ $client->id }}, {{ $password->id }})" class="btn-copy">
                                                    <i class="fas fa-copy"></i> Copy
                                                </button>
                                            </td>
                                            <td>{{ $password->notes }}</td>
                                            <td>
                                                <a href="{{ route('client_passwords.edit', [$client->id, $password->id]) }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('client_passwords.destroy', [$client->id, $password->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Include Footer -->
            @include('includes.footer')
        </div>
    </div>

    <!-- Include Sidebar -->
    @include('includes.sidebar')

    <div class="clearfix"></div>

@include('includes.sidebar-toggle')

<script>
function copyTextWithFallback(text) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(text).then(() => true).catch(() => false);
    }
    const temp = document.createElement('textarea');
    temp.value = text;
    temp.setAttribute('readonly', '');
    temp.style.position = 'absolute';
    temp.style.left = '-9999px';
    document.body.appendChild(temp);
    temp.select();
    const ok = document.execCommand('copy');
    document.body.removeChild(temp);
    return Promise.resolve(!!ok);
}

function copyPassword(clientId, passwordId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/clients/${clientId}/passwords/${passwordId}/reveal`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to reveal password');
        }
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            if (response.redirected && response.url) {
                window.location.href = response.url;
                throw { silent: true };
            }
            throw new Error('Not authorized to reveal password');
        }
        return response.json();
    })
    .then(data => {
        const passwordText = data.password || '';
        return copyTextWithFallback(passwordText).then((ok) => {
            if (!ok) {
                throw { type: 'copy_failed', password: passwordText };
            }
        });
    })
    .then(() => {
        alert('Password copied!');
    })
    .catch((err) => {
        if (err && err.silent) {
            return;
        }
        if (err && err.type === 'copy_failed') {
            window.prompt('Copy password:', err.password || '');
            return;
        }
        alert('Unable to copy password.');
    });
}
</script>

</body>
</html>

