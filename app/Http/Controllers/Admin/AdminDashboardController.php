<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Issue;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\Station;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'stationsCount' => Station::count(),
            'powerbanksCount' => Powerbank::count(),
            'activeRentalsCount' => Rental::where('status', 'active')->count(),
            'paymentsTotal' => Payment::where('status', 'paid')->sum('amount'),
            'openIssuesCount' => Issue::whereIn('status', ['open', 'in_progress'])->count(),
            'recentLogs' => ActivityLog::with('user')->latest('created_at')->limit(8)->get(),
        ]);
    }
}
