@extends('layouts.app', ['title' => 'Слоты станции'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-1">Слоты станции</h1>
<div class="text-secondary mb-4">{{ $station->name }}</div>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Слот</th><th>Текущий статус</th><th>Повербанк</th><th>Изменить</th></tr></thead>
            <tbody>
            @foreach($station->slots->sortBy('slot_number') as $slot)
                <tr>
                    <td>{{ $slot->slot_number }}</td>
                    <td><span class="status-dot status-{{ $slot->status }}"></span>{{ $slot->status }}</td>
                    <td>{{ $slot->powerbank?->serial_number ?? '—' }}</td>
                    <td>
                        <form class="d-flex gap-2" method="post" action="{{ route('admin.stations.slots.update', [$station, $slot]) }}">
                            @csrf
                            @method('PATCH')
                            <select class="form-select form-select-sm" name="status">
                                @foreach(['empty', 'occupied', 'blocked', 'maintenance'] as $status)
                                    <option value="{{ $status }}" @selected($slot->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary" type="submit">OK</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
