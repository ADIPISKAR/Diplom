@extends('layouts.app', ['title' => 'Проблемные ситуации'])

@section('content')
<h1 class="h2 fw-bold mb-4">Проблемные ситуации</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Тема</th><th>Пользователь</th><th>Оборудование</th><th>Тип</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td>{{ $issue->id }}</td>
                    <td><div class="fw-bold">{{ $issue->title }}</div><div class="text-secondary small">{{ $issue->description }}</div></td>
                    <td>{{ $issue->user?->full_name ?? '—' }}</td>
                    <td>{{ $issue->equipment?->name ?? '—' }}</td>
                    <td>{{ $issue->issue_type }}</td>
                    <td><span class="status-dot status-{{ $issue->status }}"></span>{{ $issue->status }}</td>
                    <td>
                        <form class="d-flex gap-2" method="post" action="{{ route('admin.issues.update', $issue) }}">
                            @csrf
                            @method('patch')
                            <select class="form-select form-select-sm" name="status">
                                @foreach(['open', 'in_progress', 'resolved', 'closed'] as $status)
                                    <option value="{{ $status }}" @selected($issue->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary" type="submit">Сохранить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-secondary">Проблемных ситуаций нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $issues->links() }}
</div>
@endsection
