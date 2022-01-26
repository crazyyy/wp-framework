<?php
/**
 * Troubleshoot Clues.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Clues.
 *
 * @since 0.0.0
 */
class PDT_Clues {
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

	public function get( $args ) {

	}

	public function get_id_from_args( $args ) {
		$case = $this->plugin->cases->get_active();
		if ( empty( $case['clues']['0'] ) ) {
			return null;
		}

		// If specified, make sure that data is there
		if ( !empty( $args['id'] ) && $case['clues'][(int)$args['id']] ) {
			return (int)$args['id'];
		}

		// Use latest clue by default
		return count( $case['clues'] ) - 1;
	}

	public function create( $args ) {
		if ( !isset( $args['outcome'] ) ) {
			return new WP_Error( 'outcome', __( 'outcome field required' , 'plugin-detective' ) );
		}

		$case = $this->plugin->cases->get_active();
		if ( is_a( $case, 'WP_Error' ) ) {
			return $case;
		}

		$active_plugins = array();
		$plugins = $this->plugin->installed->get_plugins();
		foreach ($plugins as $key => $plugin) {
			if ( empty( $plugin['Active'] ) ) {
				continue;
			}

			$active_plugins[] = $plugin['plugin_file'];
		}

		$case['clues'][] = array(
			'outcome' => $args['outcome'],
			'active_plugins' => $active_plugins,
			'cleared_suspects' => $case['cleared_suspects'],
			'prime_suspects' => $case['prime_suspects'],
			'culprits' => $case['culprits'],
			'date_created' => gmdate( 'Y-m-d H:i:s' ),
		);

		$case = $this->plugin->cases->update( array(
			'clues' => $case['clues'],
		) );

		return $this->plugin->cases->review( $case );
	}

	public function update( $args ) {

	}

	public function delete( $args ) {
		$case = $this->plugin->cases->get_active();
		if ( is_a( $case, 'WP_Error' ) ) {
			return $case;
		}

		$clue_id = $this->get_id_from_args( $args );
		unset( $case['clues'][$clue_id] );
		
		return $this->plugin->cases->update( array(
			'clues' => $case['clues'],
		) );
	}
}
