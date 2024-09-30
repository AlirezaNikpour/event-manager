<?php
/**
 * Plugin Name: Event Plugin
 * Description: A plugin to manage events with custom post types and taxonomies.
 * Version: 1.0
 * Author: Alireza Nikpour
 */


if (!defined('ABSPATH')) exit;


require_once(plugin_dir_path(__FILE__) . 'includes/class-event-post-type.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-event-metaboxes.php');


function event_plugin_activate() {
    event_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'event_plugin_activate');


function event_plugin_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'event_plugin_deactivate');
function event_plugin_enqueue_assets() {
    wp_enqueue_style(
        'event-plugin-styles', 
        plugin_dir_url(__FILE__) . 'css/event-plugin-styles.css', 
        array(), 
        '1.0', 
        'all'
    );
}
add_action('wp_enqueue_scripts', 'event_plugin_enqueue_assets');