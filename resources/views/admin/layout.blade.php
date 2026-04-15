<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Portfolio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @keyframes admin-fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes admin-fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes admin-slideInLeft {
            from { opacity: 0; transform: translateX(-22px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes admin-slideInRight {
            from { opacity: 0; transform: translateX(22px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes admin-popIn {
            0% { opacity: 0; transform: scale(0.85); }
            60% { opacity: 1; transform: scale(1.04); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes admin-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        @keyframes admin-pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.5); }
            50% { box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
        }
        @keyframes admin-spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes admin-shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-4px); }
            40% { transform: translateX(4px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }
        @keyframes admin-bgShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .content-header h1 {
            animation: admin-slideInLeft 0.5s ease both;
            position: relative;
            padding-left: 14px;
        }
        .content-header h1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 5px;
            border-radius: 3px;
            background: linear-gradient(180deg, #4f46e5, #ec4899);
            animation: admin-pulseGlow 2.5s infinite;
        }

        .main-header {
            background: linear-gradient(90deg, #1a2238 0%, #232b44 100%) !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .main-header .nav-link {
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .main-header .nav-link:hover {
            color: #9fb0ff !important;
            transform: translateY(-1px);
        }
        .main-header form button {
            transition: all 0.25s ease;
        }
        .main-header form button:hover {
            background: #ef4444 !important;
            border-color: #ef4444 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(239,68,68,0.3);
        }

        .brand-link {
            background: linear-gradient(90deg, #4f46e5 0%, #9333ea 100%) !important;
            background-size: 200% 100% !important;
            animation: admin-bgShift 10s ease infinite;
        }
        .brand-text {
            font-weight: 700 !important;
            letter-spacing: 0.5px;
        }

        .main-sidebar .nav-sidebar .nav-item {
            animation: admin-slideInLeft 0.45s ease both;
        }
        .main-sidebar .nav-sidebar .nav-item:nth-child(1) { animation-delay: 0.05s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(2) { animation-delay: 0.10s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(3) { animation-delay: 0.15s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(4) { animation-delay: 0.20s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(5) { animation-delay: 0.25s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(6) { animation-delay: 0.30s; }
        .main-sidebar .nav-sidebar .nav-item:nth-child(7) { animation-delay: 0.35s; }

        .main-sidebar .nav-sidebar .nav-link {
            transition: all 0.25s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        .main-sidebar .nav-sidebar .nav-link .nav-icon {
            transition: transform 0.3s ease;
        }
        .main-sidebar .nav-sidebar .nav-link:hover {
            transform: translateX(4px);
            background: rgba(79, 70, 229, 0.15) !important;
        }
        .main-sidebar .nav-sidebar .nav-link:hover .nav-icon {
            transform: scale(1.25) rotate(-6deg);
            color: #a5b4fc;
        }
        .main-sidebar .nav-sidebar .nav-link.active {
            background: linear-gradient(90deg, #4f46e5, #7c3aed) !important;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4);
        }
        .main-sidebar .nav-sidebar .nav-link.active .nav-icon {
            animation: admin-float 2.5s ease-in-out infinite;
        }

        .card {
            animation: admin-fadeUp 0.5s ease both;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover {
            box-shadow: 0 10px 28px rgba(0,0,0,0.35);
        }
        .card-outline {
            border-top: 3px solid transparent !important;
            transition: border-color 0.3s ease;
        }
        .card-primary.card-outline { border-top-color: #4f46e5 !important; }
        .card-secondary.card-outline { border-top-color: #64748b !important; }
        .card-info.card-outline { border-top-color: #0ea5e9 !important; }
        .card-header {
            position: relative;
            overflow: hidden;
        }
        .card-title {
            animation: admin-fadeIn 0.6s ease both;
        }
        .card-title i {
            transition: transform 0.3s ease;
        }
        .card:hover .card-title i {
            transform: scale(1.2) rotate(-8deg);
        }

        .alert {
            animation: admin-popIn 0.5s ease both;
            border-left: 4px solid;
        }
        .alert-success {
            border-left-color: #22c55e;
            background: rgba(34,197,94,0.12) !important;
            color: #86efac !important;
        }
        .alert-danger {
            border-left-color: #ef4444;
            animation: admin-popIn 0.5s ease both, admin-shake 0.5s ease 0.4s;
            background: rgba(239,68,68,0.12) !important;
            color: #fca5a5 !important;
        }

        .btn {
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.25);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn i {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        .btn:hover i {
            transform: scale(1.2) rotate(-5deg);
        }

        .table tbody tr {
            animation: admin-fadeUp 0.4s ease both;
            transition: background 0.2s ease;
        }
        .table tbody tr:nth-child(1) { animation-delay: 0.04s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.08s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.12s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.16s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.20s; }
        .table tbody tr:nth-child(6) { animation-delay: 0.24s; }
        .table tbody tr:nth-child(7) { animation-delay: 0.28s; }
        .table tbody tr:nth-child(8) { animation-delay: 0.32s; }
        .table tbody tr:hover td {
            background: rgba(79, 70, 229, 0.10) !important;
        }

        .badge {
            transition: transform 0.2s ease;
        }
        .badge:hover {
            transform: scale(1.15);
        }

        .form-control {
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }
        .form-control:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
        }

        .small-box {
            transition: transform 0.25s ease;
        }
        .small-box:hover {
            transform: translateY(-3px);
        }
        .small-box .icon i {
            transition: transform 0.4s ease;
        }
        .small-box:hover .icon i {
            transform: scale(1.2) rotate(-8deg);
        }

        .main-footer {
            animation: admin-fadeIn 0.8s ease both;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
            background: linear-gradient(90deg, #4f46e5, #9333ea);
            border-color: #6366f1;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" target="_blank" class="nav-link">
                    <i class="fas fa-up-right-from-square mr-1"></i> View Portfolio
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-sm-inline-block mr-2" style="color:#9fb0d1; font-size:13px; margin-top:12px">
                <i class="far fa-clock mr-1"></i> <span id="admin-clock"></span>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light mt-1">
                        <i class="fas fa-right-from-bracket mr-1"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <i class="fas fa-rocket mr-2" style="color:#fff"></i>
            <span class="brand-text font-weight-light">Portfolio Admin</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gauge-high"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.home.edit') }}" class="nav-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-house-user"></i>
                            <p>Home (Hero / About)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.experiences.index') }}" class="nav-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Experience</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-diagram-project"></i>
                            <p>Projects</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>Contact Messages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('terminal.panel') }}" class="nav-link {{ request()->routeIs('terminal.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-terminal"></i>
                            <p>Terminal Panel</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>@yield('header', 'Admin')</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if(session('admin_success'))
                    <div class="alert alert-success">
                        <i class="fas fa-circle-check mr-1"></i> {{ session('admin_success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-triangle-exclamation mr-1"></i>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm">
        <strong><i class="fas fa-rocket mr-1"></i> Portfolio Admin Panel</strong>
        <span class="float-right text-muted">&copy; {{ date('Y') }}</span>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    (function () {
        const el = document.getElementById('admin-clock');
        if (!el) return;
        function tick() {
            const d = new Date();
            el.textContent = d.toLocaleTimeString();
        }
        tick();
        setInterval(tick, 1000);
    })();
</script>
@stack('scripts')
</body>
</html>
