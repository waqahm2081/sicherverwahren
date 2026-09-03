<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnsitePaymentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PackagesController as AdminPackagesController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\VideosController as VideosController;
use App\Http\Controllers\Admin\BlogsController as AdminBlogsController;
use App\Http\Controllers\Admin\CouponsController as AdminCouponsController;
use App\Http\Controllers\Admin\LeadsController as AdminLeadsController;
use App\Http\Controllers\Admin\FaqsController as AdminFaqsController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/* ── Public pages ── */
Route::get('/', function () {
    $latestBlogs = \App\Models\Blog::with('category')
        ->published()
        ->latest('published_at')
        ->limit(3)
        ->get();
    return view('index', compact('latestBlogs'));
});

Route::get('/about-us', function () { return view('about-us'); });

Route::get('/pricing',  [PricingController::class, 'index'])->name('pricing.index');
Route::post('/pricing/payment-intent', [PricingController::class, 'createPaymentIntent'])->name('pricing.paymentIntent');
Route::post('/pricing/validate-coupon', [PricingController::class, 'validateCoupon'])->name('pricing.validateCoupon');
Route::post('/pricing/register', [PricingController::class, 'register'])->name('pricing.register');

/* ── Onsite payment link ── */
Route::get('/pay/{token}',           [OnsitePaymentController::class, 'show'])->name('onsite.pay.show');
Route::post('/pay/{token}/intent',   [OnsitePaymentController::class, 'createIntent'])->name('onsite.pay.intent');
Route::post('/pay/{token}/complete', [OnsitePaymentController::class, 'complete'])->name('onsite.pay.complete');

Route::get('/workshops',        function () { return view('workshops'); });
Route::get('/faqs',             [FaqController::class, 'index'])->name('faqs.index');
Route::get('/sitemap.xml',      [SitemapController::class, 'index'])->name('sitemap');
Route::get('/contact-us',       function () { return view('contact-us'); });
Route::get('/impressum',        function () { return view('impressum'); });
Route::get('/datenschutz',      function () { return view('datenschutz'); });
Route::get('/agb',              function () { return view('agb'); });
Route::get('/legal-disclaimer', function () { return view('legal-disclaimer'); });

/* ── Blog (public) ── */
Route::get('/blog',        [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/lead/submit', [BlogController::class, 'submitLead'])
    ->middleware('throttle:10,1')
    ->name('lead.submit');

/* ── User auth ── */
Route::get('/login', fn () => view('login'))->name('login')->middleware('guest');

Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update')->middleware('guest');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::validate($credentials)) {
        return back()->withErrors([
            'email' => 'Die eingegebenen Zugangsdaten sind ungültig.',
        ])->onlyInput('email');
    }

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if (! $user->isAdmin() && ! $user->is_approved) {
        return back()->withErrors([
            'email' => 'Ihr Konto wurde noch nicht freigeschaltet. Sobald ein Administrator Ihr Konto genehmigt hat, können Sie sich anmelden. Bei Fragen kontaktieren Sie bitte den Support.',
        ])->onlyInput('email');
    }

    if (! $user->isAdmin() && $user->selected_option_type === 'onsite' && ! $user->payment_completed) {
        return back()->withErrors([
            'email' => 'Ihre Zahlung ist noch ausstehend. Bitte verwenden Sie den Zahlungslink, den wir Ihnen per E-Mail zugesendet haben, um Ihren Zugang freizuschalten.',
        ])->onlyInput('email');
    }

    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    return redirect()->intended('/user-dashboard');
})->name('login.post')->middleware('guest');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/* ── User Dashboard ── */
Route::middleware('auth')->group(function () {
    Route::get('/user-dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::match(['post', 'patch'], '/user-dashboard/profile', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
});

/* ── Admin routes ── */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Packages
        Route::get('/packages',                    [AdminPackagesController::class, 'index'])->name('packages.index');
        Route::get('/packages/create',             [AdminPackagesController::class, 'create'])->name('packages.create');
        Route::post('/packages',                   [AdminPackagesController::class, 'store'])->name('packages.store');
        Route::get('/packages/{package}/edit',     [AdminPackagesController::class, 'edit'])->name('packages.edit');
        Route::put('/packages/{package}',          [AdminPackagesController::class, 'update'])->name('packages.update');
        Route::patch('/packages/{package}/toggle', [AdminPackagesController::class, 'toggleActive'])->name('packages.toggle');
        Route::delete('/packages/{package}',       [AdminPackagesController::class, 'destroy'])->name('packages.destroy');

        // Videos
        Route::get   ('videos',              [VideosController::class, 'index'])   ->name('videos.index');
        Route::get   ('videos/create',       [VideosController::class, 'create'])  ->name('videos.create');
        Route::post  ('videos',              [VideosController::class, 'store'])   ->name('videos.store');
        Route::get   ('videos/{video}/edit', [VideosController::class, 'edit'])    ->name('videos.edit');
        Route::put   ('videos/{video}',      [VideosController::class, 'update'])  ->name('videos.update');
        Route::delete('videos/{video}',      [VideosController::class, 'destroy']) ->name('videos.destroy');
        Route::post  ('videos/reorder',      [VideosController::class, 'reorder']) ->name('videos.reorder');

        // Orders
        Route::get('/orders',        [AdminOrdersController::class, 'index'])->name('orders.index');
        Route::get('/orders/{user}', [AdminOrdersController::class, 'show'])->name('orders.show');

        // Users
        Route::get('/users',                  [AdminUsersController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit',      [AdminUsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',           [AdminUsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',        [AdminUsersController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/approve', [AdminUsersController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/payment-link', [AdminUsersController::class, 'sendPaymentLink'])->name('users.paymentLink');
        Route::post('/users/{user}/ship', [AdminUsersController::class, 'markShipped'])->name('users.ship');
        Route::patch('/users/{user}/access', [AdminUsersController::class, 'updateAccess'])->name('users.access');
        Route::post('/users/{user}/access/simulate', [AdminUsersController::class, 'simulateAccess'])->name('users.access.simulate');
        Route::post('/users/{user}/automated-email', [AdminUsersController::class, 'sendAutomatedEmail'])->name('users.automatedEmail');

        // Coupons
        Route::get('/coupons', [AdminCouponsController::class, 'index'])->name('coupons.index');
        Route::put('/coupons/{coupon}', [AdminCouponsController::class, 'update'])->name('coupons.update');

        // Blog Categories MUST come before /blogs/{blog} wildcard routes
        Route::get('/blogs/categories',               [AdminBlogsController::class, 'categoriesIndex'])->name('blogs.categories');
        Route::post('/blogs/categories',              [AdminBlogsController::class, 'categoryStore'])->name('blogs.category.store');
        Route::put('/blogs/categories/{category}',    [AdminBlogsController::class, 'categoryUpdate'])->name('blogs.category.update');
        Route::delete('/blogs/categories/{category}', [AdminBlogsController::class, 'categoryDestroy'])->name('blogs.category.destroy');

        // Blogs
        Route::get('/blogs',             [AdminBlogsController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/create',      [AdminBlogsController::class, 'create'])->name('blogs.create');
        Route::post('/blogs',            [AdminBlogsController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{blog}/edit', [AdminBlogsController::class, 'edit'])->name('blogs.edit');
        Route::put('/blogs/{blog}',      [AdminBlogsController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}',   [AdminBlogsController::class, 'destroy'])->name('blogs.destroy');

        // Leads
        Route::get('/leads', [AdminLeadsController::class, 'index'])->name('leads.index');
        Route::patch('/leads/{lead}', [AdminLeadsController::class, 'update'])->name('leads.update');
        Route::delete('/leads/{lead}', [AdminLeadsController::class, 'destroy'])->name('leads.destroy');

        // FAQs
        Route::get('/faqs', [AdminFaqsController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [AdminFaqsController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [AdminFaqsController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminFaqsController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [AdminFaqsController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [AdminFaqsController::class, 'destroy'])->name('faqs.destroy');
        Route::post('/faqs/reorder', [AdminFaqsController::class, 'reorder'])->name('faqs.reorder');

        // Admin profile / password
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
