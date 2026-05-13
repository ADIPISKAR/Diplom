<?php

namespace App\Http\Controllers;

use App\Models\Powerbank;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'powerbank_id' => ['required', 'exists:powerbanks,id'],
            'tariff_id' => ['nullable', 'exists:tariffs,id'],
        ]);

        $powerbank = Powerbank::findOrFail($data['powerbank_id']);

        if ($powerbank->status !== 'available') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Выбранный повербанк недоступен для аренды.'], 422);
            }

            return redirect()->route('dashboard')->withErrors('Выбранный повербанк недоступен для аренды.');
        }

        Rental::create([
            ...$data,
            'start_time' => Carbon::now(),
            'status' => 'active',
        ]);

        $powerbank->update(['status' => 'rented']);

        return $this->respond($request, 'Аренда начата.');
    }

    public function update(Request $request, Rental $rental)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,completed,overdue,cancelled'],
        ]);

        $rental->update([
            'status' => $data['status'],
            'end_time' => in_array($data['status'], ['completed', 'cancelled'], true) ? Carbon::now() : $rental->end_time,
        ]);

        if (in_array($data['status'], ['completed', 'cancelled'], true)) {
            $rental->powerbank->update(['status' => 'available']);
        }

        return $this->respond($request, 'Статус аренды обновлен.');
    }

    public function destroy(Rental $rental)
    {
        if ($rental->status === 'active') {
            $rental->powerbank->update(['status' => 'available']);
        }

        $rental->delete();

        return $this->respond(request(), 'Аренда удалена.');
    }
}
