<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Issue;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\Report;
use App\Models\ReturnModel;
use App\Models\Station;
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
                'rentals' => Rental::count(),
                'payments' => Payment::where('status', 'paid')->sum('amount'),
                'returns' => ReturnModel::count(),
                'issues' => Issue::count(),
                'stations' => Station::count(),
                'powerbanks' => Powerbank::count(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'report_type' => ['required', Rule::in(['rentals', 'payments', 'returns', 'issues', 'stations', 'powerbanks'])],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
        ]);

        $report = Report::create($data + ['admin_id' => $request->user()->id]);
        ActivityLog::record($request->user()->id, 'admin_report_created', "Создан отчёт #{$report->id}");

        return back()->with('success', 'Отчёт создан.');
    }
}
