<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarInAndOutController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CheckoutController;
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
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard.index');
        Route::get('dashboard/{checkout}', [DashboardController::class, 'show'])
            ->name('admin.dashboard.show');
        Route::get('dashboard/{checkout}/edit', [DashboardController::class, 'edit'])->name('admin.dashboard.edit');
        Route::patch('dashboard/{checkout}', [DashboardController::class, 'update'])->name('admin.dashboard.update');
        Route::get('checkouts/export/', [DashboardController::class, 'export'])->name('admin.dashboard.export');

        Route::prefix('cars')->group(function () {
            Route::resource('/car-brands', CarBrandController::class)
                ->names('admin.car-brands');
            Route::resource('/car-models', CarModelController::class)
                ->names('admin.car-models');
            Route::resource('/cars', CarController::class)
                ->names('admin.cars');
        });

        Route::resource('drivers', DriverController::class)->names('admin.drivers');
        Route::resource('banks', BankController::class)->names('admin.banks');

        Route::get('car-in-and-out', [CarInAndOutController::class, 'index'])->name('admin.car-in-and-out.index');
        Route::get('car-in-and-out/{checkout}', [CarInAndOutController::class, 'show'])->name('admin.car-in-and-out.show');
        Route::get('car-in-and-out/{checkout}/edit', [CarInAndOutController::class, 'edit'])->name('admin.car-in-and-out.edit');
        Route::patch('car-in-and-out/{checkout}', [CarInAndOutController::class, 'update'])->name('admin.car-in-and-out.update');
    });

    Route::prefix('model')->group(function () {
        Route::get('dropdown', [CarModelController::class, 'dropdown'])->name('model.dropdown');
    });

    Route::middleware('isCarAvaillable')->group(function () {
        Route::get('car-booking/{car}', [BookingController::class, 'carBooking'])->name('car-booking');
    });
    Route::post('car-booking-create', [BookingController::class, 'carBookingCreate'])->name('car-booking.create');

    Route::middleware('userCheckout')->group(function () {
        Route::get('car-checkout/{checkout}', [CheckoutController::class, 'checkoutBooking'])->name('car-checkout');
        Route::patch('car-checkout-update/{checkout}', [CheckoutController::class, 'checkoutUpdate'])
            ->name('car-checkout.update');
        Route::get('car-checkout-upload-proof/{checkout}', [CheckoutController::class, 'uploadProofIndex'])
            ->name('car-checkout.upload-proof');
        Route::get('invoice/{checkout}', [CheckoutController::class, 'invoice'])->name('invoice');

        Route::patch('cancel-checkout/{checkout}', [CheckoutController::class, 'cancelCheckout'])->name('cancel-checkout');
        Route::patch('upload-proof/{checkout}', [CheckoutController::class, 'uploadProof'])->name('upload-proof');
    });

    Route::get('my-checkout', [CheckoutController::class, 'myCheckoutIndex'])->name('my-checkout.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('isCarAvaillable')
    ->get('car-detail/{car}', [BookingController::class, 'carDetail'])
    ->name('car-detail');

// ajax request for car filter
Route::get('filter', [HomeController::class, 'carsFilter'])->name('carsFilter');
