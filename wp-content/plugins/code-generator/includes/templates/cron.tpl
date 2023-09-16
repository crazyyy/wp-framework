// Scheduled Action Hook
function {{hook}}( {{args_param}} ) {
	{{code}}
}
add_action( '{{hook}}', '{{hook}}' );
<?php if ( 'custom' === $wpg_recurrence ) { ?>

// Custom Cron Recurrences
function {{function_name}}_recurrence( $schedules ) {
	$schedules['{{recurrence_name}}'] = array(
		'display' => __( '{{recurrence_display}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
		'interval' => {{recurrence_interval}},
	);
	return $schedules;
}
add_filter( 'cron_schedules', '{{function_name}}_recurrence' );
<?php } ?>

// Schedule Cron Job Event
function {{function_name}}() {
	if ( ! wp_next_scheduled( '{{hook}}' ) ) {
		wp_schedule_event( {{timestamp}}, <?php
		if ( 'custom' !== $wpg_recurrence ) { ?>{{recurrence}}<?php } else { ?>'{{recurrence_name}}'<?php } ?>, '{{hook}}', array( {{args}} ) );
	}
}
add_action( 'wp', '{{function_name}}' );