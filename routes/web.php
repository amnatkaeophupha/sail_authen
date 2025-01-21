<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CustomVerificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signin', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', function () { return view('auth.signup'); });
Route::post('/store', [AuthController::class, 'store']);
Route::get('/forgot-password', function () { return view('auth.forgot-password'); });
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::get('/reset-password/{token}', function (string $token) { return view('auth.reset-password', ['token' => $token]);})->name('password.reset');
Route::post('/reset-password', [AuthController::class,'resetPassword']);
Route::get('/signout', [AuthController::class, 'signout'])->name('signout');


/* login not Email Verification Notice table users email_verified_at date-time goto verify-email.blade.php */
Route::get('email/verify', function () { return view('auth.verify-email'); })->middleware('auth')->name('verification.notice');
/* Please click the button below to verify your email address. Verify Email Address update datetime email_verified_at*/
Route::get('email/verify/{id}/{hash}', [CustomVerificationController::class, 'verify'])->name('verification.verify')->middleware('signed');

/* route view('auth.verify-email') Send email verify your email address */
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return redirect('signin')->with('message', 'Verification link sent!');
})->middleware(['throttle:6,1']);

Route::group([],base_path('routes/admin.php'));
Route::group([],base_path('routes/manager.php'));








