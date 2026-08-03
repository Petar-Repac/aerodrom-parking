<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // The User model's 'password' cast is 'hashed', so this hashes automatically.
            'password' => $validated['password'],
        ]);

        AuditLog::record(
            'admin.create',
            $request->user(),
            sprintf('Registered new admin %s', $admin->email),
            ['created_admin' => ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email]],
        );

        return response()->json([
            'status' => 'success',
            'admin' => $admin->only(['id', 'name', 'email', 'created_at']),
        ], 201);
    }
}
