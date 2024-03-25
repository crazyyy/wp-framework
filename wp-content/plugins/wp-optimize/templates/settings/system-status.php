<?php if (!defined('WPO_VERSION')) die('No direct access allowed');

$sqlversion = (string) $wp_optimize->get_db_info()->get_version();
?>

<p class="wpo-system-status"><em>WP-Optimize <?php echo esc_html(WPO_VERSION); ?> - <?php esc_html_e('running on:', 'wp-optimize'); ?> PHP <?php echo esc_html(PHP_VERSION); ?>, MySQL <?php echo esc_html($sqlversion); ?> - <?php echo esc_html(PHP_OS); ?></em></p>
