<?php

Route::any('lab', function () {
});

// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================
// ==================================== User Section ==========================
Route::get('/', 'PageController@home')->name('home');
Route::get('/search/{searchPanel}', 'SearchPanelController@search')->name('search');
Route::get('/businesses/{business}', 'BusinessController@show')->name('businesses.show');
Route::get('/products/{product}', 'ProductController@show')->name('products.show');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::get('/posts/tags/{tag}', 'PostController@tags')->name('posts.tag');
// ==================================== End User Section ======================
