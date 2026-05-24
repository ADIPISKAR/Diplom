<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Rental;
use App\Models\ReturnModel;
use App\Models\Station;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function create(Request $request, Rental $rental): View
    {
        abort_unless($rental->user_id === $request->user()->id && $rental->status === 'active', 403);

        return view('rentals.return', [
            'rental' => $rental->load(['powerbank', 'tariff']),
            'stations' => Station::where('status', 'active')->withCount([
                'slots as empty_slots_count' => fn ($query) => $query->where('status', 'empty'),
            ])->get(),
        ]);
    }

    public function store(Request $request, Rental $rental): RedirectResponse
    {
        abort_unless($rental->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'station_id' => ['required', 'exists:stations,id'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            DB::transaction(function () use ($data, $request, $rental): void {
                $rental = Rental::whereKey($rental->id)
                    ->where('status', 'active')
                    ->with(['tariff', 'powerbank'])
                    ->lockForUpdate()
                    ->first();

                if (! $rental) {
                    throw new \RuntimeException('Активная аренда не найдена.');
                }

                $station = Station::whereKey($data['station_id'])
                    ->where('status', 'active')
                    ->firstOrFail();

                $slot = $station->slots()
                    ->where('status', 'empty')
                    ->lockForUpdate()
                    ->orderBy('slot_number')
                    ->first();

                if (! $slot) {
                    throw new \RuntimeException('На выбранной станции нет свободного слота.');
                }

                $endedAt = now();
                $amount = $rental->calculatePrice($endedAt);
                $paymentMethod = PaymentMethod::where('name', 'demo_payment')->firstOrFail();

                Payment::updateOrCreate(
                    ['rental_id' => $rental->id, 'payment_method_id' => $paymentMethod->id],
                    [
                        'user_id' => $request->user()->id,
                        'amount' => $amount,
                        'status' => 'paid',
                        'paid_at' => $endedAt,
                    ]
                );

                ReturnModel::create([
                    'rental_id' => $rental->id,
                    'user_id' => $request->user()->id,
                    'powerbank_id' => $rental->powerbank_id,
                    'station_id' => $station->id,
                    'slot_id' => $slot->id,
                    'returned_at' => $endedAt,
                    'status' => 'completed',
                    'comment' => $data['comment'] ?? null,
                ]);

                $rental->update([
                    'return_station_id' => $station->id,
                    'ended_at' => $endedAt,
                    'status' => 'completed',
                    'total_price' => $amount,
                ]);

                $rental->powerbank->update([
                    'station_id' => $station->id,
                    'slot_id' => $slot->id,
                    'status' => 'available',
                ]);

                $slot->update(['status' => 'occupied']);

                Notification::create([
                    'user_id' => $request->user()->id,
                    'title' => 'Аренда завершена',
                    'message' => "Повербанк возвращён на станцию {$station->name}. Сумма оплаты: {$amount} руб.",
                ]);

                ActivityLog::record(
                    $request->user()->id,
                    'powerbank_returned',
                    "Возврат повербанка по аренде #{$rental->id}; сумма {$amount} руб."
                );
            });
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('rentals.history')->with('success', 'Повербанк возвращён, оплата выполнена в демо-режиме.');
    }
}
