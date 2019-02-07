<?php

if (!function_exists('_e')) {
    /**
     * Function to echo translation key.
     * @param string $key
     */
    function _e(string $key)
    {
        echo __($key);
    }
}

if (!function_exists('is_controller')) {
    /**
     * Function to verify if object is a Laravel Controller
     *
     * @param object $obj
     * @return bool
     */
    function is_controller($obj){
        return is_subclass_of($obj, 'App\Http\Controllers\Controller');
    }
}

if (!function_exists('get_controller_base_key')) {
    /**
     * Function to get base translation key from controller
     *
     * @param object $obj
     * @return bool
     */
    function get_controller_base_key($obj){
        $classPath = explode('\\', get_class($obj));
        $className = array_pop($classPath);
        $classWithoutController = str_replace("Controller", "", $className);
        return "controller." . snake_case($classWithoutController) . ".";
    }
}

if (!function_exists('get_view_base_key')) {
    /**
     * Function to get base translation key from view
     *
     * @param object $obj
     * @return bool
     * @throws ReflectionException
     */
    function get_view_base_key($obj){
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty("lastCompiled");
        $property->setAccessible(true);
        $value = $property->getValue($obj)[0];
        $paths = explode("/", $value);
        $countPaths = count($paths);
        $initIndexViews = array_search("views", $paths) + 1;
        $paths[$countPaths-1] =  str_replace(".blade.php", "", $paths[$countPaths-1]);
        return implode(".", array_slice($paths, $initIndexViews, $countPaths - $initIndexViews)).".";
    }
}

if (!function_exists('_v')) {
    /**
     * Function to auto get in views and controllers translation key.
     *
     * @param string $key
     * @return string
     */
    function _v(string $key)
    {
        $debugBackTrace = debug_backtrace();
        $i = 0;
        while ($i < 1000) {
            try {
                $obj = $debugBackTrace[$i]["object"];
                if (is_controller($obj)) {
                    $base = get_controller_base_key($obj);
                } else {
                    $base = get_view_base_key($obj);
                }
                $fullKey = $base . $key;
                $translation = __($fullKey);
                if ($fullKey == $translation) {
                    \App\Helpers\ConsoleJS::build('no translation for ' . $fullKey);
                }
                return $translation;
            } catch (Exception $e) {
                $i++;
            }
        }
        return "";
    }
}

if (!function_exists('process_if_null')) {
    /**
     * Function to verify if $var is null or string null and replace by null value
     *
     * @param null $var
     */
    function process_if_null(&$var = null)
    {
        if (!isset($var) || $var == null || $var == "null") {
            $var = NULL;
        }
    }
}

if (!function_exists('current_url')) {
    /**
     * Function to get actual url;
     * 
     * @return string
     */
    function current_url()
    {
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
        $complete_url = $base_url . $_SERVER["REQUEST_URI"];
        return $complete_url;

    }
}