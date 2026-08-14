<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SPA-First Routing
|--------------------------------------------------------------------------
|
| The storefront, customer dashboard, and admin panel now live in the React
| SPA under /frontend. Blade routes are kept ONLY for flows that still need a
| server-rendered page (email verification / password reset links), and a
| catch-all hands every other GET request to the built SPA so client-side
| routes such as /login, /admin or /admin/dashboard survive hard refreshes
| and deep links instead of returning a 404.
|
| API endpoints are registered separately in routes/api.php (they are added
| to the router before these web routes, so /api/* always wins).
|
*/

// Named 'login' route — keeps route('login') (used by the guest/auth redirect)
// working while serving the React user login screen.
Route::get('/login', function () {
    return spaResponse();
})->name('login');

// --- Server-rendered email flows (still Blade) ---
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// --- Legacy dashboard alias — kept so route('dashboard') keeps resolving ---
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect('/admin/dashboard');
    }

    return redirect('/profile');
})->name('dashboard');

// --- React SPA entry + history fallback ---
function spaResponse()
{
    $spaIndex = base_path('frontend/dist/index.html');

    if (is_file($spaIndex)) {
        return response(file_get_contents($spaIndex))->header('Content-Type', 'text/html');
    }

    abort(404, 'Frontend build not found. Run `npm run build` inside frontend/.');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', function () {
    return spaResponse();
})->where('any', '.*');
