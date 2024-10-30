<?php
/*
Plugin Name: Clickable Featured Image
Plugin URI: https://wordpress.org/plugins/clickable-featured-image/
Description: A plugin that replaces the featured image in a post or page with one that is clickable if there is a featured image and links to the full size image.
Version: 1.0.2
Author: Devenia. Free Guide - The Importance Of Featured Images
Author URI: https://www.devenia.com/free/clickable-featured-image-wordpress-plugin/
*/

function cfi_clickable_featured_image($html, $post_id, $post_thumbnail_id) {
    $image_data = wp_get_attachment_image_src($post_thumbnail_id, 'full');

    // Check if $image_data is false, and if so, return the original $html.
    if ($image_data === false) {
        return $html;
    }

    $caption = get_the_title($post_thumbnail_id);
    
    if (is_singular()) {
        $html = '<a href="' . $image_data[0] . '" data-caption="' . esc_attr($caption) . '" class="wp-block-image">' . $html . '</a>';
    } else {
        $post_url = get_permalink($post_id);
        $html = '<a href="' . $post_url . '">' . $html . '</a>';
    }
    
    return $html;
}

add_filter('post_thumbnail_html', 'cfi_clickable_featured_image', 10, 3);

function cfi_enqueue_lightbox_assets() {
    if (is_singular() && has_post_thumbnail()) {
        add_filter('baguettebox_enqueue_assets', '__return_true');
    }
}
add_action('wp', 'cfi_enqueue_lightbox_assets');
