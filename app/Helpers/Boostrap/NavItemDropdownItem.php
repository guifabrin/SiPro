<?php

namespace App\Helpers\Boostrap;


class NavItemDropdownItem
{

    private $key;
    private $url;

    public function __construct($key, $url)
    {
        $this->key = $key;
        $this->url = $url;
    }

    public static function build($key, $url)
    {
        (new self($key, $url))->__build();
    }

    public function __build()
    {
        ?>

        <a class="dropdown-item" href="<?php echo $this->url; ?>">
            <?php _e('bootstrap.nav.item.dropdown.' . $this->key); ?>
        </a>
        <?php
    }
}