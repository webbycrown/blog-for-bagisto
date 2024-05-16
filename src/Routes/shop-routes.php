<?php

Route::group([
    'prefix' => 'blog',
    'middleware' => ['web', 'theme', 'locale', 'currency']
], function () {

    Route::get('/', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController@index')->defaults('_config', [
        'view' => 'blog::shop.velocity.index',
    ])->name('shop.article.index');

    Route::get('/author/{id}', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController@authorPage')->defaults('_config', [
        'view' => 'blog::shop.author.index',
    ])->name('shop.blog.author.index');

    Route::group(['prefix' => 'tag'], function () {

        Route::get('/{slug}', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\TagController@index')->defaults('_config', [
            'view' => 'blog::shop.tag.index',
        ])->name('shop.blog.tag.index');

    });

    Route::get('/{slug}', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\CategoryController@index')->defaults('_config', [
        'view' => 'blog::shop.category.index',
    ])->name('shop.blog.category.index');

    Route::get('/{slug}/{blog_slug?}', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController@view')->defaults('_config', [
        'view' => 'blog::shop.velocity.view',
    ])->name('shop.article.view');


});
    Route::get('/api/v1/blogs', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\API\Blogs\BlogController@list');
    Route::post('/api/v1/blog/comment/store', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\CommentController@store')->name('shop.blog.comment.store');
    Route::get('/api/v1/blog/category', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\API\Blogs\BlogController@category_list')->name('shop.blog.category.list');
    Route::get('/api/v1/blog/tag', 'Webbycrown\BlogBagisto\Http\Controllers\Shop\API\Blogs\BlogController@tag_list')->name('shop.blog.category.list');