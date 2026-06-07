@extends('layouts.app', ['title' => 'Администрирование'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Административная панель</h1>
    <p class="text-secondary mb-0">Контроль пользователей, оборудования, заявок, мест хранения, проблемных ситуаций и журнала действий.</p>
</section>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Пользователи</div><div class="metric-value">{{ $usersCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Оборудование</div><div class="metric-value">{{ $equipmentCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Активные заявки</div><div class="metric-value">{{ $pendingRequestsCount + $issuedRequestsCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Проблемы</div><div class="metric-value">{{ $openIssuesCount }}</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Последние заявки</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>#</th><th>Пользователь</th><th>Категория</th><th>Статус</th></tr></thead>
                    <tbody>
                    @forelse($recentRequests as $requestModel)
                        <tr>
                            <td>{{ $requestModel->id }}</td>
                            <td>{{ $requestModel->user->full_name }}</td>
                            <td>{{ $requestModel->category->name }}</td>
                            <td><span class="status-dot status-{{ $requestModel->status }}"></span>{{ $requestModel->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-secondary">Заявок нет.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Статусы оборудования</h2>
            @foreach($equipmentStatuses as $status)
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span><span class="status-dot status-{{ $status->status }}"></span>{{ $status->status }}</span>
                    <strong>{{ $status->total }}</strong>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
