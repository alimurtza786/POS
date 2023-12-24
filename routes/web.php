<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRole;
use App\Http\Controllers\TakealotApiController;
use App\Http\Controllers\TakealotProduct;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/import-data', [TakealotApiController::class, 'importData']);
Route::get('/', [HomeController::class, 'welcome']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user-takealot', [TakealotProduct::class, 'getData'])->name('user-takealot');
    Route::get('/user-product', [TakealotProduct::class, 'getproduct'])->name('user-product');
    // Route::get('/admin-takelot', [UserController::class, 'adminMenu'])->name('admin-takealot');
    Route::get('/admin-takelot/{userId}', [UserController::class, 'userPage'])->name('admin-takealots');
     Route::get('/import-sales/{userId}', [UserController::class, 'userSaleinsert'])->name('import-sales');
    Route::get('/admin-product/{userId}', [UserController::class, 'userProduct'])->name('admin-product');
    Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/takealot-api', [TakealotApiController::class, 'getData'])->name('takealot-api');
Route::get('/takealot-product', [TakealotApiController::class, 'product'])->name('takealot-product');
Route::get('/get-product/{id}', [TakealotApiController::class, 'getWoos']);
Route::post('/takealot-product', [TakealotApiController::class, 'product']);
Route::get('/sales', [TakealotApiController::class, 'showSalesData'])->name('sales');
Route::get('/db-product', [TakealotApiController::class, 'showproduct'])->name('db-product');
Route::put('/products/{id}', [TakealotApiController::class, 'update'])->name('product.update');

Route::post('/update-sales', [TakealotApiController::class, 'updateSalesData'])->name('update.sales');
Route::get('/minimum', [UserController::class, 'minimum'])->name('minimum');
Route::get('/user-minimum', [UserController::class, 'minimum1'])->name('user-minimum');
Route::get('/user/edit/{id}', [HomeController::class, 'edit'])->name('edit.user');
Route::post('/user/update/{id}', [HomeController::class, 'update'])->name('update.user');
Route::delete('/user/delete/{id}', [HomeController::class, 'delete'])->name('delete.user');
Route::get('/woo-pos', [TakealotApiController::class, 'woo_pos'])->name('woo-pos');
Route::get('/user-pos', [TakealotApiController::class, 'user_pos'])->name('user-pos');
Route::get('/report', [UserRole::class, 'report'])->name('report');
Route::get('/user-report', [TakealotApiController::class, 'report1'])->name('user-report');
// USER Section
Route::get('/user-create', [UserRole::class, 'showRegistrationForm'])->name('user-create');
Route::post('/user-create', [UserRole::class, 'create']);
Route::post('/updateUser', [UserRole::class, 'updateUser'])->name('updateUser');
Route::post('/deleteUser', [UserRole::class, 'deleteUser'])->name('deleteUser');


Route::get('/user-all', [UserRole::class, 'index'])->name('user-all');
Route::put('/update-offer/{offerId}', [TakealotApiController::class, 'updateOffer'])->middleware('web');
Route::post('/calculate-profit-loss',[TakealotApiController::class, 'product'])->name('calculate-profit-loss');
Route::post('/get-profit-loss', [TakealotApiController::class, 'getProfitLossData'])->name('get-profit-loss');
Route::post('/get-loss-profit', [TakealotApiController::class, 'getProfitLossData'])->name('get-loss-profit');
Route::post('/update-barcode', [TakealotApiController::class, 'updateBarcode'])->name('update-barcode');
Route::post('/update-barcode-user', [TakealotProduct::class, 'updateBarcode'])->name('update-barcode-user');
Route::post('/update-barcode1', [TakealotApiController::class, 'updateBarcode1'])->name('update-barcode1');
});


require __DIR__.'/auth.php';
