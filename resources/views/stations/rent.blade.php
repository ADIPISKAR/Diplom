@extends('layouts.app', ['title' => 'Оформление аренды'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Оформление аренды</h1>
            <div class="mb-3">
                <div class="text-secondary small">Станция</div>
                <div class="fw-semibold">{{ $station->name }} · {{ $station->building }}, этаж {{ $station->floor }}</div>
            </div>
            <div class="mb-3">
                <div class="text-secondary small">Доступных повербанков</div>
                <div class="fw-semibold">{{ $station->available_powerbanks_count }}</div>
            </div>
            @if($tariff)
                <div class="bg-light rounded-2 p-3 mb-3">
                    <div class="fw-semibold">{{ $tariff->name }}</div>
                    <div class="text-secondary">30 мин: {{ $tariff->price_per_30_min }} руб. · час: {{ $tariff->price_per_hour }} руб. · сутки: {{ $tariff->price_per_day }} руб.</div>
                </div>
            @endif
            <form method="post" action="{{ route('rentals.store', $station) }}">
                @csrf
                <button class="btn btn-primary w-100" type="submit" @disabled(! $tariff || ! $station->available_powerbanks_count)>Начать аренду</button>
            </form>
        </div>
    </div>
</div>
@endsection
