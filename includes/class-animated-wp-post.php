<?php

/**
 * For setting up the post type configuration for the timelines
 * 
 * 
 */

class Animated_WP_Timeline_Post
{

    public function __construct()
    {
        add_action('init', array($this, 'register_timeline_post_types'));
        add_action('init', array($this, 'remove_post_support'));
    }
    /**
     * 
     * Registers the Timeline post types for the plugin
     * 
     */
    public function register_timeline_post_types()
    {
        $labels = array(
            'name'               => __('Timelines'),
            'singular_name'      => __('Timeline'),
            'menu_name'          => __('Timelines'),
            'add_new'            => __('Add New Timeline'),
            'add_new_item'       => __('Add New Timeline'),
            'edit_item'          => __('Edit Timeline'),
            'new_item'           => __('New Timeline'),
            'view_item'          => __('View Timeline'),
            'search_items'       => __('Search Timelines'),
            'not_found'          => __('No timelines found'),
            'not_found_in_trash' => __('No timelines found in trash'),
            'parent_item_colon'  => __('Parent Timeline:')
        );

        register_post_type('timeline', array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'timeline'),
            'show_in_menu' => false, // This line hides the menu item
        ));
    }

    /**
     * 
     * Removes the post type support
     * 
     */
    public function remove_post_support()
    {
        remove_post_type_support('timeline', 'editor');
    }
}
