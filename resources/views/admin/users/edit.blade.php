@extends('layouts.app', ['title' => 'Редактирование пользователя'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Пользователь #{{ $user->id }}</h1>
            <form method="post" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="full_name">ФИО</label>
                    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone">Телефон</label>
                        <input class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="role_id">Роль</label>
                        <select class="form-select" id="role_id" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="status">Статус</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" @selected(old('status', $user->status) === 'active')>active</option>
                            <option value="blocked" @selected(old('status', $user->status) === 'blocked')>blocked</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
