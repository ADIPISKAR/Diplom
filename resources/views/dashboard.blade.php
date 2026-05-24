@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="h2 mb-1">Личный кабинет</h1>
        <div class="text-secondary">{{ auth()->user()->full_name }}</div>
    </div>
    <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="form-section metric"><div class="text-secondary">Активных станций</div><div class="fs-3 fw-semibold">{{ $stationsCount }}</div></div></div>
    <div class="col-md-4"><div class="form-section metric"><div class="text-secondary">Ваших аренд</div><div class="fs-3 fw-semibold">{{ $rentalsCount }}</div></div></div>
    <div class="col-md-4"><div class="form-section metric"><div class="text-secondary">Текущая аренда</div><div class="fs-3 fw-semibold">{{ $activeRental ? 'Есть' : 'Нет' }}</div></div></div>
</div>

@if($activeRental)
    <div class="form-section mb-4">
        <h2 class="h5">Активная аренда #{{ $activeRental->id }}</h2>
        <div class="row g-3">
            <div class="col-md-3"><div class="text-secondary small">Повербанк</div><div class="fw-semibold">{{ $activeRental->powerbank->serial_number }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Станция</div><div class="fw-semibold">{{ $activeRental->startStation->name }}</div></div>
            <div class="col-md-3"><div class="text-secondary small">Начало</div><div class="fw-semibold">{{ $activeRental->started_at->format('d.m.Y H:i') }}</div></div>
            <div class="col-md-3"><a class="btn btn-outline-primary w-100" href="{{ route('rentals.current') }}">Открыть</a></div>
        </div>
    </div>
@endif

<div class="form-section">
    <h2 class="h5">Последние уведомления</h2>
    @forelse($notifications as $notification)
        <div class="border-top py-2">
            <div class="fw-semibold">{{ $notification->title }}</div>
            <div class="text-secondary">{{ $notification->message }}</div>
        </div>
    @empty
        <div class="text-secondary">Уведомлений пока нет.</div>
    @endforelse
</div>
@endsection
