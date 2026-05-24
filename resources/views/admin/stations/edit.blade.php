@extends('layouts.app', ['title' => 'Редактирование станции'])

@section('content')
@include('admin.partials.nav')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Станция #{{ $station->id }}</h1>
            <form method="post" action="{{ route('admin.stations.update', $station) }}">
                @csrf
                @method('PUT')
                @include('admin.stations.form', ['station' => $station])
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
