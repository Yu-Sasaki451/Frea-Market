<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
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

Route::get('/register', [AuthController::class, 'register'])->name('register_form');
Route::get('/login', [AuthController::class, 'login'])->name('login_form');
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/item/{id}', [ProductController::class, 'productDetail'])->name('product_detail');

Route::middleware('auth')->group(function(){
    Route::get('/mypage', [ProfileController::class, 'showMypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'mypageEdit'])->name('mypage_edit');
    Route::get('/sell', [ProductController::class, 'showSell'])->name('sell');
    Route::post('/mypage/profile', [ProfileController::class, 'storeProfile'])->name('profile_store');
    Route::get('/purchase/{id}', [PurchaseController::class, 'showPurchase'])->name('purchase');
    Route::post('/item/{id}', [ProductController::class, 'toggleLike'])->name('product_like');

});