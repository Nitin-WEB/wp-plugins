<?php
/**
 * Plugin Name: Dynamic Ads Display
 * Description: Displays dynamic ads based on user location or browsing behavior. The Ads will be visible at the end of the content.
 * Version: 1.0.0
 * Author: Nitin Sharma
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue CSS for ads
function dad_enqueue_scripts() {
    wp_enqueue_style( 'dad-style', plugin_dir_url(__FILE__) . 'ads.css' );
}
add_action( 'wp_enqueue_scripts', 'dad_enqueue_scripts' );

// Add ad placeholder to content
function dad_display_dynamic_ads($content) {
    if( is_single() || is_page() || is_front_page() ) {

        // Get user location
        $country = 'Guest';
        $response = wp_remote_get("https://ipapi.co/json/");
        if ( is_array($response) && ! is_wp_error($response) ) {
            $body = json_decode( wp_remote_retrieve_body($response), true );
            if ( isset($body['country_name']) ) {
                $country = sanitize_text_field($body['country_name']);
            }
        }

        // Define ads by country
        $ads = array(
            'India'      => '<div class="dad-ad">Special Offer for India! <a href="#">Shop Now</a></div>',
            'United States' => '<div class="dad-ad">Exclusive US Deal! <a href="#">Grab it</a></div>',
            'Guest'      => '<div class="dad-ad">Welcome! Check out our latest offers <a href="#">Click Here</a></div>',
        );

        $ad_html = isset($ads[$country]) ? $ads[$country] : $ads['Guest'];

        // Append ad at the end of content
        $content .= $ad_html;
    }
    return $content;
}
add_filter( 'the_content', 'dad_display_dynamic_ads' );
