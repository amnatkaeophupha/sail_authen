<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('admin')->middleware(['role:admin'])->group(function () {

    Route::get('/', function () { return view('admin.dashboard'); });
    Route::get('/profile', function () { return view('admin.user-profile'); });
    Route::post('/profile_images', [AuthController::class,'profile_images']);

    Route::get('/resize', [AuthController::class,'resize']);
});
