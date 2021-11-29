<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
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

//* Disable route GET for logout
Route::get('/logout', function () {
    return redirect()->back();
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::middleware('isAdmin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::prefix('cars')->group(function () {
            Route::resource('/car-brands', CarBrandController::class)
                ->names('admin.car-brands');
            Route::resource('/car-models', CarModelController::class)
                ->names('admin.car-models');
            Route::resource('/cars', CarController::class)
                ->names('admin.cars');
        });

        Route::resource('drivers', DriverController::class)->names('admin.drivers');
    });

    Route::prefix('model')->group(function () {
        Route::get('dropdown', [CarModelController::class, 'dropdown'])->name('model.dropdown');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('filter', [HomeController::class, 'carsFilter'])->name('carsFilter');
