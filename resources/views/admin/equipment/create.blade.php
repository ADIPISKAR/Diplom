@extends('layouts.app', ['title' => 'Новое оборудование'])

@section('content')
<div class="form-section">
    <h1 class="h3 fw-bold mb-3">Новое оборудование</h1>
    <form method="post" action="{{ route('admin.equipment.store') }}">
        @csrf
        @include('admin.equipment.form', ['equipment' => null])
    </form>
</div>
@endsection
