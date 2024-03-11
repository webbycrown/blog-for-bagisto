<?php

use Illuminate\Support\Facades\Route;
use Webbycrown\BlogBagisto\Http\Controllers\Admin\BlogController;
use Webbycrown\BlogBagisto\Http\Controllers\Admin\CategoryController;
use Webbycrown\BlogBagisto\Http\Controllers\Admin\TagController;
use Webbycrown\BlogBagisto\Http\Controllers\Admin\CommentController;
use Webbycrown\BlogBagisto\Http\Controllers\Admin\SettingController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

    /**
     * Admin blog routes
     */
    Route::get('blog', [BlogController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.blogs.index',
    ])->name('admin.blog.index');

    Route::get('blog/create', [BlogController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.blogs.create',
    ])->name('admin.blog.create');

    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.blogs.edit',
    ])->name('admin.blog.edit');

    Route::post('blog/store', [BlogController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.store');

    Route::post('/blog/update/{id}', [BlogController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.index',
    ])->name('admin.blog.update');

    Route::post('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('admin.blog.delete');

    Route::post('blog/massdelete', [BlogController::class, 'massDestroy'])->name('admin.blog.massdelete');

    /**
     * Admin blog category routes
     */
    Route::get('blog/category', [CategoryController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.categories.index',
    ])->name('admin.blog.category.index');

    Route::get('blog/category/create', [CategoryController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.categories.create',
    ])->name('admin.blog.category.create');

    Route::get('/blog/category/edit/{id}', [CategoryController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.categories.edit',
    ])->name('admin.blog.category.edit');

    Route::post('blog/category/store', [CategoryController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.store');

    Route::post('/blog/category/update/{id}', [CategoryController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.category.index',
    ])->name('admin.blog.category.update');

    Route::post('/blog/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.blog.category.delete');

    Route::post('blog/category/massdelete', [CategoryController::class, 'massDestroy'])->name('admin.blog.category.massdelete');

    /**
     * Admin blog tag routes
     */
    Route::get('blog/tag', [TagController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.tags.index',
    ])->name('admin.blog.tag.index');

    Route::get('blog/tag/create', [TagController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.tags.create',
    ])->name('admin.blog.tag.create');

    Route::get('/blog/tag/edit/{id}', [TagController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.tags.edit',
    ])->name('admin.blog.tag.edit');

    Route::post('blog/tag/store', [TagController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.store');

    Route::post('/blog/tag/update/{id}', [TagController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.tag.index',
    ])->name('admin.blog.tag.update');

    Route::post('/blog/tag/delete/{id}', [TagController::class, 'destroy'])->name('admin.blog.tag.delete');

    Route::post('blog/tag/massdelete', [TagController::class, 'massDestroy'])->name('admin.blog.tag.massdelete');

    /**
     * Admin blog comment routes
     */
    Route::get('blog/comment', [CommentController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.comments.index',
    ])->name('admin.blog.comment.index');

    Route::get('/blog/comment/edit/{id}', [CommentController::class, 'edit'])->defaults('_config', [
        'view' => 'blog::admin.comments.edit',
    ])->name('admin.blog.comment.edit');

    Route::post('/blog/comment/update/{id}', [CommentController::class, 'update'])->defaults('_config', [
        'redirect' => 'admin.blog.comment.index',
    ])->name('admin.blog.comment.update');

    Route::post('blog/comment/delete/{id}', [CommentController::class, 'destroy'])->name('admin.blog.comment.delete');

    Route::post('blog/comment/massdelete', [CommentController::class, 'massDestroy'])->name('admin.blog.comment.massdelete');

    /**
     * Admin blog setting routes
     */
    Route::get('blog/setting', [SettingController::class, 'index'])->defaults('_config', [
        'view' => 'blog::admin.setting.index',
    ])->name('admin.blog.setting.index');

    Route::post('blog/setting/store', [SettingController::class, 'store'])->defaults('_config', [
        'redirect' => 'admin.blog.setting.index',
    ])->name('admin.blog.setting.store');

});

/**
 * Admin blog API routes
 */
Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'api/v1/admin'], function () {

    Route::get('blogs', [BlogController::class, 'gteBlogs'])->name('admin.blog.gteBlogs');

});