<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Medical Record System') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --bg: #F3F4F6;
            --bg-accent: linear-gradient(160deg, #F3F4F6 0%, #ECFDF5 45%, #F3F4F6 100%);
            --surface: #FFFFFF;
            --surface-strong: #DCFCE7;
            --surface-muted: #F0FDF4;
            --text: #134E4A;
            --text-strong: #166534;
            --primary: #16A34A;
            --primary-dark: #166534;
            --primary-glow: rgba(22, 163, 74, 0.18);
            --border: #D1FAE5;
            --border-subtle: #E5E7EB;
            --muted: #64748B;
            --danger: #DC2626;
            --danger-soft: #FEE2E2;
            --warning: #D97706;
            --warning-soft: #FEF3C7;
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 2px rgba(22, 101, 52, 0.06);
            --shadow-md: 0 8px 24px rgba(22, 101, 52, 0.08);
            --shadow-lg: 0 20px 50px rgba(22, 101, 52, 0.1);
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--bg);
            background-image: var(--bg-accent);
            color: var(--text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }

        .page { display: flex; flex-direction: column; min-height: 100vh; }
        .page-inner { flex: 1; padding: 20px 24px 32px; max-width: 1440px; margin: 0 auto; width: 100%; }

        .topbar {
            display: flex; flex-wrap: wrap; justify-content: space-between; gap: 16px;
            align-items: center; padding: 14px 20px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }
        .brand {
            display: inline-flex; align-items: center; gap: 12px;
            font-size: 1.15rem; font-weight: 800; color: var(--primary-dark);
        }
        .brand-mark {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: inline-grid; place-items: center; color: white;
            font-size: 1rem; font-weight: 800;
            box-shadow: 0 4px 12px var(--primary-glow);
        }
        .topbar-actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .nav-user {
            font-size: 0.875rem; font-weight: 600; color: var(--muted);
            padding: 8px 14px; background: var(--surface-muted); border-radius: var(--radius-md);
        }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 18px; border-radius: var(--radius-md);
            font-weight: 700; font-size: 0.875rem; border: 1px solid transparent;
            cursor: pointer; transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
            font-family: inherit;
        }
        .btn:active { transform: scale(0.98); }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 14px var(--primary-glow); }
        .btn-primary:hover { background: #15803D; box-shadow: 0 6px 20px var(--primary-glow); }
        .btn-secondary { background: var(--surface); color: var(--primary-dark); border-color: var(--border); }
        .btn-secondary:hover { background: var(--surface-muted); }
        .btn-ghost { background: transparent; color: var(--primary-dark); border-color: var(--border); }
        .btn-ghost:hover { background: var(--surface-strong); }
        .btn-danger { background: var(--danger-soft); color: #991B1B; border-color: #FECACA; }
        .btn-danger:hover { background: #FECACA; }
        .btn-sm { padding: 8px 14px; font-size: 0.8125rem; }
        .btn-icon { width: 40px; height: 40px; padding: 0; }
        a.button, button.button, .button {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 20px; border-radius: var(--radius-md);
            font-weight: 700; font-size: 0.875rem; border: none; cursor: pointer;
            background: var(--primary); color: white; text-decoration: none;
            box-shadow: 0 4px 14px var(--primary-glow);
            transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
            font-family: inherit;
        }
        .button:hover { background: #15803D; transform: translateY(-1px); }
        .button.secondary { background: var(--primary-dark); box-shadow: 0 4px 14px rgba(22, 101, 52, 0.15); }

        .layout { display: grid; grid-template-columns: 280px minmax(0, 1fr); gap: 24px; align-items: start; }
        .sidebar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 20px;
            display: flex; flex-direction: column; gap: 20px;
            position: sticky; top: 20px;
            box-shadow: var(--shadow-md);
        }
        .sidebar-label {
            margin: 0; font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted);
        }
        .profile-card {
            background: linear-gradient(135deg, #ECFDF5 0%, #DCFCE7 100%);
            border-radius: var(--radius-lg); padding: 18px;
            border: 1px solid var(--border);
        }
        .profile-card h3 { margin: 0 0 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); }
        .profile-card p { margin: 0; font-size: 1.05rem; font-weight: 800; color: var(--primary-dark); }
        .sidebar nav { display: flex; flex-direction: column; gap: 4px; }
        .sidebar nav a {
            display: block;
            padding: 12px 14px; border-radius: var(--radius-md);
            color: var(--text); font-weight: 600; font-size: 0.9375rem;
            transition: background var(--transition), color var(--transition);
        }
        .sidebar nav a:hover { background: var(--surface-muted); color: var(--primary-dark); }
        .sidebar nav a.active {
            background: var(--surface-strong); color: var(--primary-dark);
            font-weight: 700;
        }
        .role-badge {
            display: inline-block; margin-top: 8px;
            padding: 4px 10px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700;
            background: var(--surface-strong); color: var(--primary-dark);
        }
        .sidebar-shortcuts { display: flex; flex-direction: column; gap: 8px; margin-top: auto; padding-top: 8px; border-top: 1px solid var(--border-subtle); }
        .sidebar-shortcuts a {
            display: block; padding: 12px 16px; border-radius: var(--radius-md);
            background: var(--primary); color: white; text-align: center;
            font-weight: 700; font-size: 0.875rem;
            box-shadow: 0 4px 14px var(--primary-glow);
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .sidebar-shortcuts a:hover { transform: translateY(-1px); box-shadow: 0 6px 20px var(--primary-glow); }
        .sidebar-shortcuts a.outline {
            background: var(--surface); color: var(--primary-dark);
            border: 1px solid var(--border); box-shadow: none;
        }
        .sidebar-shortcuts a.outline:hover { background: var(--surface-muted); }

        .content { display: flex; flex-direction: column; gap: 20px; min-width: 0; }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 24px 28px;
            box-shadow: var(--shadow-md);
        }
        .card-flat { box-shadow: var(--shadow-sm); }
        .card h1, .card h2 { margin: 0 0 4px; color: var(--primary-dark); font-weight: 800; }
        .card h1 { font-size: 1.5rem; }
        .card h2 { font-size: 1.25rem; }

        .page-header { display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between; align-items: flex-start; }
        .page-header .subtitle { margin: 6px 0 0; color: var(--muted); font-size: 0.9375rem; font-weight: 500; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between; align-items: center; }
        .toolbar-actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }

        .grid { display: grid; gap: 20px; }
        .summary-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
        .stat-card {
            padding: 22px 24px; position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--primary); border-radius: 4px 0 0 4px;
        }
        .stat-card h2 {
            margin: 0; font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted);
        }
        .stat-card .value { font-size: 2rem; font-weight: 800; color: var(--primary-dark); line-height: 1.2; margin-top: 4px; }
        .stat-card .hint { font-size: 0.8125rem; color: var(--muted); margin-top: 4px; }

        .flash {
            display: flex; align-items: flex-start; gap: 12px;
            border-left: 4px solid var(--primary);
            background: #DCFCE7; color: var(--primary-dark);
            padding: 16px 20px; border-radius: var(--radius-md);
            font-weight: 600; font-size: 0.9375rem;
            animation: slideIn 0.35s ease;
        }
        .flash.error { border-color: var(--danger); background: var(--danger-soft); color: #991B1B; }
        .flash ul { margin: 8px 0 0; padding-left: 20px; font-weight: 500; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        .table-wrap { overflow-x: auto; margin-top: 8px; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle); }
        table { width: 100%; border-collapse: collapse; font-size: 0.9375rem; }
        thead { background: linear-gradient(180deg, #ECFDF5 0%, #DCFCE7 100%); }
        th {
            padding: 14px 16px; text-align: left; font-weight: 700;
            color: var(--primary-dark); font-size: 0.8125rem;
            text-transform: uppercase; letter-spacing: 0.04em;
            border-bottom: 1px solid var(--border);
        }
        td { padding: 14px 16px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
        tbody tr { transition: background var(--transition); }
        tbody tr:hover { background: #F8FAFC; }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex; align-items: center; padding: 4px 12px;
            border-radius: 999px; font-size: 0.75rem; font-weight: 700;
        }
        .badge.success { background: #DCFCE7; color: var(--primary-dark); }
        .badge.warning { background: var(--warning-soft); color: #92400E; }
        .badge.danger { background: var(--danger-soft); color: #991B1B; }

        .actions { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        .actions a { color: var(--primary); font-weight: 700; font-size: 0.875rem; padding: 4px 8px; border-radius: 8px; transition: background var(--transition); }
        .actions a:hover { background: var(--surface-strong); }
        .actions form { display: inline; }
        .actions button.link-danger {
            border: none; background: transparent; color: var(--danger);
            cursor: pointer; font-weight: 700; font-size: 0.875rem; padding: 4px 8px;
            font-family: inherit; border-radius: 8px;
        }
        .actions button.link-danger:hover { background: var(--danger-soft); }

        .search-bar {
            display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;
            padding: 18px; background: var(--surface-muted);
            border-radius: var(--radius-lg); border: 1px solid var(--border);
            margin: 20px 0 8px;
        }
        .search-bar .field { flex: 1; min-width: 200px; }
        .search-bar label { margin-top: 0; font-size: 0.8125rem; }
        .search-bar input, .search-bar select { margin-top: 6px; }

        .form-grid { display: grid; gap: 0 20px; grid-template-columns: repeat(2, 1fr); }
        .form-grid .full { grid-column: 1 / -1; }
        @media (max-width: 720px) { .form-grid { grid-template-columns: 1fr; } }

        label { display: block; margin-top: 18px; font-weight: 700; font-size: 0.875rem; color: var(--primary-dark); }
        label:first-child { margin-top: 0; }
        .field-group label { margin-top: 0; }
        input, select, textarea {
            width: 100%; padding: 12px 16px;
            border: 1px solid #CBD5E1; border-radius: var(--radius-md);
            margin-top: 8px; background: white; color: var(--text);
            font-family: inherit; font-size: 0.9375rem;
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.12);
        }
        textarea { min-height: 100px; resize: vertical; }
        .form-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-subtle); }

        .detail-grid {
            display: grid; gap: 0;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            margin-top: 20px;
        }
        .detail-item {
            padding: 16px 20px; border-bottom: 1px solid #F1F5F9;
            border-right: 1px solid #F1F5F9;
        }
        .detail-item dt { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); margin: 0 0 6px; }
        .detail-item dd { margin: 0; font-weight: 600; color: var(--text); font-size: 1rem; }

        .empty-state {
            text-align: center; padding: 48px 24px; color: var(--muted);
        }
        .empty-state p { margin: 0 0 16px; font-weight: 600; }

        .activity-list { list-style: none; margin: 0; padding: 0; }
        .activity-list li {
            display: flex; gap: 14px; padding: 14px 0;
            border-bottom: 1px solid #F1F5F9; align-items: flex-start;
        }
        .activity-list li:last-child { border-bottom: none; }
        .activity-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--primary); margin-top: 6px; flex-shrink: 0;
            box-shadow: 0 0 0 4px var(--primary-glow);
        }
        .activity-list strong { display: block; color: var(--primary-dark); font-size: 0.9375rem; }
        .activity-list span { font-size: 0.8125rem; color: var(--muted); }
        .activity-list time { font-size: 0.75rem; color: var(--muted); margin-left: auto; white-space: nowrap; }

        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }
        .quick-action {
            display: flex; flex-direction: column; align-items: center; gap: 10px;
            padding: 20px 16px; border-radius: var(--radius-lg);
            border: 1px solid var(--border); background: var(--surface-muted);
            font-weight: 700; color: var(--primary-dark); text-align: center;
            transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        }
        .quick-action:hover {
            transform: translateY(-2px); border-color: var(--primary);
            box-shadow: var(--shadow-md); background: white;
        }
        .pagination { margin-top: 20px; display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .pagination nav { display: flex; flex-wrap: wrap; gap: 6px; }
        .pagination a, .pagination span {
            padding: 8px 14px; border-radius: var(--radius-sm);
            font-weight: 600; font-size: 0.875rem; border: 1px solid var(--border-subtle);
        }
        .pagination a:hover { background: var(--surface-strong); border-color: var(--primary); }
        .pagination span[aria-current="page"] { background: var(--primary); color: white; border-color: var(--primary); }

        .auth-shell { min-height: calc(100vh - 120px); display: grid; place-items: center; padding: 16px 0; }
        .auth-panel {
            width: 100%; max-width: 960px;
            display: grid; grid-template-columns: 1fr 1fr;
            background: var(--surface); border-radius: var(--radius-xl);
            overflow: hidden; box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
        }
        .auth-hero {
            padding: 48px 40px;
            background: linear-gradient(145deg, var(--primary-dark) 0%, var(--primary) 55%, #22C55E 100%);
            color: white; display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow: hidden;
        }
        .auth-hero::before, .auth-hero::after {
            content: ''; position: absolute; border-radius: 50%; background: rgba(255,255,255,0.08);
        }
        .auth-hero::before { width: 280px; height: 280px; top: -80px; left: -80px; }
        .auth-hero::after { width: 360px; height: 360px; bottom: -120px; right: -100px; }
        .auth-hero > * { position: relative; z-index: 1; }
        .auth-hero h1 { margin: 0 0 16px; font-size: 2rem; font-weight: 800; line-height: 1.2; }
        .auth-hero p { margin: 0; opacity: 0.92; font-size: 1rem; line-height: 1.6; max-width: 320px; }
        .auth-features { margin-top: 32px; display: flex; flex-direction: column; gap: 14px; }
        .auth-feature { display: flex; align-items: center; gap: 12px; font-weight: 600; font-size: 0.9375rem; }
        .auth-feature span {
            width: 28px; height: 28px; border-radius: 50%;
            background: white; color: var(--primary-dark);
            display: grid; place-items: center; font-size: 0.75rem; font-weight: 800;
        }
        .auth-form-wrap { padding: 40px 44px; display: flex; flex-direction: column; justify-content: center; }
        .auth-form-wrap .auth-logo {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; display: grid; place-items: center;
            font-size: 1.5rem; font-weight: 800; margin: 0 auto 16px;
            box-shadow: 0 8px 24px var(--primary-glow);
        }
        .auth-form-wrap h2 { text-align: center; margin: 0; font-size: 1.75rem; color: var(--primary-dark); }
        .auth-form-wrap .auth-sub { text-align: center; color: var(--muted); margin: 8px 0 28px; font-size: 0.9375rem; }
        .auth-form-wrap form label { margin-top: 16px; }
        .auth-form-wrap form label:first-of-type { margin-top: 0; }
        .auth-form-wrap .btn { width: 100%; margin-top: 24px; padding: 14px; font-size: 1rem; }
        .auth-footer { text-align: center; margin-top: 24px; color: var(--muted); font-size: 0.9375rem; }
        .auth-footer a { color: var(--primary); font-weight: 700; }
        .auth-footer a:hover { text-decoration: underline; }
        .auth-card-single { max-width: 440px; width: 100%; margin: 0 auto; }

        .mobile-nav-toggle { display: none; }
        @media (max-width: 960px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; }
            .mobile-nav-toggle { display: inline-flex; }
            .sidebar.collapsed { display: none; }
            .auth-panel { grid-template-columns: 1fr; }
            .auth-hero { display: none; }
        }
        @media (max-width: 640px) {
            .page-inner { padding: 16px; }
            .card { padding: 20px; }
            .auth-form-wrap { padding: 28px 24px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="page">
        <div class="page-inner">
            <header class="topbar">
                <a href="{{ url('/') }}" class="brand">
                    <span class="brand-mark">M</span>
                    {{ config('app.name', 'Medical Record System') }}
                </a>
                <div class="topbar-actions">
                    @if(session()->has('user_id'))
                        <button type="button" class="btn btn-ghost btn-sm mobile-nav-toggle" aria-label="Toggle menu" onclick="document.querySelector('.sidebar')?.classList.toggle('collapsed')">Menu</button>
                        <span class="nav-user">{{ session('user_name') }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endif
                </div>
            </header>

            @if(session('success'))
                <div class="flash" role="status">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="flash error" role="alert">
                    <div>
                        <strong>Please fix the following:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if(session()->has('user_id') && !View::hasSection('auth_only'))
                <div class="layout">
                    <aside class="sidebar">
                        <div class="profile-card">
                            <h3>Signed in as</h3>
                            <p>{{ session('user_name') }}</p>
                            <span class="role-badge">{{ session('user_role') === 'nurse' ? 'Clinic Nurse' : 'Student' }}</span>
                        </div>
                        <div>
                            <p class="sidebar-label">Navigation</p>
                            <nav>
                                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
                                @if(session('user_role') === 'nurse')
                                    <a href="{{ route('students.index') }}" class="{{ request()->is('students*') ? 'active' : '' }}">Students</a>
                                    <a href="{{ route('medical-records.index') }}" class="{{ request()->is('medical-records*') ? 'active' : '' }}">Medical Records</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">My Profile</a>
                            </nav>
                        </div>
                        @if(session('user_role') === 'nurse')
                            <div class="sidebar-shortcuts">
                                <a href="{{ route('students.create') }}">Add Student</a>
                                <a href="{{ route('medical-records.create') }}" class="outline">Add Record</a>
                            </div>
                        @endif
                    </aside>
                    <main class="content">
                        @yield('content')
                    </main>
                </div>
            @else
                <main class="content">
                    @yield('content')
                </main>
            @endif
        </div>
    </div>
</body>
</html>
