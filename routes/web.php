<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PackagesController as AdminPackagesController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;

/* ── Public pages ── */
Route::get('/', function () { return view('index'); });
Route::get('/about-us', function () { return view('about-us'); });

Route::get('/pricing',  [PricingController::class, 'index'])->name('pricing.index');
Route::post('/pricing/payment-intent', [PricingController::class, 'createPaymentIntent'])->name('pricing.paymentIntent');
Route::post('/pricing/register', [PricingController::class, 'register'])->name('pricing.register');

Route::get('/workshops',        function () { return view('workshops'); });
Route::get('/faqs',             function () { return view('faqs'); });
Route::get('/contact-us',       function () { return view('contact-us'); });
Route::get('/impressum',        function () { return view('impressum'); });
Route::get('/datenschutz',      function () { return view('datenschutz'); });
Route::get('/agb',              function () { return view('agb'); });
Route::get('/legal-disclaimer', function () { return view('legal-disclaimer'); });

/* ── User auth ── */
Route::get('/login', fn () => view('login'))->name('login')->middleware('guest');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/user-dashboard');
    }

    return back()->withErrors([
        'email' => 'Die eingegebenen Zugangsdaten sind ungültig.',
    ])->onlyInput('email');
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
    Route::post('/user-dashboard/profile', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
});

/* ── Admin routes ── */
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
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

        // Orders
        Route::get('/orders',              [AdminOrdersController::class, 'index'])->name('orders.index');
        Route::get('/orders/{user}',       [AdminOrdersController::class, 'show'])->name('orders.show');

        // Users
        Route::get('/users',               [AdminUsersController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit',   [AdminUsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',        [AdminUsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',     [AdminUsersController::class, 'destroy'])->name('users.destroy');
    });
});