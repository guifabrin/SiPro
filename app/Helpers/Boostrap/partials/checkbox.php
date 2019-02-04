<div class="form-check">
    <input type="checkbox" name="<?php echo $this->name; ?>" id="<?php echo $this->id(); ?>"
           value="<?php echo $this->value(); ?>" class="form-check-input"
        <?php if ($this->hasHelper()) { ?>
            aria-describedby="<?php echo $this->helpId(); ?>"
        <?php } ?>
        <?php if ($this->required) { ?>
            required
        <?php } ?>
        <?php if ($this->readonly) { ?>
            readonly
        <?php } ?>
    <?php if ($this->others) { ?>
        checked
    <?php } ?>>
    <label class="form-check-label" for="<?php echo $this->id(); ?>"><?php echo _v($this->name); ?></label>
    <?php if ($this->hasHelper()) { ?>
        <small id="<?php echo $this->helpId(); ?>" class="form-text text-muted">
            <?php echo $this->helperText(); ?>
        </small>
    <?php } ?>
</div>