<?php
/**
 * Plugin Name: Live Transport Tracker Enhanced
 * Description: Real-time tracking for trains, flights, and buses with table display, mobile-friendly and auto-refresh.
 * Version: 2.0.0
 * Author: Nitin Sharma
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue scripts and styles
function ltt_enqueue_scripts() {
    wp_enqueue_script( 'ltt-script', plugin_dir_url(__FILE__) . 'tracker.js', array('jquery'), null, true );
    wp_localize_script( 'ltt-script', 'lttAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'refresh_interval' => 30000 // 30 seconds
    ));
    wp_enqueue_style( 'ltt-style', plugin_dir_url(__FILE__) . 'tracker.css' );
}
add_action( 'wp_enqueue_scripts', 'ltt_enqueue_scripts' );

// Shortcode for tracker form
function ltt_tracker_shortcode() {
    ob_start(); ?>
    <div id="ltt-tracker">
        <form id="ltt-form">
            <select name="transport_type" required>
                <option value="">Select Transport</option>
                <option value="train">Train</option>
                <option value="flight">Flight</option>
                <option value="bus">Bus</option>
            </select>
            <input type="text" name="transport_number" placeholder="Enter Number" required>
            <button type="submit">Track</button>
        </form>
        <div id="ltt-result"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'live_tracker', 'ltt_tracker_shortcode' );

// AJAX callback for tracker
function ltt_ajax_tracker() {
    $type = sanitize_text_field($_POST['transport_type'] ?? '');
    $number = sanitize_text_field($_POST['transport_number'] ?? '');
    $api_key = '30a7a25cf25434286304427a8894c2d1'; // Replace with real API key

    switch($type) {
        case 'train':
            $url = "https://indianrailapi.com/api/v1/train/{$number}/status?apikey={$api_key}";
            break;
        case 'flight':
            $url = "https://api.aviationstack.com/v1/airlines?access_key={$api_key}&flight_iata={$number}";
            break;
        case 'bus':
            $url = "https://api.transitapp.com/v3/stops/{$number}/arrivals?api_key={$api_key}";
            break;
        default:
            wp_send_json_error('Invalid transport type.');
    }

    $response = wp_remote_get($url);
    if (is_wp_error($response)) wp_send_json_error('Failed to fetch data.');

    $data = json_decode(wp_remote_retrieve_body($response), true);
    wp_send_json_success($data);
}
add_action('wp_ajax_ltt_tracker', 'ltt_ajax_tracker');
add_action('wp_ajax_nopriv_ltt_tracker', 'ltt_ajax_tracker');

