<?php

if (! function_exists('enum')) {
    function enum(string $enum)
    {
        $constant = config("enum.{$enum}");
        throw_if($constant === null, 'Exception', "Undefined constant '{$enum}'");

        return $constant;
    }
}
