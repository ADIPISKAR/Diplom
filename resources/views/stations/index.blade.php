@extends('layouts.app', ['title' => 'Станции'])

@section('content')
<section class="soft-panel mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-lg-8">
            <h1 class="h2 fw-bold mb-2">Станции выдачи и возврата</h1>
            <p class="text-secondary mb-0">Выберите активную станцию, проверьте количество доступных повербанков и оформите аренду. QR-код станции хранится в карточке и может использоваться для быстрого поиска.</p>
        </div>
        <div class="col-lg-4">
            <div class="feature-tile">
                <div class="metric-label">Подсказка</div>
                <div class="text-secondary">Для аренды нужен доступный повербанк со статусом `available` и состоянием `good`.</div>
            </div>
        </div>
    </div>
</section>

<div class="row g-3">
    @forelse($stations as $station)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between gap-2 mb-2">
                        <div>
                            <h2 class="h5 fw-bold mb-1">{{ $station->name }}</h2>
                            <div class="text-secondary small">{{ $station->building }}, этаж {{ $station->floor }}</div>
                        </div>
                        <span class="status-badge"><span class="status-dot status-{{ $station->status }}"></span>{{ $station->status }}</span>
                    </div>
                    <p class="text-secondary flex-grow-1">{{ $station->location_description ?: 'Описание расположения станции не указано.' }}</p>
                    <div class="row g-2 mb-3">
                        <div class="col-6"><div class="feature-tile p-3"><div class="metric-label">Доступно</div><div class="h4 fw-bold mb-0">{{ $station->available_powerbanks_count }}</div></div></div>
                        <div class="col-6"><div class="feature-tile p-3"><div class="metric-label">Слоты</div><div class="h4 fw-bold mb-0">{{ $station->slots_count }}</div></div></div>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-primary flex-fill" href="{{ route('stations.show', $station) }}">Открыть</a>
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
