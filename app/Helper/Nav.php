<?php

use JsonSchema\Exception\JsonDecodingException;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

if (! function_exists('nav')) {
    function nav($filename)
    {
        $file = base_path('resources/nav/'.$filename.'.json');
        if (! file_exists($file)) {
            throw new FileNotFoundException($file.' not exist');
        }

        $menu = json_decode(file_get_contents($file), true, 512);
        if ($menu === null) {
            throw new JsonDecodingException(json_last_error());
        }
        // echo 'dddddddddddddddddddddddd';
        return nav_render($menu);
    }
}

if (! function_exists('nav_render')) {
    function nav_render($menu)
    {
        ?>
            <u>
            <?php foreach ($menu as $m): ?>
                <li><a href="<?= $m['link'] ?>"><?= $m['label'] ?></a></li>
                <?php if (isset($m['links'])) {
            nav_render($m['links']);
        } ?>
            <?php endforeach; ?>
            </u>
        <?php
    }
}

if (! function_exists('nav_path')) {
    function nav_path($filename = null)
    {
        if ($filename === null) {
            return storage_path('app/navs/');
        }

        return storage_path('app/navs/'.$filename.'.json');
    }
}
