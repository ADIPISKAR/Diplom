<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentRequest;
use App\Models\Issue;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('employee.dashboard', [
            'pendingCount' => EquipmentRequest::where('status', 'pending')->count(),
            'issuedCount' => EquipmentRequest::whereIn('status', ['issued', 'return_requested'])->count(),
            'availableCount' => Equipment::where('status', 'available')->where('technical_condition', 'good')->count(),
            'problemCount' => Issue::whereIn('status', ['open', 'in_progress'])->count(),
            'requests' => EquipmentRequest::with(['user', 'category', 'equipment', 'storageLocation'])
                ->whereIn('status', ['pending', 'approved', 'issued', 'return_requested'])
                ->latest('requested_at')
                ->limit(8)
                ->get(),
        ]);
    }
}
