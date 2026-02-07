<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
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

Route::get('/register', [AuthController::class, 'register'])->name('register.form');
Route::get('/login', [AuthController::class, 'login'])->name('login.form');
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/item/{id}', [ProductController::class, 'productDetail'])->name('product.detail');

Route::middleware('auth')->group(function(){
    Route::get('/mypage', [ProfileController::class, 'showMypage'])->name('mypage.show');
    Route::get('/mypage/profile', [ProfileController::class, 'mypageEdit'])->name('mypage.edit.form');
    Route::get('/sell', [SellController::class, 'showSell'])->name('sell.form');
    Route::post('/mypage/profile', [ProfileController::class, 'storeProfile'])->name('profile.store');
    Route::get('/purchase/{id}', [PurchaseController::class, 'showPurchase'])->name('purchase.form');
    Route::post('/item/{id}', [ProductController::class, 'toggleLike'])->name('product.like.store');
    Route::post('/sell', [SellController::class, 'storeProduct'])->name('product.sell.store');
    Route::post('/purchase/{id}', [PurchaseController::class, 'storePurchase'])->name('Purchase.store');
    Route::get('/purchase/address/{id}',[PurchaseController::class, 'showPurchaseAddress'])->name('purchase.address.form');
    Route::post('/purchase/address/{id}', [PurchaseController::class, 'storePurchaseAddress'])->name('purchase.address.store');
});