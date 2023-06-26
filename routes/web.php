<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SteamProxyController;
use App\Http\Controllers\ApiAuthController;

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
    
    
    Route::middleware('super_admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::resource('users', UserController::class);
    });


    Route::middleware('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

        Route::resource('orders', OrderController::class);
        Route::resource('clients', ClientController::class);
        Route::get('/orders/{id}/details', [OrderController::class, 'details']);
    });
});

Route::get('/logo', function () {
    $imagePath = public_path('images/logo.png');
    return response()->file($imagePath);
});

Route::get('/logo_name', function () {
    $imagePath = public_path('images/master_gaming.png');
    return response()->file($imagePath);
});

//Rutas API (prefijo /_api)
//Si las definimos en api.php no funcionan en vercel ya que interpreta de manera particular las rutas que comienzan con '/api'
Route::prefix('_api')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/requestpassword', [ApiAuthController::class, 'requestPasswordReset']);
    Route::post('/resetpassword', [ApiAuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [ApiAuthController::class, 'logout']);

        Route::get('/orders', [OrderController::class, 'indexApi']);
        Route::get('/orders/{id}', [OrderController::class, 'showApi']);
        //Route::post('/orders', [OrderController::class, 'storeApi']);

        Route::post('/payWithMercadopago', [OrderController::class, 'payWithMercadopago']);
    });

    Route::get('/products', [ProductController::class, 'indexApi']);
    Route::get('/products/random/{quantity}', [ProductController::class, 'randomIndexApi']);
    Route::get('/products/{id}', [ProductController::class, 'showApi']);
    Route::get('/products/search/{name}', [ProductController::class, 'searchApi']);
    Route::get('/products/search/{name}/category/{categoryId}', [ProductController::class, 'searchByNameAndCategoryApi']);
    Route::get('/products/category/{categoryId}', [ProductController::class, 'searchByCategoryApi']);
    Route::get('/products/order/{order}', [ProductController::class, 'searchByOrderApi']);
    Route::get('/products/search/{name}/order/{order}', [ProductController::class, 'searchByNameAndOrderApi']);
    Route::get('/products/category/{categoryId}/order/{order}', [ProductController::class, 'searchByCategoryAndOrderApi']);
    Route::get('/products/search/{name}/category/{categoryId}/order/{order}', [ProductController::class, 'searchByNameCategoryAndOrderApi']);

    Route::get('/categories', [CategoryController::class, 'indexApi']);

    Route::get('/steam/games/page/{page}', [SteamProxyController::class, 'indexApi']);
    Route::get('/steam/games/featured', [SteamProxyController::class, 'featuredApi']);
    Route::get('/steam/games/{id}', [SteamProxyController::class, 'showApi']);
});

require __DIR__.'/auth.php';
