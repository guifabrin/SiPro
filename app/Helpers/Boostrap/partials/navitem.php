<li class="nav-item<?php echo $active ? " active" : ""; ?>" id="<?php echo $navItemId = random_uuid(); ?>">
    <a class="nav-link" href="<?php echo $this->url; ?>"
        <?php if ($this->url[0] == '#') { ?> data-toggle="collapse" role="button" aria-expanded="false" <?php } ?>>
        <i class="<?php echo $this->icon; ?>"></i>
        <?php _e('bootstrap.nav.item.' . $this->key); ?>
        <?php echo $active ? "<span class='sr-only'></span>" : ""; ?>
    </a>
    <?php if (isset($this->subitens)) { ?>
        <ul class="collapse show navbar-nav mr-auto" id="<?php echo substr($this->url, 1); ?>">
            <?php $this->buildSubitens($navItemId); ?>
        </ul>
    <?php } ?>
</li>