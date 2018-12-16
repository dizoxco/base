<?php

Route::name('auth.')->prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');
    Route::get('register/activate/{token}', 'AuthController@activate')->name('activate');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout')->name('logout');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::name('user.')->prefix('user')->group(function () {

        Route::name('chats.')->prefix('chats')->group(function () {
            Route::get('/', 'ChatController@index')->name('index');
            Route::post('/', 'ChatController@store')->name('store');
            Route::prefix('{chat}')->group(function () {
                Route::get('/', 'ChatController@show')->name('show');
                Route::put('/', 'ChatController@update')->name('update');
            });
        });

        Route::name('tickets.')->prefix('tickets')->group(function () {
            Route::get('/', 'TicketController@index')->name('index');
            Route::post('/', 'TicketController@store')->name('store');
            Route::prefix('{ticket}')->group(function () {
                Route::get('/', 'TicketController@show')->name('show');
                Route::post('/', 'TicketController@update')->name('update');
            });
        });
    });

    Route::name('users.')->prefix('users')->group(function () {

        Route::get('/', 'UserController@index')->name('index')->middleware('permission:manage_users');
        Route::post('/', 'UserController@store')->name('store')->middleware('permission:manage_users');

        Route::prefix('{user}')->middleware('acl:user,manage_users')->group(function () {
            Route::get('chats', 'ChatController@chats')->name('.chat');
            Route::get('/', 'UserController@show')->name('show');
            Route::put('/', 'UserController@update')->name('update');
            Route::delete('/', 'UserController@delete')->name('delete');
            Route::get('restore', 'UserController@restore')->name('restore');
            Route::delete('destroy', 'UserController@destroy')->name('destroy');
            Route::get('roles', 'UserController@roles')->name('roles');
            Route::put('roles', 'UserController@syncRoles')->name('roles.sync');
            Route::get('permissions', 'UserController@permissions')->name('permissions');
        });
    });

    Route::name('posts.')->prefix('posts')->group(function () {

        Route::get('/', 'PostController@index')->name('index')->middleware('permission:manager_posts');
        Route::post('/', 'PostController@store')->name('store')->middleware('permission:manager_posts');

        Route::prefix('{post}')->middleware('acl:post,manage_posts')->group(function () {
            Route::get('/', 'PostController@show')->name('show');
            Route::put('/', 'PostController@update')->name('update');
            Route::delete('/', 'PostController@delete')->name('delete');
            Route::get('restore', 'PostController@restore')->name('restore');
            Route::delete('destroy', 'PostController@destroy')->name('destroy');
            Route::post('comments', 'PostController@commentsStore')->name('comments.store');
        });
    });

    Route::name('tickets.')->prefix('tickets')->group(function () {
        Route::get('/', 'TicketController@index')->name('index');
        Route::prefix('{ticket}')->group(function () {
            Route::get('/', 'TicketController@show')->name('show');
            Route::post('/', 'TicketController@update')->name('update');
        });
    });

    Route::name('mediagroup')->prefix('mediagroup')->group(function () {
        Route::get('{medium}', 'MediaGroupController@show');
        Route::post('{medium}', 'MediaGroupController@store');
    });
});
