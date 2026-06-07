@extends('layouts.app', ['title' => 'Оборудование'])

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4">
    <h1 class="h2 fw-bold mb-0">Оборудование</h1>
    <a class="btn btn-primary" href="{{ route('admin.equipment.create') }}">Добавить оборудование</a>
</div>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Название</th><th>Инв. номер</th><th>Категория</th><th>Место</th><th>ОС</th><th>Статус</th><th>Состояние</th><th></th></tr></thead>
            <tbody>
            @forelse($equipment as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->inventory_number }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->storageLocation->name }}</td>
                    <td>{{ $item->specification?->operating_system ?? '—' }}</td>
                    <td><span class="status-dot status-{{ $item->status }}"></span>{{ $item->status }}</td>
                    <td>{{ $item->technical_condition }}</td>
                    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.equipment.edit', $item) }}">Изменить</a></td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-secondary">Оборудование не добавлено.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $equipment->links() }}
</div>
@endsection
