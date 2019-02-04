<?php
    if (!function_exists('_e')){
        function _e($key){
            echo __($key);
        }
    }

    function _v($key = ""){
        $i = 0;
        while(true){
            try {
                $obj = debug_backtrace()[$i]["object"];
                if(is_subclass_of($obj, 'App\Http\Controllers\Controller')){
                    $function = debug_backtrace()[$i]['function'];
                    $class = explode('\\',debug_backtrace()[$i]['class']);
                    $baseKey = snake_case($class[count($class)-1]);
                    $baseKey = str_replace('_controller', '', $baseKey);
                    $baseKey = str_replace('_', '.', $baseKey);
                    return __($baseKey.".controller.".$function.".".$key);
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
                return __(str_replace(".blade.php", "", $base) . $key);
            } catch (Exception $e){
                $i++;
            }
        }
    }


function processIfNull(&$var = null){
    if (!isset($var) || $var == null || $var == "null"){
        $var = NULL;
    }
}

include 'Helpers/BootstrapHelper.php';