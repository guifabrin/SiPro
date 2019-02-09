<img class="img-rounded sipro-image-file-select" id="<?php echo $this->id(); ?>" alt="<?php _v('selected_image'); ?>"
     src="<?php echo $this->value() ? $this->value() : url('/images/no_image.png'); ?>"/>

<div class="custom-file">
    <input type="hidden" value="<?php echo $this->value() ? $this->value() : null; ?>" name="hidden-<?php echo $this->name; ?>">
    <input type="file" class="custom-file-input" id="<?php echo $this->id(); ?>" name="<?php echo $this->name; ?>"
           accept="image/x-png,image/gif,image/jpeg" onchange="siPro.renderImage(this, '<?php echo $this->id(); ?>');">
    <label class="custom-file-label" for="customFile"><?php echo _v($this->name); ?></label>
</div>