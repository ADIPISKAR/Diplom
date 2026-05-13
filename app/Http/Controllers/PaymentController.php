<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'rental_id' => ['required', 'exists:rentals,id', 'unique:payments,rental_id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:paid,pending,failed'],
        ]);

        Payment::create([
            ...$data,
            'payment_time' => Carbon::now(),
        ]);

        $rental = Rental::findOrFail($data['rental_id']);
        if ($data['status'] === 'paid' && $rental->status === 'active') {
            $rental->update(['status' => 'completed', 'end_time' => Carbon::now()]);
            $rental->powerbank->update(['status' => 'available']);
        }

        return $this->respond($request, 'Платеж сохранен.');
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:paid,pending,failed'],
        ]));

        return $this->respond($request, 'Платеж обновлен.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return $this->respond(request(), 'Платеж удален.');
    }
}
