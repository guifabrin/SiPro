<div class="form-group<?php echo $this->hasError() ? ' has-error' : ''; ?>">
    <label for="<?php echo $this->id(); ?>"><?php echo _v($this->name); ?>:</label>
    <select class="custom-select" name="<?php echo $this->name; ?>" id="<?php echo $this->id(); ?>"
        <?php if ($this->required) { ?>
            required
        <?php } ?>
        <?php if ($this->readonly) { ?>
            readonly="true"
        <?php } ?>
        <?php if ($this->hasHelper()) { ?>
            aria-describedby="<?php echo $this->helpId(); ?>"
        <?php } ?>>
        <?php foreach ($this->others as $value => $name) { ?>
            <option value="<?php echo $value; ?>"
                <?php if ($value == $this->value()) { ?>
                    selected
                <?php } ?>
            >
                <?php echo $name; ?>
            </option>
        <?php } ?>
    </select>
    <?php if ($this->hasHelper()) { ?>
        <small id="<?php echo $this->helpId(); ?>" class="form-text text-muted">
            <?php echo $this->helperText(); ?>
        </small>
    <?php } ?>
</div>