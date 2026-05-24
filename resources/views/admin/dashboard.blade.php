@extends('layouts.app', ['title' => 'Администрирование'])

@section('content')
@include('admin.partials.nav')

<section class="soft-panel mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-8">
            <span class="hero-kicker mb-3" style="background: var(--app-blue-soft); color: var(--app-blue);">Панель администратора</span>
            <h1 class="h2 fw-bold mb-2">Контроль сервиса аренды повербанков</h1>
            <p class="text-secondary mb-0">Здесь собраны пользователи, станции, повербанки, активные аренды, возвраты, обращения и журнал действий. Блоки ниже помогают быстро понять состояние инфраструктуры.</p>
        </div>
        <div class="col-lg-4">
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="{{ route('admin.stations.create') }}">Добавить станцию</a>
                <a class="btn btn-outline-primary" href="{{ route('admin.powerbanks.create') }}">Добавить повербанк</a>
            </div>
        </div>
    </div>
</section>

<section class="row g-3 mb-4">
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Пользователи</div><div class="metric-value">{{ $usersCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Станции</div><div class="metric-value">{{ $stationsCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Повербанки</div><div class="metric-value">{{ $powerbanksCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Активные</div><div class="metric-value">{{ $activeRentalsCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Оплачено</div><div class="metric-value">{{ number_format((float) $paymentsTotal, 0, ',', ' ') }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="metric-label">Проблемы</div><div class="metric-value">{{ $openIssuesCount }}</div></div></div>
</section>

<section class="row g-4 mb-4">
    <div class="col-xl-7">
        <div class="form-section h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h2 class="h4 fw-bold mb-1">Последние аренды</h2>
                    <div class="text-secondary">Новые и активные операции пользователей.</div>
                </div>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.rentals.index') }}">Все аренды</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>#</th><th>Пользователь</th><th>Повербанк</th><th>Станция</th><th>Статус</th></tr></thead>
                    <tbody>
                    @forelse($recentRentals as $rental)
                        <tr>
                            <td>{{ $rental->id }}</td>
                            <td>{{ $rental->user->full_name }}</td>
                            <td>{{ $rental->powerbank->serial_number }}</td>
                            <td>{{ $rental->startStation->name }}</td>
                            <td><span class="status-badge"><span class="status-dot status-{{ $rental->status }}"></span>{{ $rental->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-secondary">Аренд пока нет.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="form-section h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h2 class="h4 fw-bold mb-0">Проблемные ситуации</h2>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.issues.index') }}">Открыть</a>
            </div>
            @forelse($openIssues as $issue)
                <div class="feature-tile mb-2">
                    <div class="d-flex justify-content-between gap-2">
                        <div class="fw-bold">#{{ $issue->id }} · {{ $issue->issue_type }}</div>
                        <span class="status-badge"><span class="status-dot status-{{ $issue->status }}"></span>{{ $issue->status }}</span>
                    </div>
                    <div class="text-secondary small">{{ $issue->user->full_name }} · {{ $issue->station?->name ?? 'станция не указана' }}</div>
                </div>
            @empty
                <div class="soft-panel">Открытых проблем нет. Новые обращения появятся в этом блоке.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Состояние станций</h2>
            @foreach($stationOverview as $station)
                <div class="d-flex justify-content-between align-items-center border-top py-3 gap-3">
                    <div>
                        <div class="fw-bold">{{ $station->name }}</div>
                        <div class="text-secondary small">{{ $station->building }}, этаж {{ $station->floor }}</div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge"><span class="status-dot status-{{ $station->status }}"></span>{{ $station->status }}</span>
                        <div class="text-secondary small mt-1">{{ $station->available_powerbanks_count }} доступно / {{ $station->slots_count }} слотов</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Статусы повербанков</h2>
            <div class="row g-3">
                @foreach($powerbankStatuses as $status)
                    <div class="col-sm-6">
                        <div class="feature-tile">
                            <div class="metric-label">{{ $status->status }}</div>
                            <div class="metric-value">{{ $status->total }}</div>
                            <span class="status-badge mt-2"><span class="status-dot status-{{ $status->status }}"></span>{{ $status->status }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="form-section">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h2 class="h4 fw-bold mb-1">Журнал действий</h2>
            <div class="text-secondary">Последние события пользователей и администраторов.</div>
        </div>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.activity-logs.index') }}">Весь журнал</a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Дата</th><th>Пользователь</th><th>Действие</th><th>Описание</th></tr></thead>
            <tbody>
            @foreach($recentLogs as $log)
                <tr>
                    <td>{{ $log->created_at?->format('d.m.Y H:i') }}</td>
                    <td>{{ $log->user?->full_name ?? 'Система' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
