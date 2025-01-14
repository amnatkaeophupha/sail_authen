<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['role:admin'])->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    });
});
