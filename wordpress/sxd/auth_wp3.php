<?php
// Sypex Dumper 2 authorization file for WordPress 3.0.x-3.6.x
// Version 1.2
$path = '../wp-config.php'; 
$no_cookie = true;

$config = array();
foreach($_COOKIE AS $c => $v){
	if(strpos($c, 'wordpress_logged_in') !== false) {
		$config['COOKIE'] = explode('|', $v);
		break;
	}	
}
// Parsing config, to skip including wp-settings.php 
if(isset($config['COOKIE']) && count($config['COOKIE']) == 3){
	$file = file_get_contents($path);
	if(preg_match_all("/define\('(\w+)',\s*'(.*?)'\);/m", $file, $m, PREG_SET_ORDER) && preg_match("/^\\\$table_prefix\s*=\s*'(.+?)';/m", $file, $t)){
		$config['TAB_PREFIX'] = stripcslashes($t[1]);
		foreach($m AS $c){
			$config[$c[1]] = stripcslashes($c[2]);
		}
		//print_r($config);
		if($this->connect($config['DB_HOST'], '', $config['DB_USER'], $config['DB_PASSWORD'])){
			// Check user
			mysql_selectdb($config['DB_NAME']);
			mysql_query("SET NAMES {$config['DB_CHARSET']}");
			if($r = mysql_query("SELECT user_pass, meta_value AS user_level FROM {$config['TAB_PREFIX']}users u LEFT JOIN {$config['TAB_PREFIX']}usermeta m ON (u.id = m.user_id) WHERE u.user_login = '{$config['COOKIE'][0]}' AND m.meta_key = 'wp_user_level'")){
				$u = mysql_fetch_assoc($r);
				$pass_frag = substr($u['user_pass'], 8, 4);

				$key  = hash_hmac('md5', $config['COOKIE'][0] . $pass_frag . '|' . $config['COOKIE'][1],  $config['LOGGED_IN_KEY'] . $config['LOGGED_IN_SALT']);
				$hash = hash_hmac('md5', $config['COOKIE'][0] . '|' . $config['COOKIE'][1], $key);
				if($hash == $config['COOKIE'][2]){
					// User logged in, check admin permisions
					if($u['user_level'] > 7) $auth = 1;
					$this->CFG['my_db']   = $config['DB_NAME'];
					$this->CFG['exitURL'] = '../wp-admin/';
				}
			}
		}
	}
}
?>