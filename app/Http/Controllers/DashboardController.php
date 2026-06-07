<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentRequest;
use App\Models\Issue;
use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'activeRequest' => $user->activeRequest()?->load(['category', 'equipment', 'storageLocation']),
            'requestsCount' => EquipmentRequest::where('user_id', $user->id)->count(),
            'availableEquipmentCount' => Equipment::where('status', 'available')->where('technical_condition', 'good')->count(),
            'locationsCount' => StorageLocation::where('is_active', true)->count(),
            'issuesCount' => Issue::where('user_id', $user->id)->count(),
            'notifications' => $user->notifications()->latest('created_at')->limit(5)->get(),
            'recentLogs' => ActivityLog::where('user_id', $user->id)->latest('created_at')->limit(6)->get(),
            'equipment' => Equipment::with(['category', 'storageLocation'])
                ->where('status', 'available')
                ->where('technical_condition', 'good')
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }
}
