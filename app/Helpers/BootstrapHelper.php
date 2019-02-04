<?php
class BootstrapHelper{

    public static function navItem($basePath, $keyLang, $classIcon){
        $url = url($basePath);
        $requestUrl = Request::url();
        $active = $requestUrl == $url;
        ?>
        <li class="nav-item<?php echo $active ? " active" : ""; ?>">
            <a class="nav-link" href="<?php echo $url; ?>">
                <i class="<?php echo $classIcon; ?>"></i>
                <?php _e($keyLang); ?>
                <?php echo $active ? "<span class='sr-only'></span>" : ""; ?>
            </a>
        </li>
        <?php
    }

    public static function navItemDropDownItem($basePath, $keyLang){
        ?>
        <a class="dropdown-item" href="<?php echo url($basePath); ?>">
            <?php _e($keyLang); ?>
        </a>
        <?php
    }

}