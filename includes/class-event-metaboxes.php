<?php
// Add meta boxes for Event post type
function event_add_meta_boxes() {
    add_meta_box('event_meta', 'Event Details', 'event_meta_callback', 'event', 'side');
}
add_action('add_meta_boxes', 'event_add_meta_boxes');

// Meta box callback function
function event_meta_callback($post) {
    wp_nonce_field('save_event_meta', 'event_meta_nonce');
    
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    
    echo '<p><label for="event_date">Event Date</label></p>';
    echo '<input type="date" id="event_date" name="event_date" value="' . esc_attr($event_date) . '" />';
    
    echo '<p><label for="event_location">Event Location</label></p>';
    echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr($event_location) . '" />';
}

// Save meta box data
function save_event_meta($post_id) {
    if (!isset($_POST['event_meta_nonce']) || !wp_verify_nonce($_POST['event_meta_nonce'], 'save_event_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }

    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'save_event_meta');
