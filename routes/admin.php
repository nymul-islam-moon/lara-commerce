<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Auth\LoginController;



Route::get('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::middleware(['is_admin'])->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'admin'])->name('admin.home');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


    Route::controller(ProductCategoryController::class)->prefix('product/category')->group(function () {
        Route::get('/', 'index')->name('product.category.index');
        Route::get('/create', 'create')->name('dashboard.productCategory.create');
        Route::post('/store', 'store')->name('product.category.store');
        Route::get('/{productCategory}/edit', 'edit')->name('dashboard.productCategory.edit');
        Route::put('/{productCategory}/update', 'update')->name('dashboard.productCategory.update');
        Route::post('/{productCategory}/active', 'active')->name('dashboard.productCategory.active');
        Route::post('/{productCategory}/de-active', 'deactive')->name('dashboard.productCategory.deactive');
        Route::delete('/{productCategory}/destroy', 'destroy')->name('dashboard.productCategory.destroy');
        Route::post('/{productCategory}/restore', 'restore')->name('dashboard.productCategory.restore');
        Route::delete('/{productCategory}/force-delete', 'forceDelete')->name('dashboard.productCategory.forcedelete');
        Route::delete('/destroy-all', 'destroyAll')->name('dashboard.productCategory.destroyAll');
        Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('dashboard.productCategory.permanentDestroyAll');
        Route::delete('/restore-all', 'restoreAll')->name('dashboard.productCategory.restoreAll');
        Route::get('/get-data', 'getAllData')->name('dashboard.productCategory.getAllData');
    });

    Route::controller(SubCategoryController::class)->prefix('product/sub-category')->group(function () {
        Route::get('/', 'index')->name('product.subCategory.index');
        Route::get('/create', 'create')->name('product.subCategory.create');
        Route::post('/store', 'store')->name('product.subCategory.store');
        Route::get('/{subCategory}/edit', 'edit')->name('product.subCategory.edit');
        Route::put('/{subCategory}/update', 'update')->name('product.subCategory.update');
        Route::post('/{subCategory}/active', 'active')->name('product.subCategory.active');
        Route::post('/{subCategory}/de-active', 'deactive')->name('product.subCategory.deactive');
        Route::delete('/{subCategory}/destroy', 'destroy')->name('product.subCategory.destroy');
        Route::post('/{subCategory}/restore', 'restore')->name('product.subCategory.restore');
        Route::delete('/{subCategory}/force-delete', 'forceDelete')->name('product.subCategory.forcedelete');
        Route::delete('/destroy-all', 'destroyAll')->name('product.subCategory.destroyAll');
        Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('product.subCategory.permanentDestroyAll');
        Route::delete('/restore-all', 'restoreAll')->name('product.subCategory.restoreAll');
        Route::get('/get-data', 'getAllData')->name('product.subCategory.getAllData');
    });

    Route::get('/test', function () {
        return view('admin.test.index');
    });

});
