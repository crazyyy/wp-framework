<?php
defined('BBF') or die();

class Falbar_BBF_Option_SEO{

	public static $robots_txt;

	public static function image_auto_alt(){

		add_filter(
			'the_content',
			array(
				__CLASS__,
				'the_content_image_auto_alt'
			)
		);

		return false;
	}

	public static function set_last_modified(){

		add_action(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_set_last_modified'),
			999
		);

		return false;
	}

	public static function robots_txt($code = ''){

		self::$robots_txt = $code;

		add_action(
			'init',
			array(
				__CLASS__,
				'init_robots_txt'
			)
		);

		add_filter(
			'robots_txt',
			array(
				__CLASS__,
				'robots_txt_robots_txt'
			)
		);

		return false;
	}

	public function the_content_image_auto_alt($content){

		global $post;

		$pattern = array(
			' alt=""',
			' alt=\'\''
		);

		$replacement = array(
			' alt="'.esc_attr($post->post_title).'"',
			' alt=\''.esc_attr($post->post_title).'\''
		);

		$content = str_replace(
			$pattern,
			$replacement,
			$content
		);

		return $content;
	}

	public function template_redirect_set_last_modified(){

		if((defined('DOING_AJAX') && DOING_AJAX) || (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST)
		  || (defined('REST_REQUEST') && REST_REQUEST) || (is_admin())){

			return false;
		}

		if(is_search()){

			return false;
		}

		$last_modified = '';

		if(is_singular()){

			global $post;

			if(!isset($post->post_modified_gmt)){

				return false;
			}

			$post_time 	   = strtotime($post->post_modified_gmt);
			$modified_time = $post_time;

			if((int) $post->comment_count > 0){

				$comments = get_comments(array(
					'post_id' => $post->ID,
					'number'  => '1',
					'status'  => 'approve',
					'orderby' => 'comment_date_gmt'
				));

				if(!empty($comments) && isset($comments[0])){

					$comment_time = strtotime($comments[0]->comment_date_gmt);

					if ($comment_time > $post_time){

						$modified_time = $comment_time;
					}
				}
			}

			$last_modified = str_replace('+0000', 'GMT', gmdate('r', $modified_time));
		}

		if(is_archive() || is_home()){

			global $posts;

			if(empty($posts)){

				return false;
			}

			$post = $posts[0];

			if(!isset($post->post_modified_gmt)){

				return false;
			}

			$post_time 	   = strtotime($post->post_modified_gmt);
			$modified_time = $post_time;

			$last_modified = str_replace('+0000', 'GMT', gmdate('r', $modified_time));
		}

		if(headers_sent()){

			return false;
		}

		if(!empty($last_modified)){

			header('Last-Modified: '.$last_modified);

			if(!is_user_logged_in()){

				if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $modified_time){

					$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

					header($protocol.' 304 Not Modified');
				}
			}
		}

		return false;
	}

	public function init_robots_txt(){

		$robots_txt_file = dirname(dirname(dirname(BBF_BASE))).BBF_DS.'robots.txt';

		if(file_exists($robots_txt_file)){

			unlink($robots_txt_file);
		}

		return false;
	}

	public function robots_txt_robots_txt($output){

		if(!self::$robots_txt){

			$site_url = get_home_url();
			$site_url_clear = str_replace('http://', '', $site_url);
			$site_url_clear = str_replace('https://', '', $site_url_clear);

			if(is_ssl()){

				$dir_host = 'https://' . $site_url_clear;
			}else{

				$dir_host = $site_url_clear;
			}

			$output  = 'User-agent: *'.PHP_EOL;
			$output .= 'Disallow: /wp-admin'.PHP_EOL;
			$output .= 'Disallow: /wp-includes'.PHP_EOL;
			$output .= 'Disallow: /wp-content/plugins'.PHP_EOL;
			$output .= 'Disallow: /wp-content/cache'.PHP_EOL;
			$output .= 'Disallow: /wp-json/'.PHP_EOL;
			$output .= 'Disallow: /xmlrpc.php'.PHP_EOL;
			$output .= 'Disallow: /readme.html'.PHP_EOL;
			$output .= 'Disallow: /*?'.PHP_EOL;
			$output .= 'Disallow: /?s='.PHP_EOL;
			$output .= 'Allow: /*.css'.PHP_EOL;
			$output .= 'Allow: /*.js'.PHP_EOL;
			$output .= 'Host: '.$dir_host.PHP_EOL;

			if(function_exists('get_headers')){

				$get_headers = get_headers($site_url.'/sitemap.xml', 1);

				if (preg_match('#200 OK#i', $get_headers[0])){

					$output .= 'Sitemap: '.$site_url.'/sitemap.xml'.PHP_EOL;

				}else if(isset($get_headers['Location']) && !empty($get_headers['Location'])){

					$output .= 'Sitemap: ' . $get_headers['Location'] . PHP_EOL;
				}
			}
		}else{

			$output = self::$robots_txt;
		}

		return $output;
	}
}