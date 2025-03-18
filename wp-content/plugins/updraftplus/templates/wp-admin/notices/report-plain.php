<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

if (!empty($prefix)) echo wp_kses_post($prefix).' ';
echo wp_kses_post($title).': ';

echo empty($text_plain) ? wp_kses_post($text) : wp_kses_post($text_plain);

if (!empty($discount_code)) echo esc_html($discount_code).' ';

if (!empty($button_link) && !empty($button_meta)) {

	echo ' ';

	$link = apply_filters('updraftplus_com_link', $button_link);

	if ('updraftcentral' == $button_meta) {
		esc_html_e('Get UpdraftCentral', 'updraftplus');
	} elseif ('review' == $button_meta) {
		esc_html_e('Review UpdraftPlus', 'updraftplus');
	} elseif ('updraftplus' == $button_meta) {
		esc_html_e('Get Premium', 'updraftplus');
	} elseif ('signup' == $button_meta) {
		esc_html_e('Sign up', 'updraftplus');
	} elseif ('go_there' == $button_meta) {
		esc_html_e('Go there', 'updraftplus');
	} else {
		esc_html_e('Read more', 'updraftplus');
	}

	echo ' - '.esc_url($link);
	echo "\r\n";
	
}
