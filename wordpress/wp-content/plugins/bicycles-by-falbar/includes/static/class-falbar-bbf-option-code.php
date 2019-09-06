<?php
defined('BBF') or die();

class Falbar_BBF_Option_Code{

	public static function remove_recentcomments(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_recentcomments'
			)
		);

		return false;
	}

	public static function disable_emoji(){

		add_action(
			'init',
			array(
				__CLASS__,
				'init_disable_emojis'
			)
		);

		return false;
	}

	public static function disable_embed(){

		remove_action('wp_head', 'wp_oembed_add_host_js');

		return false;
	}

	public static function remove_dns_prefetch(){

		remove_action('wp_head', 'wp_resource_hints', 2);

		return false;
	}

	public static function remove_shortlink_link(){

		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		remove_action('template_redirect', 'wp_shortlink_header', 11, 0);

		return false;
	}

	public static function remove_canonical_link(){

		remove_action('wp_head', 'rel_canonical');

		return false;
	}

	public static function remove_next_prev_link(){

		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

		return false;
	}

	public static function remove_wlw_link(){

		remove_action('wp_head', 'wlwmanifest_link');

		return false;
	}

	public static function remove_rsd_link(){

		remove_action('wp_head', 'rsd_link');

		return false;
	}

	public static function disable_rest_api(){

		add_action(
			'init',
			array(
				__CLASS__,
				'init_disable_rest_api'
			)
		);

		return false;
	}

	public static function remove_jquery_migrate(){

		add_filter(
			'wp_default_scripts',
			array(
				__CLASS__,
				'wp_default_scripts_remove_jquery_migrate'
			)
		);

		return false;
	}

	public static function remove_html_comments(){

		if(!is_admin()){

			add_action(
				'init',
				array(
					__CLASS__,
					'init_remove_html_comments'
				)
			);
		}

		return false;
	}

	public static function html_minify(){

		if(!is_admin()){

			add_action(
				'init',
				array(
					__CLASS__,
					'init_html_minify'
				)
			);
		}

		return false;
	}

	public function widgets_init_remove_recentcomments(){

		global $wp_widget_factory;

		remove_action(
			'wp_head',
			array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style'
			)
		);

		return false;
	}

	public function init_disable_emojis(){

		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

		add_filter(
			'tiny_mce_plugins',
			array(
				__CLASS__,
				'tiny_mce_plugins_init_disable_emojis'
			)
		);

		return false;
	}

	public function tiny_mce_plugins_init_disable_emojis($plugins){

		if(is_array($plugins)){

			return array_diff($plugins, array('wpemoji'));
		}

		return array();
	}

	public function init_disable_rest_api(){

		add_filter('rest_enabled', '__return_false');

		remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
		remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
		remove_action('template_redirect', 'rest_output_link_header', 11, 0);
		remove_action('auth_cookie_malformed', 'rest_cookie_collect_status');
		remove_action('auth_cookie_expired', 'rest_cookie_collect_status');
		remove_action('auth_cookie_bad_username', 'rest_cookie_collect_status');
		remove_action('auth_cookie_bad_hash', 'rest_cookie_collect_status');
		remove_action('auth_cookie_valid', 'rest_cookie_collect_status');
		remove_filter('rest_authentication_errors', 'rest_cookie_check_errors', 100);

		remove_action('init', 'rest_api_init');
		remove_action('rest_api_init', 'rest_api_default_filters', 10, 1);
		remove_action('parse_request', 'rest_api_loaded');

		remove_action('rest_api_init', 'wp_oembed_register_route');
		remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);

		remove_action('wp_head', 'wp_oembed_add_discovery_links');

		add_action(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_init_disable_rest_api'
			)
		);

		return false;
	}

	public function template_redirect_init_disable_rest_api(){

		if(preg_match('#^/wp-json/(oembed|)#i', $_SERVER['REQUEST_URI']) ||
		   preg_match('#^/wp-json$#i', $_SERVER['REQUEST_URI'])){

			wp_redirect(
				get_home_url(),
				301
			);

			exit();
		}

		return false;
	}

	public function wp_default_scripts_remove_jquery_migrate($scripts){

		if(!is_admin()){

			$scripts->remove('jquery');

			$scripts->add(
				'jquery',
				false,
				array(
					'jquery-core'
				)
			);
		}

		return false;
	}

	public function init_remove_html_comments(){

		ob_start(
			array(
				__CLASS__,
				'init_remove_html_comments_start'
			)
		);

		return false;
	}

	public static function init_remove_html_comments_start($data){

		return preg_replace('#<!--(?!<!)[^\[>].*?-->#s', '', $data);
	}

	public function init_html_minify(){

		ob_start(
			array(
				__CLASS__,
				'init_html_minify_start'
			)
		);

		return false;
	}

	public static function init_html_minify_start($data){

		preg_match_all('/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si', $data, $matches, PREG_SET_ORDER);

		$data 		= '';
		$overriding = false;
		$raw_tag 	= false;

		$compress_css 	 = false;
		$remove_comments = false;
		$compress_js 	 = false;

		foreach($matches as $token){

			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;

			$content = $token[0];

			if(is_null($tag)){

				if(!empty($token['script'])){

					$strip = $compress_js;
				}else if(!empty($token['style'])){

					$strip = $compress_css;
				}else if($content == '<!--wp-html-compression no compression-->'){

					$overriding = !$overriding;

					continue;
				}else if($remove_comments){

					if(!$overriding && $raw_tag != 'textarea'){

						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			}else{

				if($tag == 'pre' || $tag == 'textarea'){

					$raw_tag = $tag;
				}else if($tag == '/pre' || $tag == '/textarea'){

					$raw_tag = false;
				}else{

					if($raw_tag || $overriding){

						$strip = false;
					}else{

						$strip = true;

						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc|\bvalue|\bitemscope)="")/', '$1', $content);

						$content = str_replace(' />', '/>', $content);
					}
				}
			}

			if($strip){

				$content = str_replace("\t", ' ', $content);
				$content = str_replace("\n",  '', $content);
				$content = str_replace("\r",  '', $content);

				while(stristr($content, '  ')){

					$content = str_replace('  ', ' ', $content);
				}
			}

			$data .= $content;
		}

		return $data;
	}
}