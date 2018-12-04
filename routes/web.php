<?php

use App\Models\User;

Auth::routes();

Route::any('lab', function () {
dd(
    User::find(2)->getMediaGroups()
);
});
