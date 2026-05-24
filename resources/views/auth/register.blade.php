@extends('layouts.app', ['title' => 'Регистрация'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="form-section">
            <h1 class="h3 mb-3">Регистрация</h1>
            <form method="post" action="{{ route('register.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="full_name">ФИО</label>
                    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone">Телефон</label>
                        <input class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password">Пароль</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password_confirmation">Повтор пароля</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>
                <button class="btn btn-primary w-100" type="submit">Создать аккаунт</button>
            </form>
        </div>
    </div>
</div>
@endsection
