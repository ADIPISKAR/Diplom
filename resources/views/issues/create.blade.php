@extends('layouts.app', ['title' => 'Создать обращение'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-section">
            <h1 class="h3 mb-3">Проблемная ситуация</h1>
            <form method="post" action="{{ route('issues.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="issue_type">Тип проблемы</label>
                        <select class="form-select" id="issue_type" name="issue_type" required>
                            @foreach(['station_error' => 'Ошибка станции', 'powerbank_not_returned' => 'Повербанк не возвращён', 'payment_error' => 'Ошибка оплаты', 'broken_powerbank' => 'Неисправный повербанк', 'slot_error' => 'Ошибка слота', 'other' => 'Другое'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('issue_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="rental_id">Аренда</label>
                        <select class="form-select" id="rental_id" name="rental_id">
                            <option value="">Не привязывать</option>
                            @foreach($rentals as $rental)
                                <option value="{{ $rental->id }}" @selected(old('rental_id') == $rental->id)>#{{ $rental->id }} · {{ $rental->started_at->format('d.m.Y H:i') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="station_id">Станция</label>
                        <select class="form-select" id="station_id" name="station_id">
                            <option value="">Не выбрана</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}" @selected(old('station_id') == $station->id)>{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="powerbank_id">Повербанк</label>
                        <select class="form-select" id="powerbank_id" name="powerbank_id">
                            <option value="">Не выбран</option>
                            @foreach($powerbanks as $powerbank)
                                <option value="{{ $powerbank->id }}" @selected(old('powerbank_id') == $powerbank->id)>{{ $powerbank->serial_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">Отправить</button>
            </form>
        </div>
    </div>
</div>
@endsection
