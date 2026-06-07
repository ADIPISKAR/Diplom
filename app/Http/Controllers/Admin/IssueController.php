<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Issue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(): View
    {
        return view('admin.issues.index', [
            'issues' => Issue::with(['user', 'employee', 'equipmentRequest', 'equipment'])
                ->latest('created_at')
                ->paginate(25),
        ]);
    }

    public function update(Request $request, Issue $issue): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['open', 'in_progress', 'resolved', 'closed'])],
        ]);

        $data['resolved_at'] = in_array($data['status'], ['resolved', 'closed'], true) ? now() : null;
        $issue->update($data);
        ActivityLog::record($request->user()->id, 'admin_issue_updated', "Изменён статус проблемной ситуации #{$issue->id}", $issue);

        return back()->with('success', 'Статус проблемной ситуации обновлён.');
    }
}
