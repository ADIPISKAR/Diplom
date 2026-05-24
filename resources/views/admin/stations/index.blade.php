@extends('layouts.app', ['title' => 'Админ · Станции'])

@section('content')
@include('admin.partials.nav')
<div class="d-flex justify-content-between align-items-start mb-4">
    <h1 class="h2 mb-0">Станции</h1>
    <a class="btn btn-primary" href="{{ route('admin.stations.create') }}">Добавить станцию</a>
</div>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Название</th><th>Локация</th><th>QR</th><th>Слоты</th><th>Повербанки</th><th>Статус</th><th></th></tr></thead>
            <tbody>
            @foreach($stations as $station)
                <tr>
                    <td>{{ $station->id }}</td>
                    <td>{{ $station->name }}</td>
                    <td>{{ $station->building }}, {{ $station->floor }}</td>
                    <td>{{ $station->qr_code }}</td>
                    <td>{{ $station->slots_count }}</td>
                    <td>{{ $station->available_powerbanks_count }}/{{ $station->powerbanks_count }}</td>
                    <td><span class="status-dot status-{{ $station->status }}"></span>{{ $station->status }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.stations.slots', $station) }}">Слоты</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.stations.edit', $station) }}">Изменить</a>
                            <form method="post" action="{{ route('admin.stations.destroy', $station) }}">
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
    {{ $stations->links() }}
</div>
@endsection
