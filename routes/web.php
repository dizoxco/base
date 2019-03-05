<?php

Route::any('lab', function () {
});

Route::get('/', 'PageController@home')->name('home');
Route::get('/products/{product}', 'ProductController@show')->name('products.show');

// Authentication Routes...// Registration Routes...
Route::post('google', 'Auth\LoginController@google')->name('google');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::post('register', 'Auth\RegisterController@register')->name('register');

// Password Reset Routes...
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/token', 'Auth\ForgotPasswordController@validateToken')->name('password.token.validate');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/', 'PostController@index')->name('index');
    Route::get('{post}', 'PostController@show')->name('show');
    Route::get('tags/{tag}', 'PostController@tags')->name('tag');
});

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

Route::get('/designers/{designer}', 'DesignerController@show')->name('designers.show');
Route::get('/designers/{designer}/json', 'DesignerController@json')->name('designers.json');

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
        Route::get('/', 'OrderController@index')->name('index');
        Route::get('{order}', 'OrderController@show')->name('show');
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
            Route::get('/edit', 'BusinessManagementController@edit')->name('edit');
            Route::put('/update', 'BusinessManagementController@update')->name('update');

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
                Route::post('{chat}', 'ChatManagementController@store')->name('store');
            });
        });
    });

    Route::resource('addresses', 'AddressController')->except('show');
});

// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================

// When therer is no route matched, the user is returned to the home page.
Route::fallback('RouteFallbackController');
