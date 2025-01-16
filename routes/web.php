<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

Route::group([],base_path('routes/admin.php'));
Route::group([],base_path('routes/manager.php'));


