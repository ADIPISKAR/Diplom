@extends('layouts.app', ['title' => 'Тарифы'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">Тарифы</h1>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="form-section">
            <h2 class="h5">Новый тариф</h2>
            <form method="post" action="{{ route('admin.tariffs.store') }}">
                @csrf
                @include('admin.tariffs.form', ['tariff' => null])
                <button class="btn btn-primary w-100" type="submit">Создать</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        @foreach($tariffs as $tariff)
            <div class="form-section mb-3">
                <form method="post" action="{{ route('admin.tariffs.update', $tariff) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.tariffs.form', ['tariff' => $tariff])
                    <button class="btn btn-outline-primary" type="submit">Сохранить</button>
                </form>
                <form class="mt-2" method="post" action="{{ route('admin.tariffs.destroy', $tariff) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
