<?php

namespace App\Helpers\Boostrap;

class LinkButton
{

    private $key;
    private $url;
    private $icon;

    public function __construct($key, $url, $icon = null)
    {
        $this->key = $key;
        $this->url = $url;
        $this->icon = $icon;
    }

    public static function build($key, $url, $icon = null)
    {
        (new self($key, $url, $icon))->__build();
    }

    public function __build()
    {
        ?>
        <a href="<?php echo url($this->url); ?>" class="btn btn-link">
            <?php if (isset($this->icon)) { ?>
                <i class="<?php echo $this->icon; ?>"></i>
            <?php } ?>
            <?php echo _v($this->key); ?>
        </a>
        <?php
    }
}