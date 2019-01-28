<?php

use JsonSchema\Exception\JsonDecodingException;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

if (! function_exists('nav')) {
    function nav($filename)
    {
        $file = storage_path('app/navs/'.$filename.'.json');
        if (! file_exists($file)) {
            throw new FileNotFoundException($file.' not exist');
        }

        $menu = json_decode(file_get_contents($file), true, 512);
        if ($menu === null) {
            throw new JsonDecodingException(json_last_error());
        }

        return $menu;
    }
}

if (! function_exists('nav_path')) {
    function nav_path($filename = null) {
        if ( $filename === null) {
            return storage_path('app/navs/');
        }

        return storage_path('app/navs/'.$filename.'.json');
    }
}
