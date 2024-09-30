<?php
// Register Event Custom Post Type and Taxonomy
function event_post_type() {
    // Register custom post type
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'menu_name' => 'Events',
        'name_admin_bar' => 'Event',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'No events found',
        'not_found_in_trash' => 'No events found in Trash',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'events'),
    );
    
    register_post_type('event', $args);
    
    // Register taxonomy
    $taxonomy_labels = array(
        'name' => 'Event Types',
        'singular_name' => 'Event Type',
        'search_items' => 'Search Event Types',
        'all_items' => 'All Event Types',
        'parent_item' => 'Parent Event Type',
        'parent_item_colon' => 'Parent Event Type:',
        'edit_item' => 'Edit Event Type',
        'update_item' => 'Update Event Type',
        'add_new_item' => 'Add New Event Type',
        'new_item_name' => 'New Event Type Name',
        'menu_name' => 'Event Types',
    );
    
    $taxonomy_args = array(
        'labels' => $taxonomy_labels,
        'public' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'event-type'),
    );
    
    register_taxonomy('event_type', array('event'), $taxonomy_args);
}

add_action('init', 'event_post_type');
// Add columns to the Events list table
function event_custom_columns($columns) {
    $columns['event_date'] = 'Event Date';
    $columns['event_location'] = 'Event Location';
    return $columns;
}
add_filter('manage_event_posts_columns', 'event_custom_columns');

// Display the event date and location in the custom columns
function event_custom_columns_data($column, $post_id) {
    switch ($column) {
        case 'event_date':
            echo esc_html(get_post_meta($post_id, '_event_date', true));
            break;
        case 'event_location':
            echo esc_html(get_post_meta($post_id, '_event_location', true));
            break;
    }
}
add_action('manage_event_posts_custom_column', 'event_custom_columns_data', 10, 2);


function event_list_shortcode() {
    $query = new WP_Query(array(
        'post_type' => 'event',
        'posts_per_page' => -1,
    ));
    
    $output = '<ul>';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    $output .= '</ul>';
    wp_reset_postdata();
    
    return $output;
}
add_shortcode('event_list', 'event_list_shortcode');
