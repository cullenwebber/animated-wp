<?php

/**
 * Mark up to display the input for the trigger rules for the timeline page
 * 
 * 
 */
?>
<div class="inside-panel-wrapper">
    <h4>Trigger type</h4>
    <div class="animated-wp-radio-buttons">
        <div class="">
            <input class="animation-trigger-type" type="radio" name="trigger-type" id="element-interaction" value="element-interaction" <?php echo ($trigger_type == 'element-interaction' ? 'checked' : '');
                                                                                                                                        echo ($trigger_type !== 'element-interaction' && $trigger_type !== 'page-load' ? 'checked' : ''); ?>>
            <label for="element-interaction">Element interaction</label>
        </div>
        <div class="">
            <input class="animation-trigger-type" type="radio" name="trigger-type" id="page-load" value="page-load" <?php echo ($trigger_type == 'page-load' ? 'checked' : ''); ?>>
            <label for="page-load">Page load</label>
        </div>

    </div>
</div>
<div class="inside-panel-wrapper element-interaction-show" <?php echo ($trigger_type == 'page-load' ? 'style="display:none;"' : '') ?>>
    <h4 class="">Trigger animation if </h4>
    <div class="input-group-wrapper">
        <label class="timeline-label">
            <input type="text" placeholder=".element" id="trigger-element" value="<?php echo $trigger_element ?>">
        </label>
        <label class="timeline-label">
            Is
        </label>
        <div class="timeline-label">
            <select name="trigger_interaction" id="trigger-interaction">
                <option value="scroll" <?php echo ($trigger_interaction == 'scroll' ? 'selected' : ''); ?>>Scrolled in to view</option>
                <option value="click" <?php echo ($trigger_interaction == 'click' ? 'selected' : ''); ?>>Clicked</option>
                <option value="hover" <?php echo ($trigger_interaction == 'hover' ? 'selected' : ''); ?>>Hovered</option>
            </select>
        </div>
    </div>
</div>