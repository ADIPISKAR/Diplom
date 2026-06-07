@extends('layouts.app', ['title' => 'Обработка заявок'])

@section('content')
<h1 class="h2 fw-bold mb-4">Обработка заявок</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Пользователь</th><th>Категория</th><th>Оборудование</th><th>Место</th><th>Статус</th><th>Дата</th><th></th></tr></thead>
            <tbody>
            @forelse($requests as $requestModel)
                <tr>
                    <td>{{ $requestModel->id }}</td>
                    <td>{{ $requestModel->user->full_name }}</td>
                    <td>{{ $requestModel->category->name }}</td>
                    <td>{{ $requestModel->equipment?->name ?? 'Не назначено' }}</td>
                    <td>{{ $requestModel->storageLocation?->name ?? 'Не указано' }}</td>
                    <td><span class="status-dot status-{{ $requestModel->status }}"></span>{{ $requestModel->status }}</td>
                    <td>{{ $requestModel->requested_at->format('d.m.Y H:i') }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('employee.requests.edit', $requestModel) }}">Открыть</a></td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-secondary">Заявок нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $requests->links() }}
</div>
@endsection
