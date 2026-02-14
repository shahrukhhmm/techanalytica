<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\backend\admin\dashboard\Analytics;
use App\Http\Controllers\backend\admin\authentications\LoginBasic;
use App\Http\Controllers\backend\admin\authentications\RegisterBasic;
use App\Http\Controllers\backend\admin\authentications\ForgotPasswordBasic;

Route::get('/optimize', function () {
  Artisan::call('optimize');

  return response()->json([
    'status' => 'optimized',
    'output' => Artisan::output(),
  ]);
});

// authentication login register routes
Route::middleware('guest')->group(function () {
  Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('login');


  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
});

// Logout route
Route::get('/logout', [LoginBasic::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {
  // Main Page Route
  Route::get('/', [Analytics::class, 'index'])->name('dashboard.analytics');
  Route::get('/dashboard/analytics/pdf', [Analytics::class, 'pdf'])->name('dashboard.analytics.pdf');

  // Category CRUD Routes
  Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', \App\Http\Controllers\backend\admin\CategoryController::class);
    Route::resource('industries', \App\Http\Controllers\backend\admin\IndustryController::class);
  });

});
