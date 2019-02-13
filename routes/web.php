<?php

Route::any('lab', function () {
});

// Override the default logout route that user GET instead of POST
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('google', 'Auth\LoginController@google')->name('google');
Auth::routes();

Route::get('/', 'PageController@home')->name('home');
Route::get('/search/{searchPanel}', 'SearchPanelController@search')->name('search');
Route::get('/products/{product}', 'ProductController@show')->name('products.show');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::get('/posts/tags/{tag}', 'PostController@tags')->name('posts.tag');

Route::name('businesses.')->prefix('businesses')->group(function () {
    Route::get('{business}', 'BusinessController@show')->name('show');
});

Route::name('wishlist.')->prefix('wishlist')->group(function () {
    Route::get('/', 'WishlistController@index')->name('index');
    Route::get('{product}', 'WishlistController@store')->name('store');
    Route::get('{product}/destroy', 'WishlistController@destroy')->name('destroy');
});

Route::name('cart.')->prefix('cart')->group(function () {
    Route::get('/', 'CartController@index')->name('index');
    Route::get('{variation}', 'CartController@store')->name('store');
    Route::get('{variation}/destroy', 'CartController@destroy')->name('destroy');
});

Route::name('profile.')->prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', 'ProfileController@index')->name('index');
    Route::get('edit', 'ProfileController@edit')->name('edit');
    Route::put('/', 'ProfileController@update')->name('update');

    Route::resource('addresses', 'AddressController');
    Route::get('orders', 'ProfileController@orders')->name('orders');
    Route::get('orders/{order}', 'ProfileController@orderShow')->name('orders.show');

    Route::name('tickets.')->prefix('tickets')->group(function () {
        Route::get('/', 'TicketController@index')->name('index');
        Route::get('create', 'TicketController@create')->name('create');
        Route::post('/', 'TicketController@store')->name('store');
        Route::get('{ticket}', 'TicketController@show')->name('show');
        Route::put('{ticket}/reply', 'TicketController@reply')->name('reply');
        Route::put('{ticket}/toggle', 'TicketController@toggle')->name('toggle');
    });
    Route::name('chats.')->prefix('chats')->group(function () {
        Route::get('/', 'ChatController@index')->name('index');
        Route::get('{business}', 'ChatController@show')->name('show');
        Route::post('{business}', 'ChatController@store')->name('store');
    });

    Route::name('businesses.')->prefix('businesses/{business}')->group(function () {
        Route::get('/', 'BusinessManagerController@show')->name('show');
        Route::get('products', 'BusinessManagerController@products')->name('products');

        Route::name('orders.')->prefix('orders')->group(function () {
            Route::get('/', 'BusinessManagerController@orders')->name('index');
            Route::get('{order}', 'BusinessManagerController@showOrder')->name('show');
        });

        Route::name('chats.')->prefix('chats')->group(function () {
            Route::get('/', 'BusinessManagerController@chats')->name('index');
            Route::get('{chat}', 'BusinessManagerController@showChat')->name('show');
            Route::post('{chat}', 'BusinessManagerController@storeChatComment')->name('store');
        });
    });

    Route::name('credentials.')->prefix('credentials')->group(function () {
        Route::get('/edit', 'ProfileController@credentials')->name('edit');
        Route::put('/update', 'ProfileController@updateCredentials')->name('update');
    });

    Route::name('info.')->prefix('info')->group(function () {
        Route::get('/', 'ProfileController@info')->name('edit');
        Route::post('/', 'ProfileController@updateInfo')->name('update');
    });
});
Route::get('/srch/{key}', function ($key) {
    $bussinesses = App\Models\Business::Where('brand', 'like', '%'.$key.'%')->take(7)->get();
    $tags = App\Models\Tag::Where('label', 'like', '%'.$key.'%')->take(7)->get();

    return view('components.srch', compact('bussinesses', 'tags'));
});

// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================
