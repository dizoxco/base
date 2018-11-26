<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('users.')->prefix('users')->group(function () {
    Route::get('/', 'UserController@index' )->name('index');
    Route::post('/', 'UserController@store' )->name('store');
    Route::get('{user}', 'UserController@show' )->name('show');
    Route::put('{user}', 'UserController@update' )->name('update');
    Route::delete('{user}', 'UserController@delete' )->name('delete');
});

Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/', 'PostController@index' )->name('index');
    Route::post('/', 'PostController@store' )->name('store');
    Route::get('{post}', 'PostController@show' )->name('show');
    Route::put('{post}', 'PostController@update' )->name('update');
    Route::delete('{post}', 'PostController@delete' )->name('delete');
});
