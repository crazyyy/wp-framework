<?php
// Block

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$block_location_name = $location_rule['value'];
$block_info = acf_get_block_type( $block_location_name );

if ( empty( $block_location_name ) || empty( $block_info ) ) {

    $i18n_str_no_block_comment_title = __( 'No registered block selected.', 'acf-theme-code' );
    $i18n_str_no_block_comment_1a = sprintf(
        /* translators: %s: > */
        __( '1. Go to the Custom Fields %s Tools page and use the Register ACF Blocks or Options Page tool', 'acf-theme-code' ),
        '>'
    );
    $i18n_str_no_block_comment_1b = __(    'to generate the code for registering a new block.', 'acf-theme-code' );
    $i18n_str_no_block_comment_2 = __( '2. Add the block registration code to your theme.', 'acf-theme-code' );
    $i18n_str_no_block_comment_3a = __( '3. Select your new block in the Locations meta box on this page and', 'acf-theme-code' );
    $i18n_str_no_block_comment_3b = __(    'hit Update on this field group', 'acf-theme-code' );

    echo htmlspecialchars("<?php
/*
 * {$i18n_str_no_block_comment_title}
 *
 * {$i18n_str_no_block_comment_1a}
 *    {$i18n_str_no_block_comment_1b}
 * {$i18n_str_no_block_comment_2}
 * {$i18n_str_no_block_comment_3a}
 *    {$i18n_str_no_block_comment_3b}
 */
?>");

} else {

    // i18n strings
    $i18n_str_block_template_file = __( 'Block template file', 'acf-theme-code' );
    $i18n_str_block_template = __( 'Block Template', 'acf-theme-code' );
    $i18n_str_param_desc_block = __( 'The block settings and attributes.', 'acf-theme-code' );
    $i18n_str_param_desc_content = __( 'The block inner HTML (empty).', 'acf-theme-code' );
    $i18n_str_param_desc_is_preview = __( 'True during AJAX preview.', 'acf-theme-code' );
    $i18n_str_param_desc_post_id = __( 'The post ID this block is saved to.', 'acf-theme-code' );
    $i18n_str_comment_id_attr = sprintf(
        /* translators: %s: "anchor" */
        __( 'Create id attribute allowing for custom %s value.', 'acf-theme-code' ),
        '"anchor"'
    );
    $i18n_str_comment_class_attr = sprintf(
        /* translators: 1: "className" 2: "align" */
        __( 'Create class attribute allowing for custom %1$s and %2$s values.', 'acf-theme-code' ),
        '"className"',
        '"align"'
    );
    $i18n_str_comment_add_styles = __( 'Add styles that use ACF values here', 'acf-theme-code' );

    // Get some info on the current block
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
 * {$i18n_str_block_template_file}: {$block_template}
 *
 * {$block_name_title_case} {$i18n_str_block_template}.
 *
 * @param   array \$block {$i18n_str_param_desc_block}
 * @param   string \$content {$i18n_str_param_desc_content}
 * @param   bool \$is_preview {$i18n_str_param_desc_is_preview}
 * @param   (int|string) \$post_id {$i18n_str_param_desc_post_id}
 */

// {$i18n_str_comment_id_attr}
\$id = '{$block_slug}-' . \$block['id'];
if ( ! empty(\$block['anchor'] ) ) {
    \$id = \$block['anchor'];
}

// {$i18n_str_comment_class_attr}
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
		/* {$i18n_str_comment_add_styles} */
	}
</style>

<div id=\"<?php echo esc_attr( \$id ); ?>\" class=\"<?php echo esc_attr( \$classes ); ?>\">
__FIELD_GROUP_HTML__</div>");

    $php = str_replace( "__FIELD_GROUP_HTML__", $field_group_html , $php ); // Required as $field_group_html has already been through htmlspecialchars
    echo $php;
}
