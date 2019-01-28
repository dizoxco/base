<?php

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
Route::get('/', 'PageController@home');
Route::get('/search/{searchPanel}', 'SearchPanelController@search');
Route::get('/blog', 'PostController@index')->name('index');
Route::get('/blog/{post}', 'PostController@show')->name('show');
Route::get('/blog/tags/{tag}', 'PostController@tags')->name('tag');
// ==================================== End User Section ======================
