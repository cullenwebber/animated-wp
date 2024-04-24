<?php

/**
 * Generic header for the ANIMATE WP
 * 
 * 
 */

?>

<div class="animated-wp-header">
    <h1>Animate WP</h1>
    <div class="header-button-group">
        <?php
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $animation_timelines_url = admin_url('admin.php?page=animated-wp');
        $documentation_url = admin_url('admin.php?page=animated-wp-documentation');

        // Check if the current screen is associated with the 'timeline' post type
        $screen = get_current_screen();
        $is_timeline_post_type = ($screen->post_type === 'timeline');
        ?>

        <a href="<?php echo $animation_timelines_url; ?>" class="animated-wp-header-btn timelines-btn <?php if ($is_timeline_post_type) echo 'selected';
                                                                                                        elseif ($current_url == $animation_timelines_url) echo 'selected'; ?>">Animation Timelines</a>
        <a href="<?php echo $documentation_url; ?>" class="animated-wp-header-btn document-btn <?php if ($current_url == $documentation_url) echo 'selected'; ?>">Documentation</a>

    </div>

</div>