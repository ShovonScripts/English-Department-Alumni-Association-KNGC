<?php

use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\AlumniStoryController as AdminAlumniStoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\BatchController as AdminBatchController;
use App\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\CorrectionRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController as AdminEventCategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ExpenseCategoryController as AdminExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\GalleryAlbumController as AdminGalleryAlbumController;
use App\Http\Controllers\Admin\GalleryPhotoController as AdminGalleryPhotoController;
use App\Http\Controllers\Admin\HomeSliderController as AdminHomeSliderController;
use App\Http\Controllers\Admin\LeaderboardController as AdminLeaderboardController;
use App\Http\Controllers\Admin\MembershipApplicationController as AdminMembershipApplicationController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\MembershipTierController as AdminMembershipTierController;
use App\Http\Controllers\Admin\MembershipTypeController as AdminMembershipTypeController;
use App\Http\Controllers\Admin\NewsCategoryController as AdminNewsCategoryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PressReleaseController as AdminPressReleaseController;
use App\Http\Controllers\Admin\PublicationCategoryController as AdminPublicationCategoryController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
use App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniStoryPublicController;
use App\Http\Controllers\CommitteePublicController;
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
use App\Http\Controllers\PressReleasePublicController;
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
Route::get('/committees', [CommitteePublicController::class, 'index'])->name('committees.index');
Route::get('/committees/history/{type}', [CommitteePublicController::class, 'history'])->name('committees.history');
Route::get('/committees/{type}/{committee}', [CommitteePublicController::class, 'show'])->name('committees.show');
Route::get('/publications', [PublicationPublicController::class, 'index'])->name('publications.index');
Route::get('/publications/{publication}', [PublicationPublicController::class, 'show'])->name('publications.show');
Route::get('/publications/{publication}/download', [PublicationPublicController::class, 'download'])->name('publications.download');
Route::get('/press-releases', [PressReleasePublicController::class, 'index'])->name('press-releases.index');
Route::get('/press-releases/{pressRelease}', [PressReleasePublicController::class, 'show'])->name('press-releases.show');
Route::get('/press-releases/{pressRelease}/download', [PressReleasePublicController::class, 'download'])->name('press-releases.download');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/credits', [PageController::class, 'credits'])->name('credits');

// Public SEO files
Route::get('/sitemap.xml', function () {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if ($disk->exists('sitemap.xml')) {
        return response($disk->get('sitemap.xml'), 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
    return response('Not Found', 404);
})->name('sitemap');

Route::get('/robots.txt', function () {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if ($disk->exists('robots.txt')) {
        return response($disk->get('robots.txt'), 200, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
    return response("User-agent: *\nAllow: /\n", 200, [
        'Content-Type' => 'text/plain',
    ]);
})->name('robots');

// Comments
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

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
Route::delete('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

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

    // Admin management
    Route::get('admins', [AdminAdminController::class, 'index'])->name('admins.index');
    Route::get('admins/create', [AdminAdminController::class, 'create'])->name('admins.create');
    Route::post('admins', [AdminAdminController::class, 'store'])->name('admins.store');
    Route::get('admins/{admin}', [AdminAdminController::class, 'show'])->name('admins.show');
    Route::get('admins/{admin}/edit', [AdminAdminController::class, 'edit'])->name('admins.edit');
    Route::put('admins/{admin}', [AdminAdminController::class, 'update'])->name('admins.update');
    Route::delete('admins/{admin}', [AdminAdminController::class, 'destroy'])->name('admins.destroy');
    Route::post('admins/{admin}/toggle-status', [AdminAdminController::class, 'toggleStatus'])->name('admins.toggle-status');

    // Activity log
    Route::get('activity-log', [AdminActivityLogController::class, 'index'])->name('activity-log.index');

    // Home slider images for Facebook Group CTA
    Route::get('home-slider', [AdminHomeSliderController::class, 'index'])->name('home-slider.index');
    Route::post('home-slider', [AdminHomeSliderController::class, 'store'])->name('home-slider.store');
    Route::put('home-slider/{slide}', [AdminHomeSliderController::class, 'update'])->name('home-slider.update');
    Route::delete('home-slider/{slide}', [AdminHomeSliderController::class, 'destroy'])->name('home-slider.destroy');
    Route::put('home-slider-reorder', [AdminHomeSliderController::class, 'reorder'])->name('home-slider.reorder');

    // Testimonials for home page
    Route::resource('testimonials', AdminTestimonialController::class)
        ->parameters(['testimonials' => 'testimonial'])
        ->except(['show']);

    Route::resource('alumni', AdminAlumniController::class)
        ->parameters(['alumni' => 'alumni']);

    Route::resource('batches', AdminBatchController::class)
        ->parameters(['batches' => 'batch'])
        ->except(['show']);

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
    Route::post('members/{membership}/recalculate-tier', [AdminMembershipController::class, 'recalculateTier'])
        ->name('members.recalculate-tier');

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

    // Manual fee collection records (Feature 13). Voiding is preferred
    // for audit safety, but hard delete is available for admins.
    Route::resource('payments', AdminPaymentController::class);

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

    // Expense records (Feature 15). Voiding is preferred for audit safety,
    // but hard delete is available for admins.
    Route::resource('expenses', AdminExpenseController::class);

    Route::post('expenses/{expense}/void', [AdminExpenseController::class, 'void'])
        ->name('expenses.void');

    // Committee management (Feature 23).
    Route::get('committee-types', [AdminCommitteeController::class, 'typeIndex'])
        ->name('committee-types.index');
    Route::get('committee-types/create', [AdminCommitteeController::class, 'typeCreate'])
        ->name('committee-types.create');
    Route::post('committee-types', [AdminCommitteeController::class, 'typeStore'])
        ->name('committee-types.store');
    Route::get('committee-types/{committeeType}', [AdminCommitteeController::class, 'typeShow'])
        ->name('committee-types.show');
    Route::get('committee-types/{committeeType}/edit', [AdminCommitteeController::class, 'typeEdit'])
        ->name('committee-types.edit');
    Route::put('committee-types/{committeeType}', [AdminCommitteeController::class, 'typeUpdate'])
        ->name('committee-types.update');
    Route::delete('committee-types/{committeeType}', [AdminCommitteeController::class, 'typeDestroy'])
        ->name('committee-types.destroy');

    Route::get('committee-roles', [AdminCommitteeController::class, 'roleIndex'])
        ->name('committee-roles.index');
    Route::post('committee-roles', [AdminCommitteeController::class, 'roleStore'])
        ->name('committee-roles.store');
    Route::post('committee-roles/{role}/up', [AdminCommitteeController::class, 'roleUp'])
        ->name('committee-roles.up');
    Route::post('committee-roles/{role}/down', [AdminCommitteeController::class, 'roleDown'])
        ->name('committee-roles.down');
    Route::delete('committee-roles/{role}', [AdminCommitteeController::class, 'roleDestroy'])
        ->name('committee-roles.destroy');

    Route::resource('committees', AdminCommitteeController::class)
        ->parameters(['committees' => 'committee']);

    Route::post('committees/{committee}/make-current', [AdminCommitteeController::class, 'makeCurrent'])
        ->name('committees.make-current');
    Route::post('committees/{committee}/add-member', [AdminCommitteeController::class, 'addMember'])
        ->name('committees.add-member');
    Route::delete('committees/{committee}/members/{membership}', [AdminCommitteeController::class, 'removeMember'])
        ->name('committees.remove-member');
    Route::put('committees/{committee}/members/{membership}/role', [AdminCommitteeController::class, 'updateMemberRole'])
        ->name('committees.update-member-role');

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

    Route::get('publications/{publication}/document', [AdminPublicationController::class, 'documentView'])
        ->name('publications.document.view');
    Route::get('publications/{publication}/document/download', [AdminPublicationController::class, 'documentDownload'])
        ->name('publications.document.download');

    Route::resource('publication-categories', AdminPublicationCategoryController::class)
        ->parameters(['publication-categories' => 'publicationCategory'])
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('press-releases', AdminPressReleaseController::class)
        ->parameters(['press-releases' => 'pressRelease']);

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

    // SEO Manager
    Route::get('seo', [AdminSeoController::class, 'index'])->name('seo.index');
    Route::get('seo/settings', [AdminSeoController::class, 'settings'])->name('seo.settings');
    Route::put('seo/settings', [AdminSeoController::class, 'updateSettings'])->name('seo.settings.update');
    Route::get('seo/pages', [AdminSeoController::class, 'pages'])->name('seo.pages');
    Route::get('seo/pages/{uri}/edit', [AdminSeoController::class, 'editPage'])->name('seo.pages.edit');
    Route::put('seo/pages/{uri}', [AdminSeoController::class, 'updatePage'])->name('seo.pages.update');
    Route::delete('seo/pages/{uri}', [AdminSeoController::class, 'resetPage'])->name('seo.pages.reset');
    Route::get('seo/sitemap', [AdminSeoController::class, 'sitemap'])->name('seo.sitemap');
    Route::post('seo/sitemap/generate', [AdminSeoController::class, 'generateSitemap'])->name('seo.sitemap.generate');
    Route::get('seo/robots', [AdminSeoController::class, 'robots'])->name('seo.robots');
    Route::put('seo/robots', [AdminSeoController::class, 'updateRobots'])->name('seo.robots.update');
    Route::delete('seo/robots', [AdminSeoController::class, 'resetRobots'])->name('seo.robots.reset');
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

Route::delete('/member/logout', [MemberAuthController::class, 'logout'])->name('member.logout')->middleware('auth');
Route::get('/member/account-status', [MemberAuthController::class, 'accountStatus'])->name('member.account-status');

/*
|--------------------------------------------------------------------------
| Member routes (authenticated + active membership required)
|--------------------------------------------------------------------------
*/

Route::prefix('member')->name('member.')->middleware(['auth', 'member', 'member.active'])->group(function () {
    Route::get('/', [MemberDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [MemberProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MemberProfileController::class, 'update'])->name('profile.update');

    Route::get('/membership', [MemberMembershipController::class, 'show'])->name('membership');
    Route::get('/membership/card', [MemberMembershipController::class, 'card'])->name('membership.card');

    Route::get('/payments', [MemberPaymentController::class, 'index'])->name('payments');

    Route::get('/applications', [MemberApplicationController::class, 'index'])->name('applications');

    Route::patch('/visibility', [MemberVisibilityController::class, 'toggle'])->name('visibility.toggle');
    Route::get('/privacy', [MemberVisibilityController::class, 'show'])->name('privacy');

    Route::get('/security', [MemberSecurityController::class, 'index'])->name('security');
    Route::put('/security/password', [MemberSecurityController::class, 'updatePassword'])->name('security.password.update');

    Route::post('/correction-requests', [MemberCorrectionRequestController::class, 'store'])->name('correction-requests.store');
});
