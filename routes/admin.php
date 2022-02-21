<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminController;


Route::name('admin.')->namespace('Admin')->prefix('admin')->group(function () {

    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'login'])->name('login');
        Route::post('/login', [AdminController::class, 'processLogin']);
    });

    Route::namespace('Auth')->middleware('auth:admin')->group(function () {

        Route::post('/logout', function () {
            Auth::guard('admin')->logout();
            return redirect()->action([
                AdminController::class,
                'login'
            ]);
        })->name('logout');
    });

});
