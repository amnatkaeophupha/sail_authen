<?php

use Illuminate\Support\Facades\Route;

Route::prefix('manager')->middleware(['role:manager'])->group(function () {

    Route::get('/', function () {

        return view('manager.dashboard');
    });

});
