<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () { return view('index'); });
Route::get('/about-us', function () { return view('about-us'); });

Route::get('/pricing',  [PricingController::class, 'index'])->name('pricing');
Route::post('/pricing/register', [PricingController::class, 'register'])->name('pricing.register');

Route::get('/workshops',   function () { return view('workshops'); });
Route::get('/faqs',        function () { return view('faqs'); });
Route::get('/contact-us',  function () { return view('contact-us'); });
Route::get('/impressum',   function () { return view('impressum'); });
Route::get('/datenschutz', function () { return view('datenschutz'); });
Route::get('/agb',         function () { return view('agb'); });
Route::get('/legal-disclaimer', function () { return view('legal-disclaimer'); });


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
 
/* ── Dashboard (auth-protected) ── */
Route::middleware('auth')->group(function () {
    Route::get('/user-dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user-dashboard/profile', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
});