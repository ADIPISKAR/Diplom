<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Models\ActivityLog;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\Station;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function create(Request $request): View
    {
        return view('issues.create', [
            'rentals' => $request->user()->rentals()->latest('started_at')->get(),
            'stations' => Station::orderBy('name')->get(),
            'powerbanks' => Powerbank::orderBy('serial_number')->get(),
        ]);
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['rental_id'])) {
            $ownsRental = Rental::where('id', $data['rental_id'])
                ->where('user_id', $request->user()->id)
                ->exists();
            abort_unless($ownsRental, 403);
        }

        $request->user()->issues()->create($data + ['status' => 'open']);
        ActivityLog::record($request->user()->id, 'issue_created', 'Создано обращение о проблемной ситуации');

        return redirect()->route('dashboard')->with('success', 'Обращение создано.');
    }
}
