<?php
// Repeater field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// ACFTC_Group arguments
if ( "posts" == ACFTC_Core::$db_table ) { // ACF PRO repeater
	$field_group_id = $this->id;
	$fields = NULL;
}
elseif ( "postmeta" == ACFTC_Core::$db_table ) { // Repeater Add On
	$field_group_id = NULL;
	$fields = $this->settings['sub_fields']; // In this case $this->settings
	// is actually just an array of all available field data
}
$nesting_arg = 0;
$sub_field_indent_count = $this->indent_count + ACFTC_Core::$indent_repeater;

$args = array(
	'field_group_id' => $field_group_id,
	'fields' => $fields,
	'nesting_level' => $nesting_arg + 1,
	'indent_count' => $sub_field_indent_count,
	'exclude_html_wrappers' => $this->exclude_html_wrappers
);
$repeater_field_group = new ACFTC_Group( $args );

// If repeater has sub fields
if ( !empty( $repeater_field_group->fields ) ) {

	$i18n_str_no_rows_found = __( 'No rows found', 'acf-theme-code' );

	echo $this->indent . htmlspecialchars("<?php if ( have_rows( '" . $this->name ."'". $this->location_rendered_param . " ) ) : ?>")."\n";
	echo $this->indent . htmlspecialchars("	<?php while ( have_rows( '" . $this->name ."'". $this->location_rendered_param . " ) ) : the_row(); ?>")."\n";

	echo $repeater_field_group->get_field_group_html();

	echo $this->indent . htmlspecialchars("	<?php endwhile; ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php else : ?>")."\n";
	echo $this->indent . htmlspecialchars("	<?php // {$i18n_str_no_rows_found} ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php endif; ?>")."\n";

}
// Repeater has no sub fields
else {

	$i18n_str_no_sub_fields_warning = sprintf(
		/* translators: %s: repeater field name */
		__( 'Warning: Repeater field %s has no sub fields', 'acf-theme-code' ),
		"'$this->name'" 
	);
	echo $this->indent . htmlspecialchars("<?php // {$i18n_str_no_sub_fields_warning} ?>\n");

}
