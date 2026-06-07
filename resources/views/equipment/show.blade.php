@extends('layouts.app', ['title' => $equipment->name])

@section('content')
<div class="form-section">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">{{ $equipment->name }}</h1>
            <div class="text-secondary">Инвентарный номер: {{ $equipment->inventory_number }}</div>
        </div>
        <span class="status-badge"><span class="status-dot status-{{ $equipment->status }}"></span>{{ $equipment->status }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Категория</div><div class="h5 mb-0">{{ $equipment->category->name }}</div></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Место хранения</div><div class="h5 mb-0">{{ $equipment->storageLocation->name }}</div></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Состояние</div><div class="h5 mb-0">{{ $equipment->technical_condition }}</div></div></div>
    </div>

    <p class="text-secondary">{{ $equipment->description ?: 'Описание оборудования не указано.' }}</p>

    @if($equipment->specification)
        <h2 class="h4 fw-bold mt-4 mb-3">Характеристики</h2>
        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Процессор</div><div class="h5 mb-0">{{ $equipment->specification->processor ?? '—' }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Оперативная память</div><div class="h5 mb-0">{{ $equipment->specification->ram ?? '—' }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Накопитель</div><div class="h5 mb-0">{{ $equipment->specification->storage ?? '—' }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Экран</div><div class="h5 mb-0">{{ $equipment->specification->screen_size ?? '—' }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Операционная система</div><div class="h5 mb-0">{{ $equipment->specification->operating_system ?? '—' }}</div></div></div>
            <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Аккумулятор</div><div class="h5 mb-0">{{ $equipment->specification->battery_condition ?? '—' }}</div></div></div>
        </div>
        @if($equipment->specification->additional_info)
            <div class="soft-panel mb-4">{{ $equipment->specification->additional_info }}</div>
        @endif
    @endif

    @if($equipment->software->isNotEmpty())
        <h2 class="h4 fw-bold mt-4 mb-3">Установленное программное обеспечение</h2>
        <div class="table-responsive form-section mb-4">
            <table class="table">
                <thead><tr><th>Программа</th><th>Версия</th><th>Лицензия</th><th>Описание</th></tr></thead>
                <tbody>
                @foreach($equipment->software as $software)
                    <tr>
                        <td>{{ $software->name }}</td>
                        <td>{{ $software->version ?? '—' }}</td>
                        <td>{{ $software->license_type ?? '—' }}</td>
                        <td>{{ $software->description ?? '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary" href="{{ route('equipment.index') }}">Назад к реестру</a>
        <a class="btn btn-primary {{ $equipment->isAvailable() ? '' : 'disabled' }}" href="{{ route('requests.create', ['equipment_id' => $equipment->id]) }}">Оформить заявку</a>
    </div>
</div>
@endsection
