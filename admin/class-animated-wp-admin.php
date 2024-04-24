<?php


class Animated_WP_Admin
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'animated_wp_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'register_styles'));
        add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
    }

    //Register the admin CSS
    public function register_styles()
    {
        wp_enqueue_style('animate-wp-css', plugins_url('css/styles.css', __FILE__));
    }

    public function register_scripts()
    {
        $translation_array = array(
            'ajax_url' => admin_url('admin-ajax.php')
        );
        wp_enqueue_script('animated-wp-admin-ajax', plugin_dir_url(__FILE__) . 'js/admin-ajax.js', array('jquery'), null, true);
        wp_localize_script('animated-wp-admin-ajax', 'animatedWp', $translation_array);

        wp_enqueue_script('animated-wp-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), null, true);
    }

    // Function that adds the menu pages
    public function animated_wp_admin_menu()
    {
        add_menu_page('Animated WP', 'Animated WP', 'manage_options', 'animated-wp', array($this, 'admin_panel'), 'dashicons-controls-play', 20);
        add_submenu_page('animated-wp', 'Documentation', 'Documentation', 'manage_options', 'animated-wp-documentation', array($this, 'documentation_panel'));
    }

    // Creates the admin interface for the main page of the plugin
    public function admin_panel()
    {
        include plugin_dir_path(__FILE__) . 'partials/class-animated-wp-admin-settings-header.php';
        include plugin_dir_path(__FILE__) . 'partials/class-animated-wp-admin-settings.php';
    }

    public function documentation_panel()
    {
        include plugin_dir_path(__FILE__) . 'partials/class-animated-wp-admin-settings-header.php';
        include plugin_dir_path(__FILE__) . 'partials/documentation/class-animated-wp-admin-documentation-panel.php';
    }

    // Renders the table of timelines for the admin panel
    public function render_timelines_list_page()
    {
        $timelines_list_table = new Timelines_List_Table();
        $timelines_list_table->prepare_items();
        $timelines_list_table->display();
    }
}
