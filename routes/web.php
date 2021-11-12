<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

//* Disable route GET for logout
Route::get('/logout', function () {
    return redirect()->back();
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::middleware('isAdmin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    });
    // Route::get('/user', [HomeController::class, 'index'])->name('user');
    // Route::get('/user/profile', [HomeController::class, 'profile'])->name('user.profile');
});
