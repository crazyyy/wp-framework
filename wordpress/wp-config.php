<?php
define( 'WP_CACHE', false );

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL


define('DB_NAME', 'DBNAME');
define('DB_USER', 'DBUSER');
define('DB_PASSWORD', 'DBPASS');

define('DB_HOST', 'localhost');

define('WP_MEMORY_LIMIT', '512M');

define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);

//if( WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX) ){
//  @ ini_set( 'display_errors', 1 );
//}

define('WPCF7_AUTOP', false);

define('CACHE_READ_WHITELIST','_transient|posts WHERE ID IN|limit_login_'); // do not read from cache is sql contains these
define('CACHE_WRITE_WHITELIST','_transient|limit_login_'); // do not reset cache if sql contains these

define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

$table_prefix  = 'nammk_';

define('DISALLOW_FILE_EDIT', true);
define('FS_METHOD', 'direct');

define('AUTH_KEY',         'B]9_9_%uF{fdsasgC)pMx/?-+_bVjX;Xrib=1y23rgghdh3a+dadAEIZ1O/z^2Gv`<GLr<7hKI');
define('SECURE_AUTH_KEY',  'Gasgb43@t+eWU&NhkNXw1daVO,adsa>mFU*kC^;8NAi0&;2RIz}a>:uO0[yU_0Cr<IPep&GG0U');
define('LOGGED_IN_KEY',    'PvbNzyB^Z?fl|Kad..Du#4/|Y{iV|ntR22zndahar534L!k)T%~vU[5Tv4Vf*4D<m GXp#wAK_');
define('NONCE_KEY',        'ubFTsbbd34Pf{Bi(ZU^QC!FM=.Qr*|id+i4#/Wvr[tasda~n+RYcs<5I8U+d:C%cb]|d]!|~R=');
define('AUTH_SALT',        '/b2p2we%Gc-NSSxg]R2|P3=+m_*das5mq]a`vc<BZFfg12zsghjhn|^scLAJzF!U@1Lpx1yJhD');
define('SECURE_AUTH_SALT', 'DGqahU{$#{1])WF?2d1{+v4mWhES6`o@))*asdaGcCa(t,+j~0+je]{`7fHc-=k!IC[U{1bjh-');
define('LOGGED_IN_SALT',   '@a*]7xfnT!asd$-,Cw{~{Y~j38>jv!,]v%tr6jVRrH2:A)asrty3sg&56yuYZ=j+k>u@6`M|A}');
define('NONCE_SALT',       '6jyK<[n:Wbnl)`;q2E:eVhp:[ez<+=|-xPadysegg5435g4n?WzGdEIfHqrFjeqV#zl|(oWv<4');

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');
