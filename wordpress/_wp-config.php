<?php
define('DB_NAME', 'DBNAME');
define('DB_USER', 'DBUSER');
define('DB_PASSWORD', 'DBPASS');

define('DB_HOST', 'localhost');

define('DISABLE_WP_CRON', true);
define('FS_METHOD', 'direct');

define('CACHE_READ_WHITELIST','_transient|posts WHERE ID IN|limit_login_'); // do not read from cache is sql contains these
define('CACHE_WRITE_WHITELIST','_transient|limit_login_'); // do not reset cache if sql contains these

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'bunnr_';

define('WPLANG', 'ru_RU');
define('DISALLOW_FILE_EDIT', true);
define('WP_DEBUG', false);

define('AUTH_KEY',         'B]9_9_%uF{fdsasgC)pMx/?-+_bVjX;Xrib=1y23rgghdh3a+dadAEIZ1O/z^2Gv`<GLr<7hKI');
define('SECURE_AUTH_KEY',  'Gasgb43@t+eWU&NhkNXw1daVO,adsa>mFU*kC^;8NAi0&;2RIz}a>:uO0[yU_0Cr<IPep&GG0U');
define('LOGGED_IN_KEY',    'PvbNzyB^Z?fl|Kad..Du#4/|Y{iV|ntR22zndahar534L!k)T%~vU[5Tv4Vf*4D<m GXp#wAK_');
define('NONCE_KEY',        'ubFTsbbd34Pf{Bi(ZU^QC!FM=.Qr*|id+i4#/Wvr[tasda~n+RYcs<5I8U+d:C%cb]|d]!|~R=');
define('AUTH_SALT',        '/b2p2we%Gc-NSSxg]R2|P3=+m_*das5mq]a`vc<BZFfg12zsghjhn|^scLAJzF!U@1Lpx1yJhD');
define('SECURE_AUTH_SALT', 'DGqahU{$#{1])WF?2d1{+v4mWhES6`o@))*asdaGcCa(t,+j~0+je]{`7fHc-=k!IC[U{1bjh-');
define('LOGGED_IN_SALT',   '@a*]7xfnT!asd$-,Cw{~{Y~j38>jv!,]v%tr6jVRrH2:A)asrty3sg&56yuYZ=j+k>u@6`M|A}');
define('NONCE_SALT',       '6jyK<[n:Wbnl)`;q2E:eVhp:[ez<+=|-xPadysegg5435g4n?WzGdEIfHqrFjeqV#zl|(oWv<4');

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');