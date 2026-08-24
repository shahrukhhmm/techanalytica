<?php

use App\Http\Controllers\frontend\PageController;
use App\Http\Controllers\backend\admin\authentications\ForgotPasswordBasic;
use App\Http\Controllers\backend\admin\authentications\LoginBasic;
use App\Http\Controllers\backend\admin\authentications\RegisterBasic;
use App\Http\Controllers\backend\admin\dashboard\Analytics;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [PageController::class, 'index'])->name('frontend.home');
Route::get('/blogs', [PageController::class, 'blogs'])->name('frontend.blogs');
Route::get('/blogs/{slug?}', [PageController::class, 'blogDetail'])->name('frontend.blogs.show');
Route::get('/vendors/crm', [PageController::class, 'crmVendor'])->name('frontend.vendors.crm');
Route::get('/category/{slug}', [PageController::class, 'crmVendor'])->name('frontend.category.show');
Route::get('/vendors/{slug?}', [PageController::class, 'vendorDetail'])->name('frontend.vendors.show');
Route::get('/tools/{slug?}', [PageController::class, 'vendorDetail'])->name('frontend.tools.show');

// Actions
Route::post('/tools/{id}/reviews', [PageController::class, 'submitReview'])->name('frontend.reviews.store');
Route::post('/newsletter/subscribe', [PageController::class, 'subscribeNewsletter'])->name('frontend.newsletter.subscribe');





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
    Route::get('/auth/register-vendor', [\App\Http\Controllers\Auth\VendorRegistrationController::class, 'index'])->name('register-vendor');
    Route::post('/auth/register-vendor', [\App\Http\Controllers\Auth\VendorRegistrationController::class, 'store'])->name('register-vendor.store');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
});

// Logout route
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', [LoginBasic::class, 'logout'])->middleware('auth'); // fallback for GET links

Route::middleware('auth')->group(function () {
    // Main Page Route
    Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard.analytics');
    Route::get('/dashboard/analytics/pdf', [Analytics::class, 'pdf'])->name('dashboard.analytics.pdf');


    // Category CRUD Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\backend\admin\CategoryController::class);
        Route::resource('industries', \App\Http\Controllers\backend\admin\IndustryController::class);
        Route::patch('industries/{industry}/toggle-approval', [\App\Http\Controllers\backend\admin\IndustryController::class, 'toggleApproval'])->name('industries.toggle-approval');

        Route::get('tools/compare', [\App\Http\Controllers\backend\admin\ToolController::class, 'compare'])->name('tools.compare');
        Route::get('tools/pending-updates', [\App\Http\Controllers\backend\admin\ToolController::class, 'pendingUpdates'])->name('tools.pending-updates');
        Route::post('tools/{tool}/approve-update', [\App\Http\Controllers\backend\admin\ToolController::class, 'approveUpdate'])->name('tools.approve-update');
        Route::post('tools/{tool}/reject-update', [\App\Http\Controllers\backend\admin\ToolController::class, 'rejectUpdate'])->name('tools.reject-update');
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

        // Submissions
        Route::get('submissions', [\App\Http\Controllers\backend\admin\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [\App\Http\Controllers\backend\admin\SubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('submissions/{submission}', [\App\Http\Controllers\backend\admin\SubmissionController::class, 'updateStatus'])->name('submissions.update-status');
        Route::delete('submissions/{submission}', [\App\Http\Controllers\backend\admin\SubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Monetization
        Route::get('sponsorships', [\App\Http\Controllers\backend\admin\SponsorshipController::class, 'index'])->name('sponsorships.index');
        Route::get('sponsorships/{sponsorship}', [\App\Http\Controllers\backend\admin\SponsorshipController::class, 'show'])->name('sponsorships.show');
        Route::patch('sponsorships/{sponsorship}', [\App\Http\Controllers\backend\admin\SponsorshipController::class, 'updateStatus'])->name('sponsorships.update-status');
        Route::delete('sponsorships/{sponsorship}', [\App\Http\Controllers\backend\admin\SponsorshipController::class, 'destroy'])->name('sponsorships.destroy');

        Route::get('billing', [\App\Http\Controllers\backend\admin\BillingTransactionController::class, 'index'])->name('billing.index');
        Route::get('billing/{transaction}', [\App\Http\Controllers\backend\admin\BillingTransactionController::class, 'show'])->name('billing.show');
        Route::patch('billing/{transaction}', [\App\Http\Controllers\backend\admin\BillingTransactionController::class, 'updateStatus'])->name('billing.update-status');

        Route::resource('vendors', \App\Http\Controllers\backend\admin\VendorController::class);

        // User Management
        Route::post('users/{user}/toggle-suspension', [\App\Http\Controllers\backend\admin\UserController::class, 'toggleSuspension'])->name('users.toggle-suspension');
        Route::post('users/{user}/force-password-reset', [\App\Http\Controllers\backend\admin\UserController::class, 'forcePasswordReset'])->name('users.force-password-reset');
        Route::post('users/{user}/verify-email', [\App\Http\Controllers\backend\admin\UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::resource('users', \App\Http\Controllers\backend\admin\UserController::class);
    });

    // Shared API routes
    Route::get('/api/compare-tools', [\App\Http\Controllers\backend\admin\dashboard\Analytics::class, 'compareTools'])->name('api.compare-tools');

    // Vendor Routes
    Route::prefix('vendor')->name('vendor.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\backend\vendor\VendorDashboardController::class, 'index']);
        Route::get('/', [\App\Http\Controllers\backend\vendor\VendorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/switch-tool/{id}', [\App\Http\Controllers\backend\vendor\VendorDashboardController::class, 'switchTool'])->name('switch-tool');
        Route::post('/tools/{tool}/submit', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'submitForReview'])->name('tools.submit');
        Route::post('/tools/{tool}/unpublish', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'unpublish'])->name('tools.unpublish');
        Route::get('/claim-product', [\App\Http\Controllers\backend\vendor\ClaimController::class, 'index'])->name('claim');
        Route::get('/claim-product/{tool}', [\App\Http\Controllers\backend\vendor\ClaimController::class, 'create'])->name('claim.create');
        Route::post('/claim-product/{tool}', [\App\Http\Controllers\backend\vendor\ClaimController::class, 'store'])->name('claim.store');

        Route::get('/submit-product', [\App\Http\Controllers\backend\vendor\SubmissionController::class, 'index'])->name('submit');
        Route::get('/submit-product/create', [\App\Http\Controllers\backend\vendor\SubmissionController::class, 'create'])->name('submit.create');
        Route::post('/submit-product/store', [\App\Http\Controllers\backend\vendor\SubmissionController::class, 'store'])->name('submit.store');
        Route::get('/submit-product/review', [\App\Http\Controllers\backend\vendor\SubmissionController::class, 'review'])->name('submit.review');
        Route::post('/submit-product/confirm', [\App\Http\Controllers\backend\vendor\SubmissionController::class, 'confirm'])->name('submit.confirm');

        Route::resource('tools', \App\Http\Controllers\backend\vendor\VendorToolController::class);
        Route::get('/analytics', [\App\Http\Controllers\backend\vendor\VendorAnalyticsController::class, 'index'])->name('analytics');

        // Sections
        Route::resource('blogs', \App\Http\Controllers\backend\vendor\VendorBlogController::class);
        Route::get('/reviews', [\App\Http\Controllers\backend\vendor\VendorReviewController::class, 'index'])->name('reviews.index');
        Route::get('/billing', [\App\Http\Controllers\backend\vendor\BillingController::class, 'index'])->name('billing');
        Route::get('/profile', [\App\Http\Controllers\backend\vendor\VendorDashboardController::class, 'profile'])->name('profile');
    });
});
