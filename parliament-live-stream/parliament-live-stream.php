<?php
/**
 * Plugin Name: Parliament Live Stream
 * Description: Embed live Lok Sabha and Rajya Sabha sessions in your website.
 * Version: 1.0.0
 * Author: Nitin Sharma
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue CSS
function pls_enqueue_scripts() {
    wp_enqueue_style( 'pls-style', plugin_dir_url(__FILE__) . 'stream.css' );
}
add_action( 'wp_enqueue_scripts', 'pls_enqueue_scripts' );

// Shortcode to display live stream
function pls_live_stream_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'house' => 'lok_sabha' // Default to Lok Sabha
    ), $atts, 'parliament_stream' );

    $embed_url = '';

    switch ( $atts['house'] ) {
        case 'raj_sabha':
            $embed_url = 'https://www.youtube-nocookie.com/embed/e4hgGMhkDxI?si=QUrZojTCJCNQtqTW'; // Example URL
            break;
        case 'lok_sabha':
        default:
            $embed_url = 'https://www.youtube-nocookie.com/embed/wk7y95hcLpo?si=wIZXACWYdYgCLclb'; 
            break;
    }

    ob_start(); ?>
    <div class="pls-container">
        <iframe src="<?php echo esc_url($embed_url); ?>"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'parliament_stream', 'pls_live_stream_shortcode' );
