@extends('layouts.app', ['title' => 'Возвраты'])

@section('content')
<h1 class="h2 fw-bold mb-4">Возвраты оборудования</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Заявка</th><th>Пользователь</th><th>Оборудование</th><th>Сотрудник</th><th>Место</th><th>Дата</th><th>Состояние</th></tr></thead>
            <tbody>
            @forelse($returns as $return)
                <tr>
                    <td>{{ $return->id }}</td>
                    <td>#{{ $return->request_id }}</td>
                    <td>{{ $return->user->full_name }}</td>
                    <td>{{ $return->equipment->name }}</td>
                    <td>{{ $return->employee->full_name }}</td>
                    <td>{{ $return->storageLocation->name }}</td>
                    <td>{{ $return->returned_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $return->condition_after_return }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-secondary">Возвратов нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $returns->links() }}
</div>
@endsection
