<?php

/*
Plugin Name: Animated WP
Description: Easy configurable animations for wordpress
Version: 1.0.0
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Cullen Webber
License: GPLv2 or later
Text Domain: woo-rewards-program
*/

class Animated_WP
{

    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies()
    {
        // Loads in all the dependencies for the plugin to run
        require_once plugin_dir_path(__FILE__) . 'includes/class-animated-wp-utils.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-animated-wp-post.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-animated-wp-post-table.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-animated-wp-post-page.php';
        require_once plugin_dir_path(__FILE__) . 'admin/class-animated-wp-admin.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-animated-wp-animation-render.php';
    }
    private function define_admin_hooks()
    {
        // Loads in the GSAP & Scroll trigger script
        $utils = new Animated_WP_Utils();

        //Load in the custom post types
        $posts = new Animated_WP_Timeline_Post();

        // Loads in the Admin functions & Hooks
        $admin_functions = new Animated_WP_Admin();

        //Loads in the Post interface for creating a timeline
        $timeline_post_page = new Animated_WP_Post_Page();

        //Renders the animations for the pages
        $animation_render = new Animated_WP_Animation_Render();
    }
}

if (!class_exists('Animated_WP_Plugin')) {
    $animated_wp = new Animated_WP();
}
