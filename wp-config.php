<?php
/** @noinspection PhpUnused */
/** @noinspection PhpDefineCanBeReplacedWithConstInspection */
define('WP_MEMORY_LIMIT', '1024M');

// do not read from cache is sql contains these
const CACHE_READ_WHITELIST  = '_transient|posts WHERE ID IN|limit_login_';
// do not reset cache if sql contains these
const CACHE_WRITE_WHITELIST = '_transient|limit_login_';

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

// https://developer.wordpress.org/apis/wp-config-php/#wp-siteurl
// WP_SITEURL - the address where your WordPress core files reside.
// Dynamically set WP_SITEURL. Example: api.example.com
//define( 'WP_SITEURL', 'https://api.' . $_SERVER['HTTP_HOST'] . '' );
// WP_HOME - address which visitors sets in browser to reach your site
// Dynamically set WP_HOME. Example: example.com
//define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] );

define('DB_NAME', 'wpframework');
define('DB_USER', 'wpframework');
define('DB_PASSWORD', 'wpframework');
define('DB_HOST', 'localhost');

$table_prefix = 'hadpj_';

// Converting Database Character Sets
// https://codex.wordpress.org/Converting_Database_Character_Sets
// If DB_CHARSET and DB_COLLATE do not exist in your wp-config.php file
// DO NOT add either definition to your wp-config.php file unless you
// read and understand Converting Database Character Sets.
/** Database Charset to use in creating database tables. */
//define('DB_CHARSET', 'utf8'); // Default
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
//define('DB_COLLATE', ''); // Default
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// https://developer.wordpress.org/apis/wp-config-php/#custom-user-and-usermeta-tables
//define( 'CUSTOM_USER_TABLE', $table_prefix . 'my_users' );
//define( 'CUSTOM_USER_META_TABLE', $table_prefix . 'my_usermeta' );

// Disable all core updates. Choose 'minor' to enable minor updates only. Set to true to enable all updates.
//define('WP_AUTO_UPDATE_CORE', false);
// Disable updates for core, plugins, and themes.
//define('AUTOMATIC_UPDATER_DISABLED', true);
// Set the autosave interval to 160 seconds.
define('AUTOSAVE_INTERVAL', 160);
// Limit the number of post revisions to 3. | true, false, 10
define('WP_POST_REVISIONS', 3);
// Force SSL for admin area and logins.
define('FORCE_SSL_ADMIN', true);
define('FORCE_SSL_LOGIN', true);
// Set the number of days to keep items in the trash to 60.
define('EMPTY_TRASH_DAYS', 60);
// There is automatic database repair support, which you can enable
// by adding the following define to your wp-config.php file.
// https://developer.wordpress.org/apis/wp-config-php/#automatic-database-optimizing
// Enable the automatic database repair feature.
//define('WP_ALLOW_REPAIR', true);
// Cleanup image edits by overwriting the original image.
define('IMAGE_EDIT_OVERWRITE', true);
// Disable WordPress multisite feature.
define('WP_ALLOW_MULTISITE', false);
// Disable file editing from the WordPress admin area.
define('DISALLOW_FILE_EDIT', true);
// Path to the Git executable for the Revisr plugin.
define('REVISR_GIT_PATH', '');
// Set the file system method to direct.
define('FS_METHOD', 'direct');
// Disable automatic paragraph formatting for Contact Form 7.
define('WPCF7_AUTOP', false);
// Disable the default WordPress cron system.
//define('DISABLE_WP_CRON', true);
// Use an alternate cron system.
//define('ALTERNATE_WP_CRON', true);
//define('WP_TEMP_DIR', 'WP_TEMP_DIR');

// https://www.php.net/manual/en/reserved.variables.environment.php
// https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type
define('WP_ENVIRONMENT_TYPE', 'local'); // local, development, staging, production
// https://make.wordpress.org/core/2023/07/14/configuring-development-mode-in-6-3/
define('WP_DEVELOPMENT_MODE', 'theme');

define('WP_DEBUG', true);

define('WP_DEBUG_LOG', true);
@error_reporting(E_ALL);
@ini_set('log_errors', true);
@ini_set('log_errors_max_len', '0');

if (WP_DEBUG) {
  @ini_set('display_errors', 'On');

  // https://developer.wordpress.org/apis/wp-config-php/#wp-disable-fatal-error-handler
  define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
  define('WP_DEBUG_DISPLAY', true);

  // https://developer.wordpress.org/apis/wp-config-php/#script-debug
  define('SCRIPT_DEBUG', false);
  define('CONCATENATE_SCRIPTS', false);
  // https://developer.wordpress.org/apis/wp-config-php/#save-queries-for-analysis
  define('SAVEQUERIES', true);

  /** Query Monitor **/
  //define('QM_DISABLED', true); // Disable Query Monitor entirely. Default value: false
  //define('QM_DISABLE_ERROR_HANDLER', true); // Disable the handling of PHP errors. Default value: false
  define('QM_ENABLE_CAPS_PANEL', true); // Enable the Capability Checks panel. Default value: false
  define('QM_HIDE_SELF', true); // Hide Query Monitor itself from various panels. Default value: false
  define('QM_HIDE_CORE_ACTIONS', true);  // Hide WordPress core on the Hooks & Actions panel. Default value: false
  define('QM_SHOW_ALL_HOOKS', true);  // In the Hooks & Actions panel, show every hook that has an action or filter attached (instead of every action hook that fired during the request). Default value: false
} else {
  ini_set('display_errors', 'Off');

  // https://developer.wordpress.org/apis/wp-config-php/#wp-disable-fatal-error-handler
  define('WP_DISABLE_FATAL_ERROR_HANDLER', false);
  define('WP_DEBUG_DISPLAY', false);

  /** Query Monitor **/
  //define('QM_DISABLED', true); // Disable Query Monitor entirely. Default value: false
}

define('SMTP_USERNAME', 'mail@gmail.com'); // Username of host like Gmail
define('SMTP_PASSWORD', 'password'); // Password for login into the App
define('SMTP_SERVER', 'smtp.gmail.com'); // SMTP server address
define('SMTP_FROM', 'mail@gmail.com'); // Your Business Email Address
define('SMTP_NAME', 'Site From'); // Business From Name
define('SMTP_PORT', '587'); // Server Port Number
define('SMTP_SECURE', 'tls'); // Encryption - ssl or tls
define('SMTP_AUTH', true); // Use SMTP authentication (true|false)
define('SMTP_DEBUG', 1); // For debugging purposes only

define('AUTH_KEY', 'PK2?Bu1fPWFWDJt,RtT0xqPi oSR@jMr$.1ERFgZe|sCTi:;?-TIG n;v^Uhl/rM');
define('SECURE_AUTH_KEY', 'eAf2wy6Q9O2d0A1EP14~D~mk:AuUyXUhGu~7ds{LI[CzFY9)|%LgFha|lkgRlk)r');
define('LOGGED_IN_KEY', '>teXm>^t0YX$ @ ku<16q#?5;fc]z1pbR#rH?C#df?NGMK+U>{7Uhmo4,ZVCnBHK');
define('NONCE_KEY', '61m=t}qTGaa>O2-)dn,@3[7mMnhLFM|(3/uNf^<-fnyFS]$EoeA|J)@Ri%WK{[`?');
define('AUTH_SALT', 'Mxj 1j5-_3Cnvq`_[l3rENZEH>q8F0b=@%YeevQZ,cjsd~vDn<V(~K,MN/.seY,2');
define('SECURE_AUTH_SALT', 'j9(Wsv3h}K-uAN}%6SxaxK_99,Xy-ZGyM|pQA@PlXh<iP*6u_Yj(|G(REF}YpAnv');
define('LOGGED_IN_SALT', 'j==zh=I^IC%QG&PKj1I1l4]N~1$XW<>Yv#|UgO[ZAfsdRY{fw|qhA0Oy ^`A^_w7');
define('NONCE_SALT', '*-p4LlLI>2=Zi0Ni?!EU@Ua.btP[W 1t9-P_&P-7^3A)E@9+n*A1[[=ISwa}}+/0');

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
  define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
