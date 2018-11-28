<?php

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');
    Route::get('register/activate/{token}', 'AuthController@activate')->name('activate');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('user', 'AuthController@user')->name('user');
    });
});

Route::name('users.')->prefix('users')->group(function () {
    Route::get('/', 'UserController@index')->name('index')
        ->middleware(['auth:api', 'permission:manage posts', 'ownership']);
    Route::post('/', 'UserController@store')->name('store');
    Route::prefix('{user}')->group(function () {
        Route::get('/', 'UserController@show')->name('show');
        Route::put('/', 'UserController@update')->name('update');
        Route::delete('/', 'UserController@delete')->name('delete');
        Route::get('comments', 'UserController@comments')->name('comments');
        Route::get('roles', 'UserController@roles')->name('roles');
        Route::post('roles', 'UserController@addRole')->name('roles.add');
        Route::put('roles', 'UserController@syncRoles')->name('roles.sync');
        Route::get('permissions', 'UserController@permissions')->name('permissions');
        Route::get('posts', 'UserController@posts')->name('posts');
    });
});

Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/', 'PostController@index')->name('index');
    Route::post('/', 'PostController@store')->name('store');
    Route::prefix('{post}')->group(function () {
        Route::get('/', 'PostController@show')->name('show');
        Route::put('/', 'PostController@update')->name('update');
        Route::delete('/', 'PostController@delete')->name('delete');
        Route::post('comments', 'PostController@comments')->name('comments');
        Route::post('comments', 'PostController@commentsStore')->name('comments.store');
    });
});
