<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function bodhi_svgs_cleanup_duplicate_meta() {
    global $wpdb;
    
    // Delete all but the latest inline_featured_image meta per post
    $wpdb->query("
        DELETE pm FROM {$wpdb->postmeta} pm
        JOIN (
            SELECT post_id, meta_id FROM (
                SELECT post_id, meta_id,
                        ROW_NUMBER() OVER (PARTITION BY post_id ORDER BY meta_id DESC) AS row_num
                FROM {$wpdb->postmeta}
                WHERE meta_key = 'inline_featured_image'
            ) as duplicates
            WHERE row_num > 1
        ) to_delete ON pm.meta_id = to_delete.meta_id
    ");

    // Delete all inline_featured_image meta entries that aren't explicitly set to 1
    $wpdb->query("
        DELETE FROM {$wpdb->postmeta} 
        WHERE meta_key = 'inline_featured_image' 
        AND (meta_value = '' OR meta_value = '0' OR meta_value IS NULL)
    ");
} 