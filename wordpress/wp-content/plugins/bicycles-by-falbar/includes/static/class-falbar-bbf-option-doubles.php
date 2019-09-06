<?php
defined('BBF') or die();

class Falbar_BBF_Option_Doubles{

	public static function remove_attachment_pages(){

		add_action(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_remove_attachment_pages'
			),
			1
		);

		return false;
	}

	public static function remove_archives_date(){

		add_action(
			'wp',
			array(
				__CLASS__,
				'wp_remove_archives_date'
			)
		);

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_archives_date'
			)
		);

		return false;
	}

	public static function remove_archives_tag(){

		add_action(
			'wp',
			array(
				__CLASS__,
				'wp_remove_archives_tag'
			)
		);

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_archives_tag'
			)
		);

		return false;
	}

	public static function remove_post_pagination(){

		add_action(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_remove_post_pagination'
			)
		);

		return false;
	}

	public static function remove_archives_author(){

		add_action(
			'wp',
			array(
				__CLASS__,
				'wp_remove_archives_author'
			)
		);

		return false;
	}

	public static function remove_replytocom(){

		add_action(
			'template_redirect',
			array(
				__CLASS__,
				'template_redirect_remove_replytocom'
			),
			1
		);

		add_filter(
			'comment_reply_link',
			array(
				__CLASS__,
				'comment_reply_link_remove_replytocom'
			)
		);

		return false;
	}

	public function template_redirect_remove_attachment_pages(){

		global $post;

		$post_parent = $post->post_parent;

		if(!isset($post_parent) || !is_numeric($post_parent)){

			return false;
		}

		if(is_attachment() && $post_parent != 0){

			$page_url = get_permalink($post_parent);
			$status	  = 301;
		}else if(is_attachment() && $post_parent < 1){

			$page_url = get_home_url();
			$status   = 302;
		}else{

			return false;
		}

		wp_safe_redirect(
			esc_url_raw(
				apply_filters(
					'sitecare_redirect_unattached_images',
					$page_url
				)
			),
			$status
		);

		exit();
	}

	public function wp_remove_archives_date(){

		if(is_date() && !is_admin()){

			wp_redirect(
				get_home_url(),
				301
			);

			exit();
		}

		return false;
	}

	public function widgets_init_remove_archives_date(){

		unregister_widget('WP_Widget_Archives');

		return false;
	}

	public function wp_remove_archives_tag(){

		if(is_tag()){

			wp_redirect(
				get_home_url(),
				301
			);

			exit();
		}

		return false;
	}

	public function widgets_init_remove_archives_tag(){

		unregister_widget('WP_Widget_Tag_Cloud');

		return false;
	}

	public function template_redirect_remove_post_pagination(){

		if(is_singular() && !is_front_page()){

			global $post, $page;

			$num_pages = substr_count($post->post_content, '<!--nextpage-->') + 1;

			if($page > $num_pages || $page == 1){

				wp_redirect(
					get_permalink($post->ID)
				);

				exit();
			}
		}

		return false;
	}

	public function wp_remove_archives_author(){

		if(is_author()){

			wp_redirect(
				get_home_url(),
				301
			);

			exit();
		}

		return false;
	}

	public function template_redirect_remove_replytocom(){

		if(isset($_GET['replytocom']) && is_singular()){

			$post_url 	  = get_permalink($GLOBALS['post']->ID);
			$comment_id   = sanitize_text_field($_GET['replytocom']);
			$query_string = remove_query_arg(
				'replytocom',
				sanitize_text_field(
					$_SERVER['QUERY_STRING']
				)
			);

			if(!empty($query_string)){

				$post_url .= '?'.$query_string;
			}

			$post_url .= '#comment-'.$comment_id;

			wp_redirect($post_url, 301);

			exit();
		}

		return false;
	}

	public function comment_reply_link_remove_replytocom($link){

		return preg_replace(
			'`href=(["\'])(?:.*(?:\?|&|&#038;)replytocom=(\d+)#respond)`',
			'href=$1#comment-$2',
			$link
		);
	}
}