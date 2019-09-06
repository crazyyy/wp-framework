<?php

/**
 * Helpers functions
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCTR_Helper {
	
	public static function transliterate( $title, $ignore_special_symbols = false ) {
		$origin_title = $title;
		$iso9_table   = self::getSymbolsPack();
		
		$title = urldecode( $title );
		$title = strtr( $title, $iso9_table );
		
		if ( function_exists( 'iconv' ) ) {
			$title = iconv( 'UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title );
		}
		
		if ( ! $ignore_special_symbols ) {
			$title = preg_replace( "/[^A-Za-z0-9'_\-\.]/", '-', $title );
			$title = preg_replace( '/\-+/', '-', $title );
			$title = preg_replace( '/^-+/', '', $title );
			$title = preg_replace( '/-+$/', '', $title );
		}
		
		return apply_filters( 'wbcr_cyrlitera_transliterate', $title, $origin_title, $iso9_table );
	}
	
	/**
	 * @param string $title обработанный заголовок
	 *
	 * @return mixed|string
	 */
	public static function sanitizeTitle( $title ) {
		global $wpdb;
		
		$origin_title = $title;
		
		$is_term   = false;
		$backtrace = debug_backtrace();
		foreach ( $backtrace as $backtrace_entry ) {
			if ( $backtrace_entry['function'] == 'wp_insert_term' ) {
				$is_term = true;
				break;
			}
		}
		
		foreach ( $backtrace as $backtrace_entry ) {
			if ( isset( $backtrace_entry['function'] ) && isset( $backtrace_entry['class'] ) ) {
				
				# WOOCOMMERCE FIXES
				# We need to cancel the transliteration of attributes for variable products,
				# as this brings harm to users.
				#------------------------------------
				/*if ( class_exists( 'WooCommerce' ) ) {
					$is_woo_variations = in_array( $backtrace_entry['function'], array(
							'set_attributes',
							'output',
							'load_variations',
							'prepare_set_attributes',
							'save_attributes',
							'add_variation',
							'save_variations',
							'read_variation_attributes'
						) ) && in_array( $backtrace_entry['class'], array(
							'WC_AJAX',
							'WC_Product',
							'WC_Meta_Box_Product_Data',
							'WC_Product_Variable_Data_Store_CPT'
						) );
					
					if ( $is_woo_variations ) {
						return $origin_title;
					}
				}*/
				#------------------------------------
				
				# FRONTEND FIXES
				#------------------------------------
				if ( ! is_admin() ) {
					$is_query = in_array( $backtrace_entry['function'], array(
							'query_posts',
							'get_terms'
						) ) && in_array( $backtrace_entry['class'], array( 'WP', 'WP_Term_Query' ) );
					
					if ( $is_query ) {
						return $origin_title;
					}
				}
				#------------------------------------
			}
		}
		
		$term = $is_term ? $wpdb->get_var( $wpdb->prepare( "SELECT slug FROM {$wpdb->terms} WHERE name = '%s'", $title ) ) : '';
		
		if ( empty( $term ) ) {
			$title = self::transliterate( $title );
		} else {
			$title = $term;
		}
		
		return apply_filters( 'wbcr_cyrlitera_sanitize_title', $title, $origin_title );
	}
	
	/**
	 * @return array
	 */
	public static function getSymbolsPack() {
		$loc = get_locale();
		
		$ret = array(
			// russian
			'А'  => 'A',
			'а'  => 'a',
			'Б'  => 'B',
			'б'  => 'b',
			'В'  => 'V',
			'в'  => 'v',
			'Г'  => 'G',
			'г'  => 'g',
			'Д'  => 'D',
			'д'  => 'd',
			'Е'  => 'E',
			'е'  => 'e',
			'Ё'  => 'Jo',
			'ё'  => 'jo',
			'Ж'  => 'Zh',
			'ж'  => 'zh',
			'З'  => 'Z',
			'з'  => 'z',
			'И'  => 'I',
			'и'  => 'i',
			'Й'  => 'J',
			'й'  => 'j',
			'К'  => 'K',
			'к'  => 'k',
			'Л'  => 'L',
			'л'  => 'l',
			'М'  => 'M',
			'м'  => 'm',
			'Н'  => 'N',
			'н'  => 'n',
			'О'  => 'O',
			'о'  => 'o',
			'П'  => 'P',
			'п'  => 'p',
			'Р'  => 'R',
			'р'  => 'r',
			'С'  => 'S',
			'с'  => 's',
			'Т'  => 'T',
			'т'  => 't',
			'У'  => 'U',
			'у'  => 'u',
			'Ф'  => 'F',
			'ф'  => 'f',
			'Х'  => 'H',
			'х'  => 'h',
			'Ц'  => 'C',
			'ц'  => 'c',
			'Ч'  => 'Ch',
			'ч'  => 'ch',
			'Ш'  => 'Sh',
			'ш'  => 'sh',
			'Щ'  => 'Shh',
			'щ'  => 'shh',
			'Ъ'  => '',
			'ъ'  => '',
			'Ы'  => 'Y',
			'ы'  => 'y',
			'Ь'  => '',
			'ь'  => '',
			'Э'  => 'Je',
			'э'  => 'je',
			'Ю'  => 'Ju',
			'ю'  => 'ju',
			'Я'  => 'Ja',
			'я'  => 'ja',
			// global
			'Ґ'  => 'G',
			'ґ'  => 'g',
			'Є'  => 'Ie',
			'є'  => 'ie',
			'І'  => 'I',
			'і'  => 'i',
			'Ї'  => 'I',
			'ї'  => 'i',
			'Ї' => 'i',
			'ї' => 'i',
			'Ё' => 'Jo',
			'ё' => 'jo',
			'й' => 'i',
			'Й' => 'I'
		);
		
		// ukrainian
		if ( $loc == 'uk' ) {
			$ret = array_merge( $ret, array(
				'Г' => 'H',
				'г' => 'h',
				'И' => 'Y',
				'и' => 'y',
				'Х' => 'Kh',
				'х' => 'kh',
				'Ц' => 'Ts',
				'ц' => 'ts',
				'Щ' => 'Shch',
				'щ' => 'shch',
				'Ю' => 'Iu',
				'ю' => 'iu',
				'Я' => 'Ia',
				'я' => 'ia',
			
			) );
			//bulgarian
		} elseif ( $loc == 'bg' || $loc == 'bg_BG' ) {
			$ret = array_merge( $ret, array(
				'Щ' => 'Sht',
				'щ' => 'sht',
				'Ъ' => 'a',
				'ъ' => 'a'
			) );
		}
		
		if ( $loc == 'ka_GE' ) {
			$ret = array(
				'ა' => 'a',
				'ბ' => 'b',
				'გ' => 'g',
				'დ' => 'd',
				'ე' => 'e',
				'ვ' => 'v',
				'ზ' => 'z',
				'თ' => 'th',
				'ი' => 'i',
				'კ' => 'k',
				'ლ' => 'l',
				'მ' => 'm',
				'ნ' => 'n',
				'ო' => 'o',
				'პ' => 'p',
				'ჟ' => 'zh',
				'რ' => 'r',
				'ს' => 's',
				'ტ' => 't',
				'უ' => 'u',
				'ფ' => 'ph',
				'ქ' => 'q',
				'ღ' => 'gh',
				'ყ' => 'qh',
				'შ' => 'sh',
				'ჩ' => 'ch',
				'ც' => 'ts',
				'ძ' => 'dz',
				'წ' => 'ts',
				'ჭ' => 'tch',
				'ხ' => 'kh',
				'ჯ' => 'j',
				'ჰ' => 'h'
			);
		}
		
		// Armenian
		if ( $loc == 'hy' ) {
			$ret = array_merge( $ret, array(
				'Ա'  => 'A',
				'ա'  => 'a',
				'Բ'  => 'B',
				'բ'  => 'b',
				'Գ'  => 'G',
				'գ'  => 'g',
				'Դ'  => 'D',
				'դ'  => 'd',
				' Ե' => ' Ye',
				'Ե'  => 'E',
				' ե' => ' ye',
				'ե'  => 'e',
				'Զ'  => 'Z',
				'զ'  => 'z',
				'Է'  => 'E',
				'է'  => 'e',
				'Ը'  => 'Y',
				'ը'  => 'y',
				'Թ'  => 'T',
				'թ'  => 't',
				'Ժ'  => 'Zh',
				'ժ'  => 'zh',
				'Ի'  => 'I',
				'ի'  => 'i',
				'Լ'  => 'L',
				'լ'  => 'l',
				'Խ'  => 'KH',
				'խ'  => 'kh',
				'Ծ'  => 'TS',
				'ծ'  => 'ts',
				'Կ'  => 'K',
				'կ'  => 'K',
				'Հ'  => 'H',
				'հ'  => 'h',
				'Ձ'  => 'DZ',
				'ձ'  => 'dz',
				'Ղ'  => 'GH',
				'ղ'  => 'gh',
				'Ճ'  => 'J',
				'Ճ'  => 'j',
				'Մ'  => 'M',
				'մ'  => 'm',
				'Յ'  => 'Y',
				'յ'  => 'y',
				'Ն'  => 'N',
				'ն'  => 'n',
				'Շ'  => 'SH',
				'շ'  => 'sh',
				' Ո' => 'VO',
				'Ո'  => 'VO',
				' ո' => ' vo',
				'ո'  => 'o',
				'Չ'  => 'Ch',
				'չ'  => 'ch',
				'Պ'  => 'P',
				'պ'  => 'p',
				'Ջ'  => 'J',
				'ջ'  => 'j',
				'Ռ'  => 'R',
				'ռ'  => 'r',
				'Ս'  => 'S',
				'ս'  => 's',
				'Վ'  => 'V',
				'վ'  => 'v',
				'Տ'  => 'T',
				'տ'  => 't',
				'Ր'  => 'R',
				'ր'  => 'r',
				'Ց'  => 'C',
				'ց'  => 'c',
				'Ու' => 'U',
				'ու' => 'u',
				'Փ'  => 'P',
				'փ'  => 'p',
				'Ք'  => 'Q',
				'ք'  => 'q',
				'Եվ' => 'EV',
				'և'  => 'ev',
				'Օ'  => 'O',
				'օ'  => 'o',
				'Ֆ'  => 'F',
				'ֆ'  => 'f'
			) );
		}
		
		// Serbian
		if ( $loc == 'sr_RS' ) {
			$ret = array_merge( $ret, array(
				"Ђ"  => "DJ",
				"Ж"  => "Z",
				"З"  => "Z",
				"Љ"  => "LJ",
				"Њ"  => "NJ",
				"Ш"  => "S",
				"Ћ"  => "C",
				"Ц"  => "C",
				"Ч"  => "C",
				"Џ"  => "DZ",
				"ђ"  => "dj",
				"ж"  => "z",
				"з"  => "z",
				"и"  => "i",
				"љ"  => "lj",
				"њ"  => "nj",
				"ш"  => "s",
				"ћ"  => "c",
				"ч"  => "c",
				"џ"  => "dz",
				"Ња" => "Nja",
				"Ње" => "Nje",
				"Њи" => "Nji",
				"Њо" => "Njo",
				"Њу" => "Nju",
				"Ља" => "Lja",
				"Ље" => "Lje",
				"Љи" => "Lji",
				"Љо" => "Ljo",
				"Љу" => "Lju",
				"Џа" => "Dza",
				"Џе" => "Dze",
				"Џи" => "Dzi",
				"Џо" => "Dzo",
				"Џу" => "Dzu"
			) );
		}
		
		$custom_rules = WCTR_Plugin::app()->getPopulateOption( 'custom_symbols_pack' );
		
		if ( ! empty( $custom_rules ) ) {
			$split_rules = explode( ',', $custom_rules );
			$split_rules = array_map( 'trim', $split_rules );
			
			foreach ( $split_rules as $rule ) {
				$split_symbols = explode( '=', $rule );
				
				if ( sizeof( $split_symbols ) === 2 ) {
					if ( empty( $split_symbols[0] ) ) {
						continue;
					}
					
					$ret[ $split_symbols[0] ] = $split_symbols[1];
				}
			}
		}
		
		return apply_filters( 'wbcr_cyrlitera_default_symbols_pack', $ret );
	}
	
	/**
	 * Делает откат изменений после выполнения метода convertExistingSlugs,
	 * этот метод не восстановливает вновь конвертированные слаги.
	 */
	public static function rollbackUrlChanges() {
		global $wpdb;
		
		$posts = $wpdb->get_results( "SELECT p.ID, p.post_name, m.meta_value as old_post_name FROM {$wpdb->posts} p
						LEFT JOIN {$wpdb->postmeta} m
						ON p.ID = m.post_id
						WHERE p.post_status
						IN ('publish', 'future', 'private') AND m.meta_key='wbcr_wp_old_slug' AND m.meta_value IS NOT NULL" );
		
		foreach ( (array) $posts as $post ) {
			if ( $post->post_name != $post->old_post_name ) {
				$wpdb->update( $wpdb->posts, array( 'post_name' => $post->old_post_name ), array( 'ID' => $post->ID ), array( '%s' ), array( '%d' ) );
				delete_post_meta( $post->ID, 'wbcr_wp_old_slug' );
			}
		}
		
		$terms = $wpdb->get_results( "SELECT t.term_id, t.slug, o.option_value as old_term_slug FROM {$wpdb->terms} t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_wp_term_',t.term_id, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
		
		foreach ( (array) $terms as $term ) {
			if ( $term->slug != $term->old_term_slug ) {
				$wpdb->update( $wpdb->terms, array( 'slug' => $term->old_term_slug ), array( 'term_id' => $term->term_id ), array( '%s' ), array( '%d' ) );
				delete_option( 'wbcr_wp_term_' . $term->term_id . '_old_slug' );
			}
		}
		
		// BuddyPress group slug
		// ! slug maybe urlencoded
		if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
			$groups = $wpdb->get_results( "SELECT t.id, t.name, t.slug, o.option_value as old_term_slug FROM {$wpdb->prefix}bp_groups t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_bp_groups_',t.id, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
			foreach ( (array) $groups as $group ) {
				if ( $group->slug != $group->old_term_slug ) {
					$wpdb->update( "{$wpdb->prefix}bp_groups", array( 'slug' => $group->old_term_slug ), array( 'id' => $group->id ), array( '%s' ), array( '%d' ) );
					delete_option( 'wbcr_bp_groups_' . $group->id . '_old_slug' );
				}
			}
		}
		
		// Asgaros Forum
		if ( is_plugin_active( 'asgaros-forum/asgaros-forum.php' ) ) {
			$forums = $wpdb->get_results( "SELECT t.id, t.name, t.slug, o.option_value as old_term_slug FROM {$wpdb->prefix}forum_forums t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_asgaros_forums_',t.id, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
			foreach ( (array) $forums as $forum ) {
				if ( $forum->slug != $forum->old_term_slug ) {
					$wpdb->update( "{$wpdb->prefix}forum_forums", array( 'slug' => $forum->old_term_slug ), array( 'id' => $forum->id ), array( '%s' ), array( '%d' ) );
					delete_option( 'wbcr_asgaros_forums_' . $forum->id . '_old_slug' );
				}
			}
			
			//topic
			$topics = $wpdb->get_results( "SELECT t.id, t.name, t.slug, o.option_value as old_term_slug FROM {$wpdb->prefix}forum_topics t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_asgaros_topics_',t.id, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
			foreach ( (array) $topics as $topic ) {
				if ( $topic->slug != $topic->old_term_slug ) {
					$wpdb->update( "{$wpdb->prefix}forum_topics", array( 'slug' => $topic->old_term_slug ), array( 'id' => $topic->id ), array( '%s' ), array( '%d' ) );
					delete_option( 'wbcr_asgaros_topics_' . $topic->id . '_old_slug' );
				}
			}
		}
		
		// WP Foro
		if ( is_plugin_active( 'wpforo/wpforo.php' ) ) {
			// forums
			$forums = $wpdb->get_results( "SELECT t.forumid, t.title, t.slug, o.option_value as old_term_slug FROM {$wpdb->prefix}wpforo_forums t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_wpforo_forums_',t.forumid, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
			
			foreach ( (array) $forums as $forum ) {
				if ( $forum->slug != $forum->old_term_slug ) {
					$wpdb->update( "{$wpdb->prefix}wpforo_forums", array( 'slug' => $forum->old_term_slug ), array( 'forumid' => $forum->forumid ), array( '%s' ), array( '%d' ) );
					delete_option( 'wbcr_wpforo_forums_' . $topic->id . '_old_slug' );
				}
			}
			
			// topics
			$topics = $wpdb->get_results( "SELECT t.topicid, t.title, t.slug, o.option_value as old_term_slug FROM {$wpdb->prefix}wpforo_topics t
						LEFT JOIN {$wpdb->options} o
						ON o.option_name=concat('wbcr_wpforo_topics_',t.topicid, '_old_slug')
						WHERE o.option_value IS NOT NULL" );
			
			foreach ( (array) $topics as $topic ) {
				if ( $topic->slug != $topic->old_term_slug ) {
					$wpdb->update( "{$wpdb->prefix}wpforo_topics", array( 'slug' => $topic->old_term_slug ), array( 'topicid' => $topic->topicid ), array( '%s' ), array( '%d' ) );
					delete_option( 'wbcr_wpforo_topics_' . $topic->id . '_old_slug' );
				}
			}
			
			// clear cache
			WPF()->phrase->clear_cache();
			WPF()->member->clear_db_cache();
			wpforo_clean_cache();
		}
	}
	
	/**
	 * Массово конвертирует слаги для страниц, записей, терминов и т.д.
	 * Делает бекап старого слага, чтобы можно было восстановить его. А также использовать в других плагинах.
	 */
	public static function convertExistingSlugs() {
		global $wpdb;
		
		$posts = $wpdb->get_results( "SELECT ID, post_name FROM {$wpdb->posts}
 					WHERE post_name REGEXP('[^_A-Za-z0-9\-]+') AND post_status IN ('publish', 'future', 'private')" );
		
		foreach ( (array) $posts as $post ) {
			$sanitized_name = WCTR_Helper::sanitizeTitle( urldecode( $post->post_name ) );
			
			if ( $post->post_name != $sanitized_name ) {
				add_post_meta( $post->ID, 'wbcr_wp_old_slug', $post->post_name );
				
				$wpdb->update( $wpdb->posts, array( 'post_name' => $sanitized_name ), array( 'ID' => $post->ID ), array( '%s' ), array( '%d' ) );
			}
		}
		
		$terms = $wpdb->get_results( "SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^_A-Za-z0-9\-]+')" );
		
		foreach ( (array) $terms as $term ) {
			$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $term->slug ) );
			
			if ( $term->slug != $sanitized_slug ) {
				update_option( 'wbcr_wp_term_' . $term->term_id . '_old_slug', $term->slug, false );
				$wpdb->update( $wpdb->terms, array( 'slug' => $sanitized_slug ), array( 'term_id' => $term->term_id ), array( '%s' ), array( '%d' ) );
			}
		}
		
		// BuddyPress group slug
		// ! slug maybe urlencoded
		if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
			
			$groups = $wpdb->get_results( "SELECT `id`, `name`, `slug` FROM {$wpdb->prefix}bp_groups WHERE slug REGEXP('%|[^_A-Za-z0-9\-]+')" );
			if ( is_array( $groups ) ) {
				foreach ( $groups as $group ) {
					$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $group->slug ) );
					if ( $group->slug != $sanitized_slug ) {
						update_option( 'wbcr_bp_groups_' . $group->id . '_old_slug', $group->slug, false );
						$wpdb->update( $wpdb->prefix . 'bp_groups', array( 'slug' => $sanitized_slug ), array( 'id' => $group->id ), array( '%s' ), array( '%d' ) );
					}
				}
			}
		}
		
		// Asgaros Forum
		if ( is_plugin_active( 'asgaros-forum/asgaros-forum.php' ) ) {
			// forum slug
			$groups = $wpdb->get_results( "SELECT `id`, `name`, `slug` FROM {$wpdb->prefix}forum_forums WHERE slug REGEXP('%|[^_A-Za-z0-9\-]+')" );
			if ( is_array( $groups ) ) {
				foreach ( $groups as $group ) {
					$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $group->slug ) );
					if ( $group->slug != $sanitized_slug ) {
						update_option( 'wbcr_asgaros_forums_' . $group->id . '_old_slug', $group->slug, false );
						$wpdb->update( $wpdb->prefix . 'forum_forums', array( 'slug' => $sanitized_slug ), array( 'id' => $group->id ), array( '%s' ), array( '%d' ) );
					}
				}
			}
			// topic slug
			$groups = $wpdb->get_results( "SELECT `id`, `name`, `slug` FROM {$wpdb->prefix}forum_topics WHERE slug REGEXP('%|[^_A-Za-z0-9\-]+')" );
			if ( is_array( $groups ) ) {
				foreach ( $groups as $group ) {
					$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $group->slug ) );
					if ( $group->slug != $sanitized_slug ) {
						update_option( 'wbcr_asgaros_topics_' . $group->id . '_old_slug', $group->slug, false );
						$wpdb->update( $wpdb->prefix . 'forum_topics', array( 'slug' => $sanitized_slug ), array( 'id' => $group->id ), array( '%s' ), array( '%d' ) );
					}
				}
			}
		}
		
		// WP Foro
		if ( is_plugin_active( 'wpforo/wpforo.php' ) ) {
			// forum slug
			$forums = $wpdb->get_results( "SELECT `forumid`, `title`, `slug` FROM {$wpdb->prefix}wpforo_forums WHERE slug REGEXP('%|[^_A-Za-z0-9\-]+')" );
			if ( is_array( $forums ) ) {
				foreach ( $forums as $forum ) {
					$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $forum->slug ) );
					if ( $forum->slug != $sanitized_slug ) {
						update_option( 'wbcr_wpforo_forums_' . $forum->forumid . '_old_slug', $forum->slug, false );
						$wpdb->update( $wpdb->prefix . 'wpforo_forums', array( 'slug' => $sanitized_slug ), array( 'forumid' => $forum->forumid ), array( '%s' ), array( '%d' ) );
					}
				}
			}
			
			// topic slug
			$topics = $wpdb->get_results( "SELECT `topicid`, `title`, `slug` FROM {$wpdb->prefix}wpforo_topics WHERE slug REGEXP('%|[^_A-Za-z0-9\-]+')" );
			if ( is_array( $topics ) ) {
				foreach ( $topics as $topic ) {
					$sanitized_slug = WCTR_Helper::sanitizeTitle( urldecode( $topic->slug ) );
					if ( $topic->slug != $sanitized_slug ) {
						update_option( 'wbcr_wpforo_topics_' . $topic->topicid . '_old_slug', $topic->slug, false );
						$wpdb->update( $wpdb->prefix . 'wpforo_topics', array( 'slug' => $sanitized_slug ), array( 'topicid' => $topic->topicid ), array( '%s' ), array( '%d' ) );
					}
				}
			}
			
			// clear cache
			WPF()->phrase->clear_cache();
			WPF()->member->clear_db_cache();
			wpforo_clean_cache();
		}
	}
}
