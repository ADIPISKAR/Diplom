@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
<section class="soft-panel mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-8">
            <span class="hero-kicker mb-3" style="background: var(--app-blue-soft); color: var(--app-blue);">Личный кабинет</span>
            <h1 class="h2 fw-bold mb-2">Здравствуйте, {{ auth()->user()->full_name }}</h1>
            <p class="text-secondary mb-0">Здесь отображаются текущая аренда, доступные станции, уведомления и быстрые действия. Если телефон разряжается, выберите ближайшую станцию и оформите аренду в один шаг.</p>
        </div>
        <div class="col-lg-4">
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
                <a class="btn btn-outline-primary" href="{{ route('issues.create') }}">Сообщить о проблеме</a>
            </div>
        </div>
    </div>
</section>

<section class="row g-3 mb-4">
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Активная аренда</div><div class="metric-value">{{ $activeRental ? 'Да' : 'Нет' }}</div><div class="text-secondary mt-2">{{ $activeRental ? 'устройство на руках' : 'можно взять повербанк' }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">История аренд</div><div class="metric-value">{{ $rentalsCount }}</div><div class="text-secondary mt-2">записей в профиле</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Доступные станции</div><div class="metric-value">{{ $stationsCount }}</div><div class="text-secondary mt-2">активные точки</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Обращения</div><div class="metric-value">{{ $issuesCount }}</div><div class="text-secondary mt-2">заявки пользователя</div></div></div>
</section>

<section class="row g-4 mb-4">
    <div class="col-xl-7">
        <div class="form-section h-100">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <div>
                    <h2 class="h4 fw-bold mb-1">Текущая аренда</h2>
                    <div class="text-secondary">Статус устройства и следующего действия.</div>
                </div>
                @if($activeRental)
                    <span class="status-badge"><span class="status-dot status-active"></span>active</span>
                @endif
            </div>

            @if($activeRental)
                <div class="row g-3">
                    <div class="col-md-6"><div class="feature-tile"><div class="text-secondary small">Повербанк</div><div class="h5 mb-0">{{ $activeRental->powerbank->serial_number }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="text-secondary small">Станция выдачи</div><div class="h5 mb-0">{{ $activeRental->startStation->name }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="text-secondary small">Начало аренды</div><div class="h5 mb-0">{{ $activeRental->started_at->format('d.m.Y H:i') }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="text-secondary small">Тариф</div><div class="h5 mb-0">{{ $activeRental->tariff->name }}</div></div></div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a class="btn btn-primary" href="{{ route('rentals.current') }}">Открыть аренду</a>
                    <a class="btn btn-outline-primary" href="{{ route('rentals.return.create', $activeRental) }}">Вернуть повербанк</a>
                </div>
            @else
                <div class="soft-panel">
                    <h3 class="h5 fw-bold">Активной аренды нет</h3>
                    <p class="text-secondary mb-3">Выберите станцию с доступными повербанками. Система автоматически проверит тариф, слот и наличие других активных аренд.</p>
                    <a class="btn btn-primary" href="{{ route('stations.index') }}">Перейти к станциям</a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-xl-5">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Быстрые действия</h2>
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="{{ route('stations.index') }}">Найти ближайшую станцию</a>
                <a class="btn btn-outline-primary" href="{{ route('bank-cards.index') }}">Привязать карту</a>
                <a class="btn btn-outline-primary" href="{{ route('rentals.history') }}">Посмотреть историю</a>
                <a class="btn btn-outline-primary" href="{{ route('issues.create') }}">Создать обращение</a>
            </div>
            <div class="mt-4 p-3 rounded-4" style="background: var(--app-blue-soft);">
                <div class="fw-bold mb-1">Что делать дальше</div>
                <div class="text-secondary">Если слот станции не принимает повербанк или устройство повреждено, создайте обращение. Администратор увидит проблему в панели управления.</div>
            </div>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="form-section h-100">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <h2 class="h4 fw-bold mb-0">Доступные станции</h2>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('stations.index') }}">Все станции</a>
            </div>
            <div class="row g-3">
                @forelse($stations as $station)
                    <div class="col-md-4">
                        <div class="feature-tile">
                            <div class="tile-icon">СТ</div>
                            <h3 class="h6 fw-bold">{{ $station->name }}</h3>
                            <div class="text-secondary small mb-2">{{ $station->building }}, этаж {{ $station->floor }}</div>
                            <span class="status-badge"><span class="status-dot status-available"></span>{{ $station->available_powerbanks_count }} доступно</span>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-secondary">Станций пока нет.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Последние действия</h2>
            @forelse($recentLogs as $log)
                <div class="d-flex gap-3 py-3 border-top">
                    <span class="tile-icon mb-0" style="width: 34px; height: 34px; min-width: 34px;">Ж</span>
                    <div>
                        <div class="fw-bold">{{ $log->action }}</div>
                        <div class="text-secondary small">{{ $log->description ?: 'Действие сохранено в журнале' }}</div>
                        <div class="text-secondary small">{{ $log->created_at?->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            @empty
                <div class="text-secondary">Действий пока нет.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="form-section">
    <h2 class="h4 fw-bold mb-3">Последние уведомления</h2>
    @forelse($notifications as $notification)
        <div class="border-top py-3">
            <div class="d-flex justify-content-between gap-2">
                <div class="fw-bold">{{ $notification->title }}</div>
                <span class="status-badge">{{ $notification->is_read ? 'прочитано' : 'новое' }}</span>
            </div>
            <div class="text-secondary">{{ $notification->message }}</div>
        </div>
    @empty
        <div class="text-secondary">Уведомлений пока нет. После возврата повербанка здесь появится подтверждение.</div>
    @endforelse
</section>
@endsection
