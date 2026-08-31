<?php

use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\AlumniStoryController as AdminAlumniStoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommitteeMemberController as AdminCommitteeMemberController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\CorrectionRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController as AdminEventCategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ExpenseCategoryController as AdminExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Admin\FeePlanController as AdminFeePlanController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\GalleryAlbumController as AdminGalleryAlbumController;
use App\Http\Controllers\Admin\GalleryPhotoController as AdminGalleryPhotoController;
use App\Http\Controllers\Admin\LeaderboardController as AdminLeaderboardController;
use App\Http\Controllers\Admin\MembershipApplicationController as AdminMembershipApplicationController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\MembershipTierController as AdminMembershipTierController;
use App\Http\Controllers\Admin\MembershipTypeController as AdminMembershipTypeController;
use App\Http\Controllers\Admin\NewsCategoryController as AdminNewsCategoryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PublicationCategoryController as AdminPublicationCategoryController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniStoryPublicController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryPublicController;
use App\Http\Controllers\LeaderboardController as PublicLeaderboardController;
use App\Http\Controllers\Member\CorrectionRequestController as MemberCorrectionRequestController;
use App\Http\Controllers\Member\MemberApplicationController;
use App\Http\Controllers\Member\MemberAuthController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\MemberMembershipController;
use App\Http\Controllers\Member\MemberPaymentController;
use App\Http\Controllers\Member\MemberProfileController;
use App\Http\Controllers\Member\MemberRegisterController;
use App\Http\Controllers\Member\MemberSecurityController;
use App\Http\Controllers\Member\MemberVisibilityController;
use App\Http\Controllers\MemberDirectoryController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicationPublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');
Route::get('/committee', [CommitteeController::class, 'index'])->name('committee.index');
Route::get('/committee/{committeeMember}', [CommitteeController::class, 'show'])->name('committee.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/news', [NewsPublicController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsPublicController::class, 'show'])->name('news.show');
Route::get('/stories', [AlumniStoryPublicController::class, 'index'])->name('stories.index');
Route::get('/stories/{story}', [AlumniStoryPublicController::class, 'show'])->name('stories.show');
Route::get('/gallery', [GalleryPublicController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{album}', [GalleryPublicController::class, 'show'])->name('gallery.show');
Route::get('/leaderboard', [PublicLeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/finance', [PageController::class, 'finance'])->name('finance.public');
Route::get('/publications', [PublicationPublicController::class, 'index'])->name('publications.index');
Route::get('/publications/{publication}', [PublicationPublicController::class, 'show'])->name('publications.show');
Route::get('/publications/{publication}/download', [PublicationPublicController::class, 'download'])->name('publications.download');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public membership application (Feature 17).
Route::get('/membership', [PageController::class, 'membership'])->name('membership');
Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])->name('membership.apply');
Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])->name('membership.apply.store');
Route::get('/membership/application/{applicationNumber}/{token}', [MembershipApplicationController::class, 'status'])->name('membership.application.status');

// Public member directory (Feature 18).
Route::get('/members', [MemberDirectoryController::class, 'index'])->name('members.index');
Route::get('/members/{slug}', [MemberDirectoryController::class, 'show'])->name('member.show');

/*
|--------------------------------------------------------------------------
| Admin Auth routes (public)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.store')->middleware('guest');
Route::delete('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.show');

    // Site settings (announcement bar, etc.)
    Route::get('settings', [AdminSiteSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSiteSettingsController::class, 'update'])->name('settings.update');

    Route::resource('alumni', AdminAlumniController::class)
        ->parameters(['alumni' => 'alumni']);

    // Membership foundation (Feature 11). The `membership-types` and
    // `membership-tiers` literals are distinct route segments, so they do
    // not collide with the `members/{membership}` resource binding.
    Route::resource('members', AdminMembershipController::class)
        ->parameters(['members' => 'membership']);

    Route::post('members/{membership}/suspend', [AdminMembershipController::class, 'suspend'])
        ->name('members.suspend');
    Route::post('members/{membership}/activate', [AdminMembershipController::class, 'activate'])
        ->name('members.activate');
    Route::post('members/{membership}/public-toggle', [AdminMembershipController::class, 'togglePublic'])
        ->name('members.public-toggle');
    Route::post('members/{membership}/verify', [AdminMembershipController::class, 'verify'])
        ->name('members.verify');
    Route::post('members/{membership}/unverify', [AdminMembershipController::class, 'unverify'])
        ->name('members.unverify');
    Route::post('members/{membership}/disable', [AdminMembershipController::class, 'disable'])
        ->name('members.disable');
    Route::post('members/{membership}/enable', [AdminMembershipController::class, 'enable'])
        ->name('members.enable');

    // Member leaderboard (Feature 14).
    Route::get('leaderboard', [AdminLeaderboardController::class, 'index'])
        ->name('leaderboard.index');
    Route::post('leaderboard/{membership}/visibility', [AdminLeaderboardController::class, 'toggleVisibility'])
        ->name('leaderboard.visibility');
    Route::post('leaderboard/public-toggle', [AdminLeaderboardController::class, 'togglePublic'])
        ->name('leaderboard.togglePublic');

    Route::resource('membership-types', AdminMembershipTypeController::class)
        ->parameters(['membership-types' => 'membershipType'])
        ->except(['show']);

    Route::resource('membership-tiers', AdminMembershipTierController::class)
        ->parameters(['membership-tiers' => 'membershipTier'])
        ->except(['show']);

    // Fee plan management (Feature 12). The literal `fee-plans` segment is
    // distinct from `members/{membership}`, so no ordering conflicts exist.
    Route::resource('fee-plans', AdminFeePlanController::class)
        ->parameters(['fee-plans' => 'feePlan']);

    Route::post('fee-plans/{feePlan}/activate', [AdminFeePlanController::class, 'activate'])
        ->name('fee-plans.activate');
    Route::post('fee-plans/{feePlan}/deactivate', [AdminFeePlanController::class, 'deactivate'])
        ->name('fee-plans.deactivate');

    // Manual fee collection records (Feature 13). No destructive delete
    // route exists — payments are voided for audit safety.
    Route::resource('payments', AdminPaymentController::class)
        ->except(['destroy']);

    Route::post('payments/{payment}/void', [AdminPaymentController::class, 'void'])
        ->name('payments.void');

    // Association finance management (Feature 15). All financial data is
    // admin-only — there are deliberately no public finance routes. The
    // `expense-categories` literal is registered before the `expenses`
    // resource so the static category path can never be swallowed by
    // `expenses/{expense}` binding.
    Route::get('finance', [AdminFinanceController::class, 'index'])
        ->name('finance.index');

    Route::post('finance/public-toggle', [AdminFinanceController::class, 'togglePublic'])
        ->name('finance.togglePublic');

    Route::resource('expense-categories', AdminExpenseCategoryController::class)
        ->parameters(['expense-categories' => 'expenseCategory'])
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // No destructive delete route exists — expenses are voided for
    // audit safety, mirroring payments.
    Route::resource('expenses', AdminExpenseController::class)
        ->except(['destroy']);

    Route::post('expenses/{expense}/void', [AdminExpenseController::class, 'void'])
        ->name('expenses.void');

    Route::resource('committee', AdminCommitteeMemberController::class)
        ->parameters(['committee' => 'committeeMember']);

    // Event category routes must be registered before the `events` resource
    // so the literal `events/categories` path is not swallowed by
    // `events/{event}` slug binding.
    Route::resource('events/categories', AdminEventCategoryController::class)
        ->parameters(['events/categories' => 'category'])
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names([
            'index' => 'events.categories.index',
            'create' => 'events.categories.create',
            'store' => 'events.categories.store',
            'edit' => 'events.categories.edit',
            'update' => 'events.categories.update',
            'destroy' => 'events.categories.destroy',
        ]);

    Route::resource('events', AdminEventController::class)
        ->parameters(['events' => 'event']);

    Route::resource('news', AdminNewsController::class)
        ->parameters(['news' => 'news']);

    Route::resource('stories', AdminAlumniStoryController::class)
        ->parameters(['stories' => 'alumniStory']);

    Route::resource('gallery', AdminGalleryAlbumController::class)
        ->parameters(['gallery' => 'galleryAlbum']);

    Route::post('gallery/{galleryAlbum}/photos', [AdminGalleryPhotoController::class, 'store'])
        ->name('gallery.photos.store');
    Route::put('gallery/{galleryAlbum}/photos/{galleryPhoto}', [AdminGalleryPhotoController::class, 'update'])
        ->name('gallery.photos.update');
    Route::delete('gallery/{galleryAlbum}/photos/{galleryPhoto}', [AdminGalleryPhotoController::class, 'destroy'])
        ->name('gallery.photos.destroy');

    Route::resource('news-categories', AdminNewsCategoryController::class)
        ->parameters(['news-categories' => 'newsCategory'])
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('publications', AdminPublicationController::class)
        ->parameters(['publications' => 'publication']);

    Route::resource('publication-categories', AdminPublicationCategoryController::class)
        ->parameters(['publication-categories' => 'publicationCategory'])
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('messages', AdminContactMessageController::class)
        ->parameters(['messages' => 'contactMessage'])
        ->only(['index', 'show', 'update', 'destroy']);

    // Membership applications (Feature 17). The `membership-applications`
    // literal is distinct from `members/{membership}` resource binding.
    Route::resource('membership-applications', AdminMembershipApplicationController::class)
        ->parameters(['membership-applications' => 'application'])
        ->only(['index', 'show']);

    Route::post('membership-applications/{application}/review', [AdminMembershipApplicationController::class, 'review'])
        ->name('membership-applications.review');
    Route::post('membership-applications/{application}/approve', [AdminMembershipApplicationController::class, 'approve'])
        ->name('membership-applications.approve');

    Route::resource('correction-requests', CorrectionRequestController::class)
        ->parameters(['correction-requests' => 'correctionRequest'])
        ->only(['index', 'show']);
    Route::post('correction-requests/{correctionRequest}/approve', [CorrectionRequestController::class, 'approve'])
        ->name('correction-requests.approve');
    Route::post('correction-requests/{correctionRequest}/reject', [CorrectionRequestController::class, 'reject'])
        ->name('correction-requests.reject');
});

/*
|--------------------------------------------------------------------------
| Member Auth routes (public)
|--------------------------------------------------------------------------
*/

Route::prefix('member')->name('member.')->middleware('guest')->group(function () {
    Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MemberAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [MemberRegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [MemberRegisterController::class, 'register'])->name('register.store');

    Route::get('/forgot-password', [MemberAuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [MemberAuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [MemberAuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [MemberAuthController::class, 'reset'])->name('password.update');
});

Route::delete('/member/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

/*
|--------------------------------------------------------------------------
| Member routes (authenticated + active membership required)
|--------------------------------------------------------------------------
*/

Route::prefix('member')->name('member.')->middleware(['auth', 'member', 'member.active'])->group(function () {
    Route::get('/email/verify', [MemberSecurityController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [MemberSecurityController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [MemberSecurityController::class, 'resendVerificationEmail'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/', [MemberDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [MemberProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MemberProfileController::class, 'update'])->name('profile.update');

    Route::get('/membership', [MemberMembershipController::class, 'show'])->name('membership');

    Route::get('/payments', [MemberPaymentController::class, 'index'])->name('payments');

    Route::get('/applications', [MemberApplicationController::class, 'index'])->name('applications');

    Route::patch('/visibility', [MemberVisibilityController::class, 'toggle'])->name('visibility.toggle');

    Route::get('/security', [MemberSecurityController::class, 'index'])->name('security');
    Route::put('/security/password', [MemberSecurityController::class, 'updatePassword'])->name('security.password.update');

    Route::post('/correction-requests', [MemberCorrectionRequestController::class, 'store'])->name('correction-requests.store');
});
