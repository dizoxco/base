<?php

use App\Models\Post;

Auth::routes();

Route::any('lab', function () {
    return (Post::find(1))->getMediaGroups;
});

Route::view('admin', 'admin');
Route::view('admin/{any}','admin')->where('any', '.*');