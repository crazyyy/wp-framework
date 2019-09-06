<?php
	/**
	 * Admin boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Получает список отключенных типов записей
	 * @return array|bool|mixed|void
	 */
	function wbcr_cmp_get_disabled_post_types()
	{

		$post_types = WCM_Plugin::app()->getPopulateOption('disable_comments_for_post_types');

		if( WCM_Plugin::app()->getPopulateOption('disable_comments', 'enable_comments') == 'disable_comments' ) {

			$args = array('public' => true);

			if( WCM_Plugin::app()->isNetworkActive() ) {
				$args['_builtin'] = true;
			}

			$all_post_types = get_post_types($args, 'objects');

			return array_keys($all_post_types);
		}

		// Not all extra_post_types might be registered on this particular site
		/*if( $this->networkactive ) {
			foreach( (array) $this->options['extra_post_types'] as $extra ) {
				if( post_type_exists( $extra ) ) {
					$types[] = $extra;
				}
			}
		}*/

		if( is_array($post_types) ) {
			return $post_types;
		}

		return explode(',', $post_types);
	}