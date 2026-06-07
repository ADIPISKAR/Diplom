@extends('layouts.app', ['title' => 'Отчёты'])

@section('content')
<h1 class="h2 fw-bold mb-4">Отчёты и сводка</h1>
<div class="row g-3 mb-4">
    @foreach($summary as $label => $value)
        <div class="col-md-3"><div class="form-section metric"><div class="metric-label">{{ $label }}</div><div class="metric-value">{{ $value }}</div></div></div>
    @endforeach
</div>

<form class="form-section mb-4" method="post" action="{{ route('admin.reports.store') }}">
    @csrf
    <h2 class="h4 fw-bold mb-3">Сформировать запись отчёта</h2>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label" for="report_type">Тип</label>
            <select class="form-select" id="report_type" name="report_type">
                @foreach(['requests', 'issued', 'returns', 'issues', 'categories', 'locations', 'equipment'] as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3"><label class="form-label">Начало</label><input class="form-control" type="date" name="period_start" required></div>
        <div class="col-md-3"><label class="form-label">Конец</label><input class="form-control" type="date" name="period_end" required></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100" type="submit">Создать</button></div>
    </div>
</form>

<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Тип</th><th>Период</th><th>Администратор</th><th>Дата</th></tr></thead>
            <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->report_type }}</td>
                    <td>{{ $report->period_start }} — {{ $report->period_end }}</td>
                    <td>{{ $report->admin->full_name }}</td>
                    <td>{{ $report->created_at?->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">Отчёты пока не создавались.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $reports->links() }}
</div>
@endsection
