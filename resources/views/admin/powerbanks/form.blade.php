<div class="mb-3">
    <label class="form-label" for="serial_number">Серийный номер</label>
    <input class="form-control" id="serial_number" name="serial_number" value="{{ old('serial_number', $powerbank?->serial_number) }}" required>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="station_id">Станция</label>
        <select class="form-select" id="station_id" name="station_id">
            <option value="">Без станции</option>
            @foreach($stations as $station)
                <option value="{{ $station->id }}" @selected(old('station_id', $powerbank?->station_id) == $station->id)>{{ $station->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="slot_id">Слот</label>
        <select class="form-select" id="slot_id" name="slot_id">
            <option value="">Без слота</option>
            @foreach($slots as $slot)
                <option value="{{ $slot->id }}" @selected(old('slot_id', $powerbank?->slot_id) == $slot->id)>
                    {{ $slot->station->name }} · слот {{ $slot->slot_number }} · {{ $slot->status }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label" for="charge_level">Заряд</label>
        <input class="form-control" id="charge_level" name="charge_level" type="number" min="0" max="100" value="{{ old('charge_level', $powerbank?->charge_level ?? 100) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="status">Статус</label>
        <select class="form-select" id="status" name="status" required>
            @foreach(['available', 'rented', 'maintenance', 'broken', 'lost'] as $status)
                <option value="{{ $status }}" @selected(old('status', $powerbank?->status ?? 'available') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="condition">Состояние</label>
        <select class="form-select" id="condition" name="condition" required>
            @foreach(['good', 'needs_service', 'damaged'] as $condition)
                <option value="{{ $condition }}" @selected(old('condition', $powerbank?->condition ?? 'good') === $condition)>{{ $condition }}</option>
            @endforeach
        </select>
    </div>
</div>
