<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTariffRequest;
use App\Models\ActivityLog;
use App\Models\Tariff;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TariffController extends Controller
{
    public function index(): View
    {
        return view('admin.tariffs.index', [
            'tariffs' => Tariff::latest()->get(),
        ]);
    }

    public function store(StoreTariffRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $tariff = Tariff::create($data);
        ActivityLog::record($request->user()->id, 'admin_tariff_created', "Создан тариф {$tariff->name}");

        return back()->with('success', 'Тариф создан.');
    }

    public function update(StoreTariffRequest $request, Tariff $tariff): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $tariff->update($data);
        ActivityLog::record($request->user()->id, 'admin_tariff_updated', "Обновлён тариф {$tariff->name}");

        return back()->with('success', 'Тариф обновлён.');
    }

    public function destroy(Tariff $tariff): RedirectResponse
    {
        $name = $tariff->name;
        $tariff->delete();
        ActivityLog::record(auth()->id(), 'admin_tariff_deleted', "Удалён тариф {$name}");

        return back()->with('success', 'Тариф удалён.');
    }
}
