<?php

use App\Http\Controllers\ProfileController;
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
    return redirect('login');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('categories', CategoryController::class)->middleware(['auth']);
Route::resource('orders', OrderController::class)->middleware(['auth']);
Route::resource('clients', ClientController::class)->middleware(['auth']);
Route::get('/orders/{id}/details', [OrderController::class, 'details'])->middleware(['auth']);

Route::get('/logo', function () {
    return response()->file('logo.png');
});

Route::get('/logo_name', function () {
    return response()->file('master_gaming.jpg');
});

//Rutas API
//Si las definimos en api.php no funcionan en vercel ya que interpreta de manera particular las rutas que comienzan con '/api'
Route::prefix('_api')->group(function () {
    Route::get('/products', [ProductController::class, 'indexApi']);
    Route::get('/products/{id}', [ProductController::class, 'showApi']);
    Route::get('/products/search/{name}', [ProductController::class, 'searchApi']);
    Route::get('/products/category/{categoryId}', [ProductController::class, 'searchByCategoryApi']);

    Route::get('/categories', [CategoryController::class, 'indexApi']);

    Route::get('/orders/{token}', [OrderController::class, 'showApi']);
    Route::post('/orders', [OrderController::class, 'storeApi']);
});

require __DIR__.'/auth.php';
