<?php

Route::any('lab', function () {
});

Route::get('/', 'PageController@home')->name('home');
// Override the default logout route that user GET instead of POST
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/token', 'Auth\ForgotPasswordController@getToken')->name('password.token.get');
Route::post('password/token', 'Auth\ForgotPasswordController@validateToken')->name('password.token.validate');
Route::post('google', 'Auth\LoginController@google')->name('google');
Auth::routes();

Route::get('/products/{product}', 'ProductController@show')->name('products.show');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::get('/posts/tags/{tag}', 'PostController@tags')->name('posts.tag');

Route::name('search.')->prefix('search')->group(function () {
    Route::get('{searchPanel}', 'SearchPanelController@panel')->name('panel');
    Route::get('keyword/{keyword}', 'SearchPanelController@keyword')->name('keyword');
});

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

Route::name('shipping.')->prefix('shipping')->middleware('auth')->group(function () {
    Route::get('/', 'ShippingController@index')->name('index');
    Route::post('/', 'ShippingController@store')->name('store');
});

Route::name('payment.')->prefix('payment')->middleware('auth')->group(function () {
    Route::get('/', 'PaymentController@index')->name('index');
    Route::post('/', 'PaymentController@store')->name('store');
    Route::get('/verify', 'PaymentController@verify')->name('verify');
});

Route::name('profile.')->prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', 'ProfileController@index')->name('index');
    Route::get('edit', 'ProfileController@edit')->name('edit');
    Route::put('/', 'ProfileController@update')->name('update');

    Route::name('verification.')->prefix('verification')->group(function () {
        Route::get('email', 'ProfileController@sendEmailVerification')->name('email.send');
        Route::get('email/{token}', 'ProfileController@checkEmailVerification')->name('email.check');

        Route::get('mobile', 'ProfileController@sendMobileVerification')->name('mobile.send');
        Route::get('mobile/{token}', 'ProfileController@checkMobileVerification')->name('mobile.check');
    });

    Route::name('wishlist.')->prefix('wishlist')->group(function () {
        Route::get('/', 'WishlistController@index')->name('index');
        Route::get('{product}', 'WishlistController@store')->name('store');
        Route::get('{product}/destroy', 'WishlistController@destroy')->name('destroy');
    });

    Route::name('orders.')->prefix('orders')->group(function () {
        Route::get('/', 'ProfileController@orders')->name('index');
        Route::get('{order}', 'ProfileController@orderShow')->name('show');
    });

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

    Route::name('businesses.')->prefix('businesses')->group(function () {
        Route::get('create', 'BusinessManagementController@create')->name('create');
        Route::post('/', 'BusinessManagementController@store')->name('store');

        Route::prefix('{business}')->group(function () {
            Route::get('/', 'BusinessManagementController@show')->name('show');

            Route::name('products.')->prefix('products')->group(function () {
                Route::get('/', 'ProductManagementController@index')->name('index');
                Route::get('{product}', 'ProductManagementController@show')->name('show');
                Route::put('{product}', 'ProductManagementController@update')->name('update');
            });

            Route::name('orders.')->prefix('orders')->group(function () {
                Route::get('/', 'OrderManagementController@index')->name('index');
                Route::get('{order}', 'OrderManagementController@show')->name('show');
            });

            Route::name('chats.')->prefix('chats')->group(function () {
                Route::get('/', 'ChatManagementController@index')->name('index');
                Route::get('{chat}', 'ChatManagementController@show')->name('show');
                Route::post('{chat}', 'ChatManagementController@comment')->name('store');
            });
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

    Route::resource('addresses', 'AddressController');
});

// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================
