<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SubBlogCategoryController;
use App\Http\Controllers\Admin\ChildBlogCategoryController;
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
            // Route::get('/create', 'create')->name('blog.category.create');
            // Route::post('/store', 'store')->name('blog.category.store');
            // Route::get('/{productCategory}/edit', 'edit')->name('product.category.edit');
            // Route::put('/{productCategory}/update', 'update')->name('product.category.update');
            // Route::post('/{productCategory}/active', 'active')->name('product.category.active');
            // Route::post('/{productCategory}/de-active', 'deactive')->name('product.category.deactive');
            // Route::delete('/{productCategory}/destroy', 'destroy')->name('product.category.destroy');
            // Route::post('/{productCategory}/restore', 'restore')->name('product.category.restore');
            // Route::delete('/{productCategory}/force-delete', 'forceDelete')->name('product.category.forcedelete');
            // Route::delete('/destroy-all', 'destroyAll')->name('blog.category.destroyAll');
            // Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('blog.category.permanentDestroyAll');
            // Route::delete('/restore-all', 'restoreAll')->name('blog.category.restoreAll');
            // Route::get('/get-data', 'getAllData')->name('blog.category.getAllData');
        });
    });

    Route::prefix('blog')->group( function () {

        Route::controller(BlogCategoryController::class)->prefix('/category')->group(function () {
            Route::get('/', 'index')->name('blog.category.index');
            Route::get('/create', 'create')->name('blog.category.create');
            Route::post('/store', 'store')->name('blog.category.store');
            Route::get('/{blogCategory}/edit', 'edit')->name('blog.category.edit');
            Route::put('/{blogCategory}/update', 'update')->name('blog.category.update');
            Route::post('/{blogCategory}/active', 'active')->name('blog.category.active');
            Route::post('/{blogCategory}/de-active', 'deactive')->name('blog.category.deactive');
            Route::delete('/{blogCategory}/destroy', 'destroy')->name('blog.category.destroy');
            Route::post('/{blogCategory}/restore', 'restore')->name('blog.category.restore');
            Route::delete('/{blogCategory}/force-delete', 'forceDelete')->name('blog.category.forcedelete');
            Route::delete('/destroy-all', 'destroyAll')->name('blog.category.destroyAll');
            Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('blog.category.permanentDestroyAll');
            Route::delete('/restore-all', 'restoreAll')->name('blog.category.restoreAll');
            Route::get('/get-data', 'getAllData')->name('blog.category.getAllData');
        });


        Route::controller(BlogController::class)->prefix('/blog')->group(function () {
            Route::get('/', 'index')->name('admin.blog.index');
            Route::get('/create', 'create')->name('admin.blog.create');
            Route::post('/store', 'store')->name('admin.blog.store');
            Route::get('/{blog}/edit', 'edit')->name('admin.blog.edit');
            Route::put('/{blog}/update', 'update')->name('admin.blog.update');
            Route::post('/{blog}/active', 'active')->name('admin.blog.active');
            Route::post('/{blog}/de-active', 'deactive')->name('admin.blog.deactive');
            Route::delete('/{blog}/destroy', 'destroy')->name('admin.blog.destroy');
            Route::post('/{blog}/restore', 'restore')->name('admin.blog.restore');
            Route::delete('/{blog}/force-delete', 'forceDelete')->name('admin.blog.forcedelete');
            Route::delete('/destroy-all', 'destroyAll')->name('admin.blog.destroyAll');
            Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('admin.blog.permanentDestroyAll');
            Route::delete('/restore-all', 'restoreAll')->name('admin.blog.restoreAll');
            Route::get('/get-data', 'getAllData')->name('admin.blog.getAllData');
        });

    });

});
