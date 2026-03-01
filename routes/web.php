<?php

use App\Http\Controllers\backend\admin\authentications\ForgotPasswordBasic;
use App\Http\Controllers\backend\admin\authentications\LoginBasic;
use App\Http\Controllers\backend\admin\authentications\RegisterBasic;
use App\Http\Controllers\backend\admin\dashboard\Analytics;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

        Route::get('tools/compare', [\App\Http\Controllers\backend\admin\ToolController::class, 'compare'])->name('tools.compare');
        Route::resource('tools', \App\Http\Controllers\backend\admin\ToolController::class);
        Route::resource('blogs', \App\Http\Controllers\backend\admin\BlogController::class);

        Route::get('reviews', [\App\Http\Controllers\backend\admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/status', [\App\Http\Controllers\backend\admin\ReviewController::class, 'updateStatus'])->name('reviews.update-status');
        Route::delete('reviews/{review}', [\App\Http\Controllers\backend\admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::resource('newsletters', \App\Http\Controllers\backend\admin\NewsletterController::class);
        Route::post('newsletters/{newsletter}/send', [\App\Http\Controllers\backend\admin\NewsletterController::class, 'send'])->name('newsletters.send');
        Route::get('subscribers', [\App\Http\Controllers\backend\admin\NewsletterController::class, 'subscribers'])->name('subscribers.index');
        Route::delete('subscribers/{subscriber}', [\App\Http\Controllers\backend\admin\NewsletterController::class, 'destroySubscriber'])->name('subscribers.destroy');

        // Pricing and Claims
        Route::resource('pricing-tiers', \App\Http\Controllers\backend\admin\PricingTierController::class);
        Route::get('tools-claims', [\App\Http\Controllers\backend\admin\ClaimController::class, 'index'])->name('tools.claims.index');
        Route::patch('tools-claims/{claim}', [\App\Http\Controllers\backend\admin\ClaimController::class, 'updateStatus'])->name('tools.claims.update-status');
        Route::delete('tools-claims/{claim}', [\App\Http\Controllers\backend\admin\ClaimController::class, 'destroy'])->name('tools.claims.destroy');

        Route::resource('vendors', \App\Http\Controllers\backend\admin\VendorController::class);

        // API route for tool comparison
        Route::get('/api/compare-tools', [Analytics::class, 'compareTools'])->name('api.compare-tools');
    });

});
