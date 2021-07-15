<?php
defined('BBF') or die();

class Falbar_BBF_Option_Widgets{

	public static function remove_widget_page(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_page'
			),
			11
		);

		return false;
	}

	public static function remove_widget_calendar(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_calendar'
			),
			11
		);

		return false;
	}

	public static function remove_widget_tags(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_tags'
			),
			11
		);

		return false;
	}

	public static function remove_widget_archives(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_archives'
			),
			11
		);

		return false;
	}

	public static function remove_widget_meta(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_meta'
			),
			11
		);

		return false;
	}

	public static function remove_widget_search(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_search'
			),
			11
		);

		return false;
	}

	public static function remove_widget_text(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_text'
			),
			11
		);

		return false;
	}

	public static function remove_widget_categories(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_categories'
			),
			11
		);

		return false;
	}

	public static function remove_widget_recent_posts(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_recent_posts'
			),
			11
		);

		return false;
	}

	public static function remove_widget_comments(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_comments'
			),
			11
		);

		return false;
	}

	public static function remove_widget_rss(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_rss'
			),
			11
		);

		return false;
	}

	public static function remove_widget_menu(){

		add_action(
			'widgets_init',
			array(
				__CLASS__,
				'widgets_init_remove_widget_menu'
			),
			11
		);

		return false;
	}

	public function widgets_init_remove_widget_page(){

		unregister_widget('WP_Widget_Pages');

		return false;
	}

	public function widgets_init_remove_widget_calendar(){

		unregister_widget('WP_Widget_Calendar');

		return false;
	}

	public function widgets_init_remove_widget_tags(){

		unregister_widget('WP_Widget_Tag_Cloud');

		return false;
	}

	public function widgets_init_remove_widget_archives(){

		unregister_widget('WP_Widget_Archives');

		return false;
	}

	public function widgets_init_remove_widget_meta(){

		unregister_widget('WP_Widget_Meta');

		return false;
	}

	public function widgets_init_remove_widget_search(){

		unregister_widget('WP_Widget_Search');

		return false;
	}

	public function widgets_init_remove_widget_text(){

		unregister_widget('WP_Widget_Text');

		return false;
	}

	public function widgets_init_remove_widget_categories(){

		unregister_widget('WP_Widget_Categories');

		return false;
	}

	public function widgets_init_remove_widget_recent_posts(){

		unregister_widget('WP_Widget_Recent_Posts');

		return false;
	}

	public function widgets_init_remove_widget_comments(){

		unregister_widget('WP_Widget_Recent_Comments');

		return false;
	}

	public function widgets_init_remove_widget_rss(){

		unregister_widget('WP_Widget_RSS');

		return false;
	}

	public function widgets_init_remove_widget_menu(){

		unregister_widget('WP_Nav_Menu_Widget');

		return false;
	}
}