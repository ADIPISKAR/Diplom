@extends('layouts.app', ['title' => 'Обращения'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">Проблемные ситуации</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Пользователь</th><th>Тип</th><th>Описание</th><th>Связи</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td>{{ $issue->id }}</td>
                    <td>{{ $issue->user->full_name }}</td>
                    <td>{{ $issue->issue_type }}</td>
                    <td style="max-width: 320px">{{ $issue->description }}</td>
                    <td>
                        аренда: {{ $issue->rental_id ?? '—' }}<br>
                        станция: {{ $issue->station?->name ?? '—' }}<br>
                        повербанк: {{ $issue->powerbank?->serial_number ?? '—' }}
                    </td>
                    <td><span class="status-dot status-{{ $issue->status }}"></span>{{ $issue->status }}</td>
                    <td>
                        <form class="d-flex gap-2" method="post" action="{{ route('admin.issues.update', $issue) }}">
                            @csrf
                            @method('PATCH')
                            <select class="form-select form-select-sm" name="status">
                                @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                    <option value="{{ $status }}" @selected($issue->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary" type="submit">OK</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-secondary">Обращений пока нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $issues->links() }}
</div>
@endsection
