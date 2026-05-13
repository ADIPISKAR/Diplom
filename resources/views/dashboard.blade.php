<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Аренда повербанков</title>
    <style>
        :root {
            color-scheme: light;
            --page: #eef2f5;
            --surface: #ffffff;
            --surface-soft: #f8fafb;
            --line: #d6dde5;
            --text: #1b2632;
            --muted: #667789;
            --accent: #0f766e;
            --accent-dark: #0b5f59;
            --warning: #c05621;
            --danger: #b42318;
            --shadow: 0 16px 38px rgba(31, 41, 51, .12);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, Arial, sans-serif;
            background: var(--page);
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
            background: #17212b;
            color: #fff;
            box-shadow: 0 8px 24px rgba(23, 33, 43, .18);
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
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 8px 22px rgba(31, 41, 51, .06);
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
            background: #e6f4f1;
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

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            margin-bottom: 18px;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(31, 41, 51, .07);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
            background: var(--surface-soft);
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
            outline: 2px solid rgba(15, 118, 110, .18);
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

        tbody tr:hover { background: #f8fbfa; }

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
            background: #edf7f5;
            color: var(--accent-dark);
            font-weight: 800;
            font-size: 12px;
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
</body>
</html>
