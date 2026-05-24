@extends('layouts.app', ['title' => $title])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">{{ $title }}</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Пользователь</th><th>Повербанк</th><th>Старт</th><th>Возврат</th><th>Статус</th><th>Сумма</th></tr></thead>
            <tbody>
            @forelse($rentals as $rental)
                <tr>
                    <td>{{ $rental->id }}</td>
                    <td>{{ $rental->user->full_name }}</td>
                    <td>{{ $rental->powerbank->serial_number }}</td>
                    <td>{{ $rental->startStation->name }}<br><span class="text-secondary small">{{ $rental->started_at->format('d.m.Y H:i') }}</span></td>
                    <td>{{ $rental->returnStation?->name ?? '—' }}<br><span class="text-secondary small">{{ $rental->ended_at?->format('d.m.Y H:i') ?? '' }}</span></td>
                    <td><span class="status-dot status-{{ $rental->status }}"></span>{{ $rental->status }}</td>
                    <td>{{ number_format((float) $rental->total_price, 2, ',', ' ') }} руб.</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-secondary">Записей нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $rentals->links() }}
</div>
@endsection
