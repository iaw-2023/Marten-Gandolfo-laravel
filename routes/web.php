<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('orders', OrderController::class);
Route::resource('clients', ClientController::class);

Route::get('/allcategories', [CategoryController::class, 'allCategories']);
Route::get('/allclients', [ClientController::class, 'allClients']);
Route::get('/allorders', [OrderController::class, 'allOrders']);
Route::get('/allorderdetails', [OrderDetailController::class, 'allOrderDetails']);
Route::get('/allproducts', [ProductController::class, 'allProducts']);
Route::get('/allusers', [UserController::class, 'allUsers']);

Route::get('/testdestroy', [CategoryController::class, 'testdestroy']);