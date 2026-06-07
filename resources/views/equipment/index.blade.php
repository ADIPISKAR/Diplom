@extends('layouts.app', ['title' => 'Оборудование'])

@section('content')
<section class="soft-panel mb-4">
    <h1 class="h2 fw-bold mb-2">Реестр оборудования</h1>
    <p class="text-secondary mb-0">В списке отображаются ноутбуки, планшеты и портативные зарядные устройства, которые используются для самоподготовки студентов.</p>
</section>

<form class="form-section mb-4" method="get" action="{{ route('equipment.index') }}">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label" for="category_id">Категория</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" id="available" type="checkbox" name="available" value="1" @checked($availableOnly)>
                <label class="form-check-label" for="available">Показать только доступное</label>
            </div>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" type="submit">Применить</button>
        </div>
    </div>
</form>

<div class="row g-3">
    @forelse($equipment as $item)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between gap-2 mb-2">
                        <div>
                            <h2 class="h5 fw-bold mb-1">{{ $item->name }}</h2>
                            <div class="text-secondary small">{{ $item->inventory_number }}</div>
                        </div>
                        <span class="status-badge"><span class="status-dot status-{{ $item->status }}"></span>{{ $item->status }}</span>
                    </div>
                    <p class="text-secondary flex-grow-1">{{ $item->description ?: 'Описание оборудования не указано.' }}</p>
                    <div class="feature-tile p-3 mb-3">
                        <div class="metric-label">Категория и место</div>
                        <div>{{ $item->category->name }}</div>
                        <div class="text-secondary small">{{ $item->storageLocation->name }}</div>
                        @if($item->specification?->operating_system)
                            <div class="text-secondary small">ОС: {{ $item->specification->operating_system }}</div>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-primary flex-fill" href="{{ route('equipment.show', $item) }}">Открыть</a>
                        <a class="btn btn-primary flex-fill {{ $item->isAvailable() ? '' : 'disabled' }}" href="{{ route('requests.create', ['equipment_id' => $item->id]) }}">Заявка</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="form-section text-secondary">Оборудование не найдено.</div></div>
    @endforelse
</div>

<div class="mt-4">{{ $equipment->links() }}</div>
@endsection
