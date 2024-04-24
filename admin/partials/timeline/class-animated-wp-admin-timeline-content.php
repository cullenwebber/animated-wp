<?php

/**
 * The content render of the timeline template
 * 
 * 
 */
?>
<div class="animated-wp-content-wrapper">
    <div class="animated-wp-panel">
        <div class="inside-panel animated-wp-panel-header">
            <h3 class="locations-heading">Location</h3>
        </div>
        <div class="inside-panel">
            <?php include plugin_dir_path(__FILE__) . 'class-animated-wp-admin-timeline-location.php'; ?>
        </div>
    </div>

    <div class="animated-wp-panel">
        <div class="inside-panel animated-wp-panel-header">
            <h3 class="trigger-heading">Animation Trigger</h3>
        </div>
        <div class="inside-panel">
            <?php include plugin_dir_path(__FILE__) . 'class-animated-wp-admin-timeline-trigger.php'; ?>
        </div>
    </div>

    <div class="animated-wp-panel">
        <div class="inside-panel animated-wp-panel-header">
            <h3 class="animation-heading">Animate Elements</h3>
        </div>
        <div id="animation-timeline-container">
            <?php
            foreach ($animation_data as $animation) :
                $state = $animation['state'];
                $element = isset($animation['element']) ? $animation['element'] : '.box';
                $ease = isset($animation['ease']) ? $animation['ease'] : 'none';
                $duration = isset($animation['duration']) ? $animation['duration'] : 1;
                $animations_array = $animation['animations'];
                $animation_offset = isset($animation['animationOffset']) ? $animation['animationOffset'] : 100;
                $animation_stagger = isset($animation['animationStagger']) ? $animation['animationStagger'] : 0;
            ?>
                <div class="inside-panel animation animation-container">
                    <?php include plugin_dir_path(__FILE__) . 'class-animated-wp-admin-timeline-animate-elements.php'; ?>
                </div>
            <?php
            endforeach;
            ?>
        </div>
        <div class="inside-panel">
            <div class="animated-wp-button animated-wp-add animated-wp-button-secondary" id="add-animation-btn">Add animation</div>
        </div>
    </div>

</div>