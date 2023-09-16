<?php

define('WP_MEMORY_LIMIT', '1024M');
define( "WP_CACHE", true ); // WP Performance

const CACHE_READ_WHITELIST  = '_transient|posts WHERE ID IN|limit_login_'; // do not read from cache is sql contains these
const CACHE_WRITE_WHITELIST = '_transient|limit_login_'; // do not reset cache if sql contains these

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

// define('WP_HOME', 'WP_HOME');
// define('WP_SITEURL', 'WP_SITEURL');
// define('WP_TEMP_DIR', 'WP_TEMP_DIR');

define('DB_NAME', 'wpframework');
define('DB_USER', 'wpframework');
define('DB_PASSWORD', 'wpframework');
define('DB_HOST', 'localhost');

define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

$table_prefix = 'hadpj_';

define( 'DEVELOPMENT_DEBUG', true );
if (DEVELOPMENT_DEBUG) {
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', true);
  define('SAVEQUERIES', true);
  define('WP_ENVIRONMENT_TYPE', 'development');
  define('WP_ENV', 'development');
  if (WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX)) {
    @ini_set('display_errors', 1);
  }
  // Query Monitor
  define('QM_ENABLE_CAPS_PANEL', true);
  define('QM_HIDE_CORE_ACTIONS', true);
  define('QM_HIDE_SELF', true);
} else {
  @ini_set('display_errors', 0);

  define('WP_DEBUG', false);
  define('WP_DEBUG_LOG', false);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', false);
  define('SAVEQUERIES', false);
  define('WP_ENVIRONMENT_TYPE', 'production');
  define('WP_ENV', 'production');
}

// define( 'DISABLE_WP_CRON', true );
// define( 'ALTERNATE_WP_CRON', true );
define('WPCF7_AUTOP', false);
define('WP_ALLOW_REPAIR', true);
define('DISALLOW_FILE_EDIT', true);
// define( 'WP_ALLOW_MULTISITE', true );
define('FS_METHOD', 'direct');
define('REVISR_GIT_PATH', '');
define('WP_POST_REVISIONS', true);
define('AUTOSAVE_INTERVAL', 300);

define('FORCE_SSL_ADMIN', true);
define('FORCE_SSL_LOGIN', true);

// define('SMTP_username', 'mail@gmail.com');  // username of host like Gmail
// define('SMTP_password', 'password');   // password for login into the App
// define('SMTP_server', 'smtp.gmail.com');     // SMTP server address
// define('SMTP_FROM', 'mail@gmail.com');   // Your Business Email Address
// define('SMTP_NAME', 'SiteFrom');   //  Business From Name
// define('SMTP_PORT', '587');     // Server Port Number
// define('SMTP_SECURE', 'tls');   // Encryption - ssl or tls
// define('SMTP_AUTH', true);  // Use SMTP authentication (true|false)
// define('SMTP_DEBUG', 1);  // for debugging purposes only

define('AUTH_KEY',         'PK2?Bu1fPWFWDJt,RtT0xqPi oSR@jMr$.1ERFgZe|sCTi:;?-TIG n;v^Uhl/rM');
define('SECURE_AUTH_KEY',  'eAf2wy6Q9O2d0A1EP14~D~mk:AuUyXUhGu~7ds{LI[CzFY9)|%LgFha|lkgRlk)r');
define('LOGGED_IN_KEY',    '>teXm>^t0YX$ @ ku<16q#?5;fc]z1pbR#rH?C#df?NGMK+U>{7Uhmo4,ZVCnBHK');
define('NONCE_KEY',        '61m=t}qTGaa>O2-)dn,@3[7mMnhLFM|(3/uNf^<-fnyFS]$EoeA|J)@Ri%WK{[`?');
define('AUTH_SALT',        'Mxj 1j5-_3Cnvq`_[l3rENZEH>q8F0b=@%YeevQZ,cjsd~vDn<V(~K,MN/.seY,2');
define('SECURE_AUTH_SALT', 'j9(Wsv3h}K-uAN}%6SxaxK_99,Xy-ZGyM|pQA@PlXh<iP*6u_Yj(|G(REF}YpAnv');
define('LOGGED_IN_SALT',   'j==zh=I^IC%QG&PKj1I1l4]N~1$XW<>Yv#|UgO[ZAfsdRY{fw|qhA0Oy ^`A^_w7');
define('NONCE_SALT',       '*-p4LlLI>2=Zi0Ni?!EU@Ua.btP[W 1t9-P_&P-7^3A)E@9+n*A1[[=ISwa}}+/0');

if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

require_once(ABSPATH . 'wp-settings.php');
