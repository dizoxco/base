<?php

Route::name('users.')->prefix('users')->group(function () {
    Route::get('/', 'UserController@index' )->name('index');
    Route::post('/', 'UserController@store' )->name('store');
    Route::prefix('{user}')->group(function () {
        Route::get('/', 'UserController@show' )->name('show');
        Route::put('/', 'UserController@update' )->name('update');
        Route::delete('/', 'UserController@delete' )->name('delete');
        Route::post('comments', 'UserController@comments')->name('comments');
        Route::post('roles', 'UserController@roles')->name('roles');
        Route::post('permissions', 'UserController@permissions')->name('permissions');
        Route::post('posts', 'UserController@posts')->name('posts');
    });
});

Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/', 'PostController@index' )->name('index');
    Route::post('/', 'PostController@store' )->name('store');
    Route::prefix('{post}')->group(function () {
        Route::get('/', 'PostController@show' )->name('show');
        Route::put('/', 'PostController@update' )->name('update');
        Route::delete('/', 'PostController@delete' )->name('delete');
        Route::post('comments', 'PostController@comments')->name('comments');
        Route::post('comments', 'PostController@commentsStore')->name('comments.store');
    });
});
