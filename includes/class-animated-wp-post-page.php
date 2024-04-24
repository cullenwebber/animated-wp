<?php

/**
 * Custom post page configuration for the timeline pages
 * 
 * 
 */

class Animated_WP_Post_Page
{

    public function __construct()
    {
        add_action('edit_form_top', array($this, 'header'));
        add_action('edit_form_after_title', array($this, 'timeline_content'));

        // AJAX actions
        add_action('wp_ajax_get_location_values', array($this, 'get_location_values'));
        add_action('wp_ajax_add_animation_inputs', array($this, 'add_animation_inputs'));
        add_action('wp_ajax_add_animated_inputs', array($this, 'add_animated_inputs'));
        add_action('wp_ajax_save_animation_data', array($this, 'save_animation_data'));
    }

    public function header()
    {
        global $post;

        // Check if the post type is 'timeline'
        if ($post->post_type !== 'timeline') {
            return;
        }
        $post_id = get_the_ID();

        include plugin_dir_path(__FILE__) . '../admin/partials/timeline/class-animated-wp-admin-timeline-header.php';
    }

    public function timeline_content()
    {
        global $post;

        // Check if the post type is 'timeline'
        if ($post->post_type !== 'timeline') {
            return;
        }

        $post_id = $post->ID;

        $trigger_data = maybe_unserialize(get_post_meta($post_id, 'trigger_data', true));
        $location_data = maybe_unserialize(get_post_meta($post_id, 'location_data', true));
        $animation_data = maybe_unserialize(get_post_meta($post_id, 'animation_data', true));

        // Get the location data
        $location_type = isset($location_data['locationType']) ? $location_data['locationType'] : 'post_type';
        $location_value = isset($location_data['locationValue']) ? $location_data['locationValue'] : null;

        $location_values = $this->get_location_values_by_type($location_type);

        // Get the trigger data
        $trigger_type = isset($trigger_data['triggerType']) ? $trigger_data['triggerType'] : null;
        $trigger_element = isset($trigger_data['triggerElement']) ? $trigger_data['triggerElement'] : null;
        $trigger_interaction = isset($trigger_data['triggerInteraction']) ? $trigger_data['triggerInteraction'] : null;

        include plugin_dir_path(__FILE__) . '../admin/partials/timeline/class-animated-wp-admin-timeline-content.php';
    }

    public function get_location_values()
    {

        $location_type = isset($_POST['location_type']) ? $_POST['location_type'] : null;

        if (!$location_type) {
            wp_die();
        }

        ob_start();

        $location_values = $this->get_location_values_by_type($location_type);

        include plugin_dir_path(__FILE__) . '../admin/partials/timeline/class-animated-wp-admin-timeline-location-select.php';

        $select_field = ob_get_clean();

        wp_send_json_success($select_field);
    }

    private function get_location_values_by_type($location_type)
    {
        $location_values = [];

        switch ($location_type) {
            case 'post_type':
                $post_types = get_post_types(['public' => true], 'objects');
                foreach ($post_types as $post_type) {
                    $location_values[] = [
                        'title' => $post_type->labels->name,
                        'slug' => $post_type->name
                    ];
                }
                break;

            case 'post_template':
                $templates = get_page_templates();
                foreach ($templates as $template_name => $template_filename) {
                    $location_values[] = [
                        'title' => $template_name,
                        'slug' => $template_filename
                    ];
                }
                break;

            case 'page':
                $pages = get_pages();
                foreach ($pages as $page) {
                    $location_values[] = [
                        'title' => $page->post_title,
                        'slug' => $page->post_name
                    ];
                }
                break;

            case 'post':
                $posts = get_posts(['numberposts' => -1]);
                foreach ($posts as $post) {
                    $location_values[] = [
                        'title' => $post->post_title,
                        'slug' => $post->post_name
                    ];
                }
                break;
        }

        return $location_values;
    }

    public function add_animation_inputs()
    {

        ob_start();

?>
        <div class="inside-panel animation animation-container">
            <?php include plugin_dir_path(__FILE__) . '../admin/partials/timeline/class-animated-wp-admin-timeline-animate-elements.php'; ?>
        </div>
<?php
        $animated_inputs = ob_get_clean();

        wp_send_json_success($animated_inputs);
    }

    public function add_animated_inputs()
    {

        ob_start();
        include plugin_dir_path(__FILE__) . '../admin/partials/timeline/class-animated-wp-admin-timeline-additional-animated-inputs.php';
        $animated_inputs = ob_get_clean();

        wp_send_json_success($animated_inputs);
    }

    /**
     * Saves the animation data from the save button
     * 
     * 
     */
    public function save_animation_data()
    {
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('No permission to edit posts');
            return;
        }

        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : null;

        if (empty($title)) {
            wp_send_json_error('Title is required');
            return;
        }

        $trigger_data = isset($_POST['triggerData']) ? $_POST['triggerData'] : null;
        $location_data = isset($_POST['locationData']) ? $_POST['locationData'] : null;
        $animation_data = isset($_POST['animationData']) ? $_POST['animationData'] : null;

        $animation_array = [
            'trigger_data' => $trigger_data,
            'location_data' => $location_data,
            'animation_data' => $animation_data
        ];

        $post_id = isset($_POST['postId']) ? intval($_POST['postId']) : null;

        $post_data = [
            'ID'           => $post_id,
            'post_title'   => $title,
            'post_status'  => 'publish',
            'post_type'    => 'timeline',
        ];

        // Insert or update post
        $result = wp_insert_post($post_data, true);

        update_post_meta($result, 'trigger_data', maybe_serialize($trigger_data));
        update_post_meta($result, 'location_data', maybe_serialize($location_data));
        update_post_meta($result, 'animation_data', maybe_serialize($animation_data));

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success('Post saved successfully');
        }
    }
}
