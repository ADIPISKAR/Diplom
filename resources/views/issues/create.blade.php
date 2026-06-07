@extends('layouts.app', ['title' => 'Проблемная ситуация'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Сообщить о проблемной ситуации</h1>
    <p class="text-secondary mb-0">Обращение может быть связано с заявкой, оборудованием, неисправностью, задержкой возврата или ошибочным статусом.</p>
</section>

<form class="form-section" method="post" action="{{ route('issues.store') }}">
    @csrf
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="equipment_request_id">Заявка</label>
            <select class="form-select" id="equipment_request_id" name="equipment_request_id">
                <option value="">Не связано с заявкой</option>
                @foreach($requests as $requestModel)
                    <option value="{{ $requestModel->id }}" @selected(old('equipment_request_id') == $requestModel->id)>#{{ $requestModel->id }} · {{ $requestModel->status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="equipment_id">Оборудование</label>
            <select class="form-select" id="equipment_id" name="equipment_id">
                <option value="">Не выбрано</option>
                @foreach($equipment as $item)
                    <option value="{{ $item->id }}" @selected(old('equipment_id') == $item->id)>{{ $item->name }} · {{ $item->inventory_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="issue_type">Тип проблемы</label>
            <select class="form-select" id="issue_type" name="issue_type" required>
                @foreach(['broken_equipment' => 'Неисправность', 'late_return' => 'Задержка возврата', 'wrong_status' => 'Ошибочный статус', 'lost_equipment' => 'Потеря устройства', 'other' => 'Другое'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('issue_type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="title">Тема</label>
            <input class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label" for="description">Описание</label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
    </div>
    <button class="btn btn-primary mt-4" type="submit">Создать обращение</button>
</form>
@endsection
