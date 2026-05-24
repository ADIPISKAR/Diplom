@extends('layouts.app', ['title' => 'Платежи'])

@section('content')
<h1 class="h2 mb-4">Платежи</h1>
<div class="form-section">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Аренда</th><th>Метод</th><th>Статус</th><th>Сумма</th><th>Дата</th></tr></thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>#{{ $payment->rental_id }} · {{ $payment->rental->powerbank->serial_number }}</td>
                    <td>{{ $payment->paymentMethod->name }}</td>
                    <td><span class="status-dot status-{{ $payment->status }}"></span>{{ $payment->status }}</td>
                    <td>{{ number_format((float) $payment->amount, 2, ',', ' ') }} руб.</td>
                    <td>{{ $payment->paid_at?->format('d.m.Y H:i') ?? $payment->created_at?->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-secondary">Платежей пока нет.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $payments->links() }}
</div>
@endsection
