@extends('layouts.app', ['title' => 'Текущая аренда'])

@section('content')
<h1 class="h2 mb-4">Текущая аренда</h1>

@if($rental)
    <div class="form-section">
        <div class="row g-3">
            <div class="col-md-3"><div class="text-secondary small">Номер</div><div class="fw-semibold">#{{ $rental->id }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Повербанк</div><div class="fw-semibold">{{ $rental->powerbank->serial_number }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Станция выдачи</div><div class="fw-semibold">{{ $rental->startStation->name }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Начало</div><div class="fw-semibold">{{ $rental->started_at->format('d.m.Y H:i') }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Тариф</div><div class="fw-semibold">{{ $rental->tariff->name }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Текущая стоимость</div><div class="fw-semibold">{{ number_format($currentPrice, 2, ',', ' ') }} руб.</div></div>
            <div class="col-md-6 d-flex align-items-end"><a class="btn btn-primary w-100" href="{{ route('rentals.return.create', $rental) }}">Вернуть повербанк</a></div>
        </div>
    </div>
@else
    <div class="form-section">
        <div class="text-secondary mb-3">Активной аренды нет.</div>
        <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
    </div>
@endif
@endsection
