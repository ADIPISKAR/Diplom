@extends('layouts.app', ['title' => 'Текущая аренда'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Текущая аренда</h1>
    <p class="text-secondary mb-0">Здесь отображается устройство, станция выдачи, тариф и рассчитанная на текущий момент стоимость.</p>
</section>

@if($rental)
    <div class="form-section">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Аренда #{{ $rental->id }}</h2>
                <div class="text-secondary">Повербанк находится у пользователя.</div>
            </div>
            <span class="status-badge"><span class="status-dot status-{{ $rental->status }}"></span>{{ $rental->status }}</span>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Повербанк</div><div class="h4 fw-bold">{{ $rental->powerbank->serial_number }}</div><div class="text-secondary">заряд {{ $rental->powerbank->charge_level }}%</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Станция выдачи</div><div class="h4 fw-bold">{{ $rental->startStation->name }}</div><div class="text-secondary">{{ $rental->startStation->building }}, этаж {{ $rental->startStation->floor }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Текущая стоимость</div><div class="h4 fw-bold">{{ number_format($currentPrice, 2, ',', ' ') }} руб.</div><div class="text-secondary">{{ $rental->tariff->name }}</div></div></div>
        </div>
        <div class="soft-panel">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="fw-bold mb-1">Возврат в свободный слот</div>
                    <div class="text-secondary">Выберите любую активную станцию со свободным слотом. После подтверждения будет создан возврат, демо-платёж и уведомление.</div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="btn btn-primary" href="{{ route('rentals.return.create', $rental) }}">Вернуть повербанк</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="form-section">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <h2 class="h4 fw-bold">Активной аренды нет</h2>
                <p class="text-secondary mb-lg-0">Перейдите к списку станций и выберите точку с доступными повербанками.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
            </div>
        </div>
    </div>
@endif
@endsection
