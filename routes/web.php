<?php

use App\Http\Controllers\backend\admin\authentications\ForgotPasswordBasic;
use App\Http\Controllers\backend\admin\authentications\LoginBasic;
use App\Http\Controllers\backend\admin\authentications\RegisterBasic;
use App\Http\Controllers\backend\admin\BillingTransactionController;
use App\Http\Controllers\backend\admin\BlogCategoryController;
use App\Http\Controllers\backend\admin\BlogController;
use App\Http\Controllers\backend\admin\CategoryController;
use App\Http\Controllers\backend\admin\ClaimController;
use App\Http\Controllers\backend\admin\dashboard\Analytics;
use App\Http\Controllers\backend\admin\IndustryController;
use App\Http\Controllers\backend\admin\NewsletterController;
use App\Http\Controllers\backend\admin\PricingTierController;
use App\Http\Controllers\backend\admin\ReviewController;
use App\Http\Controllers\backend\admin\SponsorshipController;
use App\Http\Controllers\backend\admin\SubmissionController;
use App\Http\Controllers\backend\admin\ToolController;
use App\Http\Controllers\backend\admin\UserController;
use App\Http\Controllers\backend\admin\VendorController;
use App\Http\Controllers\backend\vendor\BillingController;
use App\Http\Controllers\backend\vendor\VendorAnalyticsController;
use App\Http\Controllers\backend\vendor\VendorBlogController;
use App\Http\Controllers\backend\vendor\VendorDashboardController;
use App\Http\Controllers\backend\vendor\VendorLeadController;
use App\Http\Controllers\backend\vendor\VendorReviewController;
use App\Http\Controllers\backend\vendor\VendorToolController;
use App\Http\Controllers\frontend\PageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;



// Frontend Public Routes
Route::name('frontend.')->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('home');
    
    Route::get('/tools', [PageController::class, 'tools'])->name('tools.index');
    Route::get('/tools-list', [PageController::class, 'tools'])->name('tools');
    Route::get('/tools/{slug}', [PageController::class, 'toolDetail'])->name('tools.show');
    Route::get('/compare', [PageController::class, 'compare'])->name('compare');
    Route::get('/compare/export', [PageController::class, 'exportComparison'])->name('compare.export');
    Route::get('/leaderboard', [PageController::class, 'leaderboard'])->name('leaderboard');
    Route::post('/tools/{slug}/lead', [PageController::class, 'submitLead'])->name('tools.lead');
    Route::post('/tools/{slug}/review', [PageController::class, 'submitReview'])->name('tools.review');
    Route::post('/tools/claim', [PageController::class, 'submitClaim'])->name('tools.claim');
    Route::post('/claims/submit', [PageController::class, 'submitClaim'])->name('claims.submit');
    Route::post('/tools/submit', [PageController::class, 'submitTool'])->name('tools.submit');
    Route::post('/api/favorites/{toolId}', [PageController::class, 'toggleFavorite'])->name('tools.favorite');
    Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs.index');
    Route::get('/blogs-all', [PageController::class, 'blogs'])->name('blogs');
    Route::get('/blogs/{slug?}', [PageController::class, 'blogDetail'])->name('blogs.show');
    Route::get('/vendors/{slug}', [PageController::class, 'vendorDetail'])->name('vendors.show');
});

// Cache Clearing & Optimization Utility
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return response()->json([
        'status' => 'optimized',
        'output' => Artisan::output(),
    ]);
});

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('login');

    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::post('/auth/register-basic', [RegisterBasic::class, 'register'])->name('register');

    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
    Route::post('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'sendResetLinkEmail'])->name('password.email');
});

// Logout Route
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', [LoginBasic::class, 'logout'])->middleware('auth');

// Protected Admin Portal (Role: admin, editor)
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard.analytics');
    Route::get('/dashboard/analytics/pdf', [Analytics::class, 'pdf'])->name('dashboard.analytics.pdf');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\backend\admin\CategoryController::class);
        Route::resource('industries', \App\Http\Controllers\backend\admin\IndustryController::class);
        Route::patch('industries/{industry}/toggle-approval', [\App\Http\Controllers\backend\admin\IndustryController::class, 'toggleApproval'])->name('industries.toggle-approval');

        Route::get('tools/compare', [\App\Http\Controllers\backend\admin\ToolController::class, 'compare'])->name('tools.compare');
        Route::get('tools/pending-updates', [\App\Http\Controllers\backend\admin\ToolController::class, 'pendingUpdates'])->name('tools.pending-updates');
        Route::post('tools/{tool}/approve-update', [\App\Http\Controllers\backend\admin\ToolController::class, 'approveUpdate'])->name('tools.approve-update');
        Route::post('tools/{tool}/reject-update', [\App\Http\Controllers\backend\admin\ToolController::class, 'rejectUpdate'])->name('tools.reject-update');
        Route::patch('tools/{tool}/toggle-featured', [\App\Http\Controllers\backend\admin\ToolController::class, 'toggleFeatured'])->name('tools.toggle-featured');
        Route::resource('tools', \App\Http\Controllers\backend\admin\ToolController::class);

        // Blogs & Taxonomies
        Route::resource('blogs', \App\Http\Controllers\backend\admin\BlogController::class);
        Route::get('blog-categories', [\App\Http\Controllers\backend\admin\BlogCategoryController::class, 'index'])->name('blog-categories.index');
        Route::post('blog-categories', [\App\Http\Controllers\backend\admin\BlogCategoryController::class, 'store'])->name('blog-categories.store');
        Route::delete('blog-categories/{category}', [\App\Http\Controllers\backend\admin\BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');

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
});

// Protected Vendor Portal (Role: vendor)
Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'role:vendor'])->group(function () {
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

    Route::get('/pricing', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'pricing'])->name('pricing');
    Route::post('/pricing', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'updatePricing'])->name('pricing.update');

    Route::get('/features', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'features'])->name('features');
    Route::post('/features', [\App\Http\Controllers\backend\vendor\VendorToolController::class, 'updateFeatures'])->name('features.update');

    Route::resource('tools', \App\Http\Controllers\backend\vendor\VendorToolController::class);
    Route::get('/analytics', [\App\Http\Controllers\backend\vendor\VendorAnalyticsController::class, 'index'])->name('analytics');

    // Leads & Inquiries
    Route::get('/leads', [\App\Http\Controllers\backend\vendor\VendorLeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}', [\App\Http\Controllers\backend\vendor\VendorLeadController::class, 'updateStatus'])->name('leads.update-status');
    Route::get('/leads/export', [\App\Http\Controllers\backend\vendor\VendorLeadController::class, 'export'])->name('leads.export');

    // Blogs, Reviews & Billing
    Route::resource('blogs', \App\Http\Controllers\backend\vendor\VendorBlogController::class);
    Route::get('/reviews', [\App\Http\Controllers\backend\vendor\VendorReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/reply', [\App\Http\Controllers\backend\vendor\VendorReviewController::class, 'reply'])->name('reviews.reply');
    Route::get('/billing', [\App\Http\Controllers\backend\vendor\BillingController::class, 'index'])->name('billing');
    Route::post('/billing/subscribe', [\App\Http\Controllers\backend\vendor\BillingController::class, 'subscribe'])->name('billing.subscribe');
    Route::get('/profile', [\App\Http\Controllers\backend\vendor\VendorDashboardController::class, 'profile'])->name('profile');
});
