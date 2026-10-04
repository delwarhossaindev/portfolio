@extends('admin.layout')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('styles')
<style>
    .dash-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 28px 30px;
        margin-bottom: 22px;
        color: #fff;
        background:
            radial-gradient(600px 240px at 90% -20%, rgba(255, 255, 255, 0.22), transparent 60%),
            radial-gradient(400px 200px at 0% 120%, rgba(236, 72, 153, 0.45), transparent 60%),
            linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #a855f7 100%);
        box-shadow: 0 18px 40px -12px rgba(79, 70, 229, 0.55);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.14) 1px, transparent 1px);
        background-size: 18px 18px;
        mask-image: linear-gradient(90deg, transparent 40%, #000);
        -webkit-mask-image: linear-gradient(90deg, transparent 40%, #000);
        pointer-events: none;
    }
    .dash-hero > * { position: relative; }
    .dash-hero .eyebrow {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.8;
    }
    .dash-hero h2 {
        color: #fff;
        font-size: 26px;
        font-weight: 800;
        margin: 6px 0 6px;
        letter-spacing: -0.02em;
    }
    .dash-hero p { margin: 0; opacity: 0.88; font-size: 14px; max-width: 460px; }
    .dash-hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .dash-hero-actions a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 11px;
        font-weight: 600;
        font-size: 13px;
        color: #fff;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(6px);
        transition: background 0.15s ease, transform 0.15s ease;
    }
    .dash-hero-actions a:hover { background: rgba(255, 255, 255, 0.26); transform: translateY(-1px); text-decoration: none; color: #fff; }
    .dash-hero-actions a.solid { background: #fff; color: #4f46e5; border-color: #fff; }
    .dash-hero-actions a.solid:hover { background: #eef2ff; color: #4338ca; }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }
    @media (max-width: 1199.98px) { .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 575.98px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        display: block;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px;
        box-shadow: var(--shadow);
        color: var(--text) !important;
        transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        border-color: var(--border-strong);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
    }
    .stat-top { display: flex; align-items: center; justify-content: space-between; }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .stat-icon.c-indigo { background: rgba(99, 102, 241, 0.14); color: var(--primary-text); }
    .stat-icon.c-green { background: rgba(34, 197, 94, 0.14); color: var(--success-text); }
    .stat-icon.c-amber { background: rgba(245, 158, 11, 0.14); color: var(--warning-text); }
    .stat-icon.c-sky { background: rgba(14, 165, 233, 0.14); color: var(--info-text); }
    .stat-trend {
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 999px;
        background: var(--surface-3);
        color: var(--muted);
    }
    .stat-trend.hot { background: rgba(239, 68, 68, 0.12); color: var(--danger-text); }
    .stat-value {
        font-size: 30px;
        font-weight: 800;
        color: var(--text-strong);
        margin-top: 14px;
        line-height: 1;
        letter-spacing: -0.02em;
        font-variant-numeric: tabular-nums;
    }
    .stat-label { font-size: 13px; color: var(--muted); margin-top: 6px; }
    .stat-bar {
        height: 6px;
        border-radius: 999px;
        background: var(--surface-3);
        margin-top: 14px;
        overflow: hidden;
    }
    .stat-bar > span { display: block; height: 100%; border-radius: inherit; }
    .stat-bar .b-indigo { background: var(--gradient); }
    .stat-bar .b-green { background: linear-gradient(90deg, #22c55e, #10b981); }
    .stat-bar .b-amber { background: linear-gradient(90deg, #f59e0b, #f97316); }
    .stat-bar .b-sky { background: linear-gradient(90deg, #0ea5e9, #06b6d4); }

    .msg-list { list-style: none; margin: 0; padding: 0; }
    .msg-item a {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        color: var(--text) !important;
        transition: background 0.15s ease;
    }
    .msg-item:last-child a { border-bottom: none; }
    .msg-item a:hover { background: var(--surface-2); text-decoration: none; }
    .msg-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #fff;
        position: relative;
    }
    .msg-avatar .unread-dot {
        position: absolute;
        top: -3px;
        right: -3px;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: var(--primary);
        box-shadow: 0 0 0 2px var(--surface);
    }
    .msg-body { flex: 1; min-width: 0; }
    .msg-row { display: flex; justify-content: space-between; gap: 10px; }
    .msg-name { font-weight: 600; color: var(--text-strong); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .msg-name.unread::after { content: 'New'; font-size: 10px; font-weight: 700; margin-left: 8px; padding: 2px 6px; border-radius: 6px; background: var(--primary-soft); color: var(--primary-text); vertical-align: 1px; }
    .msg-time { font-size: 12px; color: var(--muted); white-space: nowrap; }
    .msg-subject { font-size: 13px; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }

    .quick-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    .quick-tile {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--surface-2);
        color: var(--text) !important;
        font-weight: 600;
        font-size: 13px;
        transition: border-color 0.15s ease, transform 0.15s ease, background 0.15s ease;
    }
    .quick-tile:hover { border-color: var(--primary); transform: translateY(-2px); background: var(--surface); text-decoration: none; }
    .quick-tile i {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .quick-tile small { display: block; font-weight: 500; color: var(--muted); font-size: 11.5px; margin-top: -6px; }

    .status-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border); font-size: 13px; }
    .status-row:last-child { border-bottom: none; padding-bottom: 0; }
    .status-row span:first-child { color: var(--muted); }
    .status-row strong { color: var(--text-strong); font-weight: 600; }
</style>
@endpush

@php
    $firstName = \Illuminate\Support\Str::of(auth()->user()?->name ?: explode('@', $stats['lastLoginEmail'])[0])->explode(' ')->first();
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $pct = fn ($part, $whole) => $whole > 0 ? round($part / $whole * 100) : 0;
    $avatarColors = ['#6366f1,#8b5cf6', '#0ea5e9,#06b6d4', '#f59e0b,#ef4444', '#22c55e,#10b981', '#ec4899,#8b5cf6'];
@endphp

@section('content')
    <div class="dash-hero">
        <div>
            <div class="eyebrow"><i class="far fa-calendar mr-1"></i> {{ now()->format('l, F j') }}</div>
            <h2>{{ $greeting }}, {{ $firstName }} 👋</h2>
            <p>
                @if($stats['unreadContacts'])
                    You have <strong>{{ $stats['unreadContacts'] }} unread {{ \Illuminate\Support\Str::plural('message', $stats['unreadContacts']) }}</strong> waiting. Here's your portfolio at a glance.
                @else
                    Inbox zero — nice! Here's your portfolio at a glance.
                @endif
            </p>
        </div>
        <div class="dash-hero-actions">
            <a href="{{ route('admin.projects.create') }}" class="solid"><i class="fas fa-plus"></i> New project</a>
            <a href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fas fa-arrow-up-right-from-square"></i> View site</a>
        </div>
    </div>

    <div class="stat-grid">
        <a href="{{ route('admin.contacts.index') }}" class="stat-card">
            <div class="stat-top">
                <span class="stat-icon c-indigo"><i class="fas fa-envelope"></i></span>
                <span class="stat-trend {{ $stats['unreadContacts'] ? 'hot' : '' }}">{{ $stats['unreadContacts'] }} unread</span>
            </div>
            <div class="stat-value" data-count="{{ $stats['contacts'] }}">{{ $stats['contacts'] }}</div>
            <div class="stat-label">Contact messages</div>
            <div class="stat-bar"><span class="b-indigo" style="width: {{ $stats['contacts'] ? 100 - $pct($stats['unreadContacts'], $stats['contacts']) : 0 }}%"></span></div>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="stat-card">
            <div class="stat-top">
                <span class="stat-icon c-amber"><i class="fas fa-diagram-project"></i></span>
                <span class="stat-trend"><i class="fas fa-star mr-1"></i>{{ $stats['featuredProjects'] }} featured</span>
            </div>
            <div class="stat-value" data-count="{{ $stats['projects'] }}">{{ $stats['projects'] }}</div>
            <div class="stat-label">Projects · {{ $stats['activeProjects'] }} live</div>
            <div class="stat-bar"><span class="b-amber" style="width: {{ $pct($stats['activeProjects'], $stats['projects']) }}%"></span></div>
        </a>
        <a href="{{ route('admin.experiences.index') }}" class="stat-card">
            <div class="stat-top">
                <span class="stat-icon c-green"><i class="fas fa-briefcase"></i></span>
                <span class="stat-trend">{{ $stats['activeExperiences'] }} active</span>
            </div>
            <div class="stat-value" data-count="{{ $stats['experiences'] }}">{{ $stats['experiences'] }}</div>
            <div class="stat-label">Experience entries</div>
            <div class="stat-bar"><span class="b-green" style="width: {{ $pct($stats['activeExperiences'], $stats['experiences']) }}%"></span></div>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="stat-card">
            <div class="stat-top">
                <span class="stat-icon c-sky"><i class="fas fa-newspaper"></i></span>
                <span class="stat-trend">{{ $stats['publishedArticles'] }} published</span>
            </div>
            <div class="stat-value" data-count="{{ $stats['articles'] }}">{{ $stats['articles'] }}</div>
            <div class="stat-label">Blog articles</div>
            <div class="stat-bar"><span class="b-sky" style="width: {{ $pct($stats['publishedArticles'], $stats['articles']) }}%"></span></div>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-inbox"></i> Recent messages</h3>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                        View all <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentContacts->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            No messages yet. They'll show up here when visitors reach out.
                        </div>
                    @else
                        <ul class="msg-list">
                            @foreach($recentContacts as $i => $contact)
                                <li class="msg-item">
                                    <a href="{{ route('admin.contacts.show', $contact) }}">
                                        <span class="msg-avatar" style="background: linear-gradient(135deg, {{ $avatarColors[$contact->id % count($avatarColors)] }})">
                                            {{ mb_strtoupper(mb_substr($contact->name, 0, 1)) }}
                                            @unless($contact->is_read)<span class="unread-dot"></span>@endunless
                                        </span>
                                        <span class="msg-body">
                                            <span class="msg-row">
                                                <span class="msg-name {{ $contact->is_read ? '' : 'unread' }}">{{ $contact->name }}</span>
                                                <span class="msg-time">{{ $contact->created_at?->diffForHumans(short: true) }}</span>
                                            </span>
                                            <span class="msg-subject d-block">{{ $contact->subject ?: \Illuminate\Support\Str::limit($contact->message, 80) }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-bolt"></i> Quick actions</h3>
                </div>
                <div class="card-body">
                    <div class="quick-grid">
                        <a href="{{ route('admin.home.edit') }}" class="quick-tile">
                            <i class="fas fa-house-user" style="background: rgba(99,102,241,.14); color: var(--primary-text)"></i>
                            Home section
                            <small>Hero & about</small>
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="quick-tile">
                            <i class="fas fa-rocket" style="background: rgba(245,158,11,.14); color: var(--warning-text)"></i>
                            Add project
                            <small>Showcase work</small>
                        </a>
                        <a href="{{ route('admin.experiences.create') }}" class="quick-tile">
                            <i class="fas fa-briefcase" style="background: rgba(34,197,94,.14); color: var(--success-text)"></i>
                            Add experience
                            <small>Career timeline</small>
                        </a>
                        <a href="{{ route('admin.articles.create') }}" class="quick-tile">
                            <i class="fas fa-pen-nib" style="background: rgba(14,165,233,.14); color: var(--info-text)"></i>
                            Write article
                            <small>Blog post</small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-circle-info"></i> Site status</h3>
                </div>
                <div class="card-body">
                    <div class="status-row"><span>Home content updated</span><strong>{{ $stats['contentUpdatedAt'] }}</strong></div>
                    <div class="status-row"><span>Signed in as</span><strong>{{ $stats['lastLoginEmail'] }}</strong></div>
                    <div class="status-row"><span>Environment</span><span class="pill {{ app()->environment('production') ? 'pill-success' : 'pill-warning' }} m-0">{{ app()->environment() }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('[data-count]').forEach(function (el) {
            const target = parseInt(el.dataset.count, 10) || 0;
            if (!target) return;
            const start = performance.now();
            const duration = 700;
            (function step(now) {
                const t = Math.min(1, (now - start) / duration);
                el.textContent = Math.round(target * (1 - Math.pow(1 - t, 3)));
                if (t < 1) requestAnimationFrame(step);
            })(start);
        });
    })();
</script>
@endpush
