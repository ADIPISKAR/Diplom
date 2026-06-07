@extends('layouts.app', ['title' => 'Создание заявки'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Заявка на выдачу оборудования</h1>
    <p class="text-secondary mb-0">Выберите категорию, место получения и при необходимости конкретное доступное устройство.</p>
</section>

<form class="form-section" method="post" action="{{ route('requests.store') }}">
    @csrf
    @if($equipment)
        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
        <input type="hidden" name="category_id" value="{{ $equipment->category_id }}">
        <input type="hidden" name="storage_location_id" value="{{ $equipment->storage_location_id }}">
        <div class="feature-tile mb-3">
            <div class="metric-label">Выбранное оборудование</div>
            <div class="h5 mb-1">{{ $equipment->name }}</div>
            <div class="text-secondary">{{ $equipment->category->name }} · {{ $equipment->storageLocation->name }}</div>
        </div>
    @else
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="category_id">Категория</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="storage_location_id">Предпочитаемое место получения</label>
                <select class="form-select" id="storage_location_id" name="storage_location_id">
                    <option value="">Любое доступное</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('storage_location_id') == $location->id)>{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="mt-3">
        <label class="form-label" for="user_comment">Комментарий</label>
        <textarea class="form-control" id="user_comment" name="user_comment" rows="4">{{ old('user_comment') }}</textarea>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Отправить заявку</button>
        <a class="btn btn-outline-primary" href="{{ route('equipment.index') }}">К оборудованию</a>
    </div>
</form>
@endsection
