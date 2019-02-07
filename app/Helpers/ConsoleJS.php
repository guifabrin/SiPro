<?php

namespace App\Helpers;

class ConsoleJS
{

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public static function clear()
    {
        $GLOBALS['consolejs'] = [];
    }

    public static function build($message)
    {
        $GLOBALS['consolejs'][] = (new self($message))->__build();
    }

    public function __build()
    {
        return 'console.log("' . $this->message . '");';
    }

    public static function echo()
    {
        if (!isset($GLOBALS['consolejs'])) {
            return;
        }
        foreach ($GLOBALS['consolejs'] as $message) {
            echo $message;
        }
    }
}