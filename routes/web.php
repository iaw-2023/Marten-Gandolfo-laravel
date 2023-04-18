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
//Route::get('/products', [ProductController::class, 'index']);
//Route::get('/products/create', [ProductController::class, 'create']);
//Route::post('/products/create', [ProductController::class, 'store']);
//Route::put('/products/create', [ProductController::class, 'store']);

Route::get('/allcategories', [CategoryController::class, 'allCategories']);
Route::get('/allclients', [ClientController::class, 'allClients']);
Route::get('/allorders', [OrderController::class, 'allOrders']);
Route::get('/allorderdetails', [OrderDetailController::class, 'allOrderDetails']);
Route::get('/allproducts', [ProductController::class, 'allProducts']);
Route::get('/allusers', [UserController::class, 'allUsers']);


//Si las definimos en api.php no funcionan en vercel
Route::prefix('_api')->group(function () {
    Route::get('/products', [ProductController::class, 'indexApi']);
    Route::get('/products/{id}', [ProductController::class, 'showApi']);
    Route::get('/products/search/{name}', [ProductController::class, 'searchApi']);
    Route::get('/products/category/{categoryId}', [ProductController::class, 'searchByCategoryApi']);
    
    Route::get('/categories', [CategoryController::class, 'indexApi']);
    
    Route::get('/orders/{id}', [OrderController::class, 'showApi']);
    Route::post('/orders', [OrderController::class, 'storeApi']);
});