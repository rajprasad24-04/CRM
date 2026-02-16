<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice Comments</title>
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
</head>
<body class="page-notice-comments">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp">
                <div class="notice-shell">
                    <div class="notice-header">
                        <div>
                            <div class="page-eyebrow">Notice</div>
                            <h2>{{ $notice->title }}</h2>
                            <p>All comments for this notice.</p>
                        </div>
                        <a href="{{ route('internal.apps') }}" class="btn-ghost">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="notice-card">
                        <form method="POST" action="{{ route('notices.comments.store', $notice->id) }}" class="comment-form">
                            @csrf
                            <textarea name="body" rows="2" class="form-control" placeholder="Add a comment..." required></textarea>
                            <button type="submit" class="btn-primary">
                                <i class="fa fa-paper-plane"></i> Post
                            </button>
                        </form>
                    </div>

                    <div class="notice-grid">
                        @foreach($comments as $comment)
                            <div class="notice-card">
                                <div class="comment-meta">
                                    <span class="comment-author">{{ $comment->user->name ?? 'User' }}</span>
                                    <span class="comment-time">{{ $comment->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="comment-body">{{ $comment->body }}</div>
                                @if(Auth::user()?->hasRole('admin') || Auth::user()?->can('notices.manage'))
                                    <form method="POST" action="{{ route('notices.comments.destroy', $comment->id) }}" onsubmit="return confirm('Delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrap">
                        {{ $comments->links('pagination::bootstrap-4') }}
                    </div>
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
