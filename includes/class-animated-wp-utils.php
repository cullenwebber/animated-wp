<?php

/**
 * Utils section of the animation plugin
 * 
 * 
 */

class Animated_WP_Utils
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'load_gsap'));
        add_action('wp_enqueue_scripts', array($this, 'load_scrolltrigger'));
    }

    /**
     * Loads in the GSAP script from the CDN
     * 
     */
    public function load_gsap()
    {
        $gsap_url = "https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js";
        wp_enqueue_script('gsap', $gsap_url, array(),);
    }

    /**
     * Loads in the ScrollTrigger script from the CDN
     * 
     */
    public function load_scrolltrigger()
    {
        $scrolltrigger_url = "https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js";
        wp_enqueue_script('scrolltrigger', $scrolltrigger_url, array('gsap'),);
    }
}
