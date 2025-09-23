<?php
/**
 * Plugin Name: Dynamic Popups
 * Description: Show personalized popups based on user location (IP).
 * Version: 1.0.0
 * Author: Nitin Sharma
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue JS and CSS for popup
 */
function dp_enqueue_scripts() {
    $css_file = plugin_dir_path(__FILE__) . 'popup.css';
    $js_file  = plugin_dir_path(__FILE__) . 'popup.js';

    if ( file_exists($css_file) ) {
        wp_enqueue_style( 'dp-style', plugin_dir_url(__FILE__) . 'popup.css' );
    } else {
        error_log('Dynamic Popups: popup.css not found!');
    }

    if ( file_exists($js_file) ) {
        wp_enqueue_script( 'dp-script', plugin_dir_url(__FILE__) . 'popup.js', array('jquery'), null, true );
    } else {
        error_log('Dynamic Popups: popup.js not found!');
    }

    // Pass fallback data if API fails
    $country = 'Guest';
    $response = wp_remote_get("https://ipapi.co/json/");

    if ( is_array($response) && ! is_wp_error($response) ) {
        $body = json_decode( wp_remote_retrieve_body($response), true );
        if ( isset($body['country_name']) ) {
            $country = sanitize_text_field($body['country_name']);
        }
    }

    wp_localize_script( 'dp-script', 'dpData', array(
        'country' => $country,
    ));
}
add_action( 'wp_enqueue_scripts', 'dp_enqueue_scripts' );


/**
 * Popup HTML
 */
function dp_add_popup_html() {
    ?>
    <div id="dp-popup" class="dp-hidden">
        <div class="dp-content">
            <span id="dp-close">&times;</span>
            <h2>Special Update for <span id="dp-country"></span> Users!</h2>
            <p>We have exclusive news and offers tailored for your region.</p>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'dp_add_popup_html' );
