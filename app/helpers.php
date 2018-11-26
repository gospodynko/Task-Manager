<?php

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null): string
    {
        $config = parse_ini_file(__DIR__ . '/config.ini.example');

        $value = $config[$key] ?? $default;

        if ($value) {
            return $value;
        } else {
            return '';
        }
    }
}

if (!function_exists('array_push_assoc')) {

    /**
     * @param array $array
     * @param string $key
     * @param array|string $value
     * @return array
     */
    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }
}

