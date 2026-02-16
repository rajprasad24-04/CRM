<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Applications</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_page/images/favicon.ico') }}">

    <!-- Bootstrap & FontAwesome -->
    <link href="{{ asset('admin_page/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/saas.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_page/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('admin_page/css/icon-font.min.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Inter:400,500,600,700' rel='stylesheet' type='text/css'>
</head>
<body class="page-internal-apps internal-audit">
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            @include('includes.header')

            <div class="outter-wp internal-shell">
                <section class="internal-hero">
                    <div>
                        <div class="internal-eyebrow">
                            <i class="fa fa-shield"></i>
                            Corporate Workspace
                        </div>
                        <h1>Internal Applications</h1>
                        <p>Launch tools, track updates, and collaborate in one clean, secure workspace.</p>
                        <div class="internal-actions">
                            <a class="btn btn-primary" href="{{ route('clients.index') }}">
                                <i class="fa fa-users"></i> Clients
                            </a>
                            <a class="btn btn-ghost" href="{{ route('dashboard') }}">
                                <i class="fa fa-chart-pie"></i> Dashboard
                            </a>
                        </div>
                    </div>
                    <div class="internal-stats">
                        <div class="internal-stat">
                            <div class="stat-label">Notices</div>
                            <div class="stat-value">{{ $notices->count() }}</div>
                        </div>
                        <div class="internal-stat">
                            <div class="stat-label">Today</div>
                            <div class="stat-value">{{ now()->format('M d') }}</div>
                        </div>
                        <div class="internal-stat accent">
                            <div class="stat-label">Status</div>
                            <div class="stat-value">Online</div>
                        </div>
                    </div>
                </section>

                <section class="internal-grid">
                    <div class="internal-left">
                        <div class="internal-card">
                            <div class="card-header">
                                <div class="card-title">Quick Links</div>
                                <div class="card-subtitle">Daily essentials</div>
                            </div>
                            <div class="link-grid">
                                <a href="{{ route('wealixir.policies') }}" class="link-tile" target="_blank" rel="noopener">
                                    <div class="tile-icon"><i class="fa fa-book"></i></div>
                                    <div>
                                        <div class="tile-title">Handbook</div>
                                        <div class="tile-sub">Policies & resources</div>
                                    </div>
                                </a>
                                <a href="https://wealixir.sharepoint.com/:u:/s/SupportTickets/EaDzKRbWjAhFhWByU_JEZpABwJInb6MsEjT1tA3YfHg4Qw?e=DpFVss" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-headset"></i></div>
                                    <div>
                                        <div class="tile-title">Support Ticket</div>
                                        <div class="tile-sub">Request internal help</div>
                                    </div>
                                </a>
                                <a href="https://wealixir.sharepoint.com/sites/SupportTickets/SOP/Forms/AllItems.aspx" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-clipboard-check"></i></div>
                                    <div>
                                        <div class="tile-title">SOP</div>
                                        <div class="tile-sub">Standard processes</div>
                                    </div>
                                </a>
                                <a href="https://wealixir.sharepoint.com/sites/SupportTickets/Lists/WFH%20Requests/Leave_Calendar.aspx?viewid=25983205%2Dc54b%2D4dbf%2Da84f%2Def8b685d1d53" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-calendar-check"></i></div>
                                    <div>
                                        <div class="tile-title">Leave Requests</div>
                                        <div class="tile-sub">WFH & leave calendar</div>
                                    </div>
                                </a>
                                <a href="https://wealixir.investwell.app/app/#/login" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-chart-line"></i></div>
                                    <div>
                                        <div class="tile-title">Investwell</div>
                                        <div class="tile-sub">Portfolio platform</div>
                                    </div>
                                </a>
                                <a href="https://jamku.app/" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-layer-group"></i></div>
                                    <div>
                                        <div class="tile-title">Jamku</div>
                                        <div class="tile-sub">Operations hub</div>
                                    </div>
                                </a>
                                <a href="https://i-magic.in/" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-star"></i></div>
                                    <div>
                                        <div class="tile-title">I Magic</div>
                                        <div class="tile-sub">Internal tools</div>
                                    </div>
                                </a>
                                <a href="https://payroll.razorpay.com/login" target="_blank" class="link-tile">
                                    <div class="tile-icon"><i class="fa fa-credit-card"></i></div>
                                    <div>
                                        <div class="tile-title">Razorpay</div>
                                        <div class="tile-sub">Payroll access</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        @php
                            $today = \Carbon\Carbon::now();
                            $monthStart = $today->copy()->startOfMonth();
                            $daysInMonth = $today->daysInMonth;
                            $startDay = $monthStart->dayOfWeekIso;
                            $noticesByDay = [];
                            foreach ($notices as $notice) {
                                $noticeDate = $notice->starts_at ?? $notice->created_at;
                                if (!$noticeDate) {
                                    continue;
                                }
                                if ($noticeDate->year !== $today->year || $noticeDate->month !== $today->month) {
                                    continue;
                                }
                                $dayKey = (int) $noticeDate->format('j');
                                if (!isset($noticesByDay[$dayKey])) {
                                    $noticesByDay[$dayKey] = [
                                        'count' => 0,
                                        'first_id' => $notice->id,
                                    ];
                                }
                                $noticesByDay[$dayKey]['count']++;
                            }
                        @endphp
                        <div class="internal-card">
                            <div class="card-header">
                                <div class="card-title">Calendar</div>
                                <div class="card-subtitle">{{ $today->format('F Y') }}</div>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day">Mon</div>
                                <div class="calendar-day">Tue</div>
                                <div class="calendar-day">Wed</div>
                                <div class="calendar-day">Thu</div>
                                <div class="calendar-day">Fri</div>
                                <div class="calendar-day">Sat</div>
                                <div class="calendar-day">Sun</div>
                                @for ($i = 1; $i < $startDay; $i++)
                                    <div class="calendar-date muted"></div>
                                @endfor
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $isToday = $day === (int) $today->format('j');
                                        $noticeMeta = $noticesByDay[$day] ?? null;
                                    @endphp
                                    @if($noticeMeta)
                                        <a href="#notice-{{ $noticeMeta['first_id'] }}" class="calendar-date has-notice {{ $isToday ? 'today' : '' }}">
                                            {{ $day }}
                                            <span class="notice-dot"></span>
                                            @if($noticeMeta['count'] > 1)
                                                <span class="notice-count">{{ $noticeMeta['count'] }}</span>
                                            @endif
                                        </a>
                                    @else
                                        <div class="calendar-date {{ $isToday ? 'today' : '' }}">
                                            {{ $day }}
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="internal-right">
                        <div class="internal-card welcome-panel">
                            <div class="welcome-title">
                                Welcome to Wealixir
                                @auth
                                    <span>&mdash; {{ $userName }}</span>
                                @endauth
                            </div>
                            <p>Wealixir brings together everything you need to manage Insurance, Investments, Taxation, and Real Estate in one place. Our expert-led ecosystem helps you build wealth and mitigate risks with confidence.</p>
                            @guest
                                <a href="/signin" class="cta-btn">Sign In</a>
                            @endguest
                        </div>

                        <div class="internal-card notice-board">
                            <div class="card-header">
                                <div class="card-title">Employee Notice Board</div>
                                <div class="card-subtitle">Updates and announcements</div>
                            </div>
                            @if(Auth::user()?->hasRole('admin') || Auth::user()?->can('notices.manage'))
                                <div class="notice-admin-link">
                                    <a href="{{ route('admin.notices.index') }}" class="btn btn-ghost">
                                        <i class="fa fa-pen"></i> Manage Notices
                                    </a>
                                    <a href="{{ route('admin.notices.index') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> New Notice
                                    </a>
                                </div>
                            @endif
                            <div class="notice-cards">
                                @forelse($notices as $notice)
                                    <div class="notice-card-item" id="notice-{{ $notice->id }}">
                                        <div class="notice-card-header">
                                            <div class="notice-title">
                                                {{ $notice->title }}
                                                @if($notice->created_at && $notice->created_at->gte(now()->subDays(7)))
                                                    <span class="notice-badge">New</span>
                                                @endif
                                            </div>
                                            <div class="notice-meta">
                                                @if($notice->starts_at)
                                                    <span><i class="fa fa-clock"></i> Start: {{ $notice->starts_at->format('M d, Y h:i A') }}</span>
                                                @endif
                                                @if($notice->ends_at)
                                                    <span><i class="fa fa-clock"></i> End: {{ $notice->ends_at->format('M d, Y h:i A') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($notice->banner_path)
                                            <div class="notice-banner">
                                                <img src="{{ asset('storage/' . $notice->banner_path) }}" alt="Notice banner">
                                            </div>
                                        @endif
                                        <div class="notice-body">{!! $notice->body ?: '&mdash;' !!}</div>
                                        <div class="notice-actions-row">
                                            <form method="POST" action="{{ route('notices.like', $notice->id) }}">
                                                @csrf
                                                <button type="submit" class="notice-like-btn {{ $notice->likes->isNotEmpty() ? 'is-liked' : '' }}">
                                                    <i class="fa fa-thumbs-up"></i>
                                                    Like
                                                    <span class="like-count">{{ $notice->likes_count }}</span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="notice-comments">
                                            <div class="comments-title">Comments ({{ $notice->comments_count }})</div>
                                            <form method="POST" action="{{ route('notices.comments.store', $notice->id) }}" class="comment-form">
                                                @csrf
                                                <textarea name="body" rows="2" class="form-control" placeholder="Add a comment..." required></textarea>
                                                <button type="submit" class="btn btn-ghost">
                                                    <i class="fa fa-paper-plane"></i> Post
                                                </button>
                                            </form>
                                            @if($notice->comments_count > 3)
                                                <a class="comment-link" href="{{ route('notices.comments.index', $notice->id) }}">
                                                    View all comments
                                                </a>
                                            @endif
                                            <div class="comment-list">
                                                @forelse($notice->comments as $comment)
                                                    <div class="comment-item">
                                                        <div class="comment-meta">
                                                            <span class="comment-author">{{ $comment->user->name ?? 'User' }}</span>
                                                            <span class="comment-time">{{ $comment->created_at->format('M d, Y h:i A') }}</span>
                                                        </div>
                                                        <div class="comment-body">{{ $comment->body }}</div>
                                                        @if(Auth::user()?->hasRole('admin') || Auth::user()?->can('notices.manage'))
                                                            <form method="POST" action="{{ route('notices.comments.destroy', $comment->id) }}" onsubmit="return confirm('Delete this comment?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div class="comment-empty">No comments yet.</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="notice-empty">No notices yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            @include('includes.footer')
        </div>
    </div>

    @include('includes.sidebar')
</div>

<script src="{{ asset('admin_page/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('admin_page/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_page/js/scripts.js') }}"></script>

@include('includes.sidebar-toggle')
</body>
</html>
