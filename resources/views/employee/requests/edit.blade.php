@extends('layouts.app', ['title' => 'Заявка #'.$requestModel->id])

@section('content')
<div class="form-section mb-4">
    <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
            <h1 class="h2 fw-bold mb-1">Заявка #{{ $requestModel->id }}</h1>
            <div class="text-secondary">{{ $requestModel->user->full_name }} · {{ $requestModel->requested_at->format('d.m.Y H:i') }}</div>
        </div>
        <span class="status-badge"><span class="status-dot status-{{ $requestModel->status }}"></span>{{ $requestModel->status }}</span>
    </div>
    <div class="row g-3 mt-2">
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Категория</div><div class="h5 mb-0">{{ $requestModel->category->name }}</div></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Оборудование</div><div class="h5 mb-0">{{ $requestModel->equipment?->name ?? 'Не назначено' }}</div></div></div>
        <div class="col-md-4"><div class="feature-tile"><div class="metric-label">Место</div><div class="h5 mb-0">{{ $requestModel->storageLocation?->name ?? 'Не указано' }}</div></div></div>
    </div>
    @if($requestModel->user_comment)
        <div class="soft-panel mt-3">{{ $requestModel->user_comment }}</div>
    @endif
</div>

@if($requestModel->status === 'pending')
    <div class="row g-4">
        <div class="col-lg-7">
            <form class="form-section" method="post" action="{{ route('employee.requests.approve', $requestModel) }}">
                @csrf
                @method('patch')
                <h2 class="h4 fw-bold mb-3">Подтверждение заявки</h2>
                <label class="form-label" for="equipment_id">Оборудование</label>
                <select class="form-select" id="equipment_id" name="equipment_id" required>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}" @disabled(! $item->isAvailable())>{{ $item->name }} · {{ $item->inventory_number }} · {{ $item->status }}</option>
                    @endforeach
                </select>
                <label class="form-label mt-3" for="employee_comment">Комментарий</label>
                <textarea class="form-control" id="employee_comment" name="employee_comment" rows="3"></textarea>
                <button class="btn btn-primary mt-3" type="submit">Подтвердить</button>
            </form>
        </div>
        <div class="col-lg-5">
            <form class="form-section" method="post" action="{{ route('employee.requests.reject', $requestModel) }}">
                @csrf
                @method('patch')
                <h2 class="h4 fw-bold mb-3">Отклонение</h2>
                <textarea class="form-control" name="employee_comment" rows="5" required placeholder="Укажите причину отказа"></textarea>
                <button class="btn btn-outline-danger mt-3" type="submit">Отклонить заявку</button>
            </form>
        </div>
    </div>
@endif

@if(in_array($requestModel->status, ['approved'], true))
    <form class="form-section" method="post" action="{{ route('employee.requests.issue', $requestModel) }}">
        @csrf
        @method('patch')
        <h2 class="h4 fw-bold mb-3">Фиксация выдачи</h2>
        <p class="text-secondary">После выдачи оборудование перейдет в статус `issued`, а заявка будет считаться активной.</p>
        <button class="btn btn-primary" type="submit">Зафиксировать выдачу</button>
    </form>
@endif

@if(in_array($requestModel->status, ['issued', 'return_requested'], true))
    <form class="form-section" method="post" action="{{ route('employee.requests.return', $requestModel) }}">
        @csrf
        @method('patch')
        <h2 class="h4 fw-bold mb-3">Фиксация возврата</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="storage_location_id">Место хранения</label>
                <select class="form-select" id="storage_location_id" name="storage_location_id" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="condition_after_return">Состояние после возврата</label>
                <select class="form-select" id="condition_after_return" name="condition_after_return" required>
                    <option value="good">good</option>
                    <option value="needs_check">needs_check</option>
                    <option value="broken">broken</option>
                </select>
            </div>
        </div>
        <label class="form-label mt-3" for="comment">Комментарий</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        <button class="btn btn-primary mt-3" type="submit">Завершить возврат</button>
    </form>
@endif
@endsection
