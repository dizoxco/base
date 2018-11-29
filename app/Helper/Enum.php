<?php

if (!function_exists('enum')) {
    function enum(string $enum, string $key = null)
    {
        throw_if(
            empty($enum),
            new InvalidArgumentException(
                'Too few arguments to function '.__FUNCTION__.' or enum name is empty.'
            )
        );

        throw_unless(
            app()->has($enum),
            new InvalidArgumentException(
                "Class {$enum} does not exist or not registered."
            )
        );

        $enum   =  app($enum);
        if ($key === null) {
            return $enum;
        }

        return $enum->get($key);
    }
}
