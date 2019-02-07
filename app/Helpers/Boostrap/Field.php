<?php

namespace App\Helpers\Boostrap;

use Illuminate\Support\ViewErrorBag;

class Field
{

    private $name;
    private $type;
    private $value;
    private $others;
    private $readonly;
    private $required;

    public function __construct($name, $type, $value, $required = true, $readonly = false, $others = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->others = $others;
        $this->readonly = $readonly;
        $this->required = $required;
    }

    public static function build($name, $type, $value = null, $required = true, $readonly = false, $others = null)
    {
        (new self($name, $type, $value, $required, $readonly, $others))->__build();
    }

    public function __build()
    {
        include "partials/" . $this->type . ".php";
    }

    private function hasError()
    {
        return session()->get('errors', app(ViewErrorBag::class))->has($this->name);
    }

    private function hasHelper()
    {
        return $this->helperText() != $this->helperKey();
    }

    private function helperText()
    {
        return __($this->helperKey());
    }

    private function helperKey()
    {
        return _v() . $this->name . "_helper";
    }

    private function id()
    {
        $string = $this->name . ucwords($this->type);
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    private function helpId()
    {
        return $this->name . "Help";
    }

    private function value()
    {
        if (isset($this->value)) {
            return $this->value;
        }
        $old = old($this->name);
        if (is_array($old) && !empty($old)) {
            return $old[0];
        } else {
            return '';
        }
    }
}