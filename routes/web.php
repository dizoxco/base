<?php

Auth::routes();
Route::any('lab', function () {
});
// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================
// ==================================== User Section ==========================
Route::name('web.auth')->prefix('auth')->group(function () {
    Auth::routes();
});
// ==================================== Users profile Section =================
Route::name('cart.')->prefix('cart')->group(function () {
    Route::get('/{variation}', 'CartController@store')->name('store');
    Route::delete('/', 'CartController@destroy')->name('destroy');
});

Route::name('wishlist.')->prefix('wishlist')->group(function () {
    Route::get('/{product}', 'WishlistController@store')->name('store');
    Route::delete('/', 'WishlistController@destroy')->name('destroy');
});

Route::name('profile.')->prefix('profile')->middleware('auth:web')->group(function () {
    Route::get('orders', 'ProfileController@orders')->name('orders');
    Route::get('cart', 'CartController@index')->name('cart');
    Route::get('addresses', 'ProfileController@addresses')->name('addresses');
    Route::get('wishlist', 'WishlistController@index')->name('wishlist');
    Route::get('chats', 'ProfileController@chats')->name('chats');
    Route::get('tickets', 'ProfileController@tickets')->name('tickets');
    Route::get('credentials', 'ProfileController@credentials')->name('credentials.edit');
    Route::post('credentials', 'ProfileController@updateCredentials')->name('credentials.update');
    Route::get('info', 'ProfileController@info')->name('info.edit');
    Route::post('info', 'ProfileController@updateInfo')->name('info.update');
});
// ==================================== End Users profile Section  ============
Route::get('/', 'PageController@home')->name('home');
Route::get('/search/{searchPanel}', 'SearchPanelController@search')->name('search');
Route::get('/businesses/{business}', 'BusinessController@show')->name('businesses.show');
Route::get('/products/{product}', 'ProductController@show')->name('products.show');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::get('/posts/tags/{tag}', 'PostController@tags')->name('posts.tag');
// ==================================== End User Section ======================
