<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Function to store message and auto show in home if object is okey or not.
     * @param string $key
     * @param null $object
     * @param bool $clear
     */
    protected function message(string $key, $object = null, $clear = false)
    {
        if ($clear) {
            Alert::clear();
        }
        $status = ($object) ? "success" : "danger";
        $message = ($object) ? _v($key) : _v("not_" . $key);
        Alert::build($message, $status);
    }
}
