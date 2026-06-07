<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentRequest;
use App\Models\EquipmentReturn;
use App\Models\Issue;
use App\Models\Report;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', [
            'reports' => Report::with('admin')->latest('created_at')->paginate(20),
            'summary' => [
                'requests' => EquipmentRequest::count(),
                'issued' => EquipmentRequest::whereIn('status', ['issued', 'return_requested'])->count(),
                'returns' => EquipmentReturn::count(),
                'issues' => Issue::count(),
                'categories' => EquipmentCategory::count(),
                'locations' => StorageLocation::count(),
                'equipment' => Equipment::count(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'report_type' => ['required', Rule::in(['requests', 'issued', 'returns', 'issues', 'categories', 'locations', 'equipment'])],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
        ]);

        $report = Report::create($data + ['admin_id' => $request->user()->id]);
        ActivityLog::record($request->user()->id, 'admin_report_created', "Создан отчёт #{$report->id}", $report);

        return back()->with('success', 'Отчёт создан.');
    }
}
