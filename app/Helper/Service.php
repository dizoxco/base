<?php

/**
 * @param array $data
 * @return int|mixed|string|null
 */
if (! function_exists('service_type')) {
    function service_type($input)
    {
        $methods = config('auth.via');
        foreach ($methods as $name => $config) {
            if (preg_match($config['pattern'], $input)) {
                return $name;
            }
        }

        return service_disabled();
    }
}

/*
 * @param array $data
 * @return \Illuminate\Validation\Validator
 */
if (! function_exists('service_disabled')) {
    function service_disabled()
    {
        $data['service'] = false;

        return Validator::make($data, [
            'service' => 'accepted',
        ]);
    }
}
