<?php
/*
 +=====================================================================+
 |    ____          _        ____             __ _ _                   |
 |   / ___|___   __| | ___  |  _ \ _ __ ___  / _(_) | ___ _ __         |
 |  | |   / _ \ / _` |/ _ \ | |_) | '__/ _ \| |_| | |/ _ \ '__|        |
 |  | |__| (_) | (_| |  __/ |  __/| | | (_) |  _| | |  __/ |           |
 |   \____\___/ \__,_|\___| |_|   |_|  \___/|_| |_|_|\___|_|           |
 |                                                                     |
 |  (c) Jerome Bruandet ~ https://code-profiler.com/                   |
 +=====================================================================+
*/

if (! defined('ABSPATH') ) { die('Forbidden'); }

// =====================================================================

class CodeProfiler_Profiler {

	static $tick_list;
	static $buffer;
	static $metrics;
	static $fh;
	static $connections_list = [];
	static $connections_start;
	private $tmp_iostats;
	private $tmp_summary;
	private $tmp_diskio;
	private $tmp_calls;

	/**
	 * Initialize
	 */
	public function __construct() {

		$microtime = sanitize_file_name( $_REQUEST['CODE_PROFILER_ON'] );

		$this->tmp_summary 		= CODE_PROFILER_UPLOAD_DIR ."/$microtime." .
											CODE_PROFILER_TMP_SUMMARY_LOG;
		$this->tmp_iostats 		= CODE_PROFILER_UPLOAD_DIR ."/$microtime." .
											CODE_PROFILER_TMP_IOSTATS_LOG;
		$this->tmp_calls   		= CODE_PROFILER_UPLOAD_DIR ."/$microtime." .
											CODE_PROFILER_TMP_CALLS_LOG;
		$this->tmp_diskio  		= CODE_PROFILER_UPLOAD_DIR ."/$microtime." .
											CODE_PROFILER_TMP_DISKIO_LOG;
		$this->tmp_connections	= CODE_PROFILER_UPLOAD_DIR ."/$microtime." .
											CODE_PROFILER_TMP_CONNECTIONS_LOG;

		if ( function_exists('hrtime') ) {
			// PHP >=7.3
			self::$metrics = 'hrtime';
		} else {
			self::$metrics = 'microtime';
		}

		// Select theme (stylesheet::template)
		if (! empty( $_SERVER['HTTP_THEME'] ) ) {

			$theme = explode('::', $_SERVER['HTTP_THEME'] );
			if (! empty( $theme[1] ) ) {
				define('CODE_PROFILER_STYLESHEET',	sanitize_file_name( $theme[0] ) );
				define('CODE_PROFILER_TEMPLATE',		sanitize_file_name( $theme[1] ) );

				if ( is_file( WP_CONTENT_DIR .'/themes/'. CODE_PROFILER_STYLESHEET .'/style.css' ) ) {

					add_filter('pre_option_template', function () {
						return CODE_PROFILER_TEMPLATE;
					}, 1000 );

					add_filter('pre_option_stylesheet', function () {
						return CODE_PROFILER_STYLESHEET;
					}, 1000 );

					code_profiler_log_debug(
						sprintf(
							esc_html__('Setting theme to %s', 'code-profiler'),
							CODE_PROFILER_STYLESHEET
						)
					);
				} else {
					code_profiler_log_error(
						sprintf(
							esc_html__('Unable to switch theme, %s not found', 'code-profiler'),
							CODE_PROFILER_STYLESHEET
						)
					);
				}
			}
		}

		$cp_options = get_option('code-profiler');
		if ( empty( $cp_options['accuracy'] ) ) {
			define('CODE_PROFILER_TICKS', 1 );
		} else {
			define('CODE_PROFILER_TICKS', (int) $cp_options['accuracy'] );
		}
		define('CODE_PROFILER_LENGTH', 17 + strlen( (string) CODE_PROFILER_TICKS ) );

		if ( empty( $cp_options['buffer'] ) ||
			! preg_match('/^(?:[1-9]|10)$/', $cp_options['buffer'] ) ) {

			$recommended = code_profiler_suggested_memory();
			self::$buffer = (int) $recommended * 1000000;
		} else {
			self::$buffer = $cp_options['buffer'] * 1000000;
		}
		code_profiler_log_debug(
			sprintf(
				esc_html__('Setting size of memory buffer to %sMB', 'code-profiler'),
				self::$buffer / 1000000
			)
		);

		add_filter('pre_http_request', [ $this, 'pre_http_request'], 10000, 3 );
		add_action('http_api_debug', [ $this, 'http_api_debug'], 10000, 5 );
		register_shutdown_function( [ $this, 'code_profiler_shutdown'] );
		code_profiler_log_debug(
			esc_html__('Starting profiler', 'code-profiler')
		);
		require 'class-stream.php';

		// Clear the temporary log because the buffer will be appended to it
		if ( file_exists( $this->tmp_calls ) ) {
			unlink( $this->tmp_calls );
		}
		self::$fh = fopen( $this->tmp_calls, 'wb');

		CodeProfiler_Stream::start();
		register_tick_function( array( $this, 'code_profiler_tick_handler') );
	}

	/**
	 * Save data and check for potential PHP errors.
	 */
	public function code_profiler_shutdown() {

		CodeProfiler_Stream::stop();

		fclose( self::$fh );

		$summary['memory']		= memory_get_peak_usage();
		$summary['queries']		= get_num_queries() - 2;
		$summary['precision']	= CODE_PROFILER_TICKS;
		file_put_contents( $this->tmp_summary, json_encode( $summary ) );

		// Catch potential error
		$e = error_get_last();
		if ( isset( $e['type'] ) && $e['type'] === E_ERROR ) {
			$err = str_replace( "\n", ' - ', $e['message'] );
			code_profiler_log_error( sprintf(
				/* Translators: Error message, line number and script */
				esc_html__('Error: E_ERROR (%s - line %s in %s)', 'code-profiler'),
				esc_html( $err ),
				(int) $e['line'],
				esc_html( $e['file'] )
			));
		}

		$err_msg = esc_html__('Cannot open file for writting: %s', 'code-profiler');
		$res = file_put_contents( $this->tmp_iostats, json_encode( CodeProfiler_Stream::$io_stats ) );
		if ( $res === false ) {
			$msg = sprintf( $err_msg, $this->tmp_iostats );
			code_profiler_log_error( $msg );
		}
		$res = file_put_contents( $this->tmp_calls, self::$tick_list, FILE_APPEND );
		if ( $res === false ) {
			$msg = sprintf( $err_msg, $this->tmp_calls );
			code_profiler_log_error( $msg );
		}
		$res = file_put_contents(
			$this->tmp_diskio, "read\t". CodeProfiler_Stream::$io_read ."\nwrite\t".
			CodeProfiler_Stream::$io_write
		);
		if (! empty( self::$connections_list ) ) {
			file_put_contents( $this->tmp_connections, json_encode( self::$connections_list) );
		}
	}

	/**
	 * Our tick handler.
	 */
	public function code_profiler_tick_handler() {

		$start = $this->time();

		$backtrace = debug_backtrace(	DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
		if ( isset( $backtrace[1] ) ) {
			$el = $backtrace[1];
		} else {
			$el = $backtrace[0];
		}

		if ( empty( $el['file'] ) ) {
			if ( isset( $backtrace[0]['file'] ) ) {
				$el['file'] = $backtrace[0]['file'];
			} else {
				return;
			}
		}

		self::$tick_list .= "{$el['file']}\t";
		if ( isset( $backtrace[0]['file'][0] ) ) {
			self::$tick_list .= $backtrace[0]['file'];
		} else {
			self::$tick_list .= '-';
		}
		$backtrace	= null;

		// Buffer can grow *very* big hence we flush it every 10MB by default
		if ( strlen( self::$tick_list ) > self::$buffer ) {
			CodeProfiler_Stream::stop();
			fwrite( self::$fh, self::$tick_list ."\t{$start}\t". $this->time() ."\n" );
			CodeProfiler_Stream::start();
			self::$tick_list = '';

		} else {
			self::$tick_list .="\t{$start}\t". $this->time() ."\n";
		}
	}


	/**
	 * HTTP API request.
	 */
	public function pre_http_request( $preempt, $r, $url ) {

		if ( empty( $url ) ) {
			return false;
		}
		$backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
		self::$connections_start = $this->time();
		self::$connections_list[ self::$connections_start ]['bt'] = $backtrace;
		return false;
	}


	/**
	 * HTTP API response.
	 */
	public function http_api_debug( $response, $context, $class, $parsed_args, $url ) {

		self::$connections_list[ self::$connections_start ]['stop'] = $this->time();
	}

	/**
	 * Return time
	 */
	private function time() {

		if ( self::$metrics == 'hrtime') {
			return hrtime( true );
		} else {
			return microtime( true );
		}
	}
}

new CodeProfiler_Profiler();

// =====================================================================
// EOF
