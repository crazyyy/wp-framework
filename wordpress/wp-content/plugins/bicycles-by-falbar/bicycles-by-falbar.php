<?php
/*
Plugin Name: Bicycles by falbar
Plugin URI: https://wordpress.org/plugins/bicycles-by-falbar/
Description: Collection of ready-made solutions for WordPress customization.
Version: 2.1
Author: Anton Kuleshov
Author URI: http://falbar.ru/
*/

if(!defined('ABSPATH')){

	die();
}

define('BBF', true);

$pathinfo_file = pathinfo(__FILE__);

define('BBF_BASE', dirname(__FILE__));
define('BBF_DS', DIRECTORY_SEPARATOR);

define('BBF_DIR_INC', BBF_BASE.BBF_DS.'includes'.BBF_DS);
define('BBF_DIR_INC_STAT', BBF_DIR_INC.'static'.BBF_DS);
define('BBF_DIR_LIBS', BBF_BASE.BBF_DS.'libs'.BBF_DS);

define('BBF_PLUGIN_DOMAIN', $pathinfo_file['filename']);

require_once(BBF_DIR_INC.'class-falbar-bbf-core.php');
require_once(BBF_DIR_INC.'class-falbar-bbf.php');

require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-code.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-doubles.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-seo.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-widgets.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-comments.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-security.php');
require_once(BBF_DIR_INC_STAT.'class-falbar-bbf-option-additionally.php');

require_once(BBF_DIR_LIBS.'class-sanitize-title.php');

$bbf = new Falbar_BBF(array(
	'main_file_name' => $pathinfo_file['basename'],
	'prefix_db' 	 => '_falbar_bbf'
));
$bbf->run();