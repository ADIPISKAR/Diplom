<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('notifications.index', [
            'notifications' => $request->user()->notifications()->latest('created_at')->paginate(20),
        ]);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->notifications()->update(['is_read' => true]);

        return back()->with('success', 'Уведомления отмечены прочитанными.');
    }
}
