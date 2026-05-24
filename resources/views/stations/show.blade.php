@extends('layouts.app', ['title' => $station->name])

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="h2 mb-1">{{ $station->name }}</h1>
        <div class="text-secondary">{{ $station->building }}, этаж {{ $station->floor }} · QR: {{ $station->qr_code }}</div>
    </div>
    <a class="btn btn-primary" href="{{ route('rentals.create', $station) }}">Оформить аренду</a>
</div>

<div class="form-section mb-4">
    <div class="row g-3">
        <div class="col-md-4"><div class="text-secondary small">Описание</div><div>{{ $station->location_description ?: 'Не указано' }}</div></div>
        <div class="col-md-4"><div class="text-secondary small">Статус</div><div><span class="status-dot status-{{ $station->status }}"></span>{{ $station->status }}</div></div>
        <div class="col-md-4"><div class="text-secondary small">Доступные повербанки</div><div>{{ $station->availablePowerbanks->count() }}</div></div>
    </div>
</div>

<div class="form-section">
    <h2 class="h5">Слоты станции</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Слот</th><th>Статус</th><th>Повербанк</th><th>Заряд</th></tr></thead>
            <tbody>
            @foreach($station->slots->sortBy('slot_number') as $slot)
                <tr>
                    <td>{{ $slot->slot_number }}</td>
                    <td><span class="status-dot status-{{ $slot->status }}"></span>{{ $slot->status }}</td>
                    <td>{{ $slot->powerbank?->serial_number ?? '—' }}</td>
                    <td>{{ $slot->powerbank ? $slot->powerbank->charge_level.'%' : '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
