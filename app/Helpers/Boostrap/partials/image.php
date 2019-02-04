<img class="img-rounded sipro-image-file-select" id="<?php echo $this->id(); ?>" style="margin: auto; margin-bottom: 10pt; display: block;"
     src="<?php echo $this->value() ? $this->value() : url('/images/no_image.png'); ?>"/>

<div class="custom-file">
    <input type="file" class="custom-file-input" id="<?php echo $this->id(); ?>" name="<?php echo $this->name; ?>"
           accept="image/x-png,image/gif,image/jpeg" onchange="siPro.renderImage(this, '<?php echo $this->id(); ?>');">
    <label class="custom-file-label" for="customFile"><?php echo _v($this->name); ?></label>
</div>