@extends('layouts.app', ['title' => 'Редактирование повербанка'])

@section('content')
@include('admin.partials.nav')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="form-section">
            <h1 class="h3 mb-3">Повербанк #{{ $powerbank->id }}</h1>
            <form method="post" action="{{ route('admin.powerbanks.update', $powerbank) }}">
                @csrf
                @method('PUT')
                @include('admin.powerbanks.form', ['powerbank' => $powerbank])
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
