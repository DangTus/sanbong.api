<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owner;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FieldController;
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

// Field Type
Route::get('/field-type', [HomeController::class, 'fieldType']);

// Customer
Route::group(['prefix' => 'customer'], function () {

    Route::get('/by-id', [CustomerController::class, 'getById']);
    Route::post('/update', [CustomerController::class, 'update']);
});

// Field
Route::group(['prefix' => 'field'], function () {

    Route::get('/by-location', [FieldController::class, 'getByLocation']);
    Route::get('/by-type-and-location', [FieldController::class, 'getByTypeAndLocation']);
    Route::get('/by-id', [FieldController::class, 'getById']);
    Route::post('/create', [FieldController::class, 'create']);
    Route::post('/update', [FieldController::class, 'update']);
    Route::post('/delete', [FieldController::class, 'delete']);
});

// Booking
Route::group(['prefix' => 'booking'], function () {

    Route::get('/by-location', [Owner\BookingController::class, 'getByLocation']);
    Route::get('/by-id', [Owner\BookingController::class, 'getById']);
    Route::post('/update', [Owner\BookingController::class, 'update']);
});

// Owner
Route::group(['prefix' => 'owner'], function () {

    // Location
    Route::group(['prefix' => 'location'], function () {

        Route::get('/', [Owner\LocationController::class, 'locationByUser']);
        Route::post('/update', [Owner\LocationController::class, 'updateLocation']);
        Route::get('/all-status', [Owner\LocationController::class, 'allStatus']);
    });

    // Time slot
    Route::group(['prefix' => 'time-slot'], function () {

        Route::get('/with-price', [Owner\TimeSlotController::class, 'getWithPrice']);
        Route::post('/update-price-by-timeslot', [Owner\TimeSlotController::class, 'updatePriceByTimeSlot']);
    });
});

// Admin
Route::group(['prefix' => 'admin'], function () {

    // Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/verification', [Admin\UserController::class, 'verification']);
    Route::post('/verification', [Admin\UserController::class, 'postVerification']);
});
