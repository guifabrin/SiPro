<div class="form-group<?php echo $this->hasError() ? ' has-error' : ''; ?>">
    <?php if (_v($this->name) != '') { ?>
        <label for="<?php echo $this->id(); ?>"><?php echo _v($this->name); ?>:</label>
    <?php } ?>
    <textarea name="<?php echo $this->name; ?>" id="<?php echo $this->id(); ?>" class="form-control"
        <?php if ($this->hasHelper()) { ?>
            aria-describedby="<?php echo $this->helpId(); ?>"
        <?php } ?>
           placeholder="<?php echo _v($this->name . "_placeholder"); ?>"
        <?php if ($this->required) { ?>
            required
        <?php } ?>
        <?php if ($this->readonly) { ?>
            readonly="true"
        <?php } ?>><?php echo $this->value() ?></textarea>
    <?php if ($this->hasHelper()) { ?>
        <small id="<?php echo $this->helpId(); ?>" class="form-text text-muted">
            <?php echo $this->helperText(); ?>
        </small>
    <?php } ?>
</div>