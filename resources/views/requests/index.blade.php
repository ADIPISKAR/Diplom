@extends('layouts.app', ['title' => 'Мои заявки'])

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h2 fw-bold mb-1">Мои заявки</h1>
        <div class="text-secondary">История обращений на выдачу оборудования.</div>
    </div>
    <a class="btn btn-primary" href="{{ route('requests.create') }}">Создать заявку</a>
</div>

<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Категория</th><th>Оборудование</th><th>Место</th><th>Статус</th><th>Дата</th><th></th></tr></thead>
            <tbody>
            @forelse($requests as $requestModel)
                <tr>
                    <td>{{ $requestModel->id }}</td>
                    <td>{{ $requestModel->category->name }}</td>
                    <td>{{ $requestModel->equipment?->name ?? 'Подбирается' }}</td>
                    <td>{{ $requestModel->storageLocation?->name ?? 'Не указано' }}</td>
                    <td><span class="status-dot status-{{ $requestModel->status }}"></span>{{ $requestModel->status }}</td>
                    <td>{{ $requestModel->requested_at->format('d.m.Y H:i') }}</td>
                    <td>
                        @if($requestModel->status === 'issued')
                            <form method="post" action="{{ route('requests.return-request', $requestModel) }}">
                                @csrf
                                @method('patch')
                                <button class="btn btn-sm btn-outline-primary" type="submit">Запросить возврат</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-secondary">Заявок пока нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $requests->links() }}
</div>
@endsection
