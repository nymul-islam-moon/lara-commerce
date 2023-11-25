<?php

use App\Http\Controllers\API\Admin\ProductCategoryController;
use App\Http\Controllers\API\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(LoginController::class)->group(function(){
    Route::post('login', 'login');
});

// Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {

    Route::controller(ProductCategoryController::class)->prefix('/category')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        // Route::get('/{productCategory}/edit', 'edit')->name('product.category.edit');
        // Route::put('/{productCategory}/update', 'update')->name('product.category.update');
        // Route::post('/{productCategory}/active', 'active')->name('product.category.active');
        // Route::post('/{productCategory}/de-active', 'deactive')->name('product.category.deactive');
        // Route::delete('/{productCategory}/destroy', 'destroy')->name('product.category.destroy');
        // Route::post('/{productCategory}/restore', 'restore')->name('product.category.restore');
        // Route::delete('/{productCategory}/force-delete', 'forceDelete')->name('product.category.forcedelete');
        // Route::delete('/destroy-all', 'destroyAll')->name('product.category.destroyAll');
        // Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('product.category.permanentDestroyAll');
        // Route::delete('/restore-all', 'restoreAll')->name('product.category.restoreAll');
        // Route::get('/get-data', 'getAllData')->name('product.category.getAllData');
    });

// });

