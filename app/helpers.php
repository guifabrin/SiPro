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
                $reflection = new \ReflectionClass($obj);
                $property = $reflection->getProperty("lastCompiled");
                $property->setAccessible(true);
                $value = $property->getValue($obj)[0];
                $baseKey = explode("/", $value);
                $base = "";
                for ($i=array_search("views", $baseKey)+1; $i<count($baseKey);$i++) {
                    $base .= $baseKey[$i] . ".";
                }
                return __(str_replace(".blade.php", "", $base) . $key);
            } catch (Exception $e){
                $i++;
            }
        }
    }

include 'Helpers/BootstrapHelper.php';