<?php

namespace App\Http\Controllers\Base;

use App\Helpers\Boostrap\Alert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
