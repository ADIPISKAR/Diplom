<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function create(Request $request): View
    {
        return view('issues.create', [
            'requests' => $request->user()->equipmentRequests()->latest('requested_at')->get(),
            'equipment' => Equipment::orderBy('name')->get(),
        ]);
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['equipment_request_id'])) {
            $ownsRequest = EquipmentRequest::where('id', $data['equipment_request_id'])
                ->where('user_id', $request->user()->id)
                ->exists();

            abort_unless($ownsRequest || $request->user()->isEmployee(), 403);
        }

        $issue = $request->user()->problems()->create($data + ['status' => 'open']);
        ActivityLog::record($request->user()->id, 'problem_created', 'Создана проблемная ситуация по оборудованию', $issue);

        return redirect()->route('dashboard')->with('success', 'Проблемная ситуация зарегистрирована.');
    }
}
