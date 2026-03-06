<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('backend.admin.content.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.admin.content.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,editor,vendor,public',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['vendor', 'blogs']);
        return view('backend.admin.content.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('backend.admin.content.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,editor,vendor,public',
            'is_suspended' => 'boolean',
            'suspension_reason' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleSuspension(Request $request, User $user)
    {
        $user->update([
            'is_suspended' => !$user->is_suspended,
            'suspension_reason' => $request->input('reason'),
        ]);

        $status = $user->is_suspended ? 'suspended' : 'activated';
        return back()->with('success', "User account {$status} successfully.");
    }

    public function forcePasswordReset(User $user)
    {
        $newPassword = Str::random(12);
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // In a real app, you'd email this to the user.
        return back()->with('success', "Password reset successfully. New password: {$newPassword}");
    }

    public function verifyEmail(User $user)
    {
        $user->update([
            'email_verified_at' => now(),
            'email_verified' => true,
        ]);

        return back()->with('success', 'User email verified successfully.');
    }
}
