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

    Route::get('/', 'UserController@index')->name('index')->middleware('acl:user.index');
    Route::post('/', 'UserController@store')
        ->name('store')
        ->middleware('acl:user.store');

    Route::prefix('{user}')->group(function () {

        Route::get('/', 'UserController@show')
            ->name('show')
            ->middleware('acl:user,user.show');

        Route::put('/', 'UserController@update')
            ->name('update')
            ->middleware('acl:user,user.update');

        Route::delete('/', 'UserController@delete')
            ->name('delete')
            ->middleware('acl:user,user.delete');

        Route::get('roles', 'UserController@roles')
            ->name('roles')
            ->middleware('acl:user,user.roles');

        Route::put('roles', 'UserController@syncRoles')
            ->name('roles.sync')
            ->middleware('acl:user,user.roles');

        Route::get('permissions', 'UserController@permissions')
            ->name('permissions')
            ->middleware('acl:user,user.permissions');
    });
});

Route::name('posts.')->prefix('posts')->group(function () {
    
    Route::get('/', 'PostController@index')
        ->name('index')
        ->middleware('acl:post.index');
    
    Route::post('/', 'PostController@store')
        ->name('store')
        ->middleware('acl:post.store');
    
    Route::prefix('{post}')->group(function () {
        
        Route::get('/', 'PostController@show')
            ->name('show')
            ->middleware('acl:post,post.show');
        
        Route::put('/', 'PostController@update')
            ->name('update')
            ->middleware('acl:post,post.update');
        
        Route::delete('/', 'PostController@delete')
            ->name('delete')
            ->middleware('acl:post,post.delete');
        
        Route::post('comments', 'PostController@comments')
            ->name('comments')
            ->middleware('acl:post,post.comments');
        
        Route::post('comments', 'PostController@commentsStore')
            ->name('comments.store')
            ->middleware('acl:post,post.comments.store');
    });
});
