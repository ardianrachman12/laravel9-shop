<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ShipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/shipment',[ShipmentController::class, 'shipment'])->name('shipment');
Route::get('/province',[ShipmentController::class, 'province'])->name('province');
Route::get('/city',[ShipmentController::class, 'city'])->name('city');
Route::get('/getSnapToken',[ShipmentController::class, 'token'])->name('token');

Route::get('/order',[ShipmentController::class, 'order'])->name('order');

