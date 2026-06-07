@extends('layouts.app', ['title' => 'Журнал действий'])

@section('content')
<h1 class="h2 fw-bold mb-4">Журнал действий</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Дата</th><th>Пользователь</th><th>Действие</th><th>Описание</th></tr></thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at?->format('d.m.Y H:i:s') }}</td>
                    <td>{{ $log->user?->full_name ?? 'Система' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-secondary">Журнал пока пуст.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $logs->links() }}
</div>
@endsection
