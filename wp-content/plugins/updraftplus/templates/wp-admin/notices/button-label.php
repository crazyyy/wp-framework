<?php
if (!empty($button_meta)) {
	if ('updraftcentral' == $button_meta) {
		esc_html_e('Get UpdraftCentral', 'updraftplus');
	} elseif ('updraftplus' == $button_meta) {
		esc_html_e('Get Premium', 'updraftplus');
	} elseif ('signup' == $button_meta) {
		esc_html_e('Sign up', 'updraftplus');
	} elseif ('learnmore' == $button_meta) {
		esc_html_e('Learn more', 'updraftplus');
	} elseif ('go_there' == $button_meta) {
		esc_html_e('Go there', 'updraftplus');
	} else {
		esc_html_e('Read more', 'updraftplus');
	}
} elseif (!empty($button_text)) {
	echo esc_html($button_text);
}
