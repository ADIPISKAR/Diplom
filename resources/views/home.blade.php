@extends('layouts.app', ['title' => 'PowerbankRental'])

@section('content')
<section class="hero-panel mb-4">
    <div class="hero-panel-inner">
        <div class="d-flex flex-column justify-content-center">
            <span class="hero-kicker mb-3">Цифровой сервис института</span>
            <h1 class="display-5 fw-bold mb-3">Аренда повербанков на территории учебного корпуса</h1>
            <p class="lead mb-4">PowerbankRental помогает студентам, преподавателям и сотрудникам быстро найти станцию, взять заряженный повербанк, оплатить аренду в демо-режиме и вернуть устройство в свободный слот.</p>
            <div class="d-flex flex-wrap gap-2">
                @auth
                    <a class="btn btn-primary" href="{{ route('stations.index') }}">Выбрать станцию</a>
                    <a class="btn btn-outline-primary" href="{{ route('rentals.current') }}">Текущая аренда</a>
                @else
                    <a class="btn btn-primary" href="{{ route('register') }}">Начать пользоваться</a>
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Войти в кабинет</a>
                @endauth
            </div>
        </div>
        <img class="hero-image" src="{{ asset('images/powerbank-campus-hero.png') }}" alt="Станция аренды повербанков в институте">
    </div>
</section>

<section class="row g-3 mb-4">
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Станции</div><div class="metric-value">3+</div><div class="text-secondary mt-2">точки выдачи и возврата</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Слоты</div><div class="metric-value">15</div><div class="text-secondary mt-2">учёт мест станции</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Оплата</div><div class="metric-value">Demo</div><div class="text-secondary mt-2">без реального банка</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Контроль</div><div class="metric-value">24/7</div><div class="text-secondary mt-2">история и журнал действий</div></div></div>
</section>

<section class="row g-4 align-items-center mb-5">
    <div class="col-lg-6">
        <h2 class="section-title">Как это работает</h2>
        <p class="section-subtitle mb-4">Сценарий построен как обычный личный кабинет: пользователь видит станции, выбирает доступную точку, система фиксирует выдачу, а при возврате обновляет слот, оплату и историю.</p>
        <div class="row g-3">
            <div class="col-md-6"><div class="feature-tile"><div class="tile-icon">1</div><h3 class="h5">Выберите станцию</h3><p class="text-secondary mb-0">В списке отображаются корпус, этаж, доступные повербанки и состояние станции.</p></div></div>
            <div class="col-md-6"><div class="feature-tile"><div class="tile-icon">2</div><h3 class="h5">Начните аренду</h3><p class="text-secondary mb-0">Сервис проверяет активную аренду, выбирает исправный повербанк и освобождает слот.</p></div></div>
            <div class="col-md-6"><div class="feature-tile"><div class="tile-icon">3</div><h3 class="h5">Используйте устройство</h3><p class="text-secondary mb-0">В кабинете видно время начала, текущую стоимость и выбранный тариф.</p></div></div>
            <div class="col-md-6"><div class="feature-tile"><div class="tile-icon">4</div><h3 class="h5">Верните в слот</h3><p class="text-secondary mb-0">После возврата создаётся запись, демо-платёж и уведомление пользователю.</p></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <img class="content-image" src="{{ asset('images/powerbank-station.png') }}" alt="Зарядная станция с повербанками">
    </div>
</section>

<section class="mb-5">
    <h2 class="section-title">Преимущества для учебной среды</h2>
    <p class="section-subtitle mb-4">Система закрывает бытовую проблему разряженного смартфона и одновременно даёт администрации прозрачный контроль оборудования.</p>
    <div class="row g-3">
        <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">СТ</div><h3 class="h5">Студентам</h3><p class="text-secondary mb-0">Можно быстро зарядить телефон между парами, не искать свободную розетку и не обращаться к сотрудникам вручную.</p></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">ПР</div><h3 class="h5">Преподавателям</h3><p class="text-secondary mb-0">Повербанк доступен для рабочих звонков, расписания, презентаций и образовательных сервисов в течение дня.</p></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">АД</div><h3 class="h5">Администрации</h3><p class="text-secondary mb-0">Есть контроль пользователей, станций, повербанков, тарифов, возвратов, обращений и журнала действий.</p></div></div>
    </div>
</section>

<section class="row g-4 align-items-center mb-5">
    <div class="col-lg-5">
        <img class="content-image" src="{{ asset('images/campus-users.png') }}" alt="Пользователи сервиса в учебной среде">
    </div>
    <div class="col-lg-7">
        <div class="soft-panel">
            <h2 class="section-title">Безопасность и учёт устройств</h2>
            <p class="text-secondary">В прототипе не хранится полный номер банковской карты, а оплата работает через `demo_payment`. Все важные события фиксируются в журнале действий: регистрация, вход, создание аренды, возврат, обращения и действия администратора.</p>
            <div class="row g-3 mt-1">
                <div class="col-md-6"><div class="feature-tile"><h3 class="h6 fw-bold">Одна активная аренда</h3><p class="text-secondary mb-0">Пользователь не может взять второй повербанк, пока не вернул текущий.</p></div></div>
                <div class="col-md-6"><div class="feature-tile"><h3 class="h6 fw-bold">Контроль слотов</h3><p class="text-secondary mb-0">При выдаче слот становится свободным, при возврате снова занятым.</p></div></div>
            </div>
        </div>
    </div>
</section>

<section class="form-section">
    <div class="row g-4 align-items-center">
        <div class="col-lg-8">
            <h2 class="h4 fw-bold">Готовый учебный сервис, а не статичная витрина</h2>
            <p class="text-secondary mb-lg-0">После входа пользователь получает личный кабинет со статистикой, текущей арендой, быстрыми действиями и историей. Администратор видит состояние системы и управляет справочниками.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a class="btn btn-primary" href="{{ auth()->check() ? route('dashboard') : route('register') }}">Открыть кабинет</a>
        </div>
    </div>
</section>
@endsection
