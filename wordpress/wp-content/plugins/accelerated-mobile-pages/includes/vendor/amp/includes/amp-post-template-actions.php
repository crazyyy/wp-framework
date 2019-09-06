<?php
namespace AMPforWP\AMPVendor;
// Callbacks for adding content to an AMP template

add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_title' );
function amp_post_template_add_title( $amp_template ) {
	?>
	<title><?php echo esc_html( $amp_template->get( 'document_title' ) ); ?></title>
	<?php
}

add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_canonical' );
function amp_post_template_add_canonical( $amp_template ) {
	?>
	<link rel="canonical" href="<?php echo esc_url( apply_filters('ampforwp_modify_rel_url',$amp_template->get( 'canonical_url' ) ) ); ?>" />
   <?php
}
add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_meta_generator' );
function amp_post_template_add_meta_generator() {
	?>
	<meta name="generator" content="AMP for WP <?php echo esc_attr(AMPFORWP_VERSION) ?>" />
<?php
}

add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_scripts' );
function amp_post_template_add_scripts( $amp_template ) {
	$scripts = $amp_template->get( 'amp_component_scripts', array() );
	foreach ( $scripts as $element => $script ) : 
		$custom_type = ($element == 'amp-mustache') ? 'template' : 'element'; ?>
		<script custom-<?php echo esc_attr( $custom_type ); ?>="<?php echo esc_attr( $element ); ?>" src="<?php echo esc_url( $script ); ?>" async></script>
	<?php endforeach; ?>
	<script src="<?php echo esc_url( $amp_template->get( 'amp_runtime_script' ) ); ?>" async></script>
	<?php
}

add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_fonts' );
function amp_post_template_add_fonts( $amp_template ) {
	$font_urls = $amp_template->get( 'font_urls', array() );
	foreach ( $font_urls as $slug => $url ) : ?>
		<link rel="stylesheet" href="<?php echo esc_url( $url ); ?>">
	<?php endforeach;
}

add_action( 'amp_post_template_head', 'AMPforWP\\AMPVendor\\amp_post_template_add_boilerplate_css' );
function amp_post_template_add_boilerplate_css( $amp_template ) {
	?>
	<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
	<?php
}
if(!function_exists('ampforwp_with_scheme_app_output') && !function_exists('saswp_schema_markup_output') && ( ampforwp_get_setting('ampforwp-seo-selection') != "rank_math" || ! ampforwp_get_setting('ampforwp-seo-rank_math-schema')) && ! class_exists('SQ_Classes_ObjController') ):
add_action( 'amp_post_template_footer', 'AMPforWP\\AMPVendor\\amp_post_template_add_schemaorg_metadata' );
function amp_post_template_add_schemaorg_metadata( $amp_template ) {
	$metadata = $amp_template->get( 'metadata' );
	if ( empty( $metadata ) ) {
		return;
	}
	if( (ampforwp_get_setting('ampforwp-seo-yoast-schema') == false && ampforwp_get_setting('ampforwp-seo-selection') == 'yoast') || empty(ampforwp_get_setting('ampforwp-seo-selection')) ){
	?>
	<script type="application/ld+json"><?php echo wp_json_encode( $metadata ); ?></script>
	<?php
	}
}
endif;

add_action( 'amp_post_template_css', 'AMPforWP\\AMPVendor\\amp_post_template_add_styles', 99 );
function amp_post_template_add_styles( $amp_template ) {
	$styles = $amp_template->get( 'post_amp_styles' );
	if ( ! empty( $styles ) ) {
		echo '/* Inline styles */' . PHP_EOL;
		foreach ( $styles as $selector => $declarations ) {
			$declarations = implode( ';', $declarations ) . ';';
			printf( '%1$s{%2$s}', $selector, $declarations );
		}
	}
}

add_action( 'amp_post_template_data', 'AMPforWP\\AMPVendor\\amp_post_template_add_analytics_script' );
function amp_post_template_add_analytics_script( $data ) {
	if ( ! empty( $data['amp_analytics'] ) ) {
		$data['amp_component_scripts']['amp-analytics'] = 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js';
	}
	return $data;
}

add_action( 'amp_post_template_footer', 'AMPforWP\\AMPVendor\\amp_post_template_add_analytics_data' );
function amp_post_template_add_analytics_data( $amp_template ) {
	$analytics_entries = $amp_template->get( 'amp_analytics' );
	if ( empty( $analytics_entries ) ) {
		return;
	}

	foreach ( $analytics_entries as $id => $analytics_entry ) {
		if ( ! isset( $analytics_entry['type'], $analytics_entry['attributes'], $analytics_entry['config_data'] ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( 'Analytics entry for %s is missing one of the following keys: `type`, `attributes`, or `config_data` (array keys: %s)', 'accelerated-mobile-pages' ), esc_html( $id ), esc_html( implode( ', ', array_keys( $analytics_entry ) ) ) ), '0.3.2' );
			continue;
		}

		$script_element = AMP_HTML_Utils::build_tag( 'script', array(
			'type' => 'application/json',
		), wp_json_encode( $analytics_entry['config_data'] ) );

		$amp_analytics_attr = array_merge( array(
			'id' => $id,
			'type' => $analytics_entry['type'],
		), $analytics_entry['attributes'] );

		echo AMP_HTML_Utils::build_tag( 'amp-analytics', $amp_analytics_attr, $script_element );
	}
}
