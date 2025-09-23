<?php
/**
 * Plugin Name: Enhanced Search Bar
 * Description: Adds a powerful search bar with filters, voice recognition, and AJAX results.
 * Version: 1.0.0
 * Author: Nitin Sharma
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue JS & CSS
function esb_enqueue_scripts() {
    wp_enqueue_style( 'esb-style', plugin_dir_url(__FILE__) . 'search.css' );
    wp_enqueue_script( 'esb-script', plugin_dir_url(__FILE__) . 'search.js', array('jquery'), null, true );
    wp_localize_script('esb-script', 'esbAjax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action( 'wp_enqueue_scripts', 'esb_enqueue_scripts' );

// Shortcode for search bar
function esb_search_bar_shortcode() {
    ob_start(); ?>
    <div id="esb-search">
        <input type="text" id="esb-query" placeholder="Search articles, posts, etc.">
        <button id="esb-voice">🎤</button>
        <div id="esb-filters">
            <select id="esb-post-type">
                <option value="post">Posts</option>
                <option value="page">Pages</option>
                <option value="articles">Articles</option>
            </select>
            <select id="esb-category">
                <option value="">All Categories</option>
                <?php 
                $categories = get_categories();
                foreach($categories as $cat){
                    echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
                }
                ?>
            </select>
        </div>
        <div id="esb-results"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('enhanced_search', 'esb_search_bar_shortcode');

// AJAX callback
function esb_ajax_search() {
    $query = sanitize_text_field($_POST['query'] ?? '');
    $post_type = sanitize_text_field($_POST['post_type'] ?? 'post');
    $category = intval($_POST['category'] ?? 0);

    $args = array(
        'post_type' => $post_type,
        's' => $query,
        'posts_per_page' => 10
    );

    if($category) $args['cat'] = $category;

    $search = new WP_Query($args);
    $results = [];

    if($search->have_posts()){
        while($search->have_posts()){
            $search->the_post();
            $results[] = array(
                'title' => get_the_title(),
                'link' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 20)
            );
        }
    }

    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_esb_search', 'esb_ajax_search');
add_action('wp_ajax_nopriv_esb_search', 'esb_ajax_search');
