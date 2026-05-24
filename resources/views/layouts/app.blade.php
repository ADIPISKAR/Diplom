<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PowerbankRental' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --app-blue: #1354b8;
            --app-blue-dark: #0b3477;
            --app-blue-soft: #e8f1ff;
            --app-cyan: #24a9e1;
            --app-bg: #f3f6fb;
            --app-card: #ffffff;
            --app-border: #dbe4f0;
            --app-text: #172033;
            --app-muted: #667085;
            --app-green: #159947;
            --app-yellow: #d89a13;
            --app-red: #d33b3b;
            --app-shadow: 0 16px 40px rgba(17, 39, 77, .08);
        }

        * { letter-spacing: 0; }
        body {
            min-height: 100vh;
            background: var(--app-bg);
            color: var(--app-text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }
        a { color: var(--app-blue); text-decoration: none; }
        a:hover { color: var(--app-blue-dark); }

        .app-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 288px minmax(0, 1fr);
        }
        .app-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 22px 18px;
            background: linear-gradient(180deg, #0b3477 0%, #123f8a 58%, #0e2b5e 100%);
            color: #fff;
            overflow-y: auto;
        }
        .brand-block {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 8px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .16);
        }
        .brand-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #fff;
            color: var(--app-blue);
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .16);
        }
        .brand-name { font-weight: 800; line-height: 1.1; }
        .brand-caption { color: rgba(255, 255, 255, .72); font-size: .82rem; }
        .sidebar-section-title {
            margin: 22px 8px 8px;
            color: rgba(255, 255, 255, .58);
            text-transform: uppercase;
            font-size: .72rem;
            font-weight: 700;
        }
        .sidebar-nav {
            display: grid;
            gap: 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 42px;
            padding: 10px 12px;
            border-radius: 12px;
            color: rgba(255, 255, 255, .84);
            font-weight: 600;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .13);
        }
        .sidebar-icon {
            width: 28px;
            min-width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, .13);
            font-size: .8rem;
            font-weight: 800;
        }
        .sidebar-note {
            margin-top: 22px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .84);
            font-size: .9rem;
        }
        .mobile-nav {
            display: none;
            background: #fff;
            border-bottom: 1px solid var(--app-border);
            padding: 12px 16px;
        }
        .app-content {
            min-width: 0;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 30px;
            background: rgba(255, 255, 255, .82);
            border-bottom: 1px solid var(--app-border);
            backdrop-filter: blur(16px);
        }
        .topbar-title { font-weight: 800; }
        .topbar-subtitle { color: var(--app-muted); font-size: .92rem; }
        .page-shell {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 28px 26px 44px;
        }
        .page-footer {
            margin-top: auto;
            padding: 18px 30px;
            color: var(--app-muted);
            font-size: .9rem;
            border-top: 1px solid var(--app-border);
        }

        .btn,
        .app-button {
            --bs-btn-focus-shadow-rgb: 19, 84, 184;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 700;
            line-height: 1.1;
            transition: transform .16s ease, box-shadow .16s ease, background .16s ease, border-color .16s ease;
        }
        .btn:hover,
        .app-button:hover {
            transform: translateY(-1px);
        }
        .btn-sm {
            min-height: 34px;
            padding: 7px 11px;
            border-radius: 10px;
            font-size: .84rem;
        }
        .btn-primary,
        .app-button-primary {
            background: var(--app-blue);
            border-color: var(--app-blue);
            color: #fff;
            box-shadow: 0 10px 20px rgba(19, 84, 184, .18);
        }
        .btn-primary:hover,
        .app-button-primary:hover {
            background: var(--app-blue-dark);
            border-color: var(--app-blue-dark);
            color: #fff;
        }
        .btn-outline-primary,
        .btn-outline-secondary,
        .app-button-secondary {
            background: #fff;
            border-color: #b8c9e6;
            color: var(--app-blue);
        }
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .app-button-secondary:hover {
            background: var(--app-blue-soft);
            border-color: var(--app-blue);
            color: var(--app-blue-dark);
        }
        .btn-outline-danger,
        .app-button-danger {
            background: #fff;
            border-color: #f0b8b8;
            color: var(--app-red);
        }
        .btn-outline-danger:hover,
        .app-button-danger:hover {
            background: #fff1f1;
            border-color: var(--app-red);
            color: #9b1c1c;
        }
        .btn.disabled,
        .btn:disabled {
            opacity: .55;
            transform: none;
            box-shadow: none;
        }

        .form-section,
        .app-card,
        .card {
            background: var(--app-card);
            border: 1px solid var(--app-border);
            border-radius: 18px;
            box-shadow: var(--app-shadow);
        }
        .form-section { padding: 22px; }
        .card { overflow: hidden; }
        .card-body { padding: 22px; }
        .metric {
            border-left: 0;
            position: relative;
            overflow: hidden;
        }
        .metric::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            background: linear-gradient(180deg, var(--app-blue), var(--app-cyan));
        }
        .metric-label { color: var(--app-muted); font-weight: 700; font-size: .9rem; }
        .metric-value { font-size: 2rem; font-weight: 800; line-height: 1; }
        .hero-panel {
            border-radius: 26px;
            overflow: hidden;
            background: linear-gradient(135deg, #0b3477 0%, #1354b8 56%, #24a9e1 100%);
            color: #fff;
            box-shadow: 0 24px 56px rgba(17, 39, 77, .22);
        }
        .hero-panel-inner {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 430px;
            gap: 26px;
            align-items: stretch;
            padding: 34px;
        }
        .hero-image {
            width: 100%;
            height: 100%;
            min-height: 300px;
            object-fit: cover;
            border-radius: 22px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .22);
        }
        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            color: rgba(255, 255, 255, .92);
            font-weight: 700;
            font-size: .88rem;
        }
        .feature-tile {
            padding: 20px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid var(--app-border);
            height: 100%;
        }
        .tile-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: var(--app-blue-soft);
            color: var(--app-blue);
            font-weight: 800;
            margin-bottom: 12px;
        }
        .section-title { font-weight: 800; margin-bottom: 10px; }
        .section-subtitle { color: var(--app-muted); max-width: 760px; }
        .soft-panel {
            border-radius: 22px;
            background: linear-gradient(135deg, #ffffff 0%, #eef6ff 100%);
            border: 1px solid var(--app-border);
            padding: 24px;
        }
        .content-image {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid var(--app-border);
        }
        .status-dot {
            width: .65rem;
            height: .65rem;
            border-radius: 50%;
            display: inline-block;
            margin-right: .4rem;
        }
        .status-active,
        .status-available,
        .status-completed,
        .status-paid { background: var(--app-green); }
        .status-inactive,
        .status-cancelled,
        .status-failed,
        .status-blocked,
        .status-broken,
        .status-lost,
        .status-closed { background: #667085; }
        .status-maintenance,
        .status-pending,
        .status-in_progress,
        .status-empty { background: var(--app-yellow); }
        .status-rented,
        .status-open,
        .status-problem,
        .status-overdue { background: var(--app-red); }
        .status-occupied { background: var(--app-green); }
        .badge,
        .status-badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid var(--app-border);
            background: #fff;
            color: var(--app-text);
            font-weight: 700;
        }
        .table {
            --bs-table-bg: transparent;
            --bs-table-border-color: #edf1f7;
            margin-bottom: 0;
        }
        .table thead th {
            color: var(--app-muted);
            font-size: .78rem;
            text-transform: uppercase;
            font-weight: 800;
            border-bottom-width: 1px;
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .table td {
            vertical-align: middle;
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .form-control,
        .form-select {
            min-height: 44px;
            border-radius: 12px;
            border-color: #cbd7e8;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--app-blue);
            box-shadow: 0 0 0 .22rem rgba(19, 84, 184, .14);
        }
        .alert {
            border-radius: 16px;
            border: 0;
            box-shadow: var(--app-shadow);
        }

        @media (max-width: 1080px) {
            .app-layout { grid-template-columns: 1fr; }
            .app-sidebar { display: none; }
            .mobile-nav { display: block; }
            .topbar { padding: 16px; }
            .page-shell { padding: 20px 14px 34px; }
            .hero-panel-inner { grid-template-columns: 1fr; padding: 24px; }
            .hero-image { min-height: 230px; }
        }
        @media (max-width: 640px) {
            .topbar { align-items: flex-start; flex-direction: column; }
            .hero-panel-inner { padding: 18px; }
            .form-section, .card-body, .feature-tile, .soft-panel { padding: 16px; }
            .metric-value { font-size: 1.6rem; }
            .btn { width: 100%; }
            .table-responsive { border-radius: 14px; }
        }
    </style>
</head>
<body>
@php
    $navItems = [
        ['label' => 'Главная', 'route' => 'home', 'icon' => 'ГЛ'],
    ];
    if (auth()->check()) {
        $navItems = array_merge($navItems, [
            ['label' => 'Кабинет', 'route' => 'dashboard', 'icon' => 'КБ'],
            ['label' => 'Станции', 'route' => 'stations.index', 'icon' => 'СТ'],
            ['label' => 'Текущая аренда', 'route' => 'rentals.current', 'icon' => 'АР'],
            ['label' => 'История', 'route' => 'rentals.history', 'icon' => 'ИС'],
            ['label' => 'Карты', 'route' => 'bank-cards.index', 'icon' => 'КР'],
            ['label' => 'Платежи', 'route' => 'payments.index', 'icon' => 'ПЛ'],
            ['label' => 'Обращение', 'route' => 'issues.create', 'icon' => 'ОБ'],
            ['label' => 'Уведомления', 'route' => 'notifications.index', 'icon' => 'УВ'],
        ]);
    } else {
        $navItems = array_merge($navItems, [
            ['label' => 'Вход', 'route' => 'login', 'icon' => 'ВХ'],
            ['label' => 'Регистрация', 'route' => 'register', 'icon' => 'РГ'],
        ]);
    }
    $adminItems = auth()->check() && auth()->user()->isAdmin() ? [
        ['label' => 'Панель администратора', 'route' => 'admin.dashboard', 'icon' => 'АД'],
        ['label' => 'Пользователи', 'route' => 'admin.users.index', 'icon' => 'ПЗ'],
        ['label' => 'Станции', 'route' => 'admin.stations.index', 'icon' => 'АС'],
        ['label' => 'Повербанки', 'route' => 'admin.powerbanks.index', 'icon' => 'ПБ'],
        ['label' => 'Тарифы', 'route' => 'admin.tariffs.index', 'icon' => 'ТР'],
        ['label' => 'Аренды', 'route' => 'admin.rentals.index', 'icon' => 'АА'],
        ['label' => 'Возвраты', 'route' => 'admin.returns.index', 'icon' => 'ВЗ'],
        ['label' => 'Проблемы', 'route' => 'admin.issues.index', 'icon' => 'ПР'],
        ['label' => 'Отчёты', 'route' => 'admin.reports.index', 'icon' => 'ОТ'],
        ['label' => 'Журнал', 'route' => 'admin.activity-logs.index', 'icon' => 'ЖР'],
    ] : [];
@endphp

<div class="mobile-nav">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <a class="fw-bold" href="{{ route('home') }}">PowerbankRental</a>
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Меню</button>
            <div class="dropdown-menu dropdown-menu-end">
                @foreach($navItems as $item)
                    <a class="dropdown-item" href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                @endforeach
                @foreach($adminItems as $item)
                    <a class="dropdown-item" href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="app-layout">
    <aside class="app-sidebar">
        <div class="brand-block">
            <a class="brand-mark" href="{{ route('home') }}">PB</a>
            <div>
                <div class="brand-name">PowerbankRental</div>
                <div class="brand-caption">сервис института</div>
            </div>
        </div>

        <div class="sidebar-section-title">Навигация</div>
        <nav class="sidebar-nav">
            @foreach($navItems as $item)
                <a class="sidebar-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                    <span class="sidebar-icon">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        @if($adminItems)
            <div class="sidebar-section-title">Администрирование</div>
            <nav class="sidebar-nav">
                @foreach($adminItems as $item)
                    <a class="sidebar-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                        <span class="sidebar-icon">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        @endif

        <div class="sidebar-note">
            <div class="fw-bold mb-1">Учёт без лишних действий</div>
            <div>Станции, слоты, возвраты и обращения доступны из единого личного кабинета.</div>
        </div>
    </aside>

    <div class="app-content">
        <header class="topbar">
            <div>
                <div class="topbar-title">{{ $title ?? 'PowerbankRental' }}</div>
                <div class="topbar-subtitle">Институтский сервис аренды портативных зарядных устройств</div>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                @auth
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('profile.edit') }}">{{ auth()->user()->full_name }}</a>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Выйти</button>
                    </form>
                @else
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Войти</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </header>

        <main class="page-shell">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Проверьте форму</div>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="page-footer">
            PowerbankRental · учебный веб-сервис аренды повербанков · демо-оплата без подключения банка
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
