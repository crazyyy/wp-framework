<?php

namespace Simple_History\Dropins;

use Simple_History\Helpers;

/**
 * Dropin Name: Debug
 * Dropin Description: Add some extra info to each logged context when SIMPLE_HISTORY_LOG_DEBUG is set and true, or when Detective mode is enabled.
 */
class Detective_Mode_Dropin extends Dropin {
	/** @inheritdoc */
	public function loaded() {
		$this->register_settings();

		add_action( 'simple_history/settings_page/general_section_output', [ $this, 'on_general_section_output' ] );

		// Bail if no debug mode is active.
		if ( ! Helpers::log_debug_is_enabled() && ! Helpers::detective_mode_is_enabled() ) {
			return;
		}

		add_action( 'simple_history/log_argument/context', array( $this, 'append_debug_info_to_context' ), 10, 4 );
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		$settings_general_option_group = $this->simple_history::SETTINGS_GENERAL_OPTION_GROUP;

		// Checkbox for debug setting that logs extra much info.
		register_setting(
			$settings_general_option_group,
			'simple_history_detective_mode_enabled',
			[
				'sanitize_callback' => [ Helpers::class, 'sanitize_checkbox_input' ],
			]
		);
	}

	/**
	 * Add settings field.
	 *
	 * Function fired from action `simple_history/settings_page/general_section_output`.
	 */
	public function on_general_section_output() {
		$settings_section_general_id = $this->simple_history::SETTINGS_SECTION_GENERAL_ID;
		$settings_menu_slug = $this->simple_history::SETTINGS_MENU_SLUG;

		add_settings_field(
			'simple_history_debug',
			Helpers::get_settings_field_title_output( __( 'Detective mode', 'simple-history' ), 'mystery' ),
			[ $this, 'settings_field_detective_mode' ],
			$settings_menu_slug,
			$settings_section_general_id
		);
	}

	/**
	 * Settings field output.
	 */
	public function settings_field_detective_mode() {
		$detective_mode_enabled = Helpers::detective_mode_is_enabled();
		?>
		<label>
			<input <?php checked( $detective_mode_enabled ); ?> type="checkbox" value="1" name="simple_history_detective_mode_enabled" />
			<?php esc_html_e( 'Enable detective mode', 'simple-history' ); ?>
		</label>
		
		<p class="description">
			<?php
			echo wp_kses(
				__( 'When enabled, Detective Mode captures in-depth data for each event, including the current <code>$_GET</code>, <code>$_POST</code> values, the current filter name, and much more.', 'simple-history' ),
				[
					'code' => [],
				]
			);
			?>
		</p>

		<p class="description">
			<?php esc_html_e( 'While particularly useful for developers and administrators seeking to understand complex interactions or resolve issues, please note that enabling this feature may increase the volume of logged data.', 'simple-history' ); ?>
		</p>

		<p class="description">
			<a href="https://simple-history.com/support/detective-mode/?utm_source=wpadmin" target="_blank" class="sh-ExternalLink">
				<?php esc_html_e( 'Read more about detective mode', 'simple-history' ); ?>
			</a>
		</p>
		<?php
	}

	/**
	 * Modify the context to add debug information.
	 *
	 * @param array                                 $context Context array.
	 * @param string                                $level Log level.
	 * @param string                                $message Log message.
	 * @param \Simple_History\Loggers\Simple_Logger $logger Logger instance.
	 */
	public function append_debug_info_to_context( $context, $level, $message, $logger ) {
		global $wp_current_filter;

		$context_key_prefix = 'detective_mode_';
		$detective_mode_data = [];

		// Keys from $_SERVER to add to context.
		$arr_server_keys_to_add = [
			'HTTP_HOST',
			'REQUEST_URI',
			'REQUEST_METHOD',
			'CONTENT_TYPE',
			'SCRIPT_FILENAME',
			'SCRIPT_NAME',
			'PHP_SELF',
			'HTTP_ORIGIN',
			'CONTENT_TYPE',
			'HTTP_USER_AGENT',
			'REMOTE_ADDR',
			'REQUEST_TIME',
		];

		foreach ( $arr_server_keys_to_add as $key ) {
			if ( isset( $_SERVER[ $key ] ) ) {
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				$detective_mode_data[ 'server_' . strtolower( $key ) ] = wp_unslash( $_SERVER[ $key ] );
			}
		}

		// Copy of posted data, because we may remove sensitive data.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$posted_data = $_POST;
		$post_raw = file_get_contents( 'php://input' );

		// Remove sensitive data, like user password.
		if ( did_filter( 'wp_authenticate_user' ) !== 0 && isset( $posted_data['pwd'] ) ) {
			$post_raw = str_replace( '&pwd=' . $posted_data['pwd'], '&pwd=***', $post_raw );
			$posted_data['pwd'] = '***';
		}

		$detective_mode_data += [
			'get' => $_GET,
			'post' => $posted_data,
			'post_raw' => $post_raw,
			'files' => $_FILES, // phpcs:ignore WordPress.Security.NonceVerification.Missing
			'current_filter' => implode( ', ', $wp_current_filter ?? [] ),
			'debug_backtrace' => wp_debug_backtrace_summary( null, 0, true ),
			'is_admin' => is_admin(),
			'doing_ajax' => defined( 'DOING_AJAX' ) && DOING_AJAX,
			'doing_cron' => defined( 'DOING_CRON' ) && DOING_CRON,
			'wp_cli' => defined( 'WP_CLI' ) && WP_CLI,
			'is_multisite' => is_multisite(),
			'php_sapi_name' => php_sapi_name(),
		];

		// Command line arguments. Used by for example WP-CLI.
		if ( isset( $GLOBALS['argv'] ) ) {
			$detective_mode_data['command_line_arguments'] = implode( ' ', $GLOBALS['argv'] );
		}

		// Add all detective mode data to context, with a prefix.
		foreach ( $detective_mode_data as $key => $value ) {
			$context[ $context_key_prefix . $key ] = $value;
		}

		return $context;
	}
}
