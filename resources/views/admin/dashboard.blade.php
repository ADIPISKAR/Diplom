@extends('layouts.app', ['title' => 'Администрирование'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">Администрирование</h1>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Пользователи</div><div class="fs-3 fw-semibold">{{ $usersCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Станции</div><div class="fs-3 fw-semibold">{{ $stationsCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Повербанки</div><div class="fs-3 fw-semibold">{{ $powerbanksCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Активные</div><div class="fs-3 fw-semibold">{{ $activeRentalsCount }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Оплата</div><div class="fs-3 fw-semibold">{{ number_format((float) $paymentsTotal, 0, ',', ' ') }}</div></div></div>
    <div class="col-md-4 col-xl-2"><div class="form-section metric"><div class="text-secondary">Проблемы</div><div class="fs-3 fw-semibold">{{ $openIssuesCount }}</div></div></div>
</div>

<div class="form-section">
    <h2 class="h5">Последние действия</h2>
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
</div>
@endsection
