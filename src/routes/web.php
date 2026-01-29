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

Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);
Route::middleware('auth')->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/mypage', [ProfileController::class, 'showMypage']);
    Route::get('/mypage/profile', [ProfileController::class, 'mypageEdit']);
    Route::get('/sell', [ProductController::class, 'showSell']);
    Route::post('/mypage/profile', [ProfileController::class, 'storeProfile']);
    Route::get('/item/{id}', [ProductController::class, 'productDetail']);
    Route::get('/purchase/{id}', [PurchaseController::class, 'showPurchase']);
});