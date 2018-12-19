<?php
if (!function_exists('encode')) {
    function encode($data)
    {
        return base64_encode(serialize($data));
    }
}

if (!function_exists('decode')) {
    function decode($data)
    {
        return unserialize(base64_decode($data));
    }
}