<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sweeppress_sanitize_keys_based_array( array $input ) : array {
	$clean = array();

	foreach ( $input as $key => $values ) {
		$key = sanitize_key( $key );

		if ( is_array( $values ) ) {
			$values = sweeppress_sanitize_keys_based_array( $values );
		} else {
			$values = sanitize_text_field( $values );
		}

		$clean[ $key ] = $values;
	}

	return $clean;
}

function sweeppress_strings_array_to_list( array $input ) : string {
	$display = '<ul><li>';
	$display .= join( '</li><li>', $input );
	$display .= '</li></ul>';

	return $display;
}

function sweeppress_akismet_meta_keys() : array {
	return array(
		'akismet_result',
		'akismet_error',
		'akismet_history',
		'akismet_as_submitted',
		'akismet_rechecking',
		'akismet_pro_tip',
		'akismet_user_result',
		'akismet_user',
		'akismet_delayed_moderation_email',
	);
}

function sweeppress_is_actionscheduler_active() : bool {
	$exists = class_exists( 'ActionScheduler_Versions' ) && class_exists( 'ActionScheduler' );

	if ( $exists ) {
		$exists = version_compare( ActionScheduler_Versions::instance()->latest_version(), '3.4', '>=' );
	}

	return $exists;
}
