<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Аренда повербанков</title>
    <style>
        :root {
            color-scheme: light;
            --page: #edf4ff;
            --surface: #ffffff;
            --surface-soft: #f7fbff;
            --line: #cfddf0;
            --text: #172033;
            --muted: #64748b;
            --accent: #2563eb;
            --accent-dark: #1d4ed8;
            --accent-soft: #dbeafe;
            --navy: #0f172a;
            --cyan: #14b8a6;
            --warning: #d97706;
            --danger: #b42318;
            --shadow: 0 18px 42px rgba(37, 99, 235, .14);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, Arial, sans-serif;
            background:
                linear-gradient(180deg, #dbeafe 0, var(--page) 290px),
                var(--page);
            color: var(--text);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
            padding: 18px 28px;
            background: linear-gradient(135deg, var(--navy) 0%, #1e3a8a 48%, #2563eb 100%);
            color: #fff;
            box-shadow: 0 10px 34px rgba(30, 58, 138, .24);
        }

        .topbar h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 0;
        }

        .topbar p {
            margin: 4px 0 0;
            color: #cbd5df;
            font-size: 14px;
        }

        .topbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .user-chip {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 8px;
            color: #dbeafe;
            font-weight: 800;
        }

        .shell {
            max-width: 1480px;
            margin: 0 auto;
            padding: 24px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            min-height: 116px;
            padding: 18px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(247, 251, 255, .98)),
                var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 12px 26px rgba(37, 99, 235, .08);
        }

        .stat span {
            display: block;
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat b {
            font-size: 34px;
            line-height: 1;
        }

        .stat mark {
            min-width: 42px;
            height: 42px;
            display: inline-grid;
            place-items: center;
            border-radius: 8px;
            background: var(--accent-soft);
            color: var(--accent);
            font-weight: 800;
        }

        .notice {
            border-radius: 8px;
            margin-bottom: 16px;
            padding: 12px 14px;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .errors {
            background: #fef3f2;
            color: #912018;
            border-color: #fecdca;
        }

        .toast-stack {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 80;
            display: grid;
            gap: 10px;
            width: min(360px, calc(100vw - 28px));
        }

        .toast {
            padding: 13px 14px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1e3a8a;
            border: 1px solid #bfdbfe;
            box-shadow: var(--shadow);
            font-weight: 800;
            animation: toast-in .18s ease-out;
        }

        .toast.error {
            background: #fef3f2;
            border-color: #fecdca;
            color: #912018;
        }

        @keyframes toast-in {
            from { transform: translateY(8px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            margin-bottom: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(37, 99, 235, .09);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(90deg, #f8fbff, #eff6ff);
        }

        .panel-header h2 {
            margin: 0;
            font-size: 19px;
        }

        .panel-body { padding: 18px; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 12px;
            align-items: end;
        }

        label {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        input, select, textarea {
            width: 100%;
            min-height: 40px;
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 9px 10px;
            font: inherit;
            background: #fff;
            color: var(--text);
        }

        textarea {
            min-height: 78px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            outline: 2px solid rgba(37, 99, 235, .18);
            border-color: var(--accent);
        }

        button, .button-label {
            min-height: 40px;
            border: 0;
            border-radius: 6px;
            padding: 9px 13px;
            background: var(--accent);
            color: #fff;
            font-weight: 800;
            cursor: pointer;
            text-align: center;
            white-space: nowrap;
        }

        button:hover, .button-label:hover { background: var(--accent-dark); }
        .danger { background: var(--danger); }
        .danger:hover { background: #8f1d14; }
        .warning { background: var(--warning); }
        .warning:hover { background: #9a451a; }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            border-top: 1px solid var(--line);
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            background: #fbfcfd;
        }

        tbody tr:hover { background: #f8fbff; }

        .inline-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(132px, 1fr));
            gap: 8px;
            align-items: center;
        }

        .muted { color: var(--muted); }
        .actions { width: 1%; white-space: nowrap; }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 3px 9px;
            border-radius: 6px;
            background: var(--accent-soft);
            color: var(--accent-dark);
            font-weight: 800;
            font-size: 12px;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: minmax(280px, .85fr) minmax(320px, 1fr) minmax(320px, 1fr);
            gap: 16px;
            margin-bottom: 18px;
        }

        .chart-card {
            min-height: 280px;
            padding: 18px;
            margin-bottom: 18px;
            background: rgba(255, 255, 255, .95);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .chart-card h2 {
            margin: 0 0 6px;
            font-size: 18px;
        }

        .chart-card p {
            margin: 0 0 16px;
            color: var(--muted);
            font-size: 13px;
        }

        .donut-wrap {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 18px;
            align-items: center;
        }

        .donut {
            width: 150px;
            aspect-ratio: 1;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at center, #fff 0 55%, transparent 56%),
                conic-gradient(var(--accent) calc(var(--value) * 1%), #dbeafe 0);
            box-shadow: inset 0 0 0 1px #bfdbfe;
        }

        .donut strong {
            font-size: 28px;
            color: var(--accent-dark);
        }

        .legend {
            display: grid;
            gap: 9px;
        }

        .legend-row, .bar-row {
            display: grid;
            grid-template-columns: 14px 1fr auto;
            gap: 9px;
            align-items: center;
            color: var(--muted);
            font-size: 13px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--dot);
        }

        .bar-list {
            display: grid;
            gap: 13px;
        }

        .bar-row {
            grid-template-columns: minmax(104px, 1fr) 2.4fr auto;
        }

        .bar-track {
            height: 10px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .bar-fill {
            width: var(--width);
            height: 100%;
            min-width: 3px;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--bar), #60a5fa);
        }

        .revenue-card {
            color: #fff;
            background:
                linear-gradient(135deg, #1e3a8a 0%, #2563eb 58%, #0ea5e9 100%);
            border: 0;
            overflow: hidden;
        }

        .revenue-card h2,
        .revenue-card p {
            color: #fff;
        }

        .revenue-value {
            margin-top: 18px;
            font-size: 38px;
            line-height: 1;
            font-weight: 900;
        }

        .sparkline {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 76px;
            margin-top: 28px;
        }

        .sparkline i {
            flex: 1;
            min-width: 14px;
            border-radius: 6px 6px 0 0;
            background: rgba(255, 255, 255, .72);
            height: var(--h);
        }

        .sim-toggle { display: none; }

        .sim-tab {
            position: fixed;
            right: 0;
            top: 170px;
            z-index: 40;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            border-radius: 0 8px 8px 0;
            box-shadow: var(--shadow);
        }

        .sim-drawer {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 50;
            width: min(420px, 94vw);
            height: 100vh;
            padding: 18px;
            background: #ffffff;
            border-left: 1px solid var(--line);
            box-shadow: var(--shadow);
            transform: translateX(104%);
            transition: transform .22s ease;
            overflow-y: auto;
        }

        .sim-toggle:checked ~ .sim-drawer { transform: translateX(0); }

        .sim-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .sim-header h2 { margin: 0; font-size: 22px; }
        .sim-close {
            width: 38px;
            min-width: 38px;
            padding: 8px;
            background: #eef2f5;
            color: var(--text);
        }

        .sim-card {
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            margin-bottom: 12px;
            background: var(--surface-soft);
        }

        .sim-card h3 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        .sim-card form {
            display: grid;
            gap: 10px;
        }

        @media (max-width: 760px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 16px;
            }

            .shell { padding: 14px; }
            .panel-body { padding: 14px; }
            .analytics-grid { grid-template-columns: 1fr; }
            .donut-wrap { grid-template-columns: 1fr; justify-items: center; }
            .sim-tab { top: auto; bottom: 16px; writing-mode: initial; transform: none; border-radius: 8px 0 0 8px; }
        }
    </style>
</head>
<body>
<input class="sim-toggle" type="checkbox" id="simulator">

<header class="topbar">
    <div>
        <h1>Система аренды повербанков</h1>
        <p>Администрирование станций, устройств, тарифов, аренд, платежей и ошибок</p>
    </div>
    <label class="button-label" for="simulator">Симулятор пользователя</label>
</header>

<div class="topbar-actions" style="max-width:1480px;margin:14px auto 0;padding:0 24px;">
    <span class="user-chip" style="background:#1e3a8a;">{{ auth()->user()->name }}</span>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button class="warning">Выйти</button>
    </form>
</div>

<label class="button-label sim-tab" for="simulator">Симулятор</label>

<aside class="sim-drawer">
    <div class="sim-header">
        <div>
            <h2>Симулятор пользователя</h2>
            <div class="muted">Действия меняют реальные записи и сразу отражаются в админ-панели.</div>
        </div>
        <label class="button-label sim-close" for="simulator">X</label>
    </div>

    <div class="sim-card">
        <h3>Добавить пользователя</h3>
        <form method="post" action="{{ route('simulation.store') }}">
            @csrf
            <input type="hidden" name="action" value="create_user">
            <div><label>Имя</label><input name="name" required></div>
            <div><label>Email</label><input name="email" type="email" required></div>
            <div><label>Телефон</label><input name="phone" placeholder="+7 900 000-00-00"></div>
            <div><label>Роль</label>
                <select name="role" required>
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
            </div>
            <div><label>Пароль</label><input name="password" type="password" value="password" required></div>
            <button>Создать пользователя</button>
        </form>
    </div>

    <div class="sim-card">
        <h3>Начать аренду</h3>
        <form method="post" action="{{ route('simulation.store') }}">
            @csrf
            <input type="hidden" name="action" value="rent">
            <div><label>Пользователь</label>@include('partials.user-select', ['users' => $users])</div>
            <div><label>Доступный повербанк</label>@include('partials.powerbank-select', ['powerbanks' => $powerbanks->where('status', 'available')])</div>
            <div><label>Тариф</label>@include('partials.tariff-select', ['tariffs' => $tariffs])</div>
            <button>Арендовать</button>
        </form>
    </div>

    <div class="sim-card">
        <h3>Вернуть устройство</h3>
        <form method="post" action="{{ route('simulation.store') }}">
            @csrf
            <input type="hidden" name="action" value="return">
            <div><label>Активная аренда</label>@include('partials.rental-select', ['rentals' => $activeRentals])</div>
            <button class="warning">Вернуть</button>
        </form>
    </div>

    <div class="sim-card">
        <h3>Оплатить аренду</h3>
        <form method="post" action="{{ route('simulation.store') }}">
            @csrf
            <input type="hidden" name="action" value="pay">
            <div><label>Аренда без платежа</label>@include('partials.rental-select', ['rentals' => $unpaidRentals])</div>
            <div><label>Сумма</label><input name="amount" type="number" step="0.01" min="0" value="99" required></div>
            <button>Оплатить</button>
        </form>
    </div>

    <div class="sim-card">
        <h3>Сообщить об ошибке</h3>
        <form method="post" action="{{ route('simulation.store') }}">
            @csrf
            <input type="hidden" name="action" value="report_error">
            <div><label>Описание</label><textarea name="description" required>Станция не выдала повербанк</textarea></div>
            <button class="danger">Отправить в журнал</button>
        </form>
    </div>
</aside>

<div class="toast-stack" id="toast-stack"></div>

<main class="shell">
    @if(session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="notice errors">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="stats">
        <div class="stat"><div><span>Станции</span><b>{{ $stations->count() }}</b></div><mark>S</mark></div>
        <div class="stat"><div><span>Повербанки</span><b>{{ $powerbanks->count() }}</b></div><mark>P</mark></div>
        <div class="stat"><div><span>Доступно</span><b>{{ $availablePowerbanksCount }}</b></div><mark>OK</mark></div>
        <div class="stat"><div><span>Активные аренды</span><b>{{ $activeRentalsCount }}</b></div><mark>A</mark></div>
    </div>

    @php
        $rentalMax = max(1, collect($rentalStatusChart)->max('value'));
    @endphp

    <div class="analytics-grid">
        <section class="chart-card">
            <h2>Доступность устройств</h2>
            <p>Доля повербанков, которые сейчас можно выдать пользователю.</p>
            <div class="donut-wrap">
                <div class="donut" style="--value: {{ $powerbankAvailabilityPercent }}">
                    <strong>{{ $powerbankAvailabilityPercent }}%</strong>
                </div>
                <div class="legend">
                    @foreach($powerbankStatusChart as $item)
                        <div class="legend-row">
                            <span class="dot" style="--dot: {{ $item['color'] }}"></span>
                            <span>{{ $item['label'] }}</span>
                            <b>{{ $item['value'] }}</b>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="chart-card">
            <h2>Статусы аренд</h2>
            <p>Как распределяются пользовательские действия по текущим арендам.</p>
            <div class="bar-list">
                @foreach($rentalStatusChart as $item)
                    <div class="bar-row">
                        <span>{{ $item['label'] }}</span>
                        <span class="bar-track">
                            <i class="bar-fill" style="--bar: {{ $item['color'] }}; --width: {{ round($item['value'] / $rentalMax * 100) }}%"></i>
                        </span>
                        <b>{{ $item['value'] }}</b>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="chart-card revenue-card">
            <h2>Оплаченная выручка</h2>
            <p>Сумма платежей со статусом paid.</p>
            <div class="revenue-value">{{ number_format($paidRevenue, 0, ',', ' ') }} ₽</div>
            <div class="sparkline" aria-hidden="true">
                @foreach([42, 58, 34, 74, 64, 88, 70] as $height)
                    <i style="--h: {{ $height }}%"></i>
                @endforeach
            </div>
        </section>
    </div>

    <section class="chart-card">
        <h2>Загрузка станций</h2>
        <p>Количество повербанков, закрепленных за каждой станцией.</p>
        <div class="bar-list">
            @foreach($stationLoadChart as $station)
                <div class="bar-row">
                    <span>{{ $station['label'] }}</span>
                    <span class="bar-track">
                        <i class="bar-fill" style="--bar: #2563eb; --width: {{ round($station['value'] / $maxStationLoad * 100) }}%"></i>
                    </span>
                    <b>{{ $station['value'] }}</b>
                </div>
            @endforeach
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Станции</h2><span class="badge">{{ $stations->count() }} записей</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('stations.store') }}" class="form-grid">
                @csrf
                <div><label>Расположение</label><input name="location" required></div>
                <div><label>Статус</label>@include('partials.status-select', ['name' => 'status', 'value' => 'active', 'type' => 'station'])</div>
                <button>Добавить станцию</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Расположение и статус</th><th>Устройств</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($stations as $station)
                    <tr>
                        <td>{{ $station->id }}</td>
                        <td>
                            <form method="post" action="{{ route('stations.update', $station) }}" class="inline-form">
                                @csrf @method('put')
                                <input name="location" value="{{ $station->location }}" required>
                                @include('partials.status-select', ['name' => 'status', 'value' => $station->status, 'type' => 'station'])
                                <button>Сохранить</button>
                            </form>
                        </td>
                        <td><span class="badge">{{ $station->powerbanks_count }}</span></td>
                        <td class="actions">
                            <form method="post" action="{{ route('stations.destroy', $station) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Повербанки</h2><span class="badge">{{ $availablePowerbanksCount }} доступно</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('powerbanks.store') }}" class="form-grid">
                @csrf
                <div><label>Станция</label>@include('partials.station-select', ['stations' => $stations, 'value' => null])</div>
                <div><label>Код</label><input name="code" placeholder="PB-1003" required></div>
                <div><label>Емкость, mAh</label><input name="capacity_mah" type="number" min="1000" value="10000" required></div>
                <div><label>Статус</label>@include('partials.status-select', ['name' => 'status', 'value' => 'available', 'type' => 'powerbank'])</div>
                <button>Добавить повербанк</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Данные устройства</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($powerbanks as $powerbank)
                    <tr>
                        <td>{{ $powerbank->id }}</td>
                        <td>
                            <form method="post" action="{{ route('powerbanks.update', $powerbank) }}" class="inline-form">
                                @csrf @method('put')
                                <input name="code" value="{{ $powerbank->code }}" required>
                                @include('partials.station-select', ['stations' => $stations, 'value' => $powerbank->station_id])
                                <input name="capacity_mah" type="number" min="1000" value="{{ $powerbank->capacity_mah }}" required>
                                @include('partials.status-select', ['name' => 'status', 'value' => $powerbank->status, 'type' => 'powerbank'])
                                <button>Сохранить</button>
                            </form>
                        </td>
                        <td class="actions">
                            <form method="post" action="{{ route('powerbanks.destroy', $powerbank) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Тарифы</h2><span class="badge">{{ $tariffs->count() }} тарифов</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('tariffs.store') }}" class="form-grid">
                @csrf
                <div><label>Цена за час</label><input name="price_per_hour" type="number" step="0.01" min="0" required></div>
                <div><label>Описание</label><input name="description"></div>
                <button>Добавить тариф</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Цена и описание</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($tariffs as $tariff)
                    <tr>
                        <td>{{ $tariff->id }}</td>
                        <td>
                            <form method="post" action="{{ route('tariffs.update', $tariff) }}" class="inline-form">
                                @csrf @method('put')
                                <input name="price_per_hour" type="number" step="0.01" min="0" value="{{ $tariff->price_per_hour }}" required>
                                <input name="description" value="{{ $tariff->description }}">
                                <button>Сохранить</button>
                            </form>
                        </td>
                        <td class="actions">
                            <form method="post" action="{{ route('tariffs.destroy', $tariff) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Аренды</h2><span class="badge">{{ $activeRentalsCount }} активных</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('rentals.store') }}" class="form-grid">
                @csrf
                <div><label>Пользователь</label>@include('partials.user-select', ['users' => $users])</div>
                <div><label>Повербанк</label>@include('partials.powerbank-select', ['powerbanks' => $powerbanks->where('status', 'available')])</div>
                <div><label>Тариф</label>@include('partials.tariff-select', ['tariffs' => $tariffs])</div>
                <button>Начать аренду</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Пользователь</th><th>Повербанк</th><th>Тариф</th><th>Период</th><th>Статус</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->id }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->powerbank->code }}</td>
                        <td>{{ $rental->tariff?->price_per_hour ?? '-' }}</td>
                        <td>{{ $rental->start_time->format('d.m.Y H:i') }} - {{ $rental->end_time?->format('d.m.Y H:i') ?? 'идет' }}</td>
                        <td>
                            <form method="post" action="{{ route('rentals.update', $rental) }}" class="inline-form">
                                @csrf @method('put')
                                @include('partials.status-select', ['name' => 'status', 'value' => $rental->status, 'type' => 'rental'])
                                <button>Сохранить</button>
                            </form>
                        </td>
                        <td class="actions">
                            <form method="post" action="{{ route('rentals.destroy', $rental) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Платежи</h2><span class="badge">{{ $payments->count() }} платежей</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('payments.store') }}" class="form-grid">
                @csrf
                <div><label>Аренда без платежа</label>@include('partials.rental-select', ['rentals' => $unpaidRentals])</div>
                <div><label>Сумма</label><input name="amount" type="number" step="0.01" min="0" required></div>
                <div><label>Статус</label>@include('partials.status-select', ['name' => 'status', 'value' => 'paid', 'type' => 'payment'])</div>
                <button>Добавить платеж</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Аренда</th><th>Платеж</th><th>Статус</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>#{{ $payment->rental_id }} / {{ $payment->rental->user->name }}</td>
                        <td>
                            <form method="post" action="{{ route('payments.update', $payment) }}" class="inline-form">
                                @csrf @method('put')
                                <input name="amount" type="number" step="0.01" min="0" value="{{ $payment->amount }}" required>
                                <span class="muted">{{ $payment->payment_time->format('d.m.Y H:i') }}</span>
                                @include('partials.status-select', ['name' => 'status', 'value' => $payment->status, 'type' => 'payment'])
                                <button>Сохранить</button>
                            </form>
                        </td>
                        <td><span class="badge">{{ $payment->status }}</span></td>
                        <td class="actions">
                            <form method="post" action="{{ route('payments.destroy', $payment) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header"><h2>Журнал ошибок</h2><span class="badge">{{ $errorLogs->count() }} записей</span></div>
        <div class="panel-body">
            <form method="post" action="{{ route('error-logs.store') }}" class="form-grid">
                @csrf
                <div><label>Описание ошибки</label><textarea name="description" required></textarea></div>
                <button>Добавить запись</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Описание</th><th>Дата</th><th>Действия</th></tr></thead>
                <tbody>
                @foreach($errorLogs as $errorLog)
                    <tr>
                        <td>{{ $errorLog->id }}</td>
                        <td>{{ $errorLog->description }}</td>
                        <td>{{ $errorLog->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions">
                            <form method="post" action="{{ route('error-logs.destroy', $errorLog) }}">
                                @csrf @method('delete')
                                <button class="danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</main>
<script>
    const toastStack = document.getElementById('toast-stack');

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type === 'error' ? 'error' : ''}`;
        toast.textContent = message;
        toastStack.appendChild(toast);
        window.setTimeout(() => toast.remove(), 3400);
    }

    async function refreshDashboardFragments() {
        const response = await fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        const html = await response.text();
        const nextDocument = new DOMParser().parseFromString(html, 'text/html');
        const nextShell = nextDocument.querySelector('.shell');
        const nextDrawer = nextDocument.querySelector('.sim-drawer');
        const shell = document.querySelector('.shell');
        const drawer = document.querySelector('.sim-drawer');
        const drawerWasOpen = document.getElementById('simulator')?.checked;

        if (nextShell && shell) {
            shell.innerHTML = nextShell.innerHTML;
        }

        if (nextDrawer && drawer) {
            drawer.innerHTML = nextDrawer.innerHTML;
        }

        const simulator = document.getElementById('simulator');
        if (simulator) {
            simulator.checked = Boolean(drawerWasOpen);
        }
    }

    document.addEventListener('submit', async (event) => {
        const form = event.target;

        if (!form.matches('main form, aside form')) {
            return;
        }

        event.preventDefault();

        const submitButton = form.querySelector('button[type="submit"], button:not([type])');
        if (submitButton) {
            submitButton.disabled = true;
        }

        try {
            const response = await fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: new FormData(form),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                const errors = data.errors ? Object.values(data.errors).flat().join(' ') : null;
                throw new Error(errors || data.message || 'Не удалось сохранить изменения.');
            }

            showToast(data.message || 'Изменения сохранены.');
            await refreshDashboardFragments();
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });
</script>
</body>
</html>
