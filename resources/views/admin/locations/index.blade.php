@extends('layouts.app', ['title' => 'Места хранения'])

@section('content')
<h1 class="h2 fw-bold mb-4">Места хранения</h1>
<form class="form-section mb-4" method="post" action="{{ route('admin.locations.store') }}">
    @csrf
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Название</label><input class="form-control" name="name" required></div>
        <div class="col-md-3"><label class="form-label">Тип</label><select class="form-select" name="location_type">@foreach(['library','coworking','classroom','department','employee'] as $type)<option value="{{ $type }}">{{ $type }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Корпус</label><input class="form-control" name="building"></div>
        <div class="col-md-2"><label class="form-label">Кабинет</label><input class="form-control" name="room"></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100" type="submit">Добавить</button></div>
    </div>
    <div class="form-check mt-3"><input class="form-check-input" name="is_active" type="checkbox" value="1" checked><label class="form-check-label">Активно</label></div>
</form>

<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Название</th><th>Тип</th><th>Корпус</th><th>Кабинет</th><th>Единиц</th><th>Активно</th><th></th></tr></thead>
            <tbody>
            @foreach($locations as $location)
                <tr>
                    <form method="post" action="{{ route('admin.locations.update', $location) }}">
                        @csrf
                        @method('put')
                        <td><input class="form-control" name="name" value="{{ $location->name }}" required></td>
                        <td><select class="form-select" name="location_type">@foreach(['library','coworking','classroom','department','employee'] as $type)<option value="{{ $type }}" @selected($location->location_type === $type)>{{ $type }}</option>@endforeach</select></td>
                        <td><input class="form-control" name="building" value="{{ $location->building }}"></td>
                        <td><input class="form-control" name="room" value="{{ $location->room }}"></td>
                        <td>{{ $location->equipment_count }}</td>
                        <td><input class="form-check-input" name="is_active" type="checkbox" value="1" @checked($location->is_active)></td>
                        <td><button class="btn btn-sm btn-outline-primary" type="submit">Сохранить</button></td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
