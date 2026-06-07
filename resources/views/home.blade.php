@extends('layouts.app', ['title' => 'Реестр оборудования'])

@section('content')
<section class="hero-panel mb-4">
    <div class="hero-panel-inner">
        <div>
            <div class="hero-kicker mb-3">ДГТУ · самоподготовка студентов</div>
            <h1 class="display-5 fw-bold mb-3">Веб-приложение для ведения реестра оборудования</h1>
            <p class="lead mb-4">Система помогает студентам оформлять заявки на ноутбуки, планшеты и портативные зарядные устройства, а сотрудникам — фиксировать выдачу, возврат и состояние оборудования.</p>
            <div class="d-flex flex-wrap gap-2">
                @auth
                    <a class="btn btn-primary" href="{{ route('equipment.index', ['available' => 1]) }}">Посмотреть оборудование</a>
                    <a class="btn btn-outline-primary" href="{{ route('requests.create') }}">Создать заявку</a>
                @else
                    <a class="btn btn-primary" href="{{ route('register') }}">Зарегистрироваться</a>
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Войти</a>
                @endauth
            </div>
        </div>
        <img class="hero-image" src="{{ asset('images/campus-users.png') }}" alt="Студенты используют оборудование для самоподготовки">
    </div>
</section>

<div class="row g-3">
    <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">1</div><h2 class="h5 fw-bold">Студент оформляет заявку</h2><p class="text-secondary mb-0">Пользователь выбирает категорию, доступное устройство и место получения.</p></div></div>
    <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">2</div><h2 class="h5 fw-bold">Сотрудник подтверждает выдачу</h2><p class="text-secondary mb-0">Ответственный сотрудник проверяет наличие, фиксирует передачу и меняет статус.</p></div></div>
    <div class="col-md-4"><div class="feature-tile"><div class="tile-icon">3</div><h2 class="h5 fw-bold">Администратор контролирует реестр</h2><p class="text-secondary mb-0">Администратор управляет пользователями, категориями, местами хранения и отчетами.</p></div></div>
</div>
@endsection
