<?php

if (!function_exists('is_input_null')) {
    /**
     * Function to verify if $var is null or string null and replace by null value
     *
     * @param null $var
     */
    function is_input_null($var = null) {
        return (!isset($var) || $var == null || $var == "null");
    }
}

if (!function_exists('current_url')) {
    /**
     * Function to get actual url;
     *
     * @return string
     */
    function current_url() {
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
        $complete_url = $base_url . $_SERVER["REQUEST_URI"];
        return $complete_url;

    }
}

if (!function_exists('random_uuid')) {
    function random_uuid() {
        return "ru_" . md5(uniqid(rand(), true));
    }
}
if (!function_exists('get_item_from_array')) {
    function get_item_from_array($array = null, $key = null) {
        if ($array === null || $key === null) return null;
        return (array_key_exists($key, $array)) ? $array[$key] : null;
    }
}