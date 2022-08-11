<?php
/**
 * @package Ukr-To-Lat
 * @version 1.3.5
 */
/*
Plugin Name: Ukr-To-Lat
Text Domain: ukr-to-lat
Plugin URI: https://wordpress.org/plugins/ukr-to-lat/
Description: Converts Ukrainian characters in post and term slugs to Latin characters. Useful for creating human-readable URLs. Based on the original plugin by Anton Skorobogatov and Cyr-To-Lat by SergeyBiryukov.
Author: Alexander Butyuhin
Author URI: https://roboteye.biz/
Version: 1.3.5
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
 
/** Array of letters to convert */
function ctl_sanitize_title($title) {
	global $wpdb;

	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'H', 'Ґ' => 'G',
                'Д' => 'D', 'Е' => 'E', 'Є' => 'YE', 'Ж' => 'ZH', 'З' => 'Z', 
                'И' => 'Y', 'Й' => 'Y',	'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 
		'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 
                'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 
                'Х' => 'KH', 'Ц' => 'TS', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SHCH', 
		'Ю' => 'YU', 'Я' => 'YA', 'ЗГ' => 'ZGH', 'Ь' => '',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'h', 
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ie',
		'ж' => 'zh', 'з' => 'z', 'и' => 'y', 'й' => 'y', 'і' => 'i', 
                'ї' => 'i', 'к' => 'k',  'л' => 'l', 'м' => 'm', 
                'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 
                'с' => 's', 'т' => 't',	'у' => 'u', 'ф' => 'f', 
                'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 
                'щ' => 'shch', 'ю' => 'iu', 'я' => 'ia', 'зг' => 'zgh', 'ь' => ''
	);	

	//$locale = get_locale();

	$is_term = false;
	$backtrace = debug_backtrace();
	foreach ( $backtrace as $backtrace_entry ) {
		if ( $backtrace_entry['function'] == 'wp_insert_term' ) {
			$is_term = true;
			break;
		}
	}

/** Convert new slugs */        
        
	$term = $is_term ? $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'") : '';
	if ( empty($term) ) {
		$title = strtr($title, apply_filters('ctl_table', $iso9_table));
		if (function_exists('iconv')){
			$title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
		}
		$title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
		$title = preg_replace('/\-+/', '-', $title);
		$title = preg_replace('/^-+/', '', $title);
		$title = preg_replace('/-+$/', '', $title);
	} else {
		$title = $term;
	}

	return $title;
}
add_filter('sanitize_title', 'ctl_sanitize_title', 9);
add_filter('sanitize_file_name', 'ctl_sanitize_title');

/** Convert existing slugs */

function ctl_convert_existing_slugs() {
	global $wpdb;

	$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status IN ('publish', 'future', 'private')");
	foreach ( (array) $posts as $post ) {
		$sanitized_name = ctl_sanitize_title(urldecode($post->post_name));
		if ( $post->post_name != $sanitized_name ) {
			add_post_meta($post->ID, '_wp_old_slug', $post->post_name);
			$wpdb->update($wpdb->posts, array( 'post_name' => $sanitized_name ), array( 'ID' => $post->ID ));
		}
	}

	$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+') ");
	foreach ( (array) $terms as $term ) {
		$sanitized_slug = ctl_sanitize_title(urldecode($term->slug));
		if ( $term->slug != $sanitized_slug ) {
			$wpdb->update($wpdb->terms, array( 'slug' => $sanitized_slug ), array( 'term_id' => $term->term_id ));
		}
	}
}

function ctl_schedule_conversion() {
	add_action('shutdown', 'ctl_convert_existing_slugs');
}
register_activation_hook(__FILE__, 'ctl_schedule_conversion');
