@extends('layouts.app', ['title' => 'Новая станция'])

@section('content')
@include('admin.partials.nav')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Новая станция</h1>
            <form method="post" action="{{ route('admin.stations.store') }}">
                @csrf
                @include('admin.stations.form', ['station' => null])
                <button class="btn btn-primary" type="submit">Создать</button>
            </form>
        </div>
    </div>
</div>
@endsection
