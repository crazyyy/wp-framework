<?php
defined( 'ABSPATH' ) or die( "you do not have access to this page!" );

/**
 * Currently only in use for TCF banner resets
 * @return array
 */
function cmplz_banner_color_schemes() {
	$schemes = array(
		'tcf'       => array(
			'colorpalette_background' => array(
				'color'  => '#ffffff',
				'border' => '#333333',
			),
			'colorpalette_text'       => array(
				'color'     => '#222222',
				'hyperlink' => '#1E73BE',
			),
			'colorpalette_toggles'    => array(
				'background' => '#61CE71',
				'bullet'     => '#ffffff',
				'inactive'   => '#f8be2e',
			),

			'colorpalette_button_accept' => array(
				'background' => '#333333',
				'border'     => '#333333',
				'text'       => '#ffffff',
			),

			'colorpalette_button_deny'     => array(
				'background' => '#ffffff',
				'border'     => '#ffffff',
				'text'       => '#333333',
			),
			'colorpalette_button_settings' => array(
				'background' => '#ffffff',
				'border'     => '#333333',
				'text'       => '#333333',
			),
		),
	);

	return $schemes;
}

function cmplz_get_banner_color_scheme_options() {
	$schemes = cmplz_banner_color_schemes();
	$schemes = array_keys( $schemes );
	$options = array();
	foreach ( $schemes as $scheme ) {
		$options[ $scheme ] = str_replace( '-', ' ', ucfirst( $scheme ) );
	}

	return $options;
}

add_filter( 'cmplz_field', 'cmplz_update_banner_text',10,2 );
function cmplz_update_banner_text($field, $field_id){
	if ( ($field_id=== 'message_optin' || $field_id === 'message_optout')
	     && cmplz_get_option( 'uses_ad_cookies_personalized' ) === 'yes' ){
		$banner_text = __( "We use technologies like cookies to store and/or access device information. We do this to improve browsing experience and to show (non-) personalized ads. Consenting to these technologies will allow us to process data such as browsing behavior or unique IDs on this site. Not consenting or withdrawing consent, may adversely affect certain features and functions.", 'complianz-gdpr' );
		$field['default'] = $banner_text;
		$field['placeholder'] = $banner_text;
	}

	return $field;
}

add_filter( 'cmplz_fields', 'cmplz_add_cookiebanner_settings', 10 );
function cmplz_add_cookiebanner_settings( $fields ) {
	$banner_text = __( "To provide the best experiences, we use technologies like cookies to store and/or access device information. Consenting to these technologies will allow us to process data such as browsing behavior or unique IDs on this site. Not consenting or withdrawing consent, may adversely affect certain features and functions.", 'complianz-gdpr' );
	$category_help = cmplz_get_option( 'country_company' ) === "FR" ? [
		'label' => 'default',
		'title' => __( "Categories in France", "complianz-gdpr" ),
		'text'  => __( "Due to the French CNIL guidelines we suggest using the Accept - Deny - View preferences template. For more information, read about the CNIL updated privacy guidelines in this %sarticle%s.",
			'complianz-gdpr' ),
		'url'   => "https://complianz.io/cnil-updated-privacy-guidelines/",
	] : false;

	$fields = array_merge( $fields,
		[
			/* ----- General ----- */

			//for condition purposes only
			[
				'id'          => 'consent_type',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target' => 'banner',
				'type'        => 'hidden',
			],
			[
				'id'          => 'title',
				'label'       => __( "Consent banner title", 'complianz-gdpr' ),
				'placeholder' => __( 'Descriptive title of the cookiebanner', 'complianz-gdpr' ),
				'tooltip'     => __( 'For internal use only', 'complianz-gdpr' ),
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target' => 'banner',
				'type'        => 'text',
			],

			[
				'id'               => 'use_categories',
				'menu_id'          => 'banner-general',
				'group_id'         => 'banner-general',
				'data_target'      => 'banner',
				'type'             => 'select',
				'options'          => array(
					'view-preferences' => __( 'Accept - Deny - View Preferences', 'complianz-gdpr' ),
					'save-preferences' => __( 'Accept - Deny - Save Preferences', 'complianz-gdpr' ),
					'no'               => __( 'Accept - Deny', 'complianz-gdpr' ),
				),
				'label'            => __( "Categories", 'complianz-gdpr' ),
				'tooltip'          => __( 'With categories, you can let users choose which category of cookies they want to accept.', 'complianz-gdpr' ) . ' '
				                      . __( 'Depending on your settings and cookies you use, there can be two or three categories. With Tag Manager you can use more, custom categories.',
						'complianz-gdpr' ),
				'help'             => $category_help,
				'default'          => 'view-preferences',
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optin',
					]
				],
			],
			[
				'id'          => 'manage_consent_options',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target' => 'banner',
				'type'        => 'select',
				'placeholder' => __( "Manage consent", 'complianz-gdpr' ),
				'label'       => __( "Manage consent display options", 'complianz-gdpr' ),
				'tooltip'     => __( 'Select how the manage consent text should appear.', 'complianz-gdpr' ),
				'options'     => array(
					'hover-hide-mobile' => __( 'Hover on Desktop - Hide on Mobile (Default)', 'complianz-gdpr' ),
					'hover-show-mobile' => __( 'Hover on Desktop - Show on Mobile', 'complianz-gdpr' ),
					'show-everywhere'   => __( 'Show everywhere', 'complianz-gdpr' ),
					'hide-everywhere'   => __( 'Hide everywhere', 'complianz-gdpr' ),
				),
				'default'     => 'hover-hide-mobile',
			],
			[
				'id'          => 'disable_cookiebanner',
				'source_id' => 'enable_cookie_banner',
				'data_target' => 'banner',
				'source_mapping' => [
					//source value => target value
					'no' => 1,
					'yes' => 0,
				],
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'type'        => 'checkbox',
				'label'       => __( "Disable consent banner", 'complianz-gdpr' ),
				'default'     => false,
			],
			[
				'id'               => 'default',
				'menu_id'          => 'banner-general',
				'group_id'         => 'banner-general',
				'data_target'      => 'banner',
				'type'             => 'checkbox',
				'label'            => __( "Default consent banner", 'complianz-gdpr' ),
				'help'             => [
					'label' => 'default',
					'title' => __( "Default consent banner", 'complianz-gdpr' ),
					'text'  => __( 'When enabled, this is the consent banner that is used for all visitors. Enabling it will disable this setting on the current default banner. Disabling it will enable randomly a different default banner.',
						"complianz-gdpr" ),
				],
				'default'          => false,
				'react_conditions' => [
					'relation' => 'AND',
					[
						'a_b_testing_buttons' => '1',
					]
				],
			],
			[
				'id'          => 'hide_preview',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target' => 'banner',
				'type'        => 'checkbox',
				'label'       => __( "Hide preview", 'complianz-gdpr' ),
				'default'     => false,
			],
			[
				'id'          => 'reset_cookiebanner',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target' => 'banner',
				'type'        => 'banner-reset-button',
				'label'       => __( "Reset to default values", 'complianz-gdpr' ),
				'button_text' => __( "Reset", 'complianz-gdpr' ),
				'help'        => [
					'label' => 'warning',
					'title' => __( "Reset the consent banner", 'complianz-gdpr' ),
					'text'  => __( "If you want to start from the default values, you can use the reset button.", "complianz-gdpr" ) . ' ' . __( "Texts will also get reset.", "complianz-gdpr" ),
				],
				'default'     => false,
			],

			/*
			 *
			 * US settings
			 *
			 * */

			[
				'id'               => 'dismiss_on_scroll',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target'      => 'banner',
				'type'             => 'checkbox',
				'label'            => __( "Dismiss on scroll", 'complianz-gdpr' ),
				'tooltip'          => __( 'When dismiss on scroll is enabled, the consent banner will be dismissed as soon as the user scrolls.', 'complianz-gdpr' ),
				'default'          => false,
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optout',
					]
				],
			],
			[
				'id'               => 'dismiss_on_timeout',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target'      => 'banner',
				'type'             => 'checkbox',
				'label'            => __( "Dismiss on time out", 'complianz-gdpr' ),
				'tooltip'          => __( 'When dismiss on time out is enabled, the consent banner will be dismissed after 10 seconds, or the time you choose below.', 'complianz-gdpr' ),
				'default'          => false,
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optout',
					]
				],
			],
			[
				'id'               => 'dismiss_timeout',
				'menu_id'     => 'banner-general',
				'group_id'    => 'banner-general',
				'data_target'      => 'banner',
				'type'             => 'number',
				'label'            => __( "Timeout in seconds", 'complianz-gdpr' ),
				'default'          => 10,
				'react_conditions' => [
					'relation' => 'AND',
					[
						'dismiss_on_timeout' => true,
						'consent_type'       => 'optout',
					]
				],
			],
			/* ----- Appearance ----- */
			[
				'id'          => 'position',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'type'        => 'select',
				'label'       => __( "Position", 'complianz-gdpr' ),
				'options'     => array(
					'center'       => __( "Center", 'complianz-gdpr' ),
					'bottom'       => __( "Bottom", 'complianz-gdpr' ),
					'bottom-left'  => __( "Bottom left", 'complianz-gdpr' ),
					'bottom-right' => __( "Bottom right", 'complianz-gdpr' ),
				),
				'default'     => 'bottom-right',
			],
			[
				'id'          => 'animation',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'type'        => 'select',
				'label'       => __( "Animation", 'complianz-gdpr' ),
				'options'     => array(
					'none'  => __( "None", 'complianz-gdpr' ),
					'fade'  => __( "Fade", 'complianz-gdpr' ),
					'slide' => __( "Slide", 'complianz-gdpr' ),
				),
				'default'     => 'none',
			],
			[
				'id'               => 'banner_width',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target'      => 'banner',
				'type'             => 'number',
				'default'          => '526',
				'minimum'          => '300',
				'maximum'          => '1500',
				'label'            => __( "Width of the banner in pixels", 'complianz-gdpr' ),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!position' => 'bottom',
					]
				],
			],

			[
				'id'               => 'checkbox_style',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target'      => 'banner',
				'type'             => 'select',
				'label'            => __( "Checkbox style", 'complianz-gdpr' ),
				'tooltip'          => __( "This style is for the checkboxes on the consent banner, as well as on your policy for managing consent.", 'complianz-gdpr' ),
				'options'          => [
					'classic' => __( "Classic", 'complianz-gdpr' ),
					'slider'  => __( "Slider", 'complianz-gdpr' ),
				],
				'default'          => 'slider',
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!use_categories' => 'no',
					]
				],
			],
			[
				'id'          => 'legal_documents',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target' => 'banner',
				'type'        => 'checkbox',
				'default'     => true,
				'label'       => __( "Legal document links on banner", 'complianz-gdpr' ),
				'comment'     => __( 'On the consent banner the generated documents are shown. The title is based on the actual post title.', 'complianz-gdpr' ),
			],
			[
				'id'          => 'use_logo',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'tooltip'     => __( "You can upload your own logo, hide it, or use the site logo.", 'complianz-gdpr' ) . ' '
				                 . __( "The site logo is the default logo set in your theme's site identity.", 'complianz-gdpr' ),
				'type'        => 'banner_logo',
				'label'       => __( "Logo", 'complianz-gdpr' ),
				'options'     => array(
					'hide'      => __( "Hide", 'complianz-gdpr' ),
					'site'      => __( "Use Site Logo", 'complianz-gdpr' ),
					'complianz' => __( "Use \"Powered by Complianz\"", 'complianz-gdpr' ),
					'custom'    => __( "Upload Custom Logo", 'complianz-gdpr' ) . ' (2 : 1)',
				),
				'default'     => 'hide',
			],
			[
				'id'          => 'logo_attachment_id',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'type'        => 'hidden',
			],
			[
				'id'          => 'close_button',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'type'        => 'checkbox',
				'label'       => __( "Close button", 'complianz-gdpr' ),
				'tooltip'     => __( "If enabled, a close icon will be shown on your consent banner.", 'complianz-gdpr' ),
				'default'     => true,
			],
			[
				'id'          => 'use_box_shadow',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'type'        => 'checkbox',
				'default'     => true,
				'label'       => __( "Box shadow", 'complianz-gdpr' ),
			],
			[
				'id'          => 'header_footer_shadow',
				'menu_id'     => 'appearance',
				'group_id'    => 'appearance',
				'data_target' => 'banner',
				'default'     => false,
				'type'        => 'checkbox',
				'label'       => __( "Box shadow on header and footer", 'complianz-gdpr' ),
			],
			[
				'id'               => 'soft_cookiewall',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target'      => 'banner',
				'type'             => 'checkbox',
				'default'          => false,
				'label'            => __( "Show as soft cookie wall", 'complianz-gdpr' ),
				'help'             => [
					'label' => 'default',
					'title' => __( "Soft cookie wall", 'complianz-gdpr' ),
					'text'  => __( "Read more about our privacy-friendly cookie wall.", 'complianz-gdpr' ),
					'url'   => 'https://complianz.io/the-soft-cookie-wall/',
				],
				'tooltip'          => __( 'After saving, a preview of the soft cookie wall will be shown for 3 seconds', 'complianz-gdpr' ),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!consent_type' => 'optout',
					]
				],
			],
			[
				'id'          => 'colorpalette_border_radius',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target' => 'banner',
				'type'        => 'borderradius',
				'default'     => array(
					'top'    => '12',
					'right'  => '12',
					'bottom' => '12',
					'left'   => '12',
					'type'   => 'px',
				),
				'label'       => __( "Border radius banner", 'complianz-gdpr' ),
			],
			[
				'id'          => 'border_width',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target' => 'banner',
				'type'        => 'borderwidth',
				'default'     => array(
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				),
				'label'       => __( "Border width banner", 'complianz-gdpr' ),
			],
			[
				'id'          => 'buttons_border_radius',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target' => 'banner',
				'type'        => 'borderradius',
				'default'     => array(
					'top'    => '6',
					'right'  => '6',
					'bottom' => '6',
					'left'   => '6',
					'type'   => 'px',
				),
				'label'       => __( "Border radius buttons", 'complianz-gdpr' ),
			],
			[
				'id'          => 'font_size',
				'menu_id'          => 'appearance',
				'group_id'         => 'appearance',
				'data_target' => 'banner',
				'type'        => 'number',
				'default'     => 12,
				'label'       => __( "Font size", 'complianz-gdpr' ),
			],

			/* ----- colors ----- */

			[
				'id'           => 'colorpalette_background',
				'menu_id'      => 'colors',
				'group_id'     => 'colors-general',
				'data_target'  => 'banner',
				'type'         => 'colorpicker',
				'master_label' => __( "General", 'complianz-gdpr' ),
				'label'        => __( "Background", 'complianz-gdpr' ),
				'default'      => array(
					'color'  => '#ffffff',
					'border' => '#f2f2f2',
				),
				'fields'       => array(
					array(
						'fieldname' => 'color',
						'label'     => __( "Background", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'border',
						'label'     => __( "Border", 'complianz-gdpr' ),
					),
				),
			],
			[
				'id'          => 'colorpalette_text',
				'menu_id'      => 'colors',
				'group_id'     => 'colors-general',
				'data_target' => 'banner',
				'type'        => 'colorpicker',
				'label'       => __( "Text", 'complianz-gdpr' ),
				'default'     => array(
					'color'     => '#222222',
					'hyperlink' => '#1E73BE',
				),
				'fields'      => array(
					array(
						'fieldname' => 'color',
						'label'     => __( "Color", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'hyperlink',
						'label'     => __( "Hyperlink", 'complianz-gdpr' ),
					),
				),
			],
			[
				'id'          => 'colorpalette_toggles',
				'menu_id'      => 'colors',
				'group_id'     => 'colors-toggles',
				'data_target' => 'banner',
				'type'        => 'colorpicker',
				'label'       => __( "Toggles", 'complianz-gdpr' ),
				'default'     => array(
					'background' => '#1e73be',
					'bullet'     => '#ffffff',
					'inactive'   => '#F56E28',
				),
				'fields'      => array(
					array(
						'fieldname' => 'background',
						'label'     => __( "Background", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'bullet',
						'label'     => __( "Bullet", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'inactive',
						'label'     => __( "Inactive", 'complianz-gdpr' ),
					),
				),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'checkbox_style' => 'slider',
					]
				],
			],
			[
				'id'          => 'colorpalette_button_accept',
				'menu_id'      => 'colors',
				'group_id'     => 'colors-buttons',
				'data_target' => 'banner',
				'type'        => 'colorpicker',
				'label'       => __( "Accept", 'complianz-gdpr' ),
				'default'     => array(
					'background' => '#1E73BE',
					'border'     => '#1E73BE',
					'text'       => '#ffffff',
				),
				'fields'      => array(
					array(
						'fieldname' => 'background',
						'label'     => __( "Background", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'border',
						'label'     => __( "Border", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'text',
						'label'     => __( "Text", 'complianz-gdpr' ),
					),
				),
			],
			[
				'id'               => 'colorpalette_button_deny',
				'menu_id'          => 'colors',
				'group_id'         => 'colors-buttons',
				'data_target'      => 'banner',
				'type'             => 'colorpicker',
				'label'            => __( "Deny", 'complianz-gdpr' ),
				'default'          => array(
					'background' => '#f9f9f9',
					'border'     => '#f2f2f2',
					'text'       => '#222222',
				),
				'fields'           => array(
					array(
						'fieldname' => 'background',
						'label'     => __( "Background", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'border',
						'label'     => __( "Border", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'text',
						'label'     => __( "Text", 'complianz-gdpr' ),
					),
				),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!consent_type' => 'optout',
					]
				],
			],
			[
				'id'               => 'colorpalette_button_settings',
				'menu_id'          => 'colors',
				'group_id'         => 'colors-buttons',
				'data_target'      => 'banner',
				'type'             => 'colorpicker',
				'label'            => __( "Settings", 'complianz-gdpr' ),
				'default'          => array(
					'background' => '#f9f9f9',
					'border'     => '#f2f2f2',
					'text'       => '#333333',
				),
				'fields'           => array(
					array(
						'fieldname' => 'background',
						'label'     => __( "Background", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'border',
						'label'     => __( "Border", 'complianz-gdpr' ),
					),
					array(
						'fieldname' => 'text',
						'label'     => __( "Text", 'complianz-gdpr' ),
					),
				),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!consent_type' => 'optout',
					]
				],
			],
			/* ----- Custom CSS ----- */
			[
				'id'                => 'disable_width_correction',
				'menu_id'           => 'custom-css',
				'group_id'          => 'custom-css',
				'data_target'       => 'banner',
				'type'              => 'checkbox',
				'label'             => __( "Disable width auto correction", 'complianz-gdpr' ),
				'default'           => false,
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_tcf_active()' => false,
					]
				],
				'tooltip'           => __( 'This will disable a back-end javascript to keep the banner width aligned with other elements.', 'complianz-gdpr' ),
			],
			[
				'id'          => 'use_custom_cookie_css',
				'menu_id'          => 'custom-css',
				'group_id'         => 'custom-css',
				'data_target' => 'banner',
				'type'        => 'checkbox',
				'label'       => __( "Use Custom CSS", 'complianz-gdpr' ),
				'default'     => false,
				'comment'     => __( "Custom CSS is not recommended for publishers that use TCF and additional frameworks due to strict guidelines.", "complianz-gdpr" ),
			],
			[
				'id'               => 'custom_css',
				'menu_id'          => 'custom-css',
				'group_id'         => 'custom-css',
				'data_target'      => 'banner',
				'type'             => 'css',
				'help'             => [
					'label' => 'default',
					'title' => __( "Custom CSS", 'complianz-gdpr' ),
					'text'  => __( 'You can add additional custom CSS here. For tips and CSS lessons, check out our documentation.', 'complianz-gdpr' ),
					'url'   => 'https://complianz.io/?s=css',
				],
				'condition_action' => 'disable',
				'react_conditions' => [
					'relation' => 'AND',
					[
						'use_custom_cookie_css' => true,
					]
				],
				'label'            => '',
				'default'          => '/* Container */'
				                      . "\n" . '.cmplz-cookiebanner{}'
				                      . "\n"
				                      . "\n" . '/* Logo */'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-logo{}'
				                      . "\n" . '/* Title */'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-title{}'
				                      . "\n" . '/* Close icon */'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-close{}'
				                      . "\n"
				                      . "\n" . '/* Message */'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-message{}'
				                      . "\n"
				                      . "\n" . ' /* All buttons */'
				                      . "\n" . '.cmplz-buttons .cmplz-btn{}'
				                      . "\n" . '/* Accept button */'
				                      . "\n" . '.cmplz-btn .cmplz-accept{} '
				                      . "\n" . ' /* Deny button */'
				                      . "\n" . '.cmplz-btn .cmplz-deny{}'
				                      . "\n" . ' /* Save preferences button */'
				                      . "\n" . '.cmplz-btn .cmplz-deny{}'
				                      . "\n" . ' /* View preferences button */'
				                      . "\n" . '.cmplz-btn .cmplz-deny{}'
				                      . "\n"
				                      . "\n" . ' /* Document hyperlinks */'
				                      . "\n" . '.cmplz-links .cmplz-documents{}'
				                      . "\n"
				                      . "\n" . ' /* Categories */'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-category{}'
				                      . "\n" . '.cmplz-cookiebanner .cmplz-category-title{} '
				                      . "\n"
				                      . "\n" . '/* Manage consent tab */'
				                      . "\n" . '#cmplz-manage-consent .cmplz-manage-consent{} '
				                      . "\n"
				                      . "\n" . '/* Soft cookie wall */'
				                      . "\n" . '.cmplz-soft-cookiewall{}'
				                      . "\n"
				                      . "\n" . '/* Placeholder button - Per category */'
				                      . "\n" . '.cmplz-blocked-content-container .cmplz-blocked-content-notice{}'
				                      . "\n"
				                      . "\n" . '/* Placeholder button & message - Per service */'
				                      . "\n" . '.cmplz-blocked-content-container .cmplz-blocked-content-notice,' .
				                      "\n" . '.cmplz-blocked-content-notice{}'
				                      . "\n" . 'button.cmplz-accept-service{}'
				                      . "\n"
				                      . "\n" . "/* Styles for the AMP notice */"
				                      . "\n" . '#cmplz-consent-ui, #cmplz-post-consent-ui {}'
				                      . "\n" . '/* Message */'
				                      . "\n" . '#cmplz-consent-ui .cmplz-consent-message {}'
				                      . "\n" . '/* Buttons */'
				                      . "\n" . '#cmplz-consent-ui button, #cmplz-post-consent-ui button {}',
			],
			[
				'id'          => 'revoke',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target' => 'banner',
				'type'        => 'text',
				'default'     => __( "Manage consent", 'complianz-gdpr' ),
				'placeholder' => __( "Manage consent", 'complianz-gdpr' ),
				'label'       => __( "Text on the manage consent tab", 'complianz-gdpr' ),
				'tooltip'     => __( 'The tab will show after the visitor interacted with the banner, and can be used to make the consent banner reappear.', 'complianz-gdpr' ),
			],
			[
				'id'          => 'header',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target' => 'banner',
				'type'        => 'text_checkbox',
				'label'       => __( "Header", 'complianz-gdpr' ),
				'placeholder' => __( "Manage Consent", 'complianz-gdpr' ),
				'default'     => [ 'text' => __( "Manage Consent", 'complianz-gdpr' ), 'show' => true ],
			],
			[
				'id'               => 'accept',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'      => 'banner',
				'type'             => 'text',
				'default'          => __( "Accept", 'complianz-gdpr' ),
				'label'            => __( "Accept button", 'complianz-gdpr' ),
				'placeholder'      => __( "Accept", 'complianz-gdpr' ),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optin',
					]
				],
			],
			[
				'id'                 => 'accept_informational',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'        => 'banner',
				'type'               => 'text_checkbox',
				'default'            => [ 'text' => __( "Accept", 'complianz-gdpr' ), 'show' => true ],
				'label'              => __( "Accept button", 'complianz-gdpr' ),
				'placeholder'        => __( "Accept", 'complianz-gdpr' ),
				'callback_condition' => 'cmplz_uses_optout',
				'react_conditions'   => [
					'relation' => 'AND',
					[
						'consent_type' => 'optout',
					]
				],
			],

			[
				'id'               => 'dismiss',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'      => 'banner',
				'type'             => 'text_checkbox',
				'default'          => [ 'text' => __( "Deny", 'complianz-gdpr' ), 'show' => true ],
				'label'            => __( "Deny button", 'complianz-gdpr' ),
				'placeholder'      => __( "Deny", 'complianz-gdpr' ),
				'help'             => [
					'label' => 'default',
					'title' => __( 'Deny button', 'complianz-gdpr' ),
					'text'  => __( 'This button will reject all cookies except necessary cookies, and dismisses the consent banner.', 'complianz-gdpr' ),
				],
				'react_conditions' => [
					'relation' => 'AND',
					[
						'!consent_type' => 'optout',
					]
				],
			],
			[
				'id'                => 'view_preferences',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text',
				'default'           => __( "View preferences", 'complianz-gdpr' ),
				'label'             => __( "View preferences", 'complianz-gdpr' ),
				'placeholder'       => __( "View preferences", 'complianz-gdpr' ),
				'react_conditions'  => [
					'relation' => 'AND',
					[
						'use_categories' => 'view-preferences',
						'consent_type'   => 'optin',
					]
				],
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_optin()' => true,
					]
				],
			],
			[
				'id'                => 'save_preferences',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text',
				'default'           => __( "Save preferences", 'complianz-gdpr' ),
				'placeholder'       => __( "Save preferences", 'complianz-gdpr' ),
				'label'             => __( "Save preferences", 'complianz-gdpr' ),
				'react_conditions'  => [
					'relation' => 'AND',
					[
//						'use_categories' => 'view-preferences',
						'consent_type' => 'optin',
					]
				],
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_optin()' => true,
					]
				],
			],
			[
				'id'               => 'message_optin',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'      => 'banner',
				'type'             => 'editor',
				'default'          => $banner_text,
				'label'            => __( "Cookie message", 'complianz-gdpr' ),
				'placeholder'      => $banner_text,
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optin',
					]
				],
			],

			/* ----- Categories ----- */
			[
				'id'          => 'category_functional',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target' => 'banner',
				'type'        => 'text',
				'default'     => __( "Functional", 'complianz-gdpr' ),
				'placeholder' => __( "Functional", 'complianz-gdpr' ),
				'label'       => __( "Functional", 'complianz-gdpr' ),
			],

			[
				'id'          => 'functional_text',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target' => 'banner',
				'type'        => 'text_checkbox',
				'default'     => [
					'text' => __( "The technical storage or access is strictly necessary for the legitimate purpose of enabling the use of a specific service explicitly requested by the subscriber or user, or for the sole purpose of carrying out the transmission of a communication over an electronic communications network.",
						'complianz-gdpr' ),
					'show' => true
				],
				'label'       => __( "Functional description", 'complianz-gdpr' ),
			],
			[
				'id'                => 'category_prefs',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [ 'text' => __( "Preferences", 'complianz-gdpr' ), 'show' => true ],
				'placeholder'       => __( "Preferences", 'complianz-gdpr' ),
				'label'             => __( "Preferences", 'complianz-gdpr' ),
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_preferences_cookies()' => true,
					]
				],
			],
			[
				'id'                => 'preferences_text',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [
					'text' => __( "The technical storage or access is necessary for the legitimate purpose of storing preferences that are not requested by the subscriber or user.",
						'complianz-gdpr' ),
					'show' => true
				],
				'label'             => __( "Preferences description", 'complianz-gdpr' ),
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_preferences_cookies()' => true,
					]
				],
			],
			[
				'id'          => 'category_stats',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target' => 'banner',
				'type'        => 'text_checkbox',
				'default'     => [ 'text' => __( "Statistics", 'complianz-gdpr' ), 'show' => true ],
				'label'       => __( "Statistics", 'complianz-gdpr' ),
				'placeholder' => __( "Statistics", 'complianz-gdpr' ),
			],
			[
				'id'                => 'statistics_text',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [ 'text' => __( "The technical storage or access that is used exclusively for statistical purposes.", 'complianz-gdpr' ), 'show' => true ],
				'label'             => __( "Statistics description", 'complianz-gdpr' ),
				'react_conditions'  => [
					'relation' => 'AND',
					[
						'category_stats' => true,
					]
				],
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_statistics_privacy_friendly()' => false,
					]
				],
			],

			[
				'id'                => 'statistics_text_anonymous',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [
					'text' => __( "The technical storage or access that is used exclusively for anonymous statistical purposes. Without a subpoena, voluntary compliance on the part of your Internet Service Provider, or additional records from a third party, information stored or retrieved for this purpose alone cannot usually be used to identify you.",
						'complianz-gdpr' ),
					'show' => true
				],
				'label'             => __( "Anonymous statistics description", 'complianz-gdpr' ),
				'react_conditions'  => [
					'relation' => 'AND',
					[
						'category_stats' => true,
					]
				],
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_statistics_privacy_friendly()' => true,
					]
				],
			],
			[
				'id'                => 'category_all',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [ 'text' => __( "Marketing", 'complianz-gdpr' ), 'show' => true ],
				'label'             => __( "Marketing", 'complianz-gdpr' ),
				'placeholder'       => __( "Marketing", 'complianz-gdpr' ),
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_marketing_cookies()' => true,
					]
				],
			],
			[
				'id'                => 'marketing_text',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'       => 'banner',
				'type'              => 'text_checkbox',
				'default'           => [
					'text' => __( "The technical storage or access is required to create user profiles to send advertising, or to track the user on a website or across several websites for similar marketing purposes.",
						'complianz-gdpr' ),
					'show' => true
				],
				'label'             => __( "Marketing description", 'complianz-gdpr' ),
				'react_conditions'  => [
					'relation' => 'AND',
					[
						'category_all' => true,
					]
				],
				'server_conditions' => [
					'relation' => 'AND',
					[
						'cmplz_uses_marketing_cookies()' => true,
					]
				],
			],
			[
				'id'               => 'message_optout',
				'menu_id'     => 'banner-texts',
				'group_id'    => 'banner-texts',
				'data_target'      => 'banner',
				'type'             => 'editor',
				'default'          => $banner_text,
				'placeholder'      => $banner_text,
				'label'            => __( "Cookie message", 'complianz-gdpr' ),
				'react_conditions' => [
					'relation' => 'AND',
					[
						'consent_type' => 'optout',
					]
				],
			],
		]
	);
	return apply_filters('cmplz_banner_fields', $fields);
}
