<div class="mb-3">
    <label class="form-label" for="name">Название</label>
    <input class="form-control" id="name" name="name" value="{{ old('name', $station?->name) }}" required>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="building">Корпус</label>
        <input class="form-control" id="building" name="building" value="{{ old('building', $station?->building) }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="floor">Этаж</label>
        <input class="form-control" id="floor" name="floor" value="{{ old('floor', $station?->floor) }}" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="location_description">Описание локации</label>
    <textarea class="form-control" id="location_description" name="location_description" rows="3">{{ old('location_description', $station?->location_description) }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="qr_code">QR-код</label>
        <input class="form-control" id="qr_code" name="qr_code" value="{{ old('qr_code', $station?->qr_code) }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label" for="total_slots">Слоты</label>
        <input class="form-control" id="total_slots" name="total_slots" type="number" min="1" max="100" value="{{ old('total_slots', $station?->total_slots ?? 6) }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label" for="status">Статус</label>
        <select class="form-select" id="status" name="status" required>
            @foreach(['active', 'inactive', 'maintenance'] as $status)
                <option value="{{ $status }}" @selected(old('status', $station?->status ?? 'active') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
</div>
