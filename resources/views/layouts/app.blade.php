<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PowerbankRental' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --pb-ink: #1f2937;
            --pb-accent: #0f766e;
            --pb-warm: #f59e0b;
            --pb-soft: #f8fafc;
        }
        body { background: var(--pb-soft); color: var(--pb-ink); }
        .navbar { box-shadow: 0 1px 12px rgba(15, 23, 42, .08); }
        .page-shell { max-width: 1180px; margin: 0 auto; padding: 28px 16px 48px; }
        .metric { border-left: 4px solid var(--pb-accent); }
        .status-dot { width: .7rem; height: .7rem; border-radius: 50%; display: inline-block; margin-right: .35rem; }
        .status-active, .status-available, .status-completed, .status-paid { background: #16a34a; }
        .status-inactive, .status-cancelled, .status-failed { background: #64748b; }
        .status-maintenance, .status-pending, .status-in_progress { background: var(--pb-warm); }
        .status-rented, .status-open, .status-problem, .status-overdue { background: #dc2626; }
        .status-empty { background: #0ea5e9; }
        .status-occupied { background: #16a34a; }
        .status-blocked, .status-broken, .status-lost, .status-closed { background: #64748b; }
        .btn-icon { width: 2.35rem; min-width: 2.35rem; padding-left: 0; padding-right: 0; }
        .table td, .table th { vertical-align: middle; }
        .form-section { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 18px; }
        .nav-link.active { font-weight: 600; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container-fluid page-shell py-0">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">PowerbankRental</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Открыть меню">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Кабинет</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('stations.index') }}">Станции</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('rentals.current') }}">Текущая аренда</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('rentals.history') }}">История</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('bank-cards.index') }}">Карты</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('notifications.index') }}">Уведомления</a></li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Админ</a></li>
                    @endif
                @endauth
            </ul>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('profile.edit') }}">{{ auth()->user()->full_name }}</a>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Выйти</button>
                    </form>
                @else
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Войти</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
