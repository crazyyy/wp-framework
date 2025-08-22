<?php

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WPO_Page_Optimizer')) :
class WPO_Page_Optimizer {

	/**
	 * Instance of this class
	 *
	 * @var null|WPO_Page_Optimizer
	 */
	private static $instance = null;

	/**
	 * Get the buffer and perform tasks related to page optimization
	 *
	 * @param  string $buffer Page HTML.
	 * @param  int    $flags  OB flags to be passed through.
	 *
	 * @return string
	 */
	private function optimize(string $buffer, int $flags): string {
		$buffer = apply_filters('wp_optimize_buffer', $buffer);
		
		$buffer = $this->maybe_cache_page($buffer, $flags);
	
		return $buffer;
	}

	/**
	 * Cache the page if the page cache enabled
	 *
	 * @param  string $buffer Page HTML.
	 * @param  int    $flags  OB flags to be passed through.
	 *
	 * @return string
	 */
	private function maybe_cache_page(string $buffer, int $flags): string {
		
		if (!$this->is_wp_cli() && WP_Optimize()->get_page_cache()->should_cache_page()) {
			return wpo_cache($buffer, $flags);
		}

		return $buffer;
	}

	/**
	 * Initialise output buffer handler.
	 *
	 * @return void
	 */
	public function initialise() {
		ob_start(array(self::$instance, 'optimize'));
	}

	/**
	 * Checks if the current execution context is WP-CLI.
	 *
	 * @return bool
	 */
	public function is_wp_cli(): bool {
		return defined( 'WP_CLI' ) && WP_CLI;
	}

	/**
	 * Returns singleton instance of WPO_Page_Optimizer
	 *
	 * @return WPO_Page_Optimizer
	 */
	public static function instance(): WPO_Page_Optimizer {
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

endif;
