<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'indexApi']);
Route::get('/products/{id}', [ProductController::class, 'showApi']);
Route::get('/products/search/{name}', [ProductController::class, 'searchApi']);
Route::get('/products/category/{categoryId}', [ProductController::class, 'searchByCategoryApi']);

Route::post('/order', [OrderController::class, 'storeApi']);