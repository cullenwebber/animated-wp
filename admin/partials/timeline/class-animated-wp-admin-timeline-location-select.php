<?php

/**
 * Renders the select field for different location types
 * 
 * 
 */
?>
<select name="location_value" id="location_value">
    <?php foreach ($location_values as $item) : ?>
        <option value="<?php echo htmlspecialchars($item['slug']); ?>"><?php echo htmlspecialchars($item['title']); ?></option>
    <?php endforeach; ?>
</select>