<div class="mb-3">
    <label class="form-label" for="name_{{ $tariff?->id ?? 'new' }}">Название</label>
    <input class="form-control" id="name_{{ $tariff?->id ?? 'new' }}" name="name" value="{{ old('name', $tariff?->name) }}" required>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label" for="price30_{{ $tariff?->id ?? 'new' }}">30 минут</label>
        <input class="form-control" id="price30_{{ $tariff?->id ?? 'new' }}" name="price_per_30_min" type="number" step="0.01" min="0" value="{{ old('price_per_30_min', $tariff?->price_per_30_min ?? 30) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="pricehour_{{ $tariff?->id ?? 'new' }}">Час</label>
        <input class="form-control" id="pricehour_{{ $tariff?->id ?? 'new' }}" name="price_per_hour" type="number" step="0.01" min="0" value="{{ old('price_per_hour', $tariff?->price_per_hour ?? 50) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="priceday_{{ $tariff?->id ?? 'new' }}">Сутки</label>
        <input class="form-control" id="priceday_{{ $tariff?->id ?? 'new' }}" name="price_per_day" type="number" step="0.01" min="0" value="{{ old('price_per_day', $tariff?->price_per_day ?? 250) }}" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="description_{{ $tariff?->id ?? 'new' }}">Описание</label>
    <textarea class="form-control" id="description_{{ $tariff?->id ?? 'new' }}" name="description" rows="2">{{ old('description', $tariff?->description) }}</textarea>
</div>
<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" id="is_active_{{ $tariff?->id ?? 'new' }}" name="is_active" value="1" @checked(old('is_active', $tariff?->is_active ?? true))>
    <label class="form-check-label" for="is_active_{{ $tariff?->id ?? 'new' }}">Активен</label>
</div>
