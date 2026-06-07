<div class="mb-3">
    <label class="form-label" for="name">Название</label>
    <input class="form-control" id="name" name="name" value="{{ old('name', $equipment?->name) }}" required>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="inventory_number">Инвентарный номер</label>
        <input class="form-control" id="inventory_number" name="inventory_number" value="{{ old('inventory_number', $equipment?->inventory_number) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="category_id">Категория</label>
        <select class="form-select" id="category_id" name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $equipment?->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="storage_location_id">Место хранения</label>
        <select class="form-select" id="storage_location_id" name="storage_location_id" required>
            @foreach($locations as $location)
                <option value="{{ $location->id }}" @selected(old('storage_location_id', $equipment?->storage_location_id) == $location->id)>{{ $location->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="technical_condition">Состояние</label>
        <select class="form-select" id="technical_condition" name="technical_condition" required>
            @foreach(['good', 'needs_check', 'broken'] as $condition)
                <option value="{{ $condition }}" @selected(old('technical_condition', $equipment?->technical_condition ?? 'good') === $condition)>{{ $condition }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="status">Статус</label>
        <select class="form-select" id="status" name="status" required>
            @foreach(['available', 'issued', 'returned', 'checking', 'broken', 'lost'] as $status)
                <option value="{{ $status }}" @selected(old('status', $equipment?->status ?? 'available') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-3">
    <label class="form-label" for="description">Описание</label>
    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $equipment?->description) }}</textarea>
</div>

@php
    $specification = $equipment?->specification;
    $softwareRows = old('software_name')
        ? collect(old('software_name'))->map(fn ($name, $index) => [
            'name' => $name,
            'version' => old('software_version')[$index] ?? null,
            'license_type' => old('software_license_type')[$index] ?? null,
            'description' => old('software_description')[$index] ?? null,
        ])
        : collect($equipment?->software ?? []);
    $softwareRows = $softwareRows->values();
@endphp

<div class="soft-panel mt-4">
    <h2 class="h5 fw-bold mb-3">Характеристики ПК или планшета</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="processor">Процессор</label>
            <input class="form-control" id="processor" name="processor" value="{{ old('processor', $specification?->processor) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="ram">Оперативная память</label>
            <input class="form-control" id="ram" name="ram" value="{{ old('ram', $specification?->ram) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="storage">Накопитель</label>
            <input class="form-control" id="storage" name="storage" value="{{ old('storage', $specification?->storage) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="screen_size">Диагональ экрана</label>
            <input class="form-control" id="screen_size" name="screen_size" value="{{ old('screen_size', $specification?->screen_size) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="operating_system">Операционная система</label>
            <input class="form-control" id="operating_system" name="operating_system" value="{{ old('operating_system', $specification?->operating_system) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="battery_condition">Состояние аккумулятора</label>
            <input class="form-control" id="battery_condition" name="battery_condition" value="{{ old('battery_condition', $specification?->battery_condition) }}">
        </div>
    </div>
    <label class="form-label mt-3" for="additional_info">Дополнительная информация</label>
    <textarea class="form-control" id="additional_info" name="additional_info" rows="3">{{ old('additional_info', $specification?->additional_info) }}</textarea>
</div>

<div class="soft-panel mt-4">
    <h2 class="h5 fw-bold mb-3">Установленное программное обеспечение</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Название</th><th>Версия</th><th>Лицензия</th><th>Описание</th></tr></thead>
            <tbody>
            @for($i = 0; $i < max(5, $softwareRows->count() + 2); $i++)
                @php $software = $softwareRows[$i] ?? null; @endphp
                <tr>
                    <td><input class="form-control" name="software_name[]" value="{{ data_get($software, 'name') }}"></td>
                    <td><input class="form-control" name="software_version[]" value="{{ data_get($software, 'version') }}"></td>
                    <td><input class="form-control" name="software_license_type[]" value="{{ data_get($software, 'license_type') }}"></td>
                    <td><input class="form-control" name="software_description[]" value="{{ data_get($software, 'description') }}"></td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">Сохранить</button>
    <a class="btn btn-outline-primary" href="{{ route('admin.equipment.index') }}">Назад</a>
</div>
