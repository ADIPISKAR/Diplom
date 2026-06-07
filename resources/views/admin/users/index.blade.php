@extends('layouts.app', ['title' => 'Пользователи'])

@section('content')
<h1 class="h2 fw-bold mb-4">Пользователи</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>ФИО</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td><span class="status-dot status-{{ $user->status }}"></span>{{ $user->status }}</td>
                    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.edit', $user) }}">Изменить</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection
