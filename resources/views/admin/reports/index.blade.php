@extends('layouts.app', ['title' => 'Отчёты'])

@section('content')
@include('admin.partials.nav')
<h1 class="h2 mb-4">Отчёты</h1>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="form-section">
            <h2 class="h5">Создать отчёт</h2>
            <form method="post" action="{{ route('admin.reports.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="report_type">Тип</label>
                    <select class="form-select" id="report_type" name="report_type" required>
                        @foreach(['rentals', 'payments', 'returns', 'issues', 'stations', 'powerbanks'] as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="period_start">Начало периода</label>
                    <input class="form-control" id="period_start" name="period_start" type="date" value="{{ now()->startOfMonth()->toDateString() }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="period_end">Конец периода</label>
                    <input class="form-control" id="period_end" name="period_end" type="date" value="{{ now()->toDateString() }}" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Создать</button>
            </form>
        </div>
        <div class="form-section mt-3">
            <h2 class="h5">Сводка</h2>
            @foreach($summary as $name => $value)
                <div class="d-flex justify-content-between border-top py-2"><span>{{ $name }}</span><span class="fw-semibold">{{ is_numeric($value) ? number_format((float) $value, 0, ',', ' ') : $value }}</span></div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-8">
        <div class="form-section">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>#</th><th>Тип</th><th>Период</th><th>Администратор</th><th>Создан</th></tr></thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->report_type }}</td>
                            <td>{{ $report->period_start->format('d.m.Y') }} — {{ $report->period_end->format('d.m.Y') }}</td>
                            <td>{{ $report->admin->full_name }}</td>
                            <td>{{ $report->created_at?->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-secondary">Отчётов пока нет.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
