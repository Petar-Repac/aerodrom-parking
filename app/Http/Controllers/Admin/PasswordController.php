<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        // The User model's 'password' cast is 'hashed', so this hashes automatically.
        $user->update(['password' => $validated['password']]);

        AuditLog::record('admin.password_change', $user, 'Changed own password');

        return response()->json(['status' => 'success']);
    }
}
