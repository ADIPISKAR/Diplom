<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentRequest;
use Illuminate\View\View;

class EquipmentRequestController extends Controller
{
    public function index(): View
    {
        return view('admin.requests.index', [
            'requests' => EquipmentRequest::with(['user', 'category', 'equipment', 'storageLocation'])
                ->latest('requested_at')
                ->paginate(25),
            'title' => 'Все заявки',
        ]);
    }

    public function active(): View
    {
        return view('admin.requests.index', [
            'requests' => EquipmentRequest::with(['user', 'category', 'equipment', 'storageLocation'])
                ->whereIn('status', ['pending', 'approved', 'issued', 'return_requested'])
                ->latest('requested_at')
                ->paginate(25),
            'title' => 'Активные заявки',
        ]);
    }
}
