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

        Route::name('wishlist.')->prefix('wishlist')->group(function () {
            Route::get('/', 'WishlistController@index')->name('index');
            Route::post('/', 'WishlistController@store')->name('store');
            Route::delete('{wishlist}', 'WishlistController@destroy')->name('destroy');
        });

        Route::name('cart.')->prefix('cart')->group(function () {
            Route::get('/', 'CartController@index')->name('index');
            Route::post('/', 'CartController@store')->name('store');
            Route::delete('{cart}', 'CartController@destroy')->name('destroy');
            Route::get('checkout', 'CartController@checkout')->name('checkout');
        });
    });

    Route::name('businesses.')->prefix('businesses')->group(function () {
        Route::get('/', 'BusinessController@index')->name('index')->middleware('permission:manage_businesses');
        Route::get('/trash', 'BusinessController@trash')->name('trash')->middleware('permission:manage_businesses');
        Route::post('/', 'BusinessController@store')->name('store')->middleware('permission:manage_businesses');

        Route::prefix('{business}')->middleware('acl:business,manage_businesses')->group(function () {
            Route::get('/', 'BusinessController@show')->name('show');
            Route::put('/', 'BusinessController@update')->name('update');
            Route::delete('/', 'BusinessController@delete')->name('delete');
            Route::get('restore', 'BusinessController@restore')->name('restore');
            Route::delete('destroy', 'BusinessController@destroy')->name('destroy');
        });
    });

    Route::name('products.')->prefix('products')->group(function () {
        Route::get('/', 'ProductController@index')->name('index');
        Route::get('/trash', 'ProductController@trash')->name('trash');
        Route::post('/', 'ProductController@store')->name('store');

        Route::prefix('{product}')->group(function () {
            Route::get('/', 'ProductController@show')->name('show');
            Route::put('/', 'ProductController@update')->name('update');
            Route::delete('/', 'ProductController@delete')->name('delete');
            Route::get('restore', 'ProductController@restore')->name('restore');
            Route::delete('destroy', 'ProductController@destroy')->name('destroy');

            Route::name('variations.')->prefix('variations')->group(function () {
                Route::get('/', 'VariationController@index')->name('index');
                Route::post('/', 'VariationController@store')->name('store');

                Route::prefix('{variation}')->group(function () {
                    Route::get('/', 'VariationController@show')->name('show');
                    Route::put('/', 'VariationController@update')->name('update');
                    Route::delete('/', 'VariationController@delete')->name('delete');
                    Route::get('restore', 'VariationController@restore')->name('restore');
                    Route::delete('destroy', 'VariationController@destroy')->name('destroy');
                });
            });
        });
    });

    Route::name('searchpanels.')->prefix('searchpanels')->group(function () {
        Route::get('/', 'SearchPanelController@index')->name('index')->middleware('permission:manage_search_panels');
        Route::get('/trash', 'SearchPanelController@trash')->name('trash')->middleware('permission:manage_search_panels');
        Route::post('/', 'SearchPanelController@store')->name('store')->middleware('permission:manage_search_panels');

        Route::prefix('{search_panel}')->middleware('acl:search_panel,manage_search_panels')->group(function () {
            Route::get('/', 'SearchPanelController@show')->name('show');
            Route::put('/', 'SearchPanelController@update')->name('update');
            Route::delete('/', 'SearchPanelController@delete')->name('delete');
            Route::get('restore', 'SearchPanelController@restore')->name('restore');
            Route::delete('destroy', 'SearchPanelController@destroy')->name('destroy');
        });
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('index')->middleware('permission:manage_users');
        Route::get('/trash', 'UserController@trash')->name('trash')->middleware('permission:manage_users');
        Route::post('/', 'UserController@store')->name('store')->middleware('permission:manage_users');

        Route::prefix('{user}')->middleware('acl:user,manage_users')->group(function () {
            Route::get('chats', 'ChatController@chats')->name('chat');
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
        Route::get('/', 'PostController@index')->name('index')->middleware('permission:manage_posts');
        Route::get('/trash', 'PostController@trash')->name('trash')->middleware('permission:manage_posts');
        Route::post('/', 'PostController@store')->name('store')->middleware('permission:manage_posts');

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

    Route::apiResource('taxonomies', 'TaxonomyController')->only('index', 'store', 'update');

    Route::apiResource('tags', 'TagController')->only('index', 'store', 'update');

    Route::apiResource('media', 'MediaController')->only('update', 'destroy');

    Route::name('mediagroups.')->prefix('mediagroups')->group(function () {
        Route::get('/', 'MediaGroupController@index')->name('index');
        Route::get('{medium}', 'MediaGroupController@show')->name('show');
        Route::post('{medium}', 'MediaGroupController@store')->name('store');
    });

    Route::name('comments.')->prefix('comments')->middleware('permission:manage_comments')->group(function () {
        Route::get('/', 'CommentController@index')->name('index');
        Route::delete('{comment}', 'CommentController@delete')->name('delete');
        Route::get('{comment}/restore', 'CommentController@restore')->name('restore');
        Route::delete('{comment}/destroy', 'CommentController@destroy')->name('destroy');
    });
});
