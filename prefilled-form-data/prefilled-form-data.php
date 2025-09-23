<?php
/**
 * Plugin Name: Prefilled Form Data
 * Description: Automatically fills form fields with previously entered data for logged-in users or guests.
 * Version: 1.0.0
 * Author: Nitin Sharma
 */

if (!defined('ABSPATH')) exit;

// Enqueue JS
function pfd_enqueue_scripts() {
    wp_enqueue_script('pfd-script', plugin_dir_url(__FILE__) . 'prefill.js', array('jquery'), null, true);
    wp_localize_script('pfd-script', 'pfdAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'user_data' => wp_get_current_user() ? array(
            'name' => wp_get_current_user()->display_name,
            'email' => wp_get_current_user()->user_email
        ) : array()
    ));
}
add_action('wp_enqueue_scripts', 'pfd_enqueue_scripts');
