<?php

namespace App\Helpers\Boostrap;

class Submit
{

    private $icon;

    public function __construct($icon)
    {
        $this->icon = $icon;
    }

    public static function build($icon)
    {
        (new self($icon))->__build();
    }

    public function __build()
    {
        ?>
        <button type="submit" class="btn btn-primary">
            <i class="<?php echo $this->icon; ?>"></i> <?php echo _v("submit"); ?>
        </button>
        <?php
    }
}