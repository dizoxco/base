<?php

Route::fallback(function () {
    return 'lab';
});

Route::get('/lab', function () {
    foreach (enum('gender') as $k => $v) {
        dd($k, $v, 'te');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
