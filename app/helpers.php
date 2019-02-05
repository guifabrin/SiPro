<?php

if (!function_exists('_e')) {
    function _e($key)
    {
        echo __($key);
    }
}

if (!function_exists('_v')) {
    function _v($key = "")
    {
        $i = 0;
        while (true) {
            try {
                $obj = debug_backtrace()[$i]["object"];
                if (is_subclass_of($obj, 'App\Http\Controllers\Controller')) {
                    $function = debug_backtrace()[$i]['function'];
                    $class = explode('\\', debug_backtrace()[$i]['class']);
                    $baseKey = snake_case($class[count($class) - 1]);
                    $baseKey = str_replace('_controller', '', $baseKey);
                    $baseKey = str_replace('_', '.', $baseKey);
                    return __($baseKey . ".controller." . $function . "." . $key);
                } else {
                    $reflection = new \ReflectionClass($obj);
                    $property = $reflection->getProperty("lastCompiled");
                    $property->setAccessible(true);
                    $value = $property->getValue($obj)[0];
                    $baseKey = explode("/", $value);
                    $base = "";
                    for ($i = array_search("views", $baseKey) + 1; $i < count($baseKey); $i++) {
                        $base .= $baseKey[$i] . ".";
                    }
                }
                if (empty($key)) {
                    return "";
                }
                $key = str_replace(".blade.php", "", $base) . $key;
                if ($key == __($key)) {
                    \App\Helpers\ConsoleJS::build('no translation for ' . $key);
                }
                return __($key);
            } catch (Exception $e) {
                $i++;
            }
        }
        return "";
    }
}


function processIfNull(&$var = null)
{
    if (!isset($var) || $var == null || $var == "null") {
        $var = NULL;
    }
}

function current_url()
{
    $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
    $complete_url = $base_url . $_SERVER["REQUEST_URI"];
    return $complete_url;

}