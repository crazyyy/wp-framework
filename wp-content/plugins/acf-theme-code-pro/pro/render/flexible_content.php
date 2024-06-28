<?php
// Flexible content field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// set sub field nesting level and indent
$sub_field_indent_count = $this->indent_count + ACFTC_Core::$indent_flexible_content;

// don't need to check for no layouts, acf ui insists on at least one
echo $this->indent . htmlspecialchars("<?php if ( have_rows( '" . $this->name ."'". $this->location_rendered_param . " ) ): ?>")."\n";
echo $this->indent . htmlspecialchars("	<?php while ( have_rows( '" . $this->name ."'". $this->location_rendered_param . " ) ) : the_row(); ?>")."\n";

$layout_count = 0;

// loop through layouts
foreach ( $this->settings['layouts'] as $layout ) {

	// If Flexi add on is used
	if ( "postmeta" == ACFTC_Core::$db_table ) {

		$layout_key = NULL;
		$parent_field_id = NULL;
		$sub_fields = $layout['sub_fields'];

	}
	// Else ACF PRO is used
	elseif ( "posts" == ACFTC_Core::$db_table ) {

		$layout_key = $layout['key'];
		$parent_field_id = $this->id;
		$sub_fields = NULL;

	}

	// create layout object that contains layout sub fields
	$args = array(
		'name' => $layout['name'],
		'nesting_level' => $this->nesting_level + 1,
		'indent_count' => $sub_field_indent_count,
		'layout_key' => $layout_key,
		'parent_field_id' => $this->id,
		'sub_fields' => $sub_fields,
		'exclude_html_wrappers' => $this->exclude_html_wrappers
	);
	$acftc_layout = new ACFTC_Flexible_Content_Layout( $args );

	// TODO Check for layout without a name

	// if first non empty layout
	if ( 0 == $layout_count ) {
		// render 'if'
		echo $this->indent . htmlspecialchars("		<?php if ( get_row_layout() == '" . $acftc_layout->name . "' ) : ?>")."\n";
	} else {
		// render 'elseif'
		echo $this->indent . htmlspecialchars("		<?php elseif ( get_row_layout() == '" . $acftc_layout->name . "' ) : ?>")."\n";
	}

	// if layout has sub fields
	if ( !empty( $acftc_layout->sub_fields ) ) {
		echo $acftc_layout->get_sub_fields_html();
	}
	else {
		// layout has no sub fields

		// TODO use Label instead of Name?
		$i18n_str_no_sub_fields_warning = sprintf(
			/* translators: %s: layout name */
			__( 'Warning: Layout %s has no sub fields', 'acf-theme-code' ),
			"'$acftc_layout->name'" 
		);
		echo $this->indent . htmlspecialchars("			<?php // {$i18n_str_no_sub_fields_warning} ?>\n");
	}

	$layout_count++;
}

$i18n_str_no_layouts_found = __( 'No layouts found', 'acf-theme-code' );

echo $this->indent . htmlspecialchars("		<?php endif; ?>")."\n";
echo $this->indent . htmlspecialchars("	<?php endwhile; ?>")."\n";
echo $this->indent . htmlspecialchars("<?php else: ?>")."\n";
echo $this->indent . htmlspecialchars("	<?php // {$i18n_str_no_layouts_found} ?>")."\n";
echo $this->indent . htmlspecialchars("<?php endif; ?>")."\n";
