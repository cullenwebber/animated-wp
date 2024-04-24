<?php

/**
 * Used to extend the WP_List_Table to display custom post types
 * 
 */

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class Timelines_List_Table extends WP_List_Table
{

    // Constructor
    function __construct()
    {
        parent::__construct(array(
            'singular' => 'Timeline',
            'plural'   => 'Timelines',
            'ajax'     => false
        ));
    }

    // Get columns
    function get_columns()
    {
        return array(
            'title'     => 'Title',
            'trigger-type' => 'Trigger type',
            'trigger' => 'Trigger',
            'location-type' => 'Location type',
            'location' => 'Location',
        );
    }

    // Prepare items
    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page = $this->get_items_per_page('timelines_per_page', 5);
        $current_page = $this->get_pagenum();

        $args = array(
            'post_type'      => 'timeline',
            'posts_per_page' => $per_page,
            'paged'          => $current_page,
        );

        $this->items = get_posts($args);

        $total_items = wp_count_posts('timeline')->publish;
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ));
    }

    // Default column
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'title':
                return $item->post_title;

            case 'trigger-type':

                $trigger_data = maybe_unserialize(get_post_meta($item->ID, 'trigger_data', true));
                if ($trigger_data['triggerType'] == 'element-interaction') {
                    $trigger_return = isset($trigger_data['triggerInteraction']) ? $trigger_data['triggerInteraction'] : '';
                } else {
                    $trigger_return = isset($trigger_data['triggerType']) ? $trigger_data['triggerType'] : '';
                }
                return ucfirst(str_replace('-', ' ', $trigger_return));

            case 'trigger':
                $trigger_data = maybe_unserialize(get_post_meta($item->ID, 'trigger_data', true));
                return $trigger_element = isset($trigger_data['triggerElement']) ? $trigger_data['triggerElement'] : '';

            case 'location-type':
                $location_data = maybe_unserialize(get_post_meta($item->ID, 'location_data', true));
                $location_type = isset($location_data['locationType']) ? $location_data['locationType'] : '';
                return ucfirst(str_replace('-', ' ', $location_type));

            case 'location':
                $location_data = maybe_unserialize(get_post_meta($item->ID, 'location_data', true));
                $location_value = isset($location_data['locationValue']) ? $location_data['locationValue'] : '';
                return ucfirst(str_replace('-', ' ', $location_value));

            default:
                return '';
        }
    }

    function column_title($item)
    {
        $post_edit_link = get_edit_post_link($item->ID);
        $actions = array(
            'edit'      => sprintf('<a href="%s">Edit</a>', $post_edit_link),
            'delete'    => sprintf('<a href="%s">Delete</a>', get_delete_post_link($item->ID))
        );

        // Wrap the title with an anchor tag if edit link exists
        $title_output = $post_edit_link ? sprintf('<a href="%s" class="timeline-post-title">%s</a>', $post_edit_link, $item->post_title) : $item->post_title;

        return sprintf('%1$s %2$s', $title_output, $this->row_actions($actions));
    }
}
