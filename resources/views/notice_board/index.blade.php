<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice Board Admin</title>
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

    <!-- Trix Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.4/dist/trix.css">
</head>
<body class="page-notice-board notice-v2">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                <div class="notice-shell">
                    <div class="notice-header">
                        <div>
                            <div class="page-eyebrow">Admin</div>
                            <h2>Notice Board</h2>
                            <p>Publish company updates and announcements for all users.</p>
                        </div>
                        <div class="notice-header-actions">
                            <a href="{{ route('internal.apps') }}" class="btn-ghost">
                                <i class="fa fa-arrow-left"></i> Back to Apps
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="notice-layout">
                        <div class="notice-create">
                            <div class="notice-card">
                                <div class="card-title">Create New Notice</div>
                                <form method="POST" action="{{ route('admin.notices.store') }}" class="notice-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-grid">
                                        <div>
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Banner Image</label>
                                            <input type="file" name="banner" class="form-control" accept="image/*">
                                        </div>
                                        <div>
                                            <label class="form-label">Active</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Starts At</label>
                                            <input type="datetime-local" name="starts_at" class="form-control">
                                        </div>
                                        <div>
                                            <label class="form-label">Ends At</label>
                                            <input type="datetime-local" name="ends_at" class="form-control">
                                        </div>
                                        <div class="span-2">
                                            <label class="form-label">Message</label>
                                            <input id="notice-body-new" type="hidden" name="body">
                                            <trix-editor input="notice-body-new"></trix-editor>
                                        </div>
                                    </div>
                                    <div class="notice-actions">
                                        <button type="submit" class="btn-primary">
                                            <i class="fa fa-plus"></i> Publish Notice
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="notice-listing">
                            <div class="notice-grid">
                                @foreach($notices as $notice)
                                    <div class="notice-card">
                                        <div class="notice-meta-row">
                                            <div class="notice-meta-pill {{ $notice->is_active ? 'is-active' : 'is-inactive' }}">
                                                {{ $notice->is_active ? 'Active' : 'Inactive' }}
                                            </div>
                                            <div class="notice-meta-text">
                                                {{ optional($notice->starts_at)->format('M d, Y h:i A') ?? 'No start' }}
                                                &middot;
                                                {{ optional($notice->ends_at)->format('M d, Y h:i A') ?? 'No end' }}
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('admin.notices.update', $notice->id) }}" class="notice-form" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-grid">
                                                <div>
                                                    <label class="form-label">Title</label>
                                                    <input type="text" name="title" class="form-control" value="{{ $notice->title }}" required>
                                                </div>
                                                <div>
                                                    <label class="form-label">Banner Image</label>
                                                    <input type="file" name="banner" class="form-control" accept="image/*">
                                                    @if($notice->banner_path)
                                                        <div class="banner-preview">
                                                            <img src="{{ asset('storage/' . $notice->banner_path) }}" alt="Banner">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <label class="form-label">Active</label>
                                                    <select name="is_active" class="form-select">
                                                        <option value="1" {{ $notice->is_active ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ !$notice->is_active ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="form-label">Starts At</label>
                                                    <input type="datetime-local" name="starts_at" class="form-control" value="{{ optional($notice->starts_at)->format('Y-m-d\\TH:i') }}">
                                                </div>
                                                <div>
                                                    <label class="form-label">Ends At</label>
                                                    <input type="datetime-local" name="ends_at" class="form-control" value="{{ optional($notice->ends_at)->format('Y-m-d\\TH:i') }}">
                                                </div>
                                                <div class="span-2">
                                                    <label class="form-label">Message</label>
                                                    <input id="notice-body-{{ $notice->id }}" type="hidden" name="body" value="{{ $notice->body }}">
                                                    <trix-editor input="notice-body-{{ $notice->id }}"></trix-editor>
                                                </div>
                                            </div>
                                            <div class="notice-actions">
                                                <button type="submit" class="btn-ghost">
                                                    <i class="fa fa-save"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                        <form method="POST" action="{{ route('admin.notices.destroy', $notice->id) }}" onsubmit="return confirm('Delete this notice?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

@include('includes.sidebar-toggle')

<script src="https://cdn.jsdelivr.net/npm/trix@2.1.4/dist/trix.umd.min.js"></script>
</body>
</html>
