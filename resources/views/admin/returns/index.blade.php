@extends('layouts.app', ['title' => 'Возвраты'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">Возвраты</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Аренда</th><th>Пользователь</th><th>Повербанк</th><th>Станция</th><th>Слот</th><th>Дата</th><th>Статус</th></tr></thead>
            <tbody>
            @forelse($returns as $return)
                <tr>
                    <td>{{ $return->id }}</td>
                    <td>#{{ $return->rental_id }}</td>
                    <td>{{ $return->user->full_name }}</td>
                    <td>{{ $return->powerbank->serial_number }}</td>
                    <td>{{ $return->station->name }}</td>
                    <td>{{ $return->slot->slot_number }}</td>
                    <td>{{ $return->returned_at->format('d.m.Y H:i') }}</td>
                    <td><span class="status-dot status-{{ $return->status }}"></span>{{ $return->status }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-secondary">Возвратов пока нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $returns->links() }}
</div>
@endsection
