<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ACFTC_Location_Registration extends ACF_Admin_Tool {

	/**
	 * This function will initialize the admin tool
	 */
	function initialize() {
		$this->name  = 'acftc_location_registration';
		$this->title = __( 'Register ACF Blocks or Options Pages', 'acf-theme-code' );
	}

	/**
	 * Output the metabox HTML
	 */
	function html() {

?><p><?php sprintf(
    /* translators: %s: functions.php */
    __( 'The code generated below will need to be included in your %s file (or similar).', 'acf-theme-code' ),
    'functions.php'
); ?></p>

<div class="acftc-tool-inputs">

	<div class="acftc-field acftc-field--top">

		<div class="acftc-label">
			<label for="acftc-registration-option"><?php _e( 'Location', 'acf-theme-code' ); ?></label>
		</div>

		<div class="acftc-input">
			<select id="acftc-registration-option" class="" data-ui="0" data-ajax="0" data-multiple="0" data-placeholder="Select" data-allow_null="0">
				<option value="acftc-register-block"><?php _e( 'Block', 'acf-theme-code' ); ?></option>
				<option value="acftc-register-options"><?php _e( 'Options', 'acf-theme-code' ); ?></option>
			</select>
		</div>

	</div>

	<!-- block wrapper -->
	<div id="acftc-register-block" class="registration-wrap registration-wrap--active">

		<!-- block name -->
		<div class="acftc-tool-inputs">

			<div class="acftc-field">

				<div class="acftc-label">
					<label><?php _e( 'Block Name', 'acf-theme-code' ); ?></label>
				</div>

				<div class="acftc-input">
					<input type="text" id="acf_block_name" name="acf_block_name" value="Example">
				</div>

			</div>

<div class="acf-block-code-hidden">add_action( 'acf/init', 'register_<span class="acf-tc-block-name--lower-underscores">example</span>_block' );
function register_<span class="acf-tc-block-name--lower-underscores">example</span>_block() {

	if ( function_exists( 'acf_register_block_type' ) ) {

		// <?php _e( 'Register', 'acf-theme-code' ); ?> <span class="acf-tc-block-name--raw">Example</span> <?php _e( 'block', 'acf-theme-code' ); ?>

		acf_register_block_type( array(
			'name' 					=> '<span class="acf-tc-block-name--lower-dashes">example</span>',
			'title' 				=> __( '<span class="acf-tc-block-name--raw">Example</span>' ),
			'description' 			=> __( '<?php _e( 'A custom', 'acf-theme-code' ); ?> <span class="acf-tc-block-name--raw">Example</span> <?php _e( 'block', 'acf-theme-code' ); ?>.' ),
			'category' 				=> 'formatting',
			'icon'					=> 'layout',
			'keywords'				=> array( '<span class="acf-tc-block-name--lower-keywords">example</span>' ),
			'post_types'			=> array( 'post', 'page' ),
			'mode'					=> 'auto',
			// 'align'				=> 'wide',
			'render_template'		=> 'template-parts/blocks/<span class="acf-tc-block-name--lower-dashes">example</span>.php',
			// 'render_callback'	=> '<span class="acf-tc-block-name--lower-underscores">example</span>_block_render_callback',
			// 'enqueue_style' 		=> get_template_directory_uri() . '/template-parts/blocks/<span class="acf-tc-block-name--lower-dashes">example</span>/<span class="acf-tc-block-name--lower-dashes">example</span>.css',
			// 'enqueue_script' 	=> get_template_directory_uri() . '/template-parts/blocks/<span class="acf-tc-block-name--lower-dashes">example</span>/<span class="acf-tc-block-name--lower-dashes">example</span>.js',
			// 'enqueue_assets' 	=> '<span class="acf-tc-block-name--lower-underscores">example</span>_block_enqueue_assets',
		));

	}

}</div>

			<!-- block registration output -->
			<div class="acftc-field-meta">
				<span class="acftc-field-meta__title" data-type="link" data-pseudo-content="<?php _e( 'Register a Gutenberg Block', 'acf-theme-code' ) ?>"></span>
			</div>

			<div id="acftc-block-code-output" class="acftc-field-code">
				<a href="#" class="acftc-field__copy acf-js-tooltip" title="<?php _e( 'Copy to clipboard', 'acf-theme-code' ) ?>"></a>
				<pre class="line-numbers language-php"><code id="acftc-block-code-output-code"></code></pre>
			</div>

		</div><!-- block -->

	</div>

	<!-- options -->
	<div id="acftc-register-options" class="registration-wrap">

		<div class="acftc-tool-inputs">

			<div class="acftc-field">

				<div class="acftc-label">
					<label><?php _e( 'Page Name', 'acf-theme-code' ) ?></label>
				</div>

				<div class="acftc-input">
					<input type="text" id="acf_option_name" name="acf_option_name" value="Options">
				</div>

			</div>

<div class="acf-option-code-hidden">if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title'	=> '<span class="acf-tc-option-name--raw">Options</span>',
		'menu_title'	=> '<span class="acf-tc-option-name--raw">Options</span>',
		'menu_slug' 	=> 'acf-<span class="acf-tc-option-name--lower-dashes">options</span>',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
	));

}</div>

			<!-- option registration output -->
			<div class="acftc-field-meta">
				<span class="acftc-field-meta__title" data-type="link" data-pseudo-content="<?php _e( 'Register an Options Page', 'acf-theme-code' ) ?>"></span>
			</div>

			<div id="acftc-option-code-output" class="acftc-field-code">
				<a href="#" class="acftc-field__copy acf-js-tooltip" title="<?php _e( 'Copy to clipboard', 'acf-theme-code' ) ?>"></a>
				<pre class="line-numbers language-php"><code id="acftc-option-code-output-code"></code></pre>
			</div>

		</div>

	</div>

</div>
<?php
	
	}

}
