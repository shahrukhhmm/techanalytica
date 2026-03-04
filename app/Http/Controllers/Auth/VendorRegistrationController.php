<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class VendorRegistrationController extends Controller
{
    public function index()
    {
        return view('auth.register-vendor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => ['required', 'url', 'max:255'],
            'company_size' => ['required', 'string'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->vendor()->create([
                'company_name' => $request->company_name,
                'company_website' => $request->company_website,
                'company_size' => $request->company_size,
                'designation' => $request->designation,
                'department' => $request->department,
                'phone' => $request->phone,
            ]);

            Auth::login($user);

            return redirect()->route('vendor.dashboard');
        });
    }
}
