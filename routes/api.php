<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ShipmentController;
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
Route::post('register', [ApiAuthController::class, 'registerStore']);
Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/shipment',[ShipmentController::class, 'shipment'])->name('shipment');
Route::get('/province',[ShipmentController::class, 'province'])->name('province');
Route::get('/city',[ShipmentController::class, 'city'])->name('city');
Route::get('/getSnapToken',[ShipmentController::class, 'token'])->name('token');

Route::get('/order',[ShipmentController::class, 'order'])->name('order');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/add-product', [ProductController::class, 'addProduct'])->name('addProduct');
    Route::post('/add-category', [ProductController::class, 'addCategory'])->name('addCategory');
    Route::post('/add-subcategory', [ProductController::class, 'addSubcategory'])->name('addSubcategory');
    Route::post('/add-to-cart',[OrderController::class, 'addToCart'])->name('addToCart');
});