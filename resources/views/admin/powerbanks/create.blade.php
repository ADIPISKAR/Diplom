@extends('layouts.app', ['title' => 'Новый повербанк'])

@section('content')
@include('admin.partials.nav')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Новый повербанк</h1>
            <form method="post" action="{{ route('admin.powerbanks.store') }}">
                @csrf
                @include('admin.powerbanks.form', ['powerbank' => null])
                <button class="btn btn-primary" type="submit">Создать</button>
            </form>
        </div>
    </div>
</div>
@endsection
