<?php

use App\Models\Post;

Auth::routes();

Route::any('lab', function () {
    dd(
        Post::find(3)->mediaGroup()->sync([1, 4, 3])
    );
});
