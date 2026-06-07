@extends('layouts.app', ['title' => 'Панель сотрудника'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Панель сотрудника выдачи</h1>
    <p class="text-secondary mb-0">Раздел используется для обработки заявок, подтверждения выдачи, фиксации возврата и контроля проблемных ситуаций.</p>
</section>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Ожидают</div><div class="metric-value">{{ $pendingCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">На руках</div><div class="metric-value">{{ $issuedCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Доступно</div><div class="metric-value">{{ $availableCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Проблемы</div><div class="metric-value">{{ $problemCount }}</div></div></div>
</div>

<div class="form-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 fw-bold mb-0">Последние заявки</h2>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('employee.requests.index') }}">Все заявки</a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Пользователь</th><th>Категория</th><th>Оборудование</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @forelse($requests as $requestModel)
                <tr>
                    <td>{{ $requestModel->id }}</td>
                    <td>{{ $requestModel->user->full_name }}</td>
                    <td>{{ $requestModel->category->name }}</td>
                    <td>{{ $requestModel->equipment?->name ?? 'Не назначено' }}</td>
                    <td><span class="status-dot status-{{ $requestModel->status }}"></span>{{ $requestModel->status }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('employee.requests.edit', $requestModel) }}">Обработать</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-secondary">Активных заявок нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
