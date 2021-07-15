<?php
defined('BBF') or die();

class Falbar_BBF_Option_Security{

	public static function remove_meta_generator(){

		remove_action('wp_head', 'wp_generator');
		add_filter('the_generator', '__return_empty_string');

		return false;
	}

	public static function remove_readme_license(){

		$license_path = dirname(dirname(dirname(BBF_BASE))).BBF_DS.'license.txt';
		$readme_path  = dirname(dirname(dirname(BBF_BASE))).BBF_DS.'readme.html';

		if(file_exists($license_path)){

			unlink($license_path);
		}

		if(file_exists($readme_path)){

			unlink($readme_path);
		}

		return false;
	}

	public static function hide_login_errors(){

		add_filter(
			'login_errors',
			array(
				__CLASS__,
				'login_errors_hide_login_errors'
			)
		);

		return false;
	}

	public static function disable_xmlrpc(){

		add_filter(
			'xmlrpc_enabled',
			'__return_false'
		);

		add_filter(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_disable_xmlrpc'
			)
		);

		add_filter(
			'wp_headers',
			array(
				__CLASS__,
				'wp_headers_disable_xmlrpc'
			)
		);

		return false;
	}

	public static function remove_admin_page(){

		add_action(
			'wp',
			array(
				__CLASS__,
				'wp_remove_admin_page'
			)
		);

		return false;
	}

	public static function remove_versions_styles(){

		add_filter(
			'style_loader_src',
			array(
				__CLASS__,
				'style_loader_src_remove_versions_styles'
			),
			9999,
			2
		);

		return false;
	}

	public static function remove_versions_scripts(){

		add_filter(
			'script_loader_src',
			array(
				__CLASS__,
				'script_loader_src_remove_versions_scripts'
			),
			9999,
			2
		);

		return false;
	}

	public function login_errors_hide_login_errors(){

		return __('<strong>ERROR</strong>: Invalid username or password.', BBF_PLUGIN_DOMAIN);
	}

	public function template_redirect_disable_xmlrpc($headers){

		if(function_exists('header_remove')){

			header_remove('X-Pingback');
			header_remove('Server');
		}

		return false;
	}

	public function wp_headers_disable_xmlrpc($headers){

		unset($headers['X-Pingback']);

		return $headers;
	}

	public function wp_remove_admin_page(){

		if(isset($_GET['author']) && !is_admin()){

			wp_redirect(
				home_url(),
				301
			);

			exit();
		}

		return false;
	}

	public function style_loader_src_remove_versions_styles($src, $handle){

		if(is_admin()){

			return $src;
		}

		if(strpos($src, 'ver=')){

			$src = remove_query_arg('ver', $src);
		}

		return $src;
	}

	public function script_loader_src_remove_versions_scripts($src, $handle){

		if(is_admin()){

			return $src;
		}

		if(strpos($src, 'ver=')){

			$src = remove_query_arg('ver', $src);
		}

		return $src;
	}
}