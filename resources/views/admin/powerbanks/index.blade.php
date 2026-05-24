@extends('layouts.app', ['title' => 'Повербанки'])

@section('content')
@include('admin.partials.nav')
<div class="d-flex justify-content-between align-items-start mb-4">
    <h1 class="h2 mb-0">Повербанки</h1>
    <a class="btn btn-primary" href="{{ route('admin.powerbanks.create') }}">Добавить повербанк</a>
</div>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Серийный номер</th><th>Станция</th><th>Слот</th><th>Заряд</th><th>Статус</th><th>Состояние</th><th></th></tr></thead>
            <tbody>
            @foreach($powerbanks as $powerbank)
                <tr>
                    <td>{{ $powerbank->id }}</td>
                    <td>{{ $powerbank->serial_number }}</td>
                    <td>{{ $powerbank->station?->name ?? '—' }}</td>
                    <td>{{ $powerbank->slot?->slot_number ?? '—' }}</td>
                    <td>{{ $powerbank->charge_level }}%</td>
                    <td><span class="status-dot status-{{ $powerbank->status }}"></span>{{ $powerbank->status }}</td>
                    <td>{{ $powerbank->condition }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.powerbanks.edit', $powerbank) }}">Изменить</a>
                            <form method="post" action="{{ route('admin.powerbanks.destroy', $powerbank) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $powerbanks->links() }}
</div>
@endsection
