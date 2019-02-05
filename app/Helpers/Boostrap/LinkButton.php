<?php

namespace App\Helpers\Boostrap;

class LinkButton
{

    private $key;
    private $url;
    private $icon;
    private $btn;

    public function __construct($key, $url, $icon = null, $btn = null)
    {
        $this->key = $key;
        $this->url = $url;
        $this->icon = $icon;
        $this->btn = $btn;
    }

    public static function build($key, $url, $icon = null, $btn = null)
    {
        (new self($key, $url, $icon, $btn))->__build();
    }

    public function __build()
    {
        ?>
        <a href="<?php echo url($this->url); ?>" class="btn <?php echo isset($this->btn) ? $this->btn : 'btn-link'; ?> ">
            <?php if (isset($this->icon)) { ?>
                <i class="<?php echo $this->icon; ?>"></i>
            <?php } ?>
            <?php echo _v($this->key); ?>
        </a>
        <?php
    }
}