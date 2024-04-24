<?php

/**
 * The php file that generates the animations for the page from the custom post types.
 * 
 * 
 */
class Animated_WP_Animation_Render
{


    public function __construct()
    {
        add_action('wp_footer', array($this, 'render_animations'));
    }

    /**
     * Get all the timeline posts for the animations
     * 
     */
    private function getTimelines()
    {
        $args = [
            'post_type'      => 'timeline',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        $timelines = get_posts($args);

        return $timelines;
    }

    public function render_animations()
    {
        if (is_admin()) {
            return;
        }

        $timelines = $this->getTimelines();

        if (!$timelines) {
            return;
        }

        global $post;

        $post_id = isset($post) ? $post->ID : null;

        if (!$post_id) {
            return;
        }

        foreach ($timelines as $timeline) {
            $timeline_id = $timeline->ID;

            // Get the location data when to render the timeline animation
            $location_data = maybe_unserialize(get_post_meta($timeline_id, 'location_data', true));
            $location_type = isset($location_data['locationType']) ? $location_data['locationType'] : null;
            $location_value = isset($location_data['locationValue']) ? $location_data['locationValue'] : null;

            // See if the current page matches the conditional settings
            $location_match = $this->check_if_location_matches($location_type, $location_value, $post_id);

            // Continues the loop if the conditions are not met
            if (!$location_match) {
                continue;
            }

            $trigger_data = maybe_unserialize(get_post_meta($timeline_id, 'trigger_data', true));

            $trigger_type = isset($trigger_data['triggerType']) ? $trigger_data['triggerType'] : null;
            $trigger_element = isset($trigger_data['triggerElement']) ? $trigger_data['triggerElement'] : null;
            $trigger_interaction = isset($trigger_data['triggerInteraction']) ? $trigger_data['triggerInteraction'] : null;

            $animation_data = maybe_unserialize(get_post_meta($timeline_id, 'animation_data', true));

            $timeline_name = str_replace(' ', '_', strtolower(get_the_title($timeline_id)));

            // Handles the Page Load trigger type
            if ($trigger_type == 'page-load') {
                $this->page_load_animation($animation_data, $timeline_name);
            }

            // Handles the scroll trigger events
            if ($trigger_interaction == 'scroll') {
                $this->scroll_animation($animation_data, $timeline_name, $trigger_element);
            }

            // Handle the hover trigger events
            if ($trigger_interaction == 'hover') {
                $this->hover_animation($animation_data, $timeline_name, $trigger_element);
            }

            // Handle the click trigger events
            if ($trigger_interaction == 'click') {
                $this->click_animation($animation_data, $timeline_name, $trigger_element);
            }
        }
    }

    /**
     * Checks if the location type and location value matches to the current page
     * 
     */
    private function check_if_location_matches($location_type, $location_value, $post_id)
    {
        if (!get_post($post_id)) {
            return false; // Check if the post exists
        }

        $match = false;

        switch ($location_type) {
            case 'post_type':
                $post_type = get_post_type($post_id);
                if ($post_type === $location_value) {
                    $match = true;
                }
                break;

            case 'post_template':
                $post_template = get_page_template_slug($post_id);
                if ($post_template === $location_value) {
                    $match = true;
                }
                break;

            case 'page':
            case 'post': // Combine since both are checking post_name
                $post_name = get_post_field('post_name', $post_id);
                if ($post_name === $location_value) {
                    $match = true;
                }
                break;
        }

        return $match;
    }

    /**
     * Handles the function that outputs the jQuery code that deals with the page load trigger type
     * 
     */
    private function page_load_animation($animation_data, $timeline_name)
    {
?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", () => {
                <?php
                echo $this->render_animation_from_data($animation_data, $timeline_name);
                ?>
            });
        </script>
    <?php

    }

    /**
     * Handles the function that outputs the jQuery code that deals with the scroll trigger type
     * 
     */
    private function scroll_animation($animation_data, $timeline_name, $trigger_element)
    {
    ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", () => {
                gsap.registerPlugin(ScrollTrigger);
                <?php
                echo $this->render_animation_from_data_scroll($animation_data, $timeline_name, $trigger_element);
                ?>
            });
        </script>
    <?php

    }

    /**
     * Handles the function that outputs the jQuery code that deals with the hover trigger type
     * 
     */
    private function hover_animation($animation_data, $timeline_name, $trigger_element)
    {
    ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", () => {

                <?php
                echo $this->render_animation_from_data($animation_data, $timeline_name);
                ?>

                const triggerElements = document.querySelectorAll("<?php echo $trigger_element ?>");
                <?php echo $timeline_name ?>.pause();

                triggerElements.forEach(function(element) {

                    element.addEventListener("mouseenter", () => {
                        <?php echo $timeline_name ?>.play();
                    })

                    element.addEventListener("mouseleave", () => {
                        <?php echo $timeline_name ?>.reverse();
                    })
                });
            });
        </script>
    <?php
    }

    /**
     * Handles the function that outputs the jQuery code that deals with the click trigger type
     * 
     */
    private function click_animation($animation_data, $timeline_name, $trigger_element)
    {
    ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", () => {

                <?php
                echo $this->render_animation_from_data($animation_data, $timeline_name);
                ?>

                const triggerElements = document.querySelectorAll("<?php echo $trigger_element ?>");
                <?php echo $timeline_name ?>.pause();

                triggerElements.forEach(function(element) {

                    element.addEventListener("click", () => {
                        <?php echo $timeline_name ?>.play();
                    })
                });
            });
        </script>
<?php
    }

    /**
     * Renders the GSAP Timeline
     * 
     * 
     */
    private function render_animation_from_data($animation_data, $timeline_name)
    {


        $timeline_script = "
        var $timeline_name = gsap.timeline();
            ";


        foreach ($animation_data as $animation) {

            $state = $animation['state'];
            $element = isset($animation['element']) ? $animation['element'] : '.box';
            $ease = isset($animation['ease']) ? $animation['ease'] : 'none';
            $duration = isset($animation['duration']) ? $animation['duration'] : 1;
            $animations_array = $animation['animations'];
            $animation_offset = $animation['animationOffset'];
            $animation_stagger = $animation['animationStagger'];

            $timeline_script .= "

            var elements = document.querySelectorAll('$element');
            elements.forEach(function(element) {
                element.style.transition = 'none';
            });

            $timeline_name.$state('$element', {";

            foreach ($animations_array as $animation_effect) {
                $animation_property = isset($animation_effect['property']) ? $animation_effect['property'] : '';
                $animation_value = isset($animation_effect['value']) ? $animation_effect['value'] : '';
                $timeline_script .= "$animation_property: '$animation_value',";
            }

            $timeline_script .= " duration: $duration, ease: '$ease', stagger: $animation_stagger
            }, '<$animation_offset%');
            ";
        }

        return $timeline_script;
    }
    /**
     * Renders the GSAP Timeline
     * 
     * 
     */
    private function render_animation_from_data_scroll($animation_data, $timeline_name, $trigger_element = null)
    {

        $timeline_script = "
            let lastHeight = document.documentElement.scrollHeight;

            setTimeout(() => {
                let currentHeight = document.documentElement.scrollHeight;
                if (currentHeight !== lastHeight) {
                    ScrollTrigger.refresh();
                    console.log('Document height changed. Triggering ScrollTrigger.refresh().');
                }
            }, 1000);";

        $timeline_script .= "

        var trigger_element = document.querySelectorAll('$trigger_element');
            
        trigger_element.forEach((trigger) => {

            trigger.style.overflow = 'hidden';
            
            var $timeline_name = gsap.timeline({
                scrollTrigger: {
                    trigger: trigger,
                    start: 'top center'
                }
            });
            ";


        foreach ($animation_data as $animation) {

            $state = $animation['state'];
            $element = isset($animation['element']) ? $animation['element'] : '.box';
            $ease = isset($animation['ease']) ? $animation['ease'] : 'none';
            $duration = isset($animation['duration']) ? $animation['duration'] : 1;
            $animations_array = $animation['animations'];
            $animation_offset = $animation['animationOffset'];
            $animation_stagger = $animation['animationStagger'];

            $timeline_script .= "

            var elements = trigger.querySelectorAll('$element');

            elements.forEach(function(element) {
                element.style.transition = 'none';
            });

            $timeline_name.$state(elements, {";

            foreach ($animations_array as $animation_effect) {
                $animation_property = isset($animation_effect['property']) ? $animation_effect['property'] : '';
                $animation_value = isset($animation_effect['value']) ? $animation_effect['value'] : '';
                $timeline_script .= "$animation_property: '$animation_value',";
            }

            $timeline_script .= " duration: $duration, ease: '$ease', stagger: $animation_stagger
            }, '<$animation_offset%');
            ";
        }

        $timeline_script .= "});";

        return $timeline_script;
    }
}
