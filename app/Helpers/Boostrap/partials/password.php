<div class="form-group<?php echo $this->hasError() ? ' has-error' : ''; ?>">
    <label for="<?php echo $this->id(); ?>"><?php echo _v($this->name); ?>:</label>
    <input type="password" name="<?php echo $this->name; ?>" id="<?php echo $this->id(); ?>"
           value="<?php echo $this->value() ?>"
           class="form-control"
        <?php if ($this->hasHelper()) { ?>
            aria-describedby="<?php echo $this->helpId(); ?>"
        <?php } ?>
           placeholder="<?php echo _v($this->name . "_placeholder"); ?>"
        <?php if ($this->required) { ?>
            required
        <?php } ?>
        <?php if ($this->readonly) { ?>
            readonly="true"
        <?php } ?>>
    <?php if ($this->hasHelper()) {
        ?>
        <small id="<?php echo $this->helpId(); ?>"
               class="form-text text-muted">
            <?php echo $this->helperText(); ?>
        </small>
        <?php
    } ?>
</div>