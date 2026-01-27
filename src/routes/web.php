<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
});