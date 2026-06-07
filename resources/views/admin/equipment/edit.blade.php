@extends('layouts.app', ['title' => 'Оборудование #'.$equipment->id])

@section('content')
<div class="form-section">
    <h1 class="h3 fw-bold mb-3">{{ $equipment->name }}</h1>
    <form method="post" action="{{ route('admin.equipment.update', $equipment) }}">
        @csrf
        @method('put')
        @include('admin.equipment.form', ['equipment' => $equipment])
    </form>
</div>
@endsection
