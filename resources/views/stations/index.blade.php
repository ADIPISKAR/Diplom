@extends('layouts.app', ['title' => 'Станции'])

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h2 mb-1">Станции</h1>
        <div class="text-secondary">Доступные точки выдачи и возврата повербанков.</div>
    </div>
</div>

<div class="row g-3">
    @forelse($stations as $station)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-2">
                        <h2 class="h5 mb-1">{{ $station->name }}</h2>
                        <span class="badge text-bg-light"><span class="status-dot status-{{ $station->status }}"></span>{{ $station->status }}</span>
                    </div>
                    <div class="text-secondary mb-3">{{ $station->building }}, этаж {{ $station->floor }}</div>
                    <div class="row g-2 mb-3">
                        <div class="col-6"><div class="bg-light rounded-2 p-2"><div class="fw-semibold">{{ $station->available_powerbanks_count }}</div><div class="small text-secondary">доступно</div></div></div>
                        <div class="col-6"><div class="bg-light rounded-2 p-2"><div class="fw-semibold">{{ $station->slots_count }}</div><div class="small text-secondary">слотов</div></div></div>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-secondary flex-fill" href="{{ route('stations.show', $station) }}">Открыть</a>
                        <a class="btn btn-primary flex-fill {{ $station->available_powerbanks_count ? '' : 'disabled' }}" href="{{ route('rentals.create', $station) }}">Аренда</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="form-section text-secondary">Станции ещё не добавлены.</div></div>
    @endforelse
</div>
@endsection
