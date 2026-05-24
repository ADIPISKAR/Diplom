@extends('layouts.app', ['title' => 'Вход'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="form-section">
            <h1 class="h3 mb-3">Вход</h1>
            <form method="post" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Пароль</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Войти</button>
            </form>
        </div>
    </div>
</div>
@endsection
