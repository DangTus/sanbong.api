<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owner;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']);

// Address
Route::get('/province', [AddressController::class, 'allProvince']);
Route::get('/district', [AddressController::class, 'districtByProvince']);
Route::get('/ward', [AddressController::class, 'wardByDistrict']);
Route::get('/ward-detail', [AddressController::class, 'wardByID']);

// Location
Route::group(['prefix' => 'location'], function () {

    Route::get('/by-ward', [Customer\LocationController::class, 'locationByWard']);
    Route::get('/by-id', [Customer\LocationController::class, 'locationByID']);
    Route::get('/time-slot', [Customer\LocationController::class, 'timeSlot']);
    Route::post('/book-field', [Customer\LocationController::class, 'bookField']);
});

Route::get('/field-type', [HomeController::class, 'fieldType']);
Route::get('/field-by-type-and-location', [Customer\FieldController::class, 'fieldByTypeAndLocation']);

// Owner
Route::group(['prefix' => 'owner'], function () {

    // Location
    Route::group(['prefix' => 'location'], function () {

        Route::get('/', [Owner\LocationController::class, 'locationByUser']);
        Route::post('/update', [Owner\LocationController::class, 'updateLocation']);
        Route::get('/all-status', [Owner\LocationController::class, 'allStatus']);
    });
});

// Admin
Route::group(['prefix' => 'admin'], function () {

    // Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/verification', [Admin\UserController::class, 'verification']);
    Route::post('/verification', [Admin\UserController::class, 'postVerification']);
});
