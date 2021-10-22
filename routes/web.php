<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// user common routes
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    // profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('user.profile');
        Route::post('update', [HomeController::class, 'profileUpdate'])->name('user.profile.update');
        Route::post('password/update', [HomeController::class, 'passwordUpdate'])->name('user.password.update');
        Route::post('image/update', [HomeController::class, 'imageUpdate'])->name('user.profile.image.update');
    });

    // employee
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.employee.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.employee.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.employee.store');
        Route::post('/destroy', [UserController::class, 'destroy'])->name('user.employee.destroy');
        Route::post('/block', [UserController::class, 'block'])->name('user.employee.block');
    });
});
