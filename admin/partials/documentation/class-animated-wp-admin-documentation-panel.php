<?php

/**
 * Creates the documentation page for the animations plugin
 * 
 * 
 */
?>

<div class="wrap animated-wp-body">
    <div class="animated-wp-content-wrapper">
        <div class="animated-wp-panel">
            <div class="inside-panel animated-wp-panel-header" id="trigger">
                <h3 class="trigger-heading">Animation Triggers</h3>
            </div>
            <div class="inside-panel">
                <section class="animated-wp-documentation">
                    <ol>
                        <li><strong>Element Interaction:</strong> This trigger activates animations based on user interactions with a specified element. To use this, select <code> Element interaction</code> and then:</li>
                        <ul>
                            <li>Enter a selector in the <strong>Trigger Element Field</strong>, using a class (e.g. <code>.box</code>) or an ID (e.g. <code>#box</code>). Ensure to include the '.' or '#' as appropriate to the selector type.</li>
                            <li>Choose an interaction type from the dropdown menu, which includes: </li>
                            <ul>
                                <li><strong>Scroll into view:</strong> The animation triggers when the element scrolls into view.</li>
                                <li><strong>Click:</strong> The animation triggers when the element is clicked.</li>
                                <li><strong>Hover:</strong> The animation triggers when the mouse hovers over the element.</li>
                            </ul>

                        </ul>
                        <li><strong>Page Load:</strong> This trigger type initiates the animation as soon as the webpage loads, without any need for user interaction.</li>
                    </ol>
                </section>
            </div>
        </div>
        <div class="animated-wp-panel">
            <div class="inside-panel animated-wp-panel-header" id="animate">
                <h3 class="animation-heading">Animate Elements</h3>
            </div>
            <div class="inside-panel">
                <section class="animated-wp-documentation">
                    <ol>
                        <li><strong>Animation Direction:</strong> Choose <code>To</code> to define the end values you're animating towards, or <code>From</code> to start from certain values and revert to the original state.</li>
                        <li><strong>Duration:</strong> Sets how long the animation will run, in seconds (e.g. <code>0.5</code> for half a second).</li>
                        <li><strong>Ease Type:</strong> Selects the animation's timing function: </li>
                        <ul>
                            <li><strong>Ease in:</strong> Starts slowly, accelerating towards the end.</li>
                            <li><strong>Ease out:</strong> Starts fast, decelerating towards the end.</li>
                            <li><strong>Linear:</strong> Proceeds at a constant pace throughout.</li>
                        </ul>

                        <li><strong>Animate Element:</strong> Enter the CSS selector for the element you wish to animate, using a class (e.g. <code>.textBox</code>) or an ID (e.g. <code>#textBox</code>). Include '.' or '#' as appropriate.</li>
                        <li><strong>Animated Property:</strong> Specifies the CSS property to animate (e.g. <code>opacity</code>). Use camelCase for multi-word properties (e.g. <code>borderRadius</code> for 'border-radius').</li>
                        <li><strong>Animated Value:</strong> Indicates the value the property will animate to or from, depending on the direction chosen. This value must be valid for the specified CSS property.</li>
                        <li><strong>Animation Stagger:</strong> If animating multiple elements with the same class, this sets the delay in seconds before each subsequent element begins animating (e.g. <code>0.1</code>).</li>
                        <li><strong>Animation Offset:</strong> Determines the start time of the animation relative to the last one. A value of <code>0</code> starts with the previous animation, <code>100</code> waits for it to complete, and <code>50</code> starts halfway through.</li>
                    </ol>
                </section>
            </div>
        </div>
    </div>
</div>