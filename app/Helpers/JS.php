<?php

namespace App\Helpers;

class JS
{

    private $script;

    public function __construct($script)
    {
        $this->script = $script;
    }

    public static function clear()
    {
        $GLOBALS['js'] = [];
    }

    public static function build($script)
    {
        $GLOBALS['js'][] = (new self($script))->script;
    }

    public static function echo()
    {
        if (!isset($GLOBALS['js'])) {
            return;
        }
        foreach ($GLOBALS['js'] as $script) {
            echo $script."\n";
        }
    }
}