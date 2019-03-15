<?php

namespace App\Helpers\Boostrap;

use App\Helpers\JS;

class NavItem
{

    private $key;
    private $url;
    private $icon;
    private $subitens;
    private $parentId;

    public function __construct($key, $url, $icon = null, $subitens = null, $parentId = null)
    {
        $this->key = $key;
        $this->url = $url;
        $this->icon = $icon;
        $this->subitens = $subitens;
        $this->parentId = $parentId;
    }

    public static function build($key, $url, $icon = null, $subitens = null, $parentId = null)
    {
        (new self($key, $url, $icon, $subitens, $parentId))->__build();
    }

    private function buildSubitens($navItemId){
        foreach ($this->subitens as $item) {
            NavItem::build($item[0], $item[1], $item[2], isset($item[3]) ? $item[3] : null, $navItemId);
        }
    }

    public function __build()
    {
        $active = current_url() == $this->url || current_url() == $this->url . "/";
        include 'partials/navitem.php';
        if ($active && $this->parentId)
            JS::build("$('#".$this->parentId."').addClass('active')");
    }
}