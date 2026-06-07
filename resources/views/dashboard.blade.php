@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
<section class="soft-panel mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-lg-8">
            <h1 class="h2 fw-bold mb-2">Личный кабинет</h1>
            <p class="text-secondary mb-0">Здесь отображаются активная заявка, доступное оборудование, уведомления и история действий пользователя.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a class="btn btn-primary" href="{{ route('requests.create') }}">Создать заявку</a>
        </div>
    </div>
</section>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Активная заявка</div><div class="metric-value">{{ $activeRequest ? 'Да' : 'Нет' }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Всего заявок</div><div class="metric-value">{{ $requestsCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Доступно</div><div class="metric-value">{{ $availableEquipmentCount }}</div></div></div>
    <div class="col-md-3"><div class="form-section metric"><div class="metric-label">Места хранения</div><div class="metric-value">{{ $locationsCount }}</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="form-section h-100">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <h2 class="h4 fw-bold mb-0">Текущая заявка</h2>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('requests.index') }}">Все заявки</a>
            </div>
            @if($activeRequest)
                <div class="row g-3">
                    <div class="col-md-6"><div class="feature-tile"><div class="metric-label">Категория</div><div class="h5 mb-0">{{ $activeRequest->category->name }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="metric-label">Статус</div><div class="h5 mb-0"><span class="status-dot status-{{ $activeRequest->status }}"></span>{{ $activeRequest->status }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="metric-label">Оборудование</div><div class="h5 mb-0">{{ $activeRequest->equipment?->name ?? 'Подбирается сотрудником' }}</div></div></div>
                    <div class="col-md-6"><div class="feature-tile"><div class="metric-label">Место получения</div><div class="h5 mb-0">{{ $activeRequest->storageLocation?->name ?? 'Будет уточнено' }}</div></div></div>
                </div>
                @if($activeRequest->status === 'issued')
                    <form class="mt-3" method="post" action="{{ route('requests.return-request', $activeRequest) }}">
                        @csrf
                        @method('patch')
                        <button class="btn btn-primary" type="submit">Запросить возврат</button>
                    </form>
                @endif
            @else
                <p class="text-secondary">Активных заявок нет. Выберите доступное оборудование или создайте заявку по категории.</p>
                <a class="btn btn-primary" href="{{ route('equipment.index', ['available' => 1]) }}">Выбрать оборудование</a>
            @endif
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-section h-100">
            <h2 class="h4 fw-bold mb-3">Доступное оборудование</h2>
            @forelse($equipment as $item)
                <div class="d-flex justify-content-between gap-3 py-2 border-bottom">
                    <div>
                        <div class="fw-bold">{{ $item->name }}</div>
                        <div class="text-secondary small">{{ $item->category->name }} · {{ $item->storageLocation->name }}</div>
                    </div>
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('requests.create', ['equipment_id' => $item->id]) }}">Заявка</a>
                </div>
            @empty
                <div class="text-secondary">Свободного оборудования пока нет.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
