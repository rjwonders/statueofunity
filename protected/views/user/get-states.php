<select name="State">
    <option value="">Select State</option>
    <?php foreach($rsState as $State): ?>
        <option value="<?php echo $State->stateid; ?>"><?php echo $State->states; ?></option>
    <?php endforeach; ?>
</select>