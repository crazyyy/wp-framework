<?php
defined('BBF') or die();

class Falbar_BBF_Option_Additionally{

	public static function enable_hidden_settings_page(){

		add_action(
			'admin_menu',
			array(
				__CLASS__,
				'admin_menu_enable_hidden_settings_page'
			)
		);

		return false;
	}

	public static function disable_rss_feeds(){

		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'feed_links', 2);

		add_action(
			'do_feed',
			array(
				__CLASS__,
				'disable_rss_feeds_redirect'
			),
			1
		);

		add_action(
			'do_feed_rdf',
			array(
				__CLASS__,
				'disable_rss_feeds_redirect'
			),
			1
		);

		add_action(
			'do_feed_rss',
			array(
				__CLASS__,
				'disable_rss_feeds_redirect'
			),
			1
		);

		add_action(
			'do_feed_rss2',
			array(
				__CLASS__,
				'disable_rss_feeds_redirect'
			),
			1
		);

		add_action(
			'do_feed_atom',
			array(
				__CLASS__,
				'disable_rss_feeds_redirect'
			),
			1
		);

		return false;
	}

	public static function remove_links_admin_bar(){

		add_action(
			'wp_before_admin_bar_render',
			array(
				__CLASS__,
				'wp_before_admin_bar_render_remove_links_admin_bar'
			)
		);

		return false;
	}

	public static function enable_uplode_filename_lowercase(){

		add_filter(
			'sanitize_file_name',
			array(
				__CLASS__,
				'sanitize_file_name_enable_uplode_filename_lowercase'
			),
			10
		);

		return false;
	}

	public static function redirect_from_http_to_https(){

		add_action(
			'init',
			array(
				__CLASS__,
				'init_redirect_from_http_to_https'
			)
		);

		return false;
	}

	public static function sanitize_title(){

		if(is_admin() || (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST)){

			$st = new Sanitize_Title();
			$st->init();
		}

		return false;
	}

	public static function revisions_disable(){

		add_filter(
			'wp_revisions_to_keep',
			array(
				__CLASS__,
				'wp_revisions_to_keep_revisions_disable'
			),
			10,
			2
		);

		return false;
	}

	public static function disable_post_autosave(){

		add_action(
			'wp_print_scripts',
			array(
				__CLASS__,
				'wp_print_scripts_disable_post_autosave'
			)
		);

		return false;
	}

	public function admin_menu_enable_hidden_settings_page(){

		add_options_page(
			__('All Settings', BBF_PLUGIN_DOMAIN),
			__('All Settings', BBF_PLUGIN_DOMAIN),
			'manage_options',
			'options.php'
		);

		return false;
	}

	public function disable_rss_feeds_redirect(){

		wp_redirect(
			get_home_url(),
			301
		);

		exit();
	}

	public function wp_before_admin_bar_render_remove_links_admin_bar(){

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
		$wp_admin_bar->remove_menu('view-site');

		return false;
	}

	public function sanitize_file_name_enable_uplode_filename_lowercase($filename){

		return mb_strtolower($filename, 'utf-8');
	}

	public function init_redirect_from_http_to_https(){

		if(is_ssl()){

			return false;
		}

		if(0 === strpos($_SERVER['REQUEST_URI'], 'http')){

			wp_redirect(set_url_scheme($_SERVER['REQUEST_URI'], 'https'), 301);
		}else{

			wp_redirect('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 301);
		}

		exit();
	}

	public function wp_revisions_to_keep_revisions_disable($num, $post){

		return 0;
	}

	public function wp_print_scripts_disable_post_autosave(){

		wp_deregister_script('autosave');

		return false;
	}
}