<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::prefix('admin')->middleware(['role:admin'])->group(function () {

    Route::get('/', function () { return view('admin.dashboard'); });
    Route::get('/profile', function () { return view('admin.user-profile'); });
    Route::post('/profile_images', [AuthController::class,'profile_images']);
    Route::post('/profile_update', [AuthController::class,'profile_update']);

    Route::get('/users', [UserController::class,'index']);
    Route::post('/users/store', [UserController::class,'store']);
    Route::post('/users/update', [UserController::class,'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
