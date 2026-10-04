<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Portfolio</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* ------------------------------------------------------------------
         * Design tokens
         * ------------------------------------------------------------------ */
        body {
            --primary: #6366f1;
            --primary-2: #8b5cf6;
            --primary-soft: rgba(99, 102, 241, 0.12);
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
            --radius: 14px;
            --radius-sm: 10px;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
        }
        body.dark-mode {
            --bg: #0b0d14;
            --surface: #12151f;
            --surface-2: #181c28;
            --surface-3: #1f2433;
            --border: rgba(255, 255, 255, 0.07);
            --border-strong: rgba(255, 255, 255, 0.12);
            --text: #e6e8ef;
            --text-strong: #ffffff;
            --muted: #8b93a7;
            --sidebar-bg: #0e1119;
            --shadow: 0 1px 2px rgba(0, 0, 0, 0.4), 0 8px 24px rgba(0, 0, 0, 0.25);
            --shadow-lg: 0 12px 40px rgba(0, 0, 0, 0.45);
            --primary-text: #a5b4fc;
            --success-text: #86efac;
            --warning-text: #fcd34d;
            --danger-text: #fca5a5;
            --info-text: #7dd3fc;
        }
        body.theme-light {
            --bg: #f5f6fa;
            --surface: #ffffff;
            --surface-2: #f8f9fc;
            --surface-3: #eef0f6;
            --border: #e7e9f0;
            --border-strong: #d6d9e3;
            --text: #1e2433;
            --text-strong: #0b1020;
            --muted: #6b7280;
            --sidebar-bg: #ffffff;
            --shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 4px 16px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 12px 40px rgba(15, 23, 42, 0.12);
            --primary-text: #4f46e5;
            --success-text: #15803d;
            --warning-text: #b45309;
            --danger-text: #b91c1c;
            --info-text: #0369a1;
        }

        /* ------------------------------------------------------------------
         * Base
         * ------------------------------------------------------------------ */
        body, .content-wrapper, .main-footer {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important;
        }
        body {
            background: var(--bg) !important;
            color: var(--text) !important;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }
        .content-wrapper {
            background: var(--bg) !important;
            color: var(--text) !important;
        }
        a { color: var(--primary-text); }
        a:hover { color: var(--primary); }
        .text-muted { color: var(--muted) !important; }
        .text-primary { color: var(--primary-text) !important; }
        .text-info { color: var(--info-text) !important; }
        .text-danger { color: var(--danger-text) !important; }
        h1, h2, h3, h4, h5, h6 { color: var(--text-strong); letter-spacing: -0.01em; }
        h5.text-primary {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }
        ::selection { background: rgba(99, 102, 241, 0.3); }
        * { scrollbar-width: thin; scrollbar-color: var(--border-strong) transparent; }

        @keyframes admin-fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .content > .container-fluid { animation: admin-fadeUp 0.35s ease both; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }

        /* ------------------------------------------------------------------
         * Top bar
         * ------------------------------------------------------------------ */
        .main-header {
            background: color-mix(in srgb, var(--bg) 82%, transparent) !important;
            backdrop-filter: saturate(160%) blur(12px);
            -webkit-backdrop-filter: saturate(160%) blur(12px);
            border-bottom: 1px solid var(--border) !important;
            min-height: 60px;
            padding: 0 16px;
        }
        .main-header .nav-link {
            color: var(--muted) !important;
            height: auto;
        }
        .main-header .nav-link:hover { color: var(--text-strong) !important; }
        .topbar-crumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
            margin-left: 4px;
        }
        .topbar-crumb strong { color: var(--text-strong); font-weight: 600; }
        .topbar-crumb .sep { opacity: 0.5; }
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            transition: color 0.15s ease, border-color 0.15s ease, background 0.15s ease;
            cursor: pointer;
            position: relative;
        }
        .icon-btn:hover {
            color: var(--text-strong);
            border-color: var(--border-strong);
            text-decoration: none;
        }
        .icon-btn:focus-visible, .btn:focus-visible, .nav-link:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
        .icon-btn .dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--danger);
            box-shadow: 0 0 0 2px var(--surface);
        }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        #theme-toggle .fa-sun { display: none; }
        body.theme-light #theme-toggle .fa-sun { display: inline-block; }
        body.theme-light #theme-toggle .fa-moon { display: none; }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 4px 4px 4px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
        }
        .user-chip:hover { border-color: var(--border-strong); }
        .user-chip .initials {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--gradient);
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .user-chip .name { font-size: 13px; font-weight: 600; padding-right: 6px; }
        .dropdown-menu {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-lg) !important;
            padding: 6px !important;
            min-width: 220px;
        }
        .dropdown-header { color: var(--muted) !important; font-size: 12px; padding: 8px 10px; }
        .dropdown-header strong { display: block; color: var(--text-strong); font-size: 13px; }
        .dropdown-item {
            color: var(--text) !important;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            background: transparent !important;
            width: 100%;
            text-align: left;
        }
        .dropdown-item:hover { background: var(--surface-3) !important; color: var(--text-strong) !important; }
        .dropdown-item.danger { color: var(--danger-text) !important; }
        .dropdown-divider { border-color: var(--border) !important; margin: 4px 0; }

        /* ------------------------------------------------------------------
         * Sidebar
         * ------------------------------------------------------------------ */
        .main-sidebar {
            background: var(--sidebar-bg) !important;
            border-right: 1px solid var(--border);
            box-shadow: none !important;
        }
        .brand-link {
            display: flex !important;
            align-items: center;
            gap: 10px;
            height: 60px;
            padding: 0 18px !important;
            border-bottom: 1px solid var(--border) !important;
            background: transparent !important;
            color: var(--text-strong) !important;
        }
        .brand-link img { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; }
        .brand-text { font-weight: 700 !important; font-size: 15px; letter-spacing: -0.01em; }
        .brand-tag {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 2px 7px;
            border-radius: 6px;
            background: var(--primary-soft);
            color: var(--primary-text);
            margin-left: 2px;
        }
        .sidebar { padding: 8px 10px 20px !important; }
        .nav-sidebar .nav-header {
            font-size: 10.5px !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--muted) !important;
            opacity: 0.75;
            padding: 18px 12px 6px !important;
            background: transparent !important;
        }
        .nav-sidebar .nav-link {
            color: var(--muted) !important;
            border-radius: 10px !important;
            padding: 9px 12px !important;
            margin-bottom: 2px;
            font-weight: 500;
            font-size: 13.5px;
            display: flex !important;
            align-items: center;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .nav-sidebar .nav-link p {
            display: flex !important;
            align-items: center;
            flex: 1;
            margin: 0;
        }
        .nav-sidebar .nav-link .nav-icon {
            font-size: 15px !important;
            width: 22px !important;
            margin-right: 10px !important;
            text-align: center;
        }
        .nav-sidebar .nav-link:hover {
            background: var(--surface-3) !important;
            color: var(--text-strong) !important;
        }
        .nav-sidebar > .nav-item > .nav-link.active {
            background: var(--primary-soft) !important;
            color: var(--primary-text) !important;
            box-shadow: inset 3px 0 0 var(--primary) !important;
        }
        .nav-sidebar .nav-treeview { padding-left: 14px; }
        .nav-sidebar .nav-treeview .nav-link { font-size: 13px; padding: 7px 12px !important; }
        .nav-sidebar .nav-treeview .nav-link .nav-icon { font-size: 6px !important; }
        .nav-sidebar .nav-treeview .nav-link.active {
            background: transparent !important;
            color: var(--text-strong) !important;
            font-weight: 600;
        }
        .nav-sidebar .nav-treeview .nav-link.active .nav-icon { color: var(--primary); }
        .nav-sidebar .nav-link > p > .right {
            position: static !important;
            margin-left: auto;
            font-size: 11px;
            transition: transform 0.2s ease;
        }
        .nav-badge {
            margin-left: auto;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 999px;
            background: var(--danger);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-card {
            margin: 18px 4px 0;
            padding: 14px;
            border-radius: 12px;
            background: var(--gradient);
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .sidebar-card::after {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
        }
        .sidebar-card strong { display: block; font-size: 13px; }
        .sidebar-card span { font-size: 12px; opacity: 0.85; }
        .sidebar-card a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff !important;
            font-size: 12px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        .sidebar-card a:hover { background: rgba(255, 255, 255, 0.28); text-decoration: none; }
        .sidebar-collapse .main-sidebar:not(:hover) .sidebar-card,
        .sidebar-collapse .main-sidebar:not(:hover) .brand-tag,
        .sidebar-collapse .main-sidebar:not(:hover) .nav-badge { display: none; }

        /* ------------------------------------------------------------------
         * Page header
         * ------------------------------------------------------------------ */
        .content-header { padding: 28px .5rem 18px !important; }
        .page-head h1 {
            font-size: 24px !important;
            font-weight: 700;
            margin: 0;
            color: var(--text-strong);
        }
        .page-head p { margin: 4px 0 0; color: var(--muted); font-size: 13.5px; }

        /* ------------------------------------------------------------------
         * Cards
         * ------------------------------------------------------------------ */
        .card {
            background: var(--surface) !important;
            color: var(--text) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow) !important;
            margin-bottom: 20px;
        }
        .card-outline { border-top: 1px solid var(--border) !important; }
        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 16px 20px !important;
            color: var(--text-strong);
        }
        .card-header::after { display: none; }
        .card-header.d-flex::after { display: none; }
        .card-title {
            font-size: 15px !important;
            font-weight: 600 !important;
            color: var(--text-strong);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .card-title > i:first-child {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-soft);
            color: var(--primary-text);
            font-size: 13px;
            margin-right: 8px !important;
        }
        .card-info .card-title > i:first-child { background: rgba(14, 165, 233, 0.12); color: var(--info-text); }
        .card-secondary .card-title > i:first-child { background: var(--surface-3); color: var(--muted); }
        .card-body { padding: 20px !important; }
        .card-body.p-0 { padding: 0 !important; }
        .card-footer {
            background: var(--surface-2) !important;
            border-top: 1px solid var(--border) !important;
            border-radius: 0 0 var(--radius) var(--radius) !important;
            padding: 14px 20px !important;
        }
        /* Nested cards (e.g. Home editor sections) */
        .card .card {
            background: var(--surface-2) !important;
            box-shadow: none !important;
        }

        /* ------------------------------------------------------------------
         * Buttons
         * ------------------------------------------------------------------ */
        .btn {
            border-radius: 10px !important;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 16px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, filter 0.15s ease;
            border-width: 1px;
        }
        .btn-sm { padding: 6px 12px; font-size: 12.5px; }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-primary {
            background: var(--gradient) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .btn-primary:hover { filter: brightness(1.08); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45); }
        .btn-secondary, .btn-default, .btn-outline-light, .btn-outline-secondary {
            background: var(--surface) !important;
            border: 1px solid var(--border-strong) !important;
            color: var(--text) !important;
        }
        .btn-secondary:hover, .btn-default:hover, .btn-outline-light:hover, .btn-outline-secondary:hover {
            background: var(--surface-3) !important;
            color: var(--text-strong) !important;
        }
        .btn-success { background: var(--success) !important; border-color: var(--success) !important; color: #fff !important; }
        .btn-danger { background: var(--danger) !important; border-color: var(--danger) !important; color: #fff !important; }
        .btn-info { background: var(--info) !important; border-color: var(--info) !important; color: #fff !important; }
        .btn-warning { background: var(--warning) !important; border-color: var(--warning) !important; color: #1f1300 !important; }
        .btn-outline-info {
            color: var(--info-text) !important;
            border-color: rgba(14, 165, 233, 0.4) !important;
            background: transparent !important;
        }
        .btn-outline-info:hover { background: rgba(14, 165, 233, 0.1) !important; }

        /* ------------------------------------------------------------------
         * Forms
         * ------------------------------------------------------------------ */
        label, .form-group label {
            font-weight: 600 !important;
            font-size: 13px;
            color: var(--text) !important;
            margin-bottom: 6px;
        }
        label > i { color: var(--muted); }
        .form-control, .custom-select {
            background: var(--surface-2) !important;
            color: var(--text-strong) !important;
            border: 1px solid var(--border-strong) !important;
            border-radius: var(--radius-sm) !important;
            min-height: 40px;
            font-size: 14px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        textarea.form-control { min-height: 96px; line-height: 1.55; }
        .form-control::placeholder { color: var(--muted); opacity: 0.7; }
        .form-control:focus, .custom-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
            background: var(--surface) !important;
        }
        .form-control-file {
            padding: 10px;
            border: 1px dashed var(--border-strong);
            border-radius: var(--radius-sm);
            background: var(--surface-2);
            width: 100%;
            color: var(--muted);
        }
        .form-text { color: var(--muted) !important; font-size: 12px; }
        .custom-control-label::before {
            background: var(--surface-3) !important;
            border-color: var(--border-strong) !important;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background: var(--gradient) !important;
            border-color: var(--primary) !important;
        }
        .custom-control-input:focus ~ .custom-control-label::before {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
        }
        .custom-control-label { font-weight: 500 !important; }

        /* ------------------------------------------------------------------
         * Alerts
         * ------------------------------------------------------------------ */
        .alert {
            border-radius: 12px !important;
            border: 1px solid !important;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            animation: admin-fadeUp 0.3s ease both;
        }
        .alert > i { margin-top: 2px; }
        .alert-success { background: rgba(34, 197, 94, 0.1) !important; color: var(--success-text) !important; border-color: rgba(34, 197, 94, 0.3) !important; }
        .alert-danger { background: rgba(239, 68, 68, 0.1) !important; color: var(--danger-text) !important; border-color: rgba(239, 68, 68, 0.3) !important; }
        .alert-warning { background: rgba(245, 158, 11, 0.1) !important; color: var(--warning-text) !important; border-color: rgba(245, 158, 11, 0.3) !important; }
        .alert-info { background: rgba(14, 165, 233, 0.1) !important; color: var(--info-text) !important; border-color: rgba(14, 165, 233, 0.3) !important; }
        .alert .close { color: inherit; opacity: 0.6; margin-left: auto; text-shadow: none; padding: 0 0 0 10px; }

        /* ------------------------------------------------------------------
         * Badges & pills
         * ------------------------------------------------------------------ */
        .badge {
            border-radius: 999px;
            padding: 4px 9px;
            font-weight: 600;
            font-size: 11px;
        }
        .badge-info { background: var(--primary-soft) !important; color: var(--primary-text) !important; }
        .badge-success { background: rgba(34, 197, 94, 0.14) !important; color: var(--success-text) !important; }
        .badge-danger { background: rgba(239, 68, 68, 0.14) !important; color: var(--danger-text) !important; }
        .badge-warning { background: rgba(245, 158, 11, 0.14) !important; color: var(--warning-text) !important; }
        .badge-secondary { background: var(--surface-3) !important; color: var(--muted) !important; }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 600;
            margin: 2px 4px 2px 0;
            border: 1px solid transparent;
            white-space: nowrap;
        }
        .pill i { font-size: 10px; }
        .pill-role { background: var(--primary-soft); color: var(--primary-text); border-color: rgba(99, 102, 241, 0.25); }
        .pill-perm { background: rgba(14, 165, 233, 0.1); color: var(--info-text); border-color: rgba(14, 165, 233, 0.25); }
        .pill-muted { background: var(--surface-3); color: var(--muted); border-color: var(--border); }
        .pill-success { background: rgba(34, 197, 94, 0.1); color: var(--success-text); border-color: rgba(34, 197, 94, 0.25); }
        .pill-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning-text); border-color: rgba(245, 158, 11, 0.25); }
        .pill-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger-text); border-color: rgba(239, 68, 68, 0.25); }

        /* ------------------------------------------------------------------
         * Tables
         * ------------------------------------------------------------------ */
        .card-body.p-0 { overflow-x: auto; }
        .admin-table, .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
            color: var(--text) !important;
            background: transparent !important;
        }
        .admin-table thead th, .table thead th {
            background: var(--surface-2) !important;
            color: var(--muted) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.06em;
            padding: 12px 16px !important;
            border: none !important;
            border-bottom: 1px solid var(--border) !important;
            white-space: nowrap;
        }
        .admin-table thead th i, .table thead th i { display: none; }
        .admin-table tbody td, .table tbody td {
            padding: 14px 16px !important;
            border: none !important;
            border-bottom: 1px solid var(--border) !important;
            vertical-align: middle !important;
            background: transparent !important;
            color: var(--text) !important;
        }
        .admin-table tbody tr, .table tbody tr { transition: background 0.15s ease; }
        .admin-table tbody td:last-child { white-space: nowrap; }
        .admin-table tbody tr:hover td, .table tbody tr:hover td { background: var(--surface-2) !important; }
        .admin-table tbody tr:last-child td, .table tbody tr:last-child td { border-bottom: none !important; }

        .row-index {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 28px;
            padding: 0 6px;
            border-radius: 8px;
            background: var(--surface-3);
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        .avatar-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--gradient);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .user-cell { display: flex; align-items: center; }
        .user-meta { line-height: 1.3; min-width: 0; }
        .user-meta .user-name { font-weight: 600; color: var(--text-strong); }
        .user-meta .user-sub { font-size: 12px; color: var(--muted); }

        .order-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 26px;
            padding: 0 8px;
            border-radius: 7px;
            background: var(--surface-3);
            color: var(--text);
            font-weight: 600;
            font-size: 12px;
            font-variant-numeric: tabular-nums;
        }

        .action-group { display: inline-flex; gap: 6px; }
        .action-group form { margin: 0; }
        .action-group .btn {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            border-radius: 8px !important;
            padding: 6px 11px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: none !important;
        }
        .action-group .btn-edit {
            background: var(--primary-soft) !important;
            color: var(--primary-text) !important;
            border: 1px solid rgba(99, 102, 241, 0.25) !important;
        }
        .action-group .btn-edit:hover { background: var(--primary) !important; color: #fff !important; }
        .action-group .btn-delete {
            background: rgba(239, 68, 68, 0.1) !important;
            color: var(--danger-text) !important;
            border: 1px solid rgba(239, 68, 68, 0.25) !important;
        }
        .action-group .btn-delete:hover { background: var(--danger) !important; color: #fff !important; }
        .action-group .btn-view {
            background: rgba(34, 197, 94, 0.1) !important;
            color: var(--success-text) !important;
            border: 1px solid rgba(34, 197, 94, 0.25) !important;
        }
        .action-group .btn-view:hover { background: var(--success) !important; color: #fff !important; }
        .action-group .btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

        .empty-state {
            padding: 56px 20px !important;
            text-align: center;
            color: var(--muted) !important;
        }
        .empty-state i {
            font-size: 22px;
            width: 56px;
            height: 56px;
            line-height: 56px;
            border-radius: 16px;
            background: var(--surface-3);
            color: var(--muted);
            margin: 0 auto 12px;
            display: block;
        }

        /* ------------------------------------------------------------------
         * Footer
         * ------------------------------------------------------------------ */
        .main-footer {
            background: var(--bg) !important;
            background-color: var(--bg) !important;
            border-top: 1px solid var(--border) !important;
            color: var(--muted) !important;
            font-size: 12.5px;
            padding: 14px 24px;
        }
        .main-footer a { color: var(--muted); }

        @media (max-width: 767.98px) {
            .content-header { padding: 20px .5rem 12px !important; }
            .page-head h1 { font-size: 20px !important; }
            .user-chip .name { display: none; }
            .card-header { padding: 14px 16px !important; }
            .card-body { padding: 16px !important; }
        }
    </style>
    @stack('styles')
</head>
@php
    $adminTheme = request()->cookie('admin_theme') === 'light' ? 'light' : 'dark';
    $adminUser = auth()->user();
    $adminInitials = collect(preg_split('/\s+/', trim($adminUser?->name ?: 'A')))->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
    $userMgmtOpen = request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*');
@endphp
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed {{ $adminTheme === 'light' ? 'theme-light' : 'dark-mode' }}">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-md-flex">
                <div class="topbar-crumb">
                    <span>Admin</span><span class="sep">/</span><strong>@yield('header', 'Admin')</strong>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto topbar-actions">
            <li class="nav-item d-none d-sm-block">
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="icon-btn" title="View portfolio" aria-label="View portfolio">
                    <i class="fas fa-arrow-up-right-from-square"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.contacts.index') }}" class="icon-btn" title="Messages" aria-label="Messages{{ $unreadContacts ? ' ('.$unreadContacts.' unread)' : '' }}">
                    <i class="far fa-bell"></i>
                    @if($unreadContacts)<span class="dot"></span>@endif
                </a>
            </li>
            <li class="nav-item">
                <button type="button" id="theme-toggle" class="icon-btn" title="Toggle theme" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </button>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="user-chip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="initials">{{ $adminInitials }}</span>
                    <span class="name">{{ $adminUser?->name }}</span>
                    <i class="fas fa-chevron-down text-muted" style="font-size:10px; padding-right:6px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">
                        <strong>{{ $adminUser?->name }}</strong>
                        {{ $adminUser?->email }}
                    </div>
                    <div class="dropdown-divider"></div>
                    @if($adminUser)
                        <a href="{{ route('admin.users.edit', $adminUser) }}" class="dropdown-item"><i class="far fa-user mr-2"></i> My account</a>
                    @endif
                    <a href="{{ route('admin.home.edit') }}" class="dropdown-item"><i class="fas fa-sliders mr-2"></i> Site content</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger"><i class="fas fa-right-from-bracket mr-2"></i> Log out</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <aside id="admin-sidebar" class="main-sidebar {{ $adminTheme === 'light' ? 'sidebar-light-primary' : 'sidebar-dark-primary' }}">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('favicon.svg') }}?v=2" alt="">
            <span class="brand-text">Portfolio</span>
            <span class="brand-tag">Admin</span>
        </a>
        <div class="sidebar">
            <nav aria-label="Admin navigation">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">Overview</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gauge-high"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">Content</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.home.edit') }}" class="nav-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-house-user"></i>
                            <p>Home Section</p>
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
                        <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Blog Articles</p>
                        </a>
                    </li>

                    <li class="nav-header">Inbox</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>
                                Messages
                                @if($unreadContacts)<span class="nav-badge">{{ $unreadContacts }}</span>@endif
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">Access</li>
                    <li class="nav-item has-treeview {{ $userMgmtOpen ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $userMgmtOpen ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-gear"></i>
                            <p>
                                User Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- The terminal route only exists in local + debug, so guard it to keep production rendering. --}}
                    @if(Route::has('terminal.panel'))
                        <li class="nav-header">Developer</li>
                        <li class="nav-item">
                            <a href="{{ route('terminal.panel') }}" class="nav-link {{ request()->routeIs('terminal.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-terminal"></i>
                                <p>Terminal</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <div class="sidebar-card">
                <strong>Your site is live ✨</strong>
                <span>See your changes as visitors do.</span>
                <br>
                <a href="{{ url('/') }}" target="_blank" rel="noopener">Open portfolio <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="page-head d-flex flex-wrap justify-content-between align-items-end" style="gap:12px">
                    <div>
                        <h1>@yield('header', 'Admin')</h1>
                        @hasSection('subtitle')
                            <p>@yield('subtitle')</p>
                        @endif
                    </div>
                    @yield('header-actions')
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if(session('admin_success'))
                    <div class="alert alert-success" role="status" data-autohide>
                        <i class="fas fa-circle-check"></i>
                        <div>{{ session('admin_success') }}</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-triangle-exclamation"></i>
                        <div>
                            <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-1 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer d-flex justify-content-between">
        <span>&copy; {{ date('Y') }} Portfolio Admin</span>
        <span id="admin-clock" class="d-none d-sm-inline"></span>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    (function () {
        const el = document.getElementById('admin-clock');
        if (!el) return;
        const fmt = { weekday: 'short', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        function tick() { el.textContent = new Date().toLocaleString(undefined, fmt); }
        tick();
        setInterval(tick, 30000);
    })();

    (function () {
        document.querySelectorAll('[data-autohide]').forEach(function (el) {
            setTimeout(function () { $(el).fadeOut(300); }, 5000);
        });
    })();

    (function () {
        const body = document.body;
        const sidebar = document.getElementById('admin-sidebar');
        const btn = document.getElementById('theme-toggle');
        if (!btn) return;

        btn.addEventListener('click', function () {
            const goLight = !body.classList.contains('theme-light');
            if (goLight) {
                body.classList.remove('dark-mode');
                body.classList.add('theme-light');
                sidebar && sidebar.classList.replace('sidebar-dark-primary', 'sidebar-light-primary');
            } else {
                body.classList.add('dark-mode');
                body.classList.remove('theme-light');
                sidebar && sidebar.classList.replace('sidebar-light-primary', 'sidebar-dark-primary');
            }
            document.cookie = 'admin_theme=' + (goLight ? 'light' : 'dark') + '; path=/; max-age=31536000; SameSite=Lax';
        });
    })();
</script>
@stack('scripts')
</body>
</html>
