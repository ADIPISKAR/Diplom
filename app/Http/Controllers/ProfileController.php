<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['password_confirmation']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $request->user()->update($data);
        ActivityLog::record($request->user()->id, 'profile_updated', 'Пользователь обновил профиль');

        return back()->with('success', 'Профиль обновлён.');
    }
}
