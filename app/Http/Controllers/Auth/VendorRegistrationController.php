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
        return redirect()->route('auth-login-basic')->with('error', 'Public vendor registration is disabled. Vendor accounts are created by Administrators upon tool claim approval.');
    }

    public function store(Request $request)
    {
        return redirect()->route('auth-login-basic')->with('error', 'Public vendor registration is disabled.');
    }
}
