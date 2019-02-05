<?php

namespace App\Helpers\Boostrap;

class NavItem
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
        $active = current_url() == $this->url || current_url() == $this->url . "/";
        ?>
        <li class="nav-item<?php echo $active ? " active" : ""; ?>">
            <a class="nav-link" href="<?php echo $this->url; ?>">
                <i class="<?php echo $this->icon; ?>"></i>
                <?php _e('bootstrap.nav.item.' . $this->key); ?>
                <?php echo $active ? "<span class='sr-only'></span>" : ""; ?>
            </a>
        </li>
        <?php
    }
}