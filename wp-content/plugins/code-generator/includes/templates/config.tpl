<?php echo <<<'HEREDOC'
<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
 
HEREDOC;
?>

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME',     '{{database_name}}' );
/** MySQL database username */
define( 'DB_USER',     '{{database_username}}' );
/** MySQL database password */
define( 'DB_PASSWORD', '{{database_password}}' );
<?php if ( ! empty ( $wpg_database_hostname ) ) { ?>
/** MySQL hostname */
define( 'DB_HOST',     '{{database_hostname}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_database_charset ) ) { ?>
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET',  '{{database_charset}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_database_collate ) ) { ?>
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE',  '{{database_collate}}' );
<?php } ?>


/* MySQL database table prefix. */
$table_prefix = '{{table_prefix}}';
<?php if ( ! empty ( $wpg_custom_user_table ) ) { ?>
define( 'CUSTOM_USER_TABLE',      $table_prefix . '{{custom_user_table}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_custom_user_meta_table ) ) { ?>
define( 'CUSTOM_USER_META_TABLE', $table_prefix . '{{custom_user_meta_table}}' );
<?php } ?>


<?php if ( ! empty ( $wpg_security ) && 'true' === $wpg_security ) { ?>
<?php echo file_get_contents( 'https://api.wordpress.org/secret-key/1.1/salt/' ); ?>
<?php } else { ?>
/* Authentication Unique Keys and Salts. */
/* https://api.wordpress.org/secret-key/1.1/salt/ */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );
<?php } ?>
<?php if ( ! empty ( $wpg_ssl_login ) || ! empty ( $wpg_ssl_admin ) ) { ?>


/* SSL */
<?php } ?>
<?php if ( ! empty ( $wpg_ssl_login ) ) { ?>
define( 'FORCE_SSL_LOGIN', {{ssl_login}} );
<?php } ?>
<?php if ( ! empty ( $wpg_ssl_admin ) ) { ?>
define( 'FORCE_SSL_ADMIN', {{ssl_admin}} );
<?php } ?>
<?php if ( ! empty ( $wpg_site_url ) || ! empty ( $wpg_home_url ) || ! empty ( $wpg_content_url ) ||
		! empty ( $wpg_uploads_url ) || ! empty ( $wpg_plugins_url ) || ! empty ( $wpg_cookie_domain ) ) { ?>

/* Custom WordPress URL. */
<?php } ?>
<?php if ( ! empty ( $wpg_site_url ) ) { ?>
define( 'WP_SITEURL',     '{{site_url}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_home_url ) ) { ?>
define( 'WP_HOME',        '{{home_url}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_content_url ) ) { ?>
define( 'WP_CONTENT_URL', '{{content_url}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_uploads_url ) ) { ?>
define( 'UPLOADS',        '{{uploads_url}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_plugins_url ) ) { ?>
define( 'WP_PLUGIN_URL',  '{{plugins_url}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_cookie_domain ) ) { ?>
define( 'COOKIE_DOMAIN',  '{{cookie_domain}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_autosave ) || ! empty ( $wpg_revisions ) && 'false' === $wpg_revisions || ! empty ( $wpg_revisions_num ) || ! empty ( $wpg_media_trash ) || ! empty ( $wpg_trash ) ) { ?>


<?php } ?>
<?php if ( ! empty ( $wpg_autosave ) ) { ?>
/* AutoSave Interval. */
define( 'AUTOSAVE_INTERVAL', '{{autosave}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_revisions ) && 'false' === $wpg_revisions ) { ?>
/* Disable Post Revisions. */
define( 'WP_POST_REVISIONS', {{revisions}} );
<?php } ?>
<?php if ( ! empty ( $wpg_revisions_num ) ) { ?>
/* Specify maximum number of Revisions. */
define( 'WP_POST_REVISIONS', '{{revisions_num}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_media_trash ) ) { ?>
/* Media Trash. */
define( 'MEDIA_TRASH', {{media_trash}} );
<?php } ?>
<?php if ( ! empty ( $wpg_trash ) ) { ?>
/* Trash Days. */
define( 'EMPTY_TRASH_DAYS', '{{trash}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_multisite ) ) { ?>


/* Multisite. */
define( 'WP_ALLOW_MULTISITE', {{multisite}} );
<?php } ?>
<?php if ( ! empty ( $wpg_debug ) || ! empty ( $wpg_debug_log ) || ! empty ( $wpg_debug_display ) || ! empty ( $wpg_script_debug ) || ! empty ( $wpg_save_queries ) ) { ?>


/* WordPress debug mode for developers. */
<?php } ?>
<?php if ( ! empty ( $wpg_debug ) ) { ?>
define( 'WP_DEBUG',         {{debug}} );
<?php } ?>
<?php if ( ! empty ( $wpg_debug_log ) ) { ?>
define( 'WP_DEBUG_LOG',     {{debug_log}} );
<?php } ?>
<?php if ( ! empty ( $wpg_debug_display ) ) { ?>
define( 'WP_DEBUG_DISPLAY', {{debug_display}} );
<?php } ?>
<?php if ( ! empty ( $wpg_script_debug ) ) { ?>
define( 'SCRIPT_DEBUG',     {{script_debug}} );
<?php } ?>
<?php if ( ! empty ( $wpg_save_queries ) ) { ?>
define( 'SAVEQUERIES',      {{save_queries}} );
<?php } ?>
<?php if ( ! empty ( $wpg_memory_limit ) || ! empty ( $wpg_max_memory_limit ) ) { ?>

/* PHP Memory */
<?php } ?>
<?php if ( ! empty ( $wpg_memory_limit ) ) { ?>
define( 'WP_MEMORY_LIMIT', '{{memory_limit}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_max_memory_limit ) ) { ?>
define( 'WP_MAX_MEMORY_LIMIT', '{{max_memory_limit}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_cache ) ) { ?>


/* WordPress Cache */
define( 'WP_CACHE', {{cache}} );
<?php } ?>
<?php if ( ! empty ( $wpg_compress_css ) || ! empty ( $wpg_compress_scripts ) || ! empty ( $wpg_concatenate_scripts ) || ! empty ( $wpg_enforce_gzip ) ) { ?>


/* Compression */
<?php } ?>
<?php if ( ! empty ( $wpg_compress_css ) ) { ?>
define( 'COMPRESS_CSS',        {{compress_css}} );
<?php } ?>
<?php if ( ! empty ( $wpg_compress_scripts ) ) { ?>
define( 'COMPRESS_SCRIPTS',    {{compress_scripts}} );
<?php } ?>
<?php if ( ! empty ( $wpg_concatenate_scripts ) ) { ?>
define( 'CONCATENATE_SCRIPTS', {{concatenate_scripts}} );
<?php } ?>
<?php if ( ! empty ( $wpg_enforce_gzip ) ) { ?>
define( 'ENFORCE_GZIP',        {{enforce_gzip}} );
<?php } ?>
<?php if ( ! empty ( $wpg_ftp_user ) || ! empty ( $wpg_ftp_password ) || ! empty ( $wpg_ftp_host ) || ! empty ( $wpg_ftp_ssl ) ) { ?>

/* FTP */
<?php } ?>
<?php if ( ! empty ( $wpg_ftp_user ) ) { ?>
define( 'FTP_USER', '{{ftp_user}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_ftp_password ) ) { ?>
define( 'FTP_PASS', '{{ftp_password}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_ftp_host ) ) { ?>
define( 'FTP_HOST', '{{ftp_host}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_ftp_ssl ) ) { ?>
define( 'FTP_SSL', {{ftp_ssl}} );
<?php } ?>
<?php if ( ! empty ( $wpg_disable_wp_cron ) || ! empty ( $wpg_alternate_wp_cron ) || ! empty ( $wpg_wp_cron_lock_timeout ) ) { ?>


/* CRON */
<?php } ?>
<?php if ( ! empty ( $wpg_disable_wp_cron ) ) { ?>
define( 'DISABLE_WP_CRON',      {{disable_wp_cron}} );
<?php } ?>
<?php if ( ! empty ( $wpg_alternate_wp_cron ) ) { ?>
define( 'ALTERNATE_WP_CRON',    {{alternate_wp_cron}} );
<?php } ?>
<?php if ( ! empty ( $wpg_wp_cron_lock_timeout ) ) { ?>
define( 'WP_CRON_LOCK_TIMEOUT', {{wp_cron_lock_timeout}} );
<?php } ?>
<?php if ( ! empty ( $wpg_disallow_file_mods ) || ! empty ( $wpg_wp_auto_update_core ) || ! empty ( $wpg_disallow_file_edit ) ) { ?>


/* Updates */
<?php } ?>
<?php if ( ! empty ( $wpg_disallow_file_mods ) ) { ?>
define( 'DISALLOW_FILE_MODS', {{disallow_file_mods}} );
<?php } ?>
<?php if ( ! empty ( $wpg_wp_auto_update_core ) ) { ?>
define( 'WP_AUTO_UPDATE_CORE', {{wp_auto_update_core}} );
<?php } ?>
<?php if ( ! empty ( $wpg_disallow_file_edit ) ) { ?>
define( 'DISALLOW_FILE_EDIT', {{disallow_file_edit}} );
<?php } ?>


/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
