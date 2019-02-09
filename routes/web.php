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

Route::name('tickets.')->prefix('tickets')->group(function () {
    Route::get('create', 'TicketController@create')->name('create');
    Route::post('/', 'TicketController@store')->name('store');
    Route::get('{ticket}', 'TicketController@show')->name('show');
    Route::put('{ticket}/reply', 'TicketController@reply')->name('reply');
    Route::put('{ticket}/toggle', 'TicketController@toggle')->name('toggle');
});

Route::name('profile.')->prefix('profile')->group(function () {
    Route::middleware('auth:web')->group(function () {
        Route::name('wishlist.')->prefix('wishlist')->group(function () {
            Route::get('/', 'WishlistController@index')->name('index')->middleware('auth:web');
        });
        Route::get('/', 'ProfileController@index')->name('index');
        Route::get('orders', 'ProfileController@orders')->name('orders');
        Route::get('cart', 'CartController@index')->name('cart');
        Route::resource('addresses', 'AddressController');
        Route::get('chats', 'ProfileController@chats')->name('chats');
        Route::get('tickets', 'TicketController@index')->name('tickets');
        Route::name('credentials.')->prefix('credentials')->group(function () {
            Route::get('/edit', 'ProfileController@credentials')->name('edit');
            Route::post('/update', 'ProfileController@updateCredentials')->name('update');
        });
        Route::get('info', 'ProfileController@info')->name('info.edit');
        Route::post('info', 'ProfileController@updateInfo')->name('info.update');
    });
    Route::name('wishlist.')->prefix('wishlist/{product}')->group(function () {
        Route::get('/', 'WishlistController@store')->name('store');
        Route::delete('/', 'WishlistController@destroy')->name('destroy');
    });
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
