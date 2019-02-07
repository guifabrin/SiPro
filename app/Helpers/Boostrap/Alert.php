<?php

namespace App\Helpers\Boostrap;

class Alert
{

    private $status;
    private $message;

    public function __construct($message, $status = 'success')
    {
        $this->status = $status;
        $this->message = $message;
    }

    public static function clear()
    {
        $GLOBALS['messages'] = [];
    }

    public static function build($message, $status = 'success')
    {
        $GLOBALS['messages'][] = (new self($message, $status))->__build();
    }

    public function __build()
    {
        return "<div class='alert alert-" . $this->status . "'>" . $this->message . "</div>";
    }

    public static function echo()
    {
        if (!isset($GLOBALS['messages'])) {
            return;
        }
        foreach ($GLOBALS['messages'] as $message) {
            echo $message;
        }
    }
}