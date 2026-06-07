<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentRequest;
use App\Models\Issue;
use App\Models\StorageLocation;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'categoriesCount' => EquipmentCategory::count(),
            'locationsCount' => StorageLocation::count(),
            'equipmentCount' => Equipment::count(),
            'pendingRequestsCount' => EquipmentRequest::where('status', 'pending')->count(),
            'issuedRequestsCount' => EquipmentRequest::whereIn('status', ['issued', 'return_requested'])->count(),
            'openIssuesCount' => Issue::whereIn('status', ['open', 'in_progress'])->count(),
            'recentLogs' => ActivityLog::with('user')->latest('created_at')->limit(8)->get(),
            'recentRequests' => EquipmentRequest::with(['user', 'category', 'equipment'])->latest('requested_at')->limit(6)->get(),
            'equipmentStatuses' => Equipment::query()
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->orderBy('status')
                ->get(),
        ]);
    }
}
