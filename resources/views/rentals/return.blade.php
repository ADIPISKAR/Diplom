@extends('layouts.app', ['title' => 'Возврат повербанка'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-section">
            <h1 class="h3 mb-3">Возврат повербанка</h1>
            <div class="row g-3 mb-3">
                <div class="col-md-4"><div class="text-secondary small">Аренда</div><div class="fw-semibold">#{{ $rental->id }}</div></div>
                <div class="col-md-4"><div class="text-secondary small">Повербанк</div><div class="fw-semibold">{{ $rental->powerbank->serial_number }}</div></div>
                <div class="col-md-4"><div class="text-secondary small">Тариф</div><div class="fw-semibold">{{ $rental->tariff->name }}</div></div>
            </div>
            <form method="post" action="{{ route('rentals.return.store', $rental) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="station_id">Станция возврата</label>
                    <select class="form-select" id="station_id" name="station_id" required>
                        @foreach($stations as $station)
                            <option value="{{ $station->id }}" @disabled($station->empty_slots_count < 1)>
                                {{ $station->name }} · свободных слотов: {{ $station->empty_slots_count }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="comment">Комментарий</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                </div>
                <button class="btn btn-primary w-100" type="submit">Подтвердить возврат и оплату</button>
            </form>
        </div>
    </div>
</div>
@endsection
