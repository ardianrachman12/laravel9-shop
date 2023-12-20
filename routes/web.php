<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth:web')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('/profile-admin', [DashboardController::class, 'profileAdmin']);
    Route::post('/update-profile', [DashboardController::class, 'updateProfile']);
    Route::resource('admin', AdminController::class);
    Route::resource('kategori', CategoryController::class);
    Route::resource('subkategori', SubcategoryController::class);
    Route::resource('produk', ProductController::class);
    Route::post('produk/select-category', [ProductController::class, 'selectCategory'])->name('produk.select-category');
    Route::resource('slider', SliderController::class);
    Route::resource('member', MemberController::class);
    Route::get('order/pesananbaru', [AdminOrderController::class, 'pesananbaru'])->name('pesananbaru');
    Route::get('order/pesananbayar', [AdminOrderController::class, 'pesananbayar'])->name('pesananbayar');
    Route::get('order/pesanankemas', [AdminOrderController::class, 'pesanankemas'])->name('pesanankemas');
    Route::get('order/pesanankirim', [AdminOrderController::class, 'pesanankirim'])->name('pesanankirim');
    Route::get('order/pesananterima', [AdminOrderController::class, 'pesananterima'])->name('pesananterima');
    Route::get('order/pesanancancel', [AdminOrderController::class, 'pesanancancel'])->name('pesanancancel');

    Route::get('/payments', [AdminPaymentController::class, 'index']);

    Route::get('detailpesanan/{id}', [AdminOrderController::class, 'detailpesanan'])->name('detailpesanan');
    Route::post('confirm/{id}', [AdminOrderController::class, 'confirm'])->name('confirm');
    Route::post('inputresi/{id}', [AdminOrderController::class, 'inputresi'])->name('inputresi');

    Route::get('/report/revenue', [AdminReportController::class, 'revenue'])->name('revenue.report');
    // Route::get('/export-excel/{startDate}/{endDate}', [AdminReportController::class, 'generateReport'])->name('export-revenue');

    Route::post('/upload-category', [CategoryController::class, 'uploadCategory'])->name('uploadCategory');
    Route::post('/upload-subcategory', [SubcategoryController::class, 'uploadSubcategory'])->name('uploadSubcategory');
    Route::post('/upload-product', [ProductController::class, 'uploadProduct'])->name('uploadProduct');

    Route::get('/exportPdf/{startDate}/{endDate}', [AdminReportController::class, 'exportPdf'])->name('exportPdf');
    // Route::get('/revenuePdf/{startDate}/{endDate}',[AdminReportController::class, 'revenuePdf'])->name('revenuePdf');

});

Route::middleware('auth:web,member')->group(function () {
    Route::post('delivered/{id}', [AdminOrderController::class, 'delivered'])->name('delivered');
    Route::post('cancel/{id}', [AdminOrderController::class, 'cancel'])->name('cancel');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product-subcategories/{id}', [HomeController::class, 'productSubcategories'])->name('home.product-subcategories');
Route::get('/product-categories/{id}', [HomeController::class, 'productCategories'])->name('home.product-categories');
Route::get('/product-subcategories/product-detail/{id}', [HomeController::class, 'productDetail'])->name('home.product-detail');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordPage'])->name('auth.forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('auth.registerStore');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('web');
Route::post('payment/notification', [PaymentController::class, 'notification']);

Route::middleware('auth:member')->group(function () {
    // Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/cart', [OrderController::class, 'index'])->name('cart');
    Route::post('/order/{id}', [OrderController::class, 'orderStore'])->name('order.orderStore');
    Route::delete('/cart/deleteproduct{id}', [OrderController::class, 'deleteproduct'])->name('deleteproduct');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profil');
    Route::post('/profile/address', [ProfileController::class, 'createAddress'])->name('createAddress');
    Route::post('/profil-update', [ProfileController::class, 'updateProfile']);
    Route::get('/profile/address/edit-address{id}', [ProfileController::class, 'editAddress'])->name('editAddress');
    Route::put('/profile/address/update-address{id}', [ProfileController::class, 'updateAddress'])->name('updateAddress');


    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('select-provinsi', [ProfileController::class, 'selectprovinsi'])->name('selectprovinsi');

    Route::post('/checkout/placeorder', [CheckoutController::class, 'placeorder'])->name('placeorder');
    Route::get('/checkout/order-confirm/{id}', [CheckoutController::class, 'orderconfirm'])->name('orderconfirm');
    // Route::post('/checkout/order-confirm/{id}',[CheckoutController::class, 'payment'])->name('payment');


    Route::get('/orderlist', [CheckoutController::class, 'orderlist'])->name('orderlist');
    Route::get('/orderlist/orderinfo/{id}', [CheckoutController::class, 'orderinfo'])->name('orderinfo');

    Route::get('/invoice/{id}', [CheckoutController::class, 'invoice'])->name('invoice');
    Route::get('/send-invoice', [CheckoutController::class, 'sendInvoice']);
    // Route::get('/checkout/getongkir',[CheckoutController::class, 'getongkir']);
    // Route::get('/checkout/getapi',[CheckoutController::class, 'getapi']);
    // Route::post('/checkout/getcost',[CheckoutController::class, 'getcost'])->name('getcost');
    // Route::get('/checkout/getcost',[CheckoutController::class, 'getcost'])->name('getcost');

    // Route::get('/invoice', [CheckoutController::class, 'invoice']);
});
