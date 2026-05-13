<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SimulationController extends Controller
{
    public function store(Request $request)
    {
        $action = $request->validate([
            'action' => ['required', 'in:rent,return,pay,report_error'],
        ])['action'];

        return match ($action) {
            'rent' => $this->rent($request),
            'return' => $this->returnRental($request),
            'pay' => $this->pay($request),
            'report_error' => $this->reportError($request),
        };
    }

    private function rent(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'powerbank_id' => ['required', 'exists:powerbanks,id'],
            'tariff_id' => ['nullable', 'exists:tariffs,id'],
        ]);

        $powerbank = Powerbank::findOrFail($data['powerbank_id']);

        if ($powerbank->status !== 'available') {
            return redirect()->route('dashboard')->withErrors('Симуляция: выбранный повербанк уже недоступен.');
        }

        Rental::create([
            ...$data,
            'start_time' => Carbon::now(),
            'status' => 'active',
        ]);

        $powerbank->update(['status' => 'rented']);

        return redirect()->route('dashboard')->with('success', 'Симуляция: пользователь начал аренду.');
    }

    private function returnRental(Request $request)
    {
        $data = $request->validate([
            'rental_id' => ['required', 'exists:rentals,id'],
        ]);

        $rental = Rental::with('powerbank')->findOrFail($data['rental_id']);
        $rental->update([
            'status' => 'completed',
            'end_time' => Carbon::now(),
        ]);
        $rental->powerbank->update(['status' => 'available']);

        return redirect()->route('dashboard')->with('success', 'Симуляция: пользователь вернул повербанк.');
    }

    private function pay(Request $request)
    {
        $data = $request->validate([
            'rental_id' => ['required', 'exists:rentals,id', 'unique:payments,rental_id'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $rental = Rental::with('powerbank')->findOrFail($data['rental_id']);

        Payment::create([
            'rental_id' => $rental->id,
            'amount' => $data['amount'],
            'payment_time' => Carbon::now(),
            'status' => 'paid',
        ]);

        if ($rental->status === 'active') {
            $rental->update(['status' => 'completed', 'end_time' => Carbon::now()]);
            $rental->powerbank->update(['status' => 'available']);
        }

        return redirect()->route('dashboard')->with('success', 'Симуляция: пользователь оплатил аренду.');
    }

    private function reportError(Request $request)
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'max:1000'],
        ]);

        ErrorLog::create([
            'description' => 'Пользователь сообщил: '.$data['description'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Симуляция: сообщение об ошибке попало в журнал.');
    }
}
