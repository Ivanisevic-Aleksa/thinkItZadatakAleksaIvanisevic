<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('shop')->middleware(['auth'])->group(function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::prefix('users')->middleware(['can:admin'])->group(function(){
        Route::get('/', [ShopController::class, 'users']);
        Route::get('/ajax', [ShopController::class, 'usersAjax']);
    });
    Route::prefix('categories')->group(function(){
        Route::get('/', [ShopController::class, 'categories']);
        Route::get('/ajax', [ShopController::class, 'categoriesAjax']);
        Route::get('/{category_id}/delete', [ShopController::class, 'categoryDelete'])->middleware(['can:admin']);
        Route::post('/update', [ShopController::class, 'categoryUpdate'])->middleware(['can:admin']);
        Route::post('/add', [ShopController::class, 'categoryAdd'])->middleware(['can:admin']);
    });
    Route::prefix('products')->group(function(){
        Route::get('/', [ShopController::class, 'products']);
        Route::get('/ajax', [ShopController::class, 'productsAjax']);
        Route::post('/add', [ShopController::class, 'productAdd'])->middleware(['can:admin']);
        Route::get('/image/{filename}', [ShopController::class, 'getImage']);
        Route::get('/{product_id}/delete', [ShopController::class, 'productDelete'])->middleware(['can:admin']);
        Route::post('/update', [ShopController::class, 'productUpdate'])->middleware(['can:admin']);
    });
});
