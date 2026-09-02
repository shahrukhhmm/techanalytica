<?php

namespace App\Http\Controllers\backend\admin\authentications;

use App\Http\Controllers\Controller;
use App\Models\PricingTier;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterBasic extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'vendor') {
                return redirect()->route('vendor.tools.index');
            }
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'editor') {
                return redirect()->route('dashboard.analytics');
            }
            return redirect()->route('frontend.home');
        }

        return view('backend.admin.content.authentications.auth-register-basic');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:public,vendor',
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified' => false,
        ]);

        if ($validated['role'] === 'vendor') {
            $freeTier = PricingTier::where('name', 'Free')->first();

            Vendor::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'] ?? ($validated['name'] . ' Company'),
                'company_website' => $validated['company_website'] ?? null,
                'pricing_tier_id' => $freeTier ? $freeTier->id : null,
                'billing_email' => $user->email,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'vendor') {
            return redirect()->route('vendor.tools.index')->with('success', 'Vendor account created successfully! Welcome to your dashboard.');
        }

        return redirect()->route('frontend.home')->with('success', 'Account created successfully! Welcome to TechAnalytica.');
    }
}
