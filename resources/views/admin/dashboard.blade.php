@extends('admin.layout')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('styles')
<style>
    @keyframes dash-fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes dash-popIn {
        0% { opacity: 0; transform: scale(0.7) rotate(-10deg); }
        60% { opacity: 1; transform: scale(1.1) rotate(5deg); }
        100% { opacity: 1; transform: scale(1) rotate(0); }
    }
    @keyframes dash-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    @keyframes dash-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.5); }
        50% { box-shadow: 0 0 0 12px rgba(79, 70, 229, 0); }
    }
    @keyframes dash-shimmer {
        0% { background-position: -400px 0; }
        100% { background-position: 400px 0; }
    }
    @keyframes dash-slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes dash-spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .dash-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #9333ea 50%, #ec4899 100%);
        background-size: 400% 400%;
        border-radius: 14px;
        padding: 22px 26px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        animation: dash-fadeUp 0.6s ease both, dash-shimmer 8s linear infinite;
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.35);
    }
    .dash-hero h2 {
        margin: 0;
        font-weight: 700;
        font-size: 24px;
    }
    .dash-hero p {
        margin: 4px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .dash-hero .dash-wave {
        display: inline-block;
        animation: dash-float 2s ease-in-out infinite;
        font-size: 28px;
        margin-right: 10px;
    }
    .dash-hero-date {
        background: rgba(255,255,255,0.15);
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        border: 1px solid rgba(255,255,255,0.25);
        backdrop-filter: blur(4px);
    }

    .dash-stat {
        animation: dash-fadeUp 0.6s ease both;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        overflow: hidden;
        position: relative;
    }
    .dash-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.35);
    }
    .dash-stat .icon i {
        animation: dash-float 3.5s ease-in-out infinite;
        transition: transform 0.3s ease;
    }
    .dash-stat:hover .icon i {
        transform: scale(1.2) rotate(-6deg);
    }
    .dash-stat::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 40%;
        height: 200%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.18), transparent);
        transform: rotate(20deg);
        transition: left 0.6s ease;
    }
    .dash-stat:hover::after { left: 120%; }

    .dash-stat.delay-1 { animation-delay: 0.08s; }
    .dash-stat.delay-2 { animation-delay: 0.16s; }
    .dash-stat.delay-3 { animation-delay: 0.24s; }
    .dash-stat.delay-4 { animation-delay: 0.32s; }

    .dash-card {
        animation: dash-fadeUp 0.7s ease both;
        animation-delay: 0.4s;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .dash-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.3);
    }
    .dash-card .card-title i {
        animation: dash-pulse 2.5s infinite;
        padding: 4px;
        border-radius: 50%;
    }

    .dash-quick-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease;
        animation: dash-slideIn 0.5s ease both;
    }
    .dash-quick-btn:hover {
        transform: translateX(6px);
        letter-spacing: 0.3px;
    }
    .dash-quick-btn i {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    .dash-quick-btn:hover i {
        transform: scale(1.3) rotate(-8deg);
    }
    .dash-quick-btn.delay-1 { animation-delay: 0.5s; }
    .dash-quick-btn.delay-2 { animation-delay: 0.58s; }
    .dash-quick-btn.delay-3 { animation-delay: 0.66s; }
    .dash-quick-btn.delay-4 { animation-delay: 0.74s; }
    .dash-quick-btn.delay-5 { animation-delay: 0.82s; }

    .dash-row-anim tr {
        animation: dash-slideIn 0.5s ease both;
    }
    .dash-row-anim tr:nth-child(1) { animation-delay: 0.55s; }
    .dash-row-anim tr:nth-child(2) { animation-delay: 0.62s; }
    .dash-row-anim tr:nth-child(3) { animation-delay: 0.69s; }
    .dash-row-anim tr:nth-child(4) { animation-delay: 0.76s; }
    .dash-row-anim tr:nth-child(5) { animation-delay: 0.83s; }

    .dash-counter {
        display: inline-block;
        animation: dash-popIn 0.7s ease both;
        animation-delay: 0.2s;
    }

    .dash-spinner-icon {
        animation: dash-spin-slow 6s linear infinite;
    }

    .dash-row-anim tr:hover td {
        background: rgba(79, 70, 229, 0.12) !important;
    }
</style>
@endpush

@section('content')
    <div class="dash-hero">
        <div>
            <h2><span class="dash-wave">👋</span> Welcome back, {{ explode('@', $stats['lastLoginEmail'])[0] }}</h2>
            <p>Here's what's happening with your portfolio today.</p>
        </div>
        <div class="dash-hero-date">
            <i class="far fa-calendar-alt mr-1"></i> {{ now()->format('l, M d, Y') }}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info dash-stat delay-1">
                <div class="inner">
                    <h3><span class="dash-counter" data-target="{{ $stats['contacts'] }}">0</span></h3>
                    <p><i class="fas fa-envelope-open-text mr-1"></i> Contact Messages</p>
                </div>
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <a href="{{ route('admin.contacts.index') }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success dash-stat delay-2">
                <div class="inner">
                    <h3><span class="dash-counter" data-target="{{ $stats['experiences'] }}">0</span></h3>
                    <p><i class="fas fa-circle-check mr-1"></i> Experiences ({{ $stats['activeExperiences'] }} active)</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <a href="{{ route('admin.experiences.index') }}" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning dash-stat delay-3">
                <div class="inner">
                    <h3><span class="dash-counter" data-target="{{ $stats['projects'] }}">0</span></h3>
                    <p><i class="fas fa-star mr-1"></i> Projects ({{ $stats['featuredProjects'] }} featured)</p>
                </div>
                <div class="icon"><i class="fas fa-diagram-project"></i></div>
                <a href="{{ route('admin.projects.index') }}" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary dash-stat delay-4">
                <div class="inner">
                    <h3 style="font-size:20px">{{ $stats['contentUpdatedAt'] }}</h3>
                    <p><i class="fas fa-pen-to-square mr-1"></i> Home Content Updated</p>
                </div>
                <div class="icon"><i class="fas fa-clock dash-spinner-icon"></i></div>
                <a href="{{ route('admin.home.edit') }}" class="small-box-footer">Edit <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline dash-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-inbox mr-1"></i> Recent Messages</h3>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-info">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user mr-1"></i> Name</th>
                                <th><i class="fas fa-tag mr-1"></i> Subject</th>
                                <th><i class="fas fa-clock mr-1"></i> Received</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="dash-row-anim">
                            @forelse($recentContacts as $contact)
                                <tr>
                                    <td><i class="fas fa-circle-user text-info mr-1"></i> {{ $contact->name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($contact->subject, 40) }}</td>
                                    <td><i class="far fa-clock mr-1"></i> {{ $contact->created_at?->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:0.4"></i>
                                    No messages yet.
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-secondary card-outline dash-card">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-bolt mr-1"></i> Quick Actions</h3>
                </div>
                <div class="card-body d-flex flex-column" style="gap:10px">
                    <a href="{{ route('admin.home.edit') }}" class="btn btn-primary text-left dash-quick-btn delay-1">
                        <i class="fas fa-house mr-2"></i> Edit Home Section
                    </a>
                    <a href="{{ route('admin.experiences.create') }}" class="btn btn-success text-left dash-quick-btn delay-2">
                        <i class="fas fa-briefcase-medical mr-2"></i> Add Experience
                    </a>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-warning text-left dash-quick-btn delay-3">
                        <i class="fas fa-rocket mr-2"></i> Add Project
                    </a>
                    <a href="{{ route('terminal.panel') }}" class="btn btn-secondary text-left dash-quick-btn delay-4">
                        <i class="fas fa-terminal mr-2"></i> Terminal Panel
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light text-left dash-quick-btn delay-5">
                        <i class="fas fa-up-right-from-square mr-2"></i> View Portfolio
                    </a>
                </div>
                <div class="card-footer text-muted">
                    <i class="fas fa-user-shield mr-1"></i> Logged in as: <strong>{{ $stats['lastLoginEmail'] }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.dash-counter').forEach(function (el) {
        const target = parseInt(el.getAttribute('data-target'), 10) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        const duration = 1000;
        const stepTime = Math.max(20, Math.floor(duration / target));
        let current = 0;
        const timer = setInterval(function () {
            current += Math.max(1, Math.ceil(target / (duration / stepTime)));
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, stepTime);
    });
</script>
@endpush
