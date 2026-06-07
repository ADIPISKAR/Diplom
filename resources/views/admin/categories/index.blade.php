@extends('layouts.app', ['title' => 'Категории оборудования'])

@section('content')
<h1 class="h2 fw-bold mb-4">Категории оборудования</h1>
<div class="row g-4">
    <div class="col-lg-5">
        <form class="form-section" method="post" action="{{ route('admin.categories.store') }}">
            @csrf
            <h2 class="h4 fw-bold mb-3">Новая категория</h2>
            <label class="form-label" for="name">Название</label>
            <input class="form-control" id="name" name="name" required>
            <label class="form-label mt-3" for="description">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            <div class="form-check mt-3">
                <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" checked>
                <label class="form-check-label" for="is_active">Активна</label>
            </div>
            <button class="btn btn-primary mt-3" type="submit">Добавить</button>
        </form>
    </div>
    <div class="col-lg-7">
        <div class="form-section">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Название</th><th>Устройств</th><th>Активна</th><th></th></tr></thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <form method="post" action="{{ route('admin.categories.update', $category) }}">
                                @csrf
                                @method('put')
                                <td><input class="form-control" name="name" value="{{ $category->name }}" required></td>
                                <td>{{ $category->equipment_count }}</td>
                                <td><input class="form-check-input" name="is_active" type="checkbox" value="1" @checked($category->is_active)></td>
                                <td class="text-end"><button class="btn btn-sm btn-outline-primary" type="submit">Сохранить</button></td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
