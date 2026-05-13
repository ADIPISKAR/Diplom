<?php

namespace App\Http\Controllers;

use App\Models\Powerbank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PowerbankController extends Controller
{
    public function store(Request $request)
    {
        Powerbank::create($request->validate([
            'station_id' => ['required', 'exists:stations,id'],
            'code' => ['required', 'string', 'max:100', 'unique:powerbanks,code'],
            'capacity_mah' => ['required', 'integer', 'min:1000', 'max:100000'],
            'status' => ['required', 'in:available,rented,maintenance,lost'],
        ]));

        return $this->respond($request, 'Повербанк добавлен.');
    }

    public function update(Request $request, Powerbank $powerbank)
    {
        $powerbank->update($request->validate([
            'station_id' => ['required', 'exists:stations,id'],
            'code' => ['required', 'string', 'max:100', Rule::unique('powerbanks', 'code')->ignore($powerbank)],
            'capacity_mah' => ['required', 'integer', 'min:1000', 'max:100000'],
            'status' => ['required', 'in:available,rented,maintenance,lost'],
        ]));

        return $this->respond($request, 'Повербанк обновлен.');
    }

    public function destroy(Powerbank $powerbank)
    {
        $powerbank->delete();

        return $this->respond(request(), 'Повербанк удален.');
    }
}
