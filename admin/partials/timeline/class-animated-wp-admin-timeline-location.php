<?php

/**
 * Mark up to display the input for the location rules for the timeline page
 * 
 * 
 */
?>
<div class="inside-panel-wrapper">
    <h4>Play animation if </h4>
    <div class="input-group-wrapper">
        <label class="timeline-label">
            <select name="location_type" id="location_type">
                <option value="post_type" <?php echo ($location_type == 'post_type' ? 'selected' : ''); ?>>Post type</option>
                <option value="post_template" <?php echo ($location_type == 'post_template' ? 'selected' : ''); ?>>Post template</option>
                <option value="page" <?php echo ($location_type == 'page' ? 'selected' : ''); ?>>Page</option>
                <option value="post" <?php echo ($location_type == 'post' ? 'selected' : ''); ?>>Post</option>
            </select>
        </label>
        <label class="timeline-label">
            Is equal to
        </label>
        <div class="timeline-label" id="location-value-label">
            <select name="location_value" id="location_value">
                <?php foreach ($location_values as $item) : ?>
                    <option <?php echo ($location_value == $item['slug'] ? 'selected' : ''); ?> value="<?php echo htmlspecialchars($item['slug']); ?>"><?php echo htmlspecialchars($item['title']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>