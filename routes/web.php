<?php

use App\Models\MediaGroup;
use App\Models\Post;

Auth::routes();

Route::any('lab', function () {
    return (Post::find(1))->getMediaGroups;
});

// ==================================== Admin Section =========================
Route::view('admin', 'admin');
Route::view('admin/{any}', 'admin')->where('any', '.*');
// ==================================== End Admin Section =====================
// ==================================== User Section ==========================
Route::get('/', 'PageController@home')->name('home');
Route::get('/search/{searchPanel}', 'SearchPanelController@search');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::get('/posts/tags/{tag}', 'PostController@tags')->name('posts.tag');
// ==================================== End User Section ======================
