<?php
/**
 * Troubleshoot Case.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Case.
 *
 * @since 0.0.0
 */
class PDT_Cases {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Troubleshoot
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Troubleshoot $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
		
	}

	public function get_schema() {
		return array(
			'id' => array(
				'name' => 'id',
				'access' => 'private',
				'type' => 'int',
			),
			'user_id' => array(
				'name' => 'user_id',
				'access' => 'private',
				'type' => 'int',
			),
			'status' => array(
				'name' => 'status',
				'access' => 'private',
				'type' => 'string',
			),
			'stage' => array(
				'name' => 'stage',
				'access' => 'private',
				'type' => 'string',
			),
			'outcome' => array(
				'name' => 'outcome',
				'access' => 'private',
				'type' => 'string',
			),
			'url' => array(
				'name' => 'url',
				'access' => 'public',
				'type' => 'string',
			),
			'clues' => array(
				'name' => 'clues',
				'access' => 'private',
				'type' => 'array',
			),
			'all_suspects' => array(
				'name' => 'all_suspects',
				'access' => 'private',
				'type' => 'array',
			),
			'required_plugins' => array(
				'name' => 'required_plugins',
				'access' => 'public',
				'type' => 'array',
			),
			'suspects_under_interrogation' => array(
				'name' => 'suspects_under_interrogation',
				'access' => 'private',
				'type' => 'array',
			),
			'cleared_suspects' => array(
				'name' => 'cleared_suspects',
				'access' => 'private',
				'type' => 'array',
			),
			'prime_suspects' => array(
				'name' => 'prime_suspects',
				'access' => 'private',
				'type' => 'array',
			),
			'culprits' => array(
				'name' => 'culprits',
				'access' => 'private',
				'type' => 'array',
			),
		);
	}

	public function open( $args=array() ) {
		// Check for an active case first (only one case at a time)
		$active = $this->get_active( $args );
		if ( is_a( $active, 'WP_Error' ) && $active->get_error_code() !== 'no_active_case' ) {
			return $active;
		}

		$all_cases = $this->get_all();
		$new_case_id = substr( wp_hash( site_url() . time() ), 0, 10 );
		if ( in_array( $new_case_id, $all_cases ) ) {
			return new WP_Error( 'error_creating_case', __( 'Plugin Detective was unable to open a new case. Please contact support.', 'plugin-detective' ) );
		}
		$all_cases[] = $new_case_id;
		if ( isset( $args['id'] )) {
			unset( $args['id'] );
		}
		if ( isset( $args['status'] )) {
			unset( $args['status'] );
		}
		foreach ($this->get_schema() as $key => $field) {
			if ( isset( $args[$field['name']] ) && $field['access'] == 'private' ) {
				unset( $args[$field['name']] );
			}
		}

		$active_plugins = array();
		$all_plugins = $this->plugin->installed->get_plugins();
		foreach ($all_plugins as $key => $plugin) {
			if ( empty( $plugin['Active'] ) ) {
				continue;
			}

			if ( empty( $plugin['slug'] ) ) {
				continue;
			}

			$active_plugins[$plugin['plugin_file']] = $plugin;
		}

		update_option( 'pdt_tmp_active_plugins_backup_from_case_opening', get_option( 'active_plugins' ) );
		
		$this->create( array_merge( array(
			'id' => $new_case_id,
			'user_id' => 0,
			'status' => 'open',
			'stage' => 'investigating',
			'date_opened' => gmdate( 'Y-m-d H:i:s' ),
			'url' => site_url(),
			'required_plugins' => array(),
			'all_suspects' => $active_plugins,
			'cleared_suspects' => array(),
			'suspects_under_interrogation' => array(),
			'prime_suspects' => array(),
			'clues' => array(),
			'culprits' => array(),
			'outcome' => '',
		), $args ) );
		update_option( 'pdt_active_case_id', $new_case_id );
		update_option( 'pdt_cases', json_encode( $all_cases ) );

		return $this->get_active();
	}


	public function suspend( $args=array() ) {
		$active_case = $this->get_active( $args );
		if ( is_a( $active_case, 'WP_Error' ) ) {
			return $active_case;
		}

		$active_case['status'] = 'suspended';
		$response = $this->update( $active_case );
		if ( is_a( $response, 'WP_Error' ) ) {
			return $response;
		}

		delete_option( 'pdt_active_case_id' );

		return $this->get( $active_case );
	}

	public function close( $args=array() ) {
		$args = shortcode_atts( array(
			'reset_active_plugins' => false,
		), $args );

		$active_case = $this->get_active( $args );
		if ( is_a( $active_case, 'WP_Error' ) ) {
			return $active_case;
		}

		if ( !empty( $active_case['status'] ) && $active_case['status'] == 'closed' ) {
			return $active_case;
		}

		if ( !empty( $args['reset_active_plugins'] ) ) {
			// Revert WP active_plugins to value when we opened the case
			if ( isset( $active_case['all_suspects'] ) && is_array( $active_case['all_suspects'] ) ) {
				$this->plugin->plugins->set_active( array_keys( $active_case['all_suspects'] ) );
			}
		}

		$active_case['status'] = 'closed';

		$response = $this->update( $active_case );
		if ( is_a( $response, 'WP_Error' ) ) {
			return $response;
		}

		return $this->get( $active_case );
	}

	public function get_active( $args=array() ) {
		$active_case_id = get_option( 'pdt_active_case_id' );
		if ( empty( $active_case_id )) {
			return new WP_Error( 'no_active_case' , __( 'No active case found', 'plugin-detective' ) );
		}

		$active_case = $this->get( array( 'id' => $active_case_id ) );
		if ( is_a( $active_case, 'WP_Error' ) ) {
			return $active_case;
		}

		if ( empty( $active_case ) ) {
			return new WP_Error( 'case_data_missing' , __( 'Case ID '.$active_case_id.' missing', 'plugin-detective' ) );
		}

		return $active_case;
	}

	public function get( $args=array() ) {
		if ( empty( $args['id'] ) ) {
			return new WP_Error( 'get_id_missing', __( 'No case id specified for get()', 'plugin-detective' ) );
		}

		$case = get_option( 'pdt_case_' . esc_attr( $args['id'] ) );
		if ( empty( $case ) ) {
			return new WP_Error( 'case_data_missing' , __( 'Case ID '.$args['id'].' missing', 'plugin-detective' ) );
		}

		return json_decode( $case, true );
	}

	public function create( $args=array() ) {
		if ( empty( $args['id'] ) ) {
			return new WP_Error( 'update_id_missing', __( 'No case id specified for create()', 'plugin-detective' ) );
		}

		update_option( 'pdt_case_'.esc_attr( $args['id'] ), json_encode( $args ) );
	}


	public function update( $args=array() ) {
		$case = $this->get_active();
		if ( is_a( $case, 'WP_Error' ) ) {
			return $case;
		}

		$args['id'] = $case['id'];
		
		// foreach ($this->get_schema() as $field) {
		// 	if ( isset( $args[$field['name']] ) && $field['access'] === 'private' ) {
		// 		unset( $args[$field['name']] );
		// 	}
		// }

		$case = array_merge( $case, $args );
		update_option( 'pdt_case_'.esc_attr( $args['id'] ), json_encode( $case ) );
		return $this->get( array( 'id' => $args['id'] ) );
	}

	public function review( $args=array() ) {
		$case = $this->get_active();
		if ( is_a( $case, 'WP_Error' ) ) {
			return $case;
		}

		$case = $this->plugin->detective->review_case( $case ); // update $case['suspects_under_interrogation']

		if ( $case['stage'] != 'investigating' ) {
			$case = $this->update( $case );
			$case = $this->close( array(
				'reset_active_plugins' => true,
			) );
		} else {
			$this->plugin->plugins->set_active( $case['suspects_under_interrogation'] );
			$case = $this->update( $case );
		}

		return $case;
	}

	public function get_all( $args=array() ) {
		$cases = get_option( 'pdt_cases', json_encode( array() ) );
		$cases = json_decode( $cases, true );
		if ( empty( $cases ) ) {
			$cases = array();
		}

		return $cases;
	}
}
