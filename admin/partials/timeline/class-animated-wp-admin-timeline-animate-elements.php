<?php

/**
 * Mark up to display the animation timelines for elements
 * 
 * 
 * 
 */

?>
<div class="heading-container">
    <h3>Animation</h3>
    <div class="animation-remove"></div>
</div>
<div class="input-group-wrapper">
    <div class="animated-wp-input-wrapper">
        <h4>Animation direction</h4>
        <label class="timeline-label">
            <select name="animated-state" id="animated-state">
                <option value="to" <?php echo (!empty($state) && $state == 'to') ? 'selected' : ''; ?>>To</option>
                <option value="from" <?php echo (!empty($state) && $state == 'from') ? 'selected' : ''; ?>>From</option>
            </select>
        </label>
    </div>
    <div class="animated-wp-input-wrapper">
        <h4>Duration</h4>
        <label class="timeline-label">
            <input type="number" name="duration" id="duration" placeholder="1" value="<?php echo isset($duration) ? $duration : ''; ?>">
        </label>
    </div>
    <div class="animated-wp-input-wrapper">
        <h4>Ease type</h4>
        <select name="ease" id="ease">
            <option value="none" <?php echo (!empty($ease) && $ease == 'none') ? 'selected' : ''; ?>>Linear</option>
            <option value="power2.in" <?php echo (!empty($ease) && $ease == 'power2.in') ? 'selected' : ''; ?>>Ease in</option>
            <option value="power2.out" <?php echo (!empty($ease) && $ease == 'power2.out') ? 'selected' : ''; ?>>Ease out</option>
        </select>
    </div>
</div>
<div class="input-group-wrapper">
    <div class="animated-wp-input-wrapper">
        <h4>Animate element</h4>
        <label class="timeline-label">
            <input type="text" name="animated-element" id="animated-element" placeholder=".box" value="<?php echo isset($element) ? $element : ''; ?>">
        </label>
    </div>

    <div class="animated-wp-input-wrapper">
        <h4>Animated property</h4>
        <label class="timeline-label">
            <input type="text" name="animated-property" id="animated-property" placeholder="opacity" value="<?php echo $animations_array[0]['property']; ?>">
        </label>
    </div>
    <div class="animated-wp-input-wrapper">
        <h4>Animated value</h4>
        <label class="timeline-label">
            <input type="text" name="animated-value" id="animated-value" placeholder="0" value="<?php echo $animations_array[0]['value']; ?>">
        </label>
    </div>
    <div class="animation-add"></div>
</div>
<?php
if (!empty($animations_array) && count($animations_array) > 1) :  // Ensuring there's more than one item to iterate over
    for ($i = 1; $i < count($animations_array); $i++) :
?>
        <div class="input-group-wrapper">
            <div class="empty-input-div">
                <div class="animation-add-remove"></div>
            </div>
            <div class="animated-wp-input-wrapper">
                <h4>Animated property</h4>
                <label class="timeline-label">
                    <input type="text" name="animated-property" id="animated-property" placeholder="opacity" value="<?php echo $animations_array[$i]['property']; ?>">
                </label>
            </div>
            <div class="animated-wp-input-wrapper">
                <h4>Animated value</h4>
                <label class="timeline-label">
                    <input type="text" name="animated-value" id="animated-value" placeholder="0" value="<?php echo $animations_array[$i]['value']; ?>">
                </label>
            </div>
            <div class="animation-add"></div>
        </div>
<?php
    endfor;
endif;
?>
<div class="input-group-wrapper">
    <div class="empty-input-div">
    </div>
    <div class="animated-wp-input-wrapper">
        <h4>Animation stagger</h4>
        <label class="timeline-label">
            <input type="number" name="animation-stagger" id="animation-stagger" placeholder="0.1" value="<?php echo $animation_stagger; ?>">
        </label>
    </div>
    <div class="animated-wp-input-wrapper">
        <h4>Animation offset</h4>
        <label class="timeline-label">
            <input type="number" name="animation-offset" id="animation-offset" placeholder="50" value="<?php echo $animation_offset; ?>">
        </label>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        /**
         * Remove animation functionality
         *
         */

        $(".animation-remove").on("click", function(e) {
            e.preventDefault();
            var parentContainer = $(this).parent().parent();
            parentContainer.remove();
        });
    });
</script>