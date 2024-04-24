<?php

/**
 * Partial to display the admin interface of the timeline add page
 * 
 * 
 */
?>
<style type="text/css">
    .wp-heading-inline {
        display: none !important;
    }

    .wrap {
        margin: 0px !important;
    }

    #screen-meta-links {
        display: none !important;
    }

    .page-title-action {
        display: none !important;
    }

    #titlediv {
        display: none !important;
    }

    #submitdiv {
        display: none !important;
    }

    #poststuff #post-body.columns-2 {
        margin-right: 20px !important;
        width: 80%;
    }

    #post-body.columns-2 #postbox-container-1 {
        display: none !important;
        width: 0 !important;
    }

    @media (max-width: 1100px) {
        #poststuff #post-body.columns-2 {
            margin-right: 20px !important;
            width: auto;
        }
    }

    @media (max-width: 783px) {
        #poststuff {
            padding-right: 10px !important;
        }

        #poststuff #post-body.columns-2 {
            margin-right: 0px !important;
            width: auto;
        }

        .animated-wp-button-group {
            width: 100%;
        }

        .animated-wp-button {
            width: 100%;
            justify-content: center;
        }

        #wpcontent .animated-wp-sub-header {
            position: relative;
        }

        .animated-wp-sub-header>.animated-wp-button-group:first-child {
            flex-direction: column;
            align-items: flex-start;
        }

        #wpcontent .animated-wp-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

    }
</style>

<?php include plugin_dir_path(__FILE__) . '../class-animated-wp-admin-header.php'; ?>
<div class="animated-wp-sub-header edit-page">
    <div class="animated-wp-button-group">
        <?php
        if (!get_the_title()) : ?>
            <h2>New Animation Timeline</h2>
        <?php
        else :
        ?>
            <h2>Edit Animation Timeline</h2>
        <?php
        endif;
        ?>
        <input class="animated-wp-title-input" id="animated-wp-title-input" type="text" placeholder="Add Timeline Title" value="<?php echo get_the_title(); ?>">
        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id ?>">
    </div>
    <div class="animated-wp-button-group">
        <a href="<?php echo 'post-new.php?post_type=timeline' ?>" class="animated-wp-button animated-wp-add animated-wp-button-secondary">Add New</a>
        <a href="" class="animated-wp-button" id="save-animation-timeline">Save changes</a>
    </div>
</div>