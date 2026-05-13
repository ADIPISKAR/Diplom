<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function store(Request $request)
    {
        Tariff::create($request->validate([
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('dashboard')->with('success', 'Тариф добавлен.');
    }

    public function update(Request $request, Tariff $tariff)
    {
        $tariff->update($request->validate([
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('dashboard')->with('success', 'Тариф обновлен.');
    }

    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return redirect()->route('dashboard')->with('success', 'Тариф удален.');
    }
}
