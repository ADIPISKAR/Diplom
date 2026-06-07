<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEquipmentCategoryRequest;
use App\Models\ActivityLog;
use App\Models\EquipmentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => EquipmentCategory::withCount('equipment')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEquipmentCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $category = EquipmentCategory::create($data);
        ActivityLog::record($request->user()->id, 'category_created', "Создана категория {$category->name}", $category);

        return back()->with('success', 'Категория создана.');
    }

    public function update(StoreEquipmentCategoryRequest $request, EquipmentCategory $category): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $category->update($data);
        ActivityLog::record($request->user()->id, 'category_updated', "Обновлена категория {$category->name}", $category);

        return back()->with('success', 'Категория обновлена.');
    }

    public function destroy(EquipmentCategory $category): RedirectResponse
    {
        $name = $category->name;
        $category->delete();
        ActivityLog::record(auth()->id(), 'category_deleted', "Удалена категория {$name}");

        return back()->with('success', 'Категория удалена.');
    }
}
