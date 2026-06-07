<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStorageLocationRequest;
use App\Models\ActivityLog;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StorageLocationController extends Controller
{
    public function index(): View
    {
        return view('admin.locations.index', [
            'locations' => StorageLocation::withCount('equipment')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreStorageLocationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $location = StorageLocation::create($data);
        ActivityLog::record($request->user()->id, 'location_created', "Создано место хранения {$location->name}", $location);

        return back()->with('success', 'Место хранения создано.');
    }

    public function update(StoreStorageLocationRequest $request, StorageLocation $location): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $location->update($data);
        ActivityLog::record($request->user()->id, 'location_updated', "Обновлено место хранения {$location->name}", $location);

        return back()->with('success', 'Место хранения обновлено.');
    }

    public function destroy(StorageLocation $location): RedirectResponse
    {
        $name = $location->name;
        $location->delete();
        ActivityLog::record(auth()->id(), 'location_deleted', "Удалено место хранения {$name}");

        return back()->with('success', 'Место хранения удалено.');
    }
}
