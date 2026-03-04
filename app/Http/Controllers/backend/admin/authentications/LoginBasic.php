<?php

namespace App\Http\Controllers\backend\admin\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      if (Auth::user()->role === 'vendor') {
        return redirect()->route('vendor.tools.index');
      }
      return redirect()->route('dashboard.analytics');
    }

    return view('backend.admin.content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email-username' => 'required|string',
      'password'      => 'required|string',
    ]);

    $field = filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $remember = $request->has('remember-me');

    if (Auth::attempt([$field => $credentials['email-username'], 'password' => $credentials['password']], $remember)) {
      $request->session()->regenerate();
      
      $redirectRoute = Auth::user()->role === 'vendor' ? route('vendor.tools.index') : route('dashboard.analytics');

      return redirect()->intended($redirectRoute)
        ->with('success', 'Welcome back!');
    }

    return back()->withErrors([
      'email-username' => 'The provided credentials do not match our records.',
    ])->onlyInput('email-username');
  }

  // Logout
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/auth/login-basic');
  }
}
