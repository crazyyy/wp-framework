<?php
// Block

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if ( empty( $location_rule['value'] ) ) {

    echo htmlspecialchars("<?php
/*
 * No block selected.
 *
 * 1. Go to the Custom Fields > Tools page and use the 'Register ACF Blocks or Options Page'
 *    tool to generate the code for registering a new block.
 * 2. Add the block registration code to your theme.
 * 3. Select your new block in the Locations meta box on this page and
 *    hit Update on this field group
 */
?>");

} else {

    // get some info on the current block
    $block_location_name = $location_rule['value'];
    $block_info = acf_get_block_type($block_location_name);
    $block_template = $block_info['render_template'];

    $block_slug = str_replace('acf/', '', $location_rule['value']);
    $block_name = str_replace('-', ' ', $block_slug);
    $block_name_title_case = ucwords($block_name);

    $args = array(
        'field_group_id' => $this->field_group_post_ID,
        'indent_count' => 1,
        'nesting_level' => 0,
        'location_rule_param' => $location_rule['param'],
        'exclude_html_wrappers' => true
    );
    $field_group = new ACFTC_Group( $args );
    $field_group_html = $field_group->get_field_group_html();

    $php = htmlspecialchars("<?php
/**
 * Block template file: {$block_template}
 *
 * {$block_name_title_case} Block Template.
 *
 * @param   array \$block The block settings and attributes.
 * @param   string \$content The block inner HTML (empty).
 * @param   bool \$is_preview True during AJAX preview.
 * @param   (int|string) \$post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom \"anchor\" value.
\$id = '{$block_slug}-' . \$block['id'];
if ( ! empty(\$block['anchor'] ) ) {
    \$id = \$block['anchor'];
}

// Create class attribute allowing for custom \"className\" and \"align\" values.
\$classes = 'block-{$block_slug}';
if ( ! empty( \$block['className'] ) ) {
    \$classes .= ' ' . \$block['className'];
}
if ( ! empty( \$block['align'] ) ) {
    \$classes .= ' align' . \$block['align'];
}
?>

<style type=\"text/css\">
	<?php echo '#' . \$id; ?> {
		/* Add styles that use ACF values here */
	}
</style>

<div id=\"<?php echo esc_attr( \$id ); ?>\" class=\"<?php echo esc_attr( \$classes ); ?>\">
__FIELD_GROUP_HTML__</div>");

    $php = str_replace( "__FIELD_GROUP_HTML__", $field_group_html , $php ); // Required as $field_group_html has already been through htmlspecialchars
    echo $php;
}
