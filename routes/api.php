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

    Route::get('/', 'UserController@index')->name('index')->middleware('acl:manage_users');
    Route::post('/', 'UserController@store')->name('store');

    Route::prefix('{user}')->group(function () {
        Route::get('/', 'UserController@show')->name('show')->middleware('acl:user,manage_users');
        Route::put('/', 'UserController@update')->name('update')->middleware('acl:user,manage_users');
        Route::delete('/', 'UserController@destroy')->name('destroy')->middleware('acl:user,manage_users');
        Route::get('roles', 'UserController@roles')->name('roles')->middleware('acl:user,manage_users');
        Route::put('roles', 'UserController@syncRoles')->name('roles.sync')->middleware('acl:user,manage_users');
        Route::get('permissions', 'UserController@permissions')->name('permissions')->middleware('acl:user,manage_users');
    });
});

Route::name('posts.')->prefix('posts')->group(function () {

    Route::get('/', 'PostController@index')->name('index');
    Route::post('/', 'PostController@store')->name('store');
    
    Route::prefix('{post}')->group(function () {
        Route::get('/', 'PostController@show')->name('show');
        Route::put('/', 'PostController@update')->name('update');
        Route::delete('/', 'PostController@delete')->name('delete');
        Route::get('/restore', 'PostController@restore')->name('restore');
        Route::delete('/destroy', 'PostController@destroy')->name('destroy');
        Route::post('comments', 'PostController@commentsStore')->name('comments.store');
    });
});

Route::get('mediagroup/{medium}', 'MediaGroupController@show');
Route::post('mediagroup/{medium}', 'MediaGroupController@store');
