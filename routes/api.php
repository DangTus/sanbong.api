<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Owner;
use App\Http\Controllers\Admin;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddressController;

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

Route::get('/test', [LoginController::class, 'test']);

Route::post('/login', [LoginController::class, 'login']);

// Address
Route::get('/province', [AddressController::class, 'allProvince']);
Route::get('/district', [AddressController::class, 'districtByProvince']);
Route::get('/ward', [AddressController::class, 'wardByDistrict']);
Route::get('/ward-detail', [AddressController::class, 'wardByID']);

// Admin
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/verification', [Admin\UserController::class, 'verification']);
    Route::post('/verification', [Admin\UserController::class, 'postVerification']);
});
