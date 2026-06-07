<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['status'] = 'active';

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Неверный email, пароль или пользователь заблокирован.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        ActivityLog::record(Auth::id(), 'login', 'Авторизация в системе');

        if (Auth::user()->isAdmin()) {
            return redirect()->intended('/admin');
        }

        if (Auth::user()->isEmployee()) {
            return redirect()->intended('/employee');
        }

        return redirect()->intended('/dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $role = Role::where('name', 'user')->firstOrFail();
        $user = User::create($request->safe()->merge([
            'role_id' => $role->id,
            'status' => 'active',
        ])->all());

        Auth::login($user);
        $request->session()->regenerate();
        ActivityLog::record($user->id, 'register', 'Регистрация нового пользователя');

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        ActivityLog::record($request->user()?->id, 'logout', 'Выход из системы');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
