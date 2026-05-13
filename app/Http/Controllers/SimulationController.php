<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class SimulationController extends Controller
{
    public function store(Request $request)
    {
        $action = $request->validate([
            'action' => ['required', 'in:create_user,rent,return,pay,report_error'],
        ])['action'];

        return match ($action) {
            'create_user' => $this->createUser($request),
            'rent' => $this->rent($request),
            'return' => $this->returnRental($request),
            'pay' => $this->pay($request),
            'report_error' => $this->reportError($request),
        };
    }

    private function createUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:user,admin'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return $this->respond($request, 'Пользователь добавлен.');
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
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Симуляция: выбранный повербанк уже недоступен.'], 422);
            }

            return redirect()->route('dashboard')->withErrors('Симуляция: выбранный повербанк уже недоступен.');
        }

        Rental::create([
            ...$data,
            'start_time' => Carbon::now(),
            'status' => 'active',
        ]);

        $powerbank->update(['status' => 'rented']);

        return $this->respond($request, 'Симуляция: пользователь начал аренду.');
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

        return $this->respond($request, 'Симуляция: пользователь вернул повербанк.');
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

        return $this->respond($request, 'Симуляция: пользователь оплатил аренду.');
    }

    private function reportError(Request $request)
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'max:1000'],
        ]);

        ErrorLog::create([
            'description' => 'Пользователь сообщил: '.$data['description'],
        ]);

        return $this->respond($request, 'Симуляция: сообщение об ошибке попало в журнал.');
    }
}
