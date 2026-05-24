@extends('layouts.app', ['title' => 'PowerbankRental'])

@section('content')
<section class="row align-items-center g-4">
    <div class="col-lg-7">
        <h1 class="display-5 fw-semibold mb-3">Аренда повербанков в институте</h1>
        <p class="lead text-secondary">Система для выдачи, возврата и учёта портативных зарядных устройств через станции на территории учебного заведения.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
            @auth
                <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
                <a class="btn btn-outline-secondary" href="{{ route('rentals.current') }}">Текущая аренда</a>
            @else
                <a class="btn btn-primary" href="{{ route('register') }}">Начать аренду</a>
                <a class="btn btn-outline-secondary" href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-section">
            <div class="row g-3">
                <div class="col-6"><div class="p-3 bg-light rounded-2"><div class="fs-4 fw-semibold">QR</div><div class="text-secondary small">Сканирование станции</div></div></div>
                <div class="col-6"><div class="p-3 bg-light rounded-2"><div class="fs-4 fw-semibold">24/7</div><div class="text-secondary small">Учёт аренд</div></div></div>
                <div class="col-6"><div class="p-3 bg-light rounded-2"><div class="fs-4 fw-semibold">Demo</div><div class="text-secondary small">Оплата без банка</div></div></div>
                <div class="col-6"><div class="p-3 bg-light rounded-2"><div class="fs-4 fw-semibold">Admin</div><div class="text-secondary small">Контроль станций</div></div></div>
            </div>
        </div>
    </div>
</section>
@endsection
