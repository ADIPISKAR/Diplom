<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Equipment::with(['category', 'storageLocation', 'specification'])
            ->whereHas('category', fn ($category) => $category->where('is_active', true));

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->boolean('available')) {
            $query->where('status', 'available')->where('technical_condition', 'good');
        }

        return view('equipment.index', [
            'equipment' => $query->orderBy('name')->paginate(12)->withQueryString(),
            'categories' => EquipmentCategory::where('is_active', true)->orderBy('name')->get(),
            'selectedCategory' => $request->integer('category_id'),
            'availableOnly' => $request->boolean('available'),
        ]);
    }

    public function show(Equipment $equipment): View
    {
        return view('equipment.show', [
            'equipment' => $equipment->load(['category', 'storageLocation', 'specification', 'software']),
        ]);
    }
}
