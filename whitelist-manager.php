<?php
/**
 * Plugin Name: Trusted Domains Manager
 * Description: Manage a list of trusted domains through an admin panel with pagination, search, and domain sanitization.
 * Version: 1.0
 * Author: Nitin Sharma
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

global $wpdb;
$table_name = $wpdb->prefix . 'trusted_domains_badges';

/**
 * Create table on plugin activation
 */
function tdm_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'trusted_domains_badges';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        domain VARCHAR(255) NOT NULL UNIQUE,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'tdm_create_table');

/**
 * Fetch trusted domains with pagination and search
 */
function get_trusted_domains_paginated($offset, $limit, $search = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'trusted_domains_badges';

    $query = "SELECT domain FROM $table_name";
    if (!empty($search)) {
        $query .= $wpdb->prepare(" WHERE domain LIKE %s", '%' . $wpdb->esc_like($search) . '%');
    }
    $query .= $wpdb->prepare(" ORDER BY id DESC LIMIT %d, %d", $offset, $limit);
    
    return $wpdb->get_results($query);
}

/**
 * Count total trusted domains (with optional search)
 */
function get_total_trusted_domains($search = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'trusted_domains_badges';
    
    if (!empty($search)) {
        return (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE domain LIKE %s", '%' . $wpdb->esc_like($search) . '%'));
    }
    
    return (int) $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
}

/**
 * Extract clean domain from user input
 */
function sanitize_domain($url) {
    $parsed_url = parse_url(trim($url));

    if (!isset($parsed_url['host'])) {
        if (isset($parsed_url['path'])) {
            $host = preg_replace('/^www\./', '', $parsed_url['path']);
        } else {
            return false;
        }
    } else {
        $host = preg_replace('/^www\./', '', $parsed_url['host']);
    }

    return filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) ? $host : false;
}

/**
 * Display admin notices
 */
function tdm_admin_notices() {
    if (!empty($_GET['tdm_message'])) {
        echo '<div class="updated"><p>' . esc_html($_GET['tdm_message']) . '</p></div>';
    }
}
add_action('admin_notices', 'tdm_admin_notices');

/**
 * Add menu page in WordPress admin
 */
function tdm_add_admin_menu() {
    add_menu_page(
        'Trusted Domains', 
        'Trusted Domains', 
        'manage_options', 
        'trusted-domains', 
        'tdm_admin_page', 
        'dashicons-shield', 
        100
    );
}
add_action('admin_menu', 'tdm_add_admin_menu');


/**
 * Admin page for managing trusted domains with pagination and search
 */
function tdm_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'trusted_domains_badges';

    $limit = 25; // Domains per page
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

    // Handle Add Domain
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_domain'])) {
        check_admin_referer('tdm_nonce_action', 'tdm_nonce_field');

        $new_domain = sanitize_domain($_POST['new_domain']);

        if ($new_domain) {
            $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE domain = %s", $new_domain));

            if (!$exists) {
                $wpdb->insert($table_name, ['domain' => $new_domain]);
                wp_redirect(add_query_arg('tdm_message', 'Domain added successfully!', $_SERVER['REQUEST_URI']));
                exit;
            } else {
                wp_redirect(add_query_arg('tdm_message', 'Domain already exists!', $_SERVER['REQUEST_URI']));
                exit;
            }
        } else {
            wp_redirect(add_query_arg('tdm_message', 'Invalid domain format!', $_SERVER['REQUEST_URI']));
            exit;
        }
    }


    // Handle Delete Request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_domain'])) {
        check_admin_referer('tdm_nonce_action', 'tdm_nonce_field');

        $delete_domain = sanitize_text_field($_POST['delete_domain']);

        if (!empty($delete_domain)) {
            $wpdb->delete($table_name, ['domain' => $delete_domain]);
            wp_redirect(add_query_arg('tdm_message', 'Domain deleted successfully!', $_SERVER['REQUEST_URI']));
            exit;
        }
    }

    // Fetch Domains
    $domains = get_trusted_domains_paginated($offset, $limit, $search);
    $total_domains = get_total_trusted_domains($search);
    $total_pages = ceil($total_domains / $limit);
    ?>
    <div class="wrap">
        <h1>Manage Trusted Domains</h1>
        
        <div style="display: flex; gap: 10px; align-items: center; flex-direction: row; justify-content: space-between;">
            <!-- Add Domain Form -->
            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                <?php wp_nonce_field('tdm_nonce_action', 'tdm_nonce_field'); ?>
                <input type="text" name="new_domain" placeholder="Enter domain (example.com)..." required>
                <input type="submit" value="Add Domain" class="button button-primary">
            </form>

            <!-- Search Form -->
            <form method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input type="hidden" name="page" value="trusted-domains">
                <input type="text" name="search" placeholder="Search domain..." value="<?php echo esc_attr($search); ?>">
                <input type="submit" value="Search" class="button">
            </form>
        </div>
        <hr>
        
        <!-- List Trusted Domains -->
        <h2>Existing Trusted Domains</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($domains)) : ?>
                    <?php foreach ($domains as $domain) : ?>
                        <tr>
                            <td><?php echo esc_html($domain->domain); ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this domain?');">
                                    <?php wp_nonce_field('tdm_nonce_action', 'tdm_nonce_field'); ?>
                                    <input type="hidden" name="delete_domain" value="<?php echo esc_attr($domain->domain); ?>">
                                    <input type="submit" value="Delete" class="button button-danger">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="2">No trusted domains found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if ($total_pages > 1) : ?>
            <div class="pagination" style="margin-top:20px;">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a class="button <?php echo ($i == $page) ? 'button-primary' : ''; ?>" href="<?php echo esc_url(add_query_arg(['paged' => $i, 'search' => $search])); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
