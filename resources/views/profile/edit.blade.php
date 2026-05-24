@extends('layouts.app', ['title' => 'Профиль'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Профиль</h1>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="form-label" for="full_name">ФИО</label>
                    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone">Телефон</label>
                        <input class="form-control" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password">Новый пароль</label>
                        <input class="form-control" id="password" name="password" type="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password_confirmation">Повтор пароля</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
