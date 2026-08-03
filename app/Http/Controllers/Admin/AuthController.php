<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            AuditLog::record(
                'admin.login_failed',
                null,
                sprintf('Failed login attempt for %s', $credentials['email']),
            );

            return back()
                ->withErrors(['email' => 'Those credentials do not match an admin account.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        AuditLog::record('admin.login', Auth::user(), 'Admin logged in');

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        AuditLog::record('admin.logout', Auth::user(), 'Admin logged out');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
