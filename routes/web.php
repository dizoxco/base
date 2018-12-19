<?php

use App\Models\Post;

Auth::routes();

Route::any('lab', function () {
    return (Post::find(1))->getMediaGroups;
});
