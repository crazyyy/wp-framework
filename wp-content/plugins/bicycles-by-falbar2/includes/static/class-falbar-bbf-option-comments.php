<?php
defined('BBF') or die();

class Falbar_BBF_Option_Comments{

	public static $style_comment_text;
	public static $style_comment_author;

	public static function remove_url_from_comment_form(){

		add_filter(
			'comment_form_default_fields',
			array(
				__CLASS__,
				'comment_form_default_fields_remove_url_from_comment_form'
			)
		);

		return false;
	}

	public static function comment_text_convert_links_pseudo($style = ''){

		self::$style_comment_text = $style;

		add_action(
			'wp_head',
			array(
				__CLASS__,
				'wp_head_comment_text_convert_links_pseudo'
			)
		);

		add_action(
			'wp_footer',
			array(
				__CLASS__,
				'wp_footer_comment_text_convert_links_pseudo'
			)
		);

		add_filter(
			'comment_text',
			array(
				__CLASS__,
				'comment_text_comment_text_convert_links_pseudo'
			)
		);

		return false;
	}

	public static function pseudo_comment_author_link($style = ''){

		self::$style_comment_author = $style;

		add_action(
			'wp_head',
			array(
				__CLASS__,
				'wp_head_pseudo_comment_author_link'
			)
		);

		add_action(
			'wp_footer',
			array(
				__CLASS__,
				'wp_footer_pseudo_comment_author_link'
			)
		);

		add_filter(
			'get_comment_author_link',
			array(
				__CLASS__,
				'get_comment_author_link_pseudo_comment_author_link'
			),
			100,
			3
		);

		return false;
	}

	public function comment_form_default_fields_remove_url_from_comment_form($fields){

		if(!empty($fields['url'])){

			unset($fields['url']);
		}

		return $fields;
	}

	public function wp_head_comment_text_convert_links_pseudo(){

		if(!self::$style_comment_text){

			$style = '.pseudo-link{';
				$style .= 'cursor: pointer;';
				$style .= 'text-decoration: underline;';
				$style .= 'color: #1f60d6;';
			$style .= '}';
			$style .= '.pseudo-link:hover{';
				$style .= 'text-decoration: none;';
			$style .= '}';
		}else{

			$style = self::$style_comment_text;
		}

		?>
		<style>
			<?php echo($style); ?>
		</style>
		<?php

		return false;
	}

	public function wp_footer_comment_text_convert_links_pseudo(){

		?>
		<script>
			(function($){

				$(function(){

					$(document).on("click", ".pseudo-link", function(){

						window.open($(this).data("link"));
					});
				});
			})(jQuery);
		</script>
		<?php

		return false;
	}

	public function comment_text_comment_text_convert_links_pseudo($text){

		preg_match_all('/(<a.*>)(.*)(<\/a>)/ismU', $text, $text_links, PREG_SET_ORDER);

		if(!empty($text_links)){

			foreach($text_links as $key => $comment_link){

				preg_match('/href\s*=\s*[\'|\"]\s*(.*)\s*[\'|\"]/i', $comment_link[1], $href);

				if(substr_count($href[1], get_home_url()) === 0 && (substr($href[1], 0, 7) == 'http://' || substr($href[1], 0, 8) == 'https://')){

					$prepared_link = $text_links[$key][0];
					$prepared_link = str_replace('<a', '<span class="pseudo-link"', $prepared_link);
					$prepared_link = str_replace('</a>', '</span>', $prepared_link);
					$prepared_link = str_replace('href=', 'data-link=', $prepared_link);

					$text = str_replace($text_links[$key][0], $prepared_link, $text);
				}
			}
		}

		return $text;
	}

	public function wp_head_pseudo_comment_author_link(){

		if(!self::$style_comment_author){

			$style = '.pseudo-author-link{';
				$style .= 'cursor: pointer;';
				$style .= 'text-decoration: underline;';
				$style .= 'color: #1f60d6;';
			$style .= '}';
			$style .= '.pseudo-author-link:hover{';
				$style .= 'text-decoration: none;';
			$style .= '}';
		}else{

			$style = self::$style_comment_author;
		}

		?>
		<style>
			<?php echo($style); ?>
		</style>
		<?php

		return false;
	}

	public function wp_footer_pseudo_comment_author_link(){

		?>
		<script>
			(function($){

				$(function(){

					$(document).on("click", ".pseudo-author-link", function(){

						window.open($(this).data("link"));
					});
				});
			})(jQuery);
		</script>
		<?php

		return false;
	}

	public function get_comment_author_link_pseudo_comment_author_link($return, $author, $comment_ID){

		$url    = get_comment_author_url($comment_ID);
		$author = get_comment_author($comment_ID);

		if(empty($url) || 'http://' == $url){

			$return = $author;
		}else{

			$return = '<span class="pseudo-author-link" data-link="'. $url .'">'. $author .'</span>';
		}

		return $return;
	}
}