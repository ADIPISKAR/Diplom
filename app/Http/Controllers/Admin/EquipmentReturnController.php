<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentReturn;
use Illuminate\View\View;

class EquipmentReturnController extends Controller
{
    public function index(): View
    {
        return view('admin.returns.index', [
            'returns' => EquipmentReturn::with(['request', 'user', 'employee', 'equipment', 'storageLocation'])
                ->latest('returned_at')
                ->paginate(25),
        ]);
    }
}
