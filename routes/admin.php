<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoleController;





Route::get('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::middleware(['is_admin', 'auth'])->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'admin'])->name('admin.home');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::resource('roles', RoleController::class);

    Route::prefix('user')->group( function () {
        Route::controller(UserController::class)->prefix('/')->group(function () {
            Route::get('/', 'index')->name('admin.user.index');
            // Route::get('/create', 'create')->name('product.category.create');
            // Route::post('/store', 'store')->name('product.category.store');
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
    });

    Route::prefix('product')->group( function () {

        Route::controller(CategoryController::class)->prefix('/category')->group(function () {
            Route::get('/', 'index')->name('product.category.index');
            Route::get('/create', 'create')->name('product.category.create');
            Route::post('/store', 'store')->name('product.category.store');
            Route::get('/{productCategory}/edit', 'edit')->name('product.category.edit');
            Route::put('/{productCategory}/update', 'update')->name('product.category.update');
            Route::post('/{productCategory}/active', 'active')->name('product.category.active');
            Route::post('/{productCategory}/de-active', 'deactive')->name('product.category.deactive');
            Route::delete('/{productCategory}/destroy', 'destroy')->name('product.category.destroy');
            Route::post('/{productCategory}/restore', 'restore')->name('product.category.restore');
            Route::delete('/{productCategory}/force-delete', 'forceDelete')->name('product.category.forcedelete');
            Route::delete('/destroy-all', 'destroyAll')->name('product.category.destroyAll');
            Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('product.category.permanentDestroyAll');
            Route::delete('/restore-all', 'restoreAll')->name('product.category.restoreAll');
            Route::get('/get-data', 'getAllData')->name('product.category.getAllData');
        });

        Route::controller(SubCategoryController::class)->prefix('/sub-category')->group(function () {
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


        Route::controller(ChildCategoryController::class)->prefix('/child-category')->group(function () {
            Route::get('/', 'index')->name('product.childCategory.index');
            Route::get('/create', 'create')->name('product.childCategory.create');
            Route::post('/store', 'store')->name('product.childCategory.store');
            Route::get('/{subCategory}/edit', 'edit')->name('product.childCategory.edit');
            Route::put('/{subCategory}/update', 'update')->name('product.childCategory.update');
            Route::post('/{subCategory}/active', 'active')->name('product.childCategory.active');
            Route::post('/{subCategory}/de-active', 'deactive')->name('product.childCategory.deactive');
            Route::delete('/{subCategory}/destroy', 'destroy')->name('product.childCategory.destroy');
            Route::post('/{subCategory}/restore', 'restore')->name('product.childCategory.restore');
            Route::delete('/{subCategory}/force-delete', 'forceDelete')->name('product.childCategory.forcedelete');
            Route::delete('/destroy-all', 'destroyAll')->name('product.childCategory.destroyAll');
            Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('product.childCategory.permanentDestroyAll');
            Route::delete('/restore-all', 'restoreAll')->name('product.childCategory.restoreAll');
            Route::get('/get-data', 'getAllData')->name('product.childCategory.getAllData');
        });

    });

});
