<?php

if (! function_exists('cities')) {
    function cities()
    {
        return App\Models\City::All();
    }
}
