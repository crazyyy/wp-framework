<?php
/**
 * Troubleshoot Detective.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Detective.
 *
 * @since 0.0.0
 */
class PDT_Detective {
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

	public function review_case( $case ) {
		$next = array();

		if ( !is_array( $case ) ) {
			return new WP_Error( 'empty_case' );
		}

		if ( empty( $case['clues'] ) ) {
			$case['clues'] = array();
		}
		if ( empty( $case['culprits'] ) ) {
			$case['culprits'] = array();
		}

		$case = $this->clear_the_interrogation_room( $case );

		$procedure = array(
			array( 'method' => 'clear_suspects_based_on_clues', ),
			array( 'method' => 'name_required_plugins_as_culprits_based_on_broken_clue', ),
			array( 'method' => 'name_culprit_if_there_is_only_one_suspect_in_a_failed_clue', ),
			array( 'method' => 'interrogate_by_disabling_all_plugins_if_none_are_required', ),
			array( 'method' => 'interrogate_required_plugins_if_they_arent_cleared_yet', ),

			// array( 'method' => 'declare_unsolvable_if_every_suspect_is_cleared', ),
			// array( 'method' => 'interrogate_one_at_a_time_after_ten_clues', ),
			array( 'method' => 'interrogate_other_half_after_clue_with_broken_outcome', ),
			array( 'method' => 'interrogate_random_half', ),
		);

		foreach ($procedure as $key => $step) {
			$method = $step['method'];
			$case = $this->$method( $case );

			if ( !empty( $case['stage'] ) && in_array( $case['stage'], array( 'solved', 'unsolved' ) ) ) {
				return $case;
			}

			if ( !empty( $case['suspects_under_interrogation'] ) ) {
				if ( in_array( 'no_required_plugins', $case['suspects_under_interrogation'] ) ) {
					$case['suspects_under_interrogation'] = array();
				}

				$case['suspects_under_interrogation'] = array_values( array_unique( array_merge( $case['required_plugins'], $case['suspects_under_interrogation'] ) ) );

				return $case;
			}
		}

		return $case;
	}

	public function clear_the_interrogation_room( $case ) {
		$case['suspects_under_interrogation'] = array();
		return $case;
	}

	public function name_required_plugins_as_culprits_based_on_broken_clue( $case ) {
		// if ( empty( $case['required_plugins'] ) ) {
		// 	return $case;
		// }
		foreach ($case['clues'] as $key => $clue) {

			if ( $clue['outcome'] == 'broken' && count( $clue['active_plugins'] ) == count( $case['required_plugins'] ) ) {
				if ( array_diff( $case['required_plugins'], $clue['active_plugins'] ) === array() ) {
					// We got a broken result with only the required plugins active
					$case['outcome'] = 'required_plugins_broken';
					$case['stage'] = 'solved';
					return $case;
				}

			}
		}

		return $case;
	}

	public function name_culprit_if_there_is_only_one_suspect_in_a_failed_clue( $case ) {
		foreach ($case['clues'] as $key => $clue) {
			if ( $clue['outcome'] == 'broken' && count( array_diff( $clue['active_plugins'], $case['required_plugins'] ) ) == 1 ) {
				$case['culprits'] = array_values( array_unique( array_merge( $case['culprits'], array_diff( $clue['active_plugins'], $case['required_plugins'] ) ) ) );
				$case['stage'] = 'solved';
				$case['outcome'] = 'culprits_identified';
				return $case;
			}
		}

		return $case;
	}

	public function clear_suspects_based_on_clues( $case ) {
		$case['cleared_suspects'] = array();
		foreach ($case['clues'] as $key => $clue) {
			if ( $clue['outcome'] != 'fixed' ) {
				continue;
			}

			$case['cleared_suspects'] = array_merge( $case['cleared_suspects'], $clue['active_plugins'] );
		}

		$case['cleared_suspects'] = array_values( array_unique( $case['cleared_suspects'] ) );

		return $case;
	}

	public function interrogate_by_disabling_all_plugins_if_none_are_required( $case ) {
		if ( !empty( $case['required_plugins'] ) ) {
			return $case; // this procedure is only used to disable all plugins if there are no required_plugins, so we can skip this procedure if there are required plugins
		}

		if ( !empty( $case['clues'] ) ) {
			return $case; // this procedure should only run once... and it will always be the first clue, so if we already have a clue, we can skip this procedure
		}

		$case['required_plugins'] = array();
		$case['suspects_under_interrogation'] = array( 'no_required_plugins' );

		return $case;
	}

	public function interrogate_required_plugins_if_they_arent_cleared_yet( $case ) {
		// Let's clear the required plugins by themselves first
		if ( !empty( $case['required_plugins'] ) ) {
			foreach ($case['required_plugins'] as $plugin_file ) {
				if ( !in_array( $plugin_file, $case['cleared_suspects'] ) ) {
					// This also accounts for someone going back and modifying their required_plugins after the case is already under way
					$case['suspects_under_interrogation'] = $case['required_plugins'];
					return $case; // Let's test all required plugins in one set (even if we're retesting one that was previously cleared)
				}
			}
		}

		return $case;
	}

	public function interrogate_other_half_after_clue_with_broken_outcome( $case ) {
		// TODO: if last clue failed, do the other half of suspects
		if ( empty( $case['clues'] ) ) {
			return $case;
		}

		$last_clue = $case['clues'][count($case['clues'])-1];
		if ( $last_clue['outcome'] != 'broken' ) {
			return $case;
		}

		if ( count($case['clues'] ) >= 2 ) {
			$second_to_last_clue = $case['clues'][count($case['clues'])-2];
			if ( $second_to_last_clue['outcome'] == 'broken' ) {
				// 2 bad clues in a row means there's something wrong 
				// (possibly multiple culprits, possibly human clue-entry error)
				// regardless of cause, we don't want an infinite loop (swapping the same 2 sets over and over)
				$third_to_last_clue = $case['clues'][count($case['clues'])-3];
				if ( $third_to_last_clue['outcome'] == 'broken' ) {
					$fourth_to_last_clue = $case['clues'][count($case['clues'])-4];
					if ( $fourth_to_last_clue['outcome'] == 'broken' ) {
						$fifth_to_last_clue = $case['clues'][count($case['clues'])-5];
						if ( $fifth_to_last_clue['outcome'] == 'broken' ) {
							// if we've had 5 broken ones in a row, something's wrong
							$case['stage'] = 'unsolved';
							$case['outcome'] = 'broken_loop';
							return $case;
						}
					}
				}

				// we'll skip this procedure and let it be handled by randomness
				return $case;
			}

		}
		
		$case['suspects_under_interrogation'] = array_values( array_diff( array_keys( $case['all_suspects'] ), $last_clue['active_plugins'], $case['cleared_suspects'] ) );

		return $case;
	}

	public function interrogate_random_half( $case ) {
		$remaining_suspects = array_diff( array_keys( $case['all_suspects'] ), $case['cleared_suspects'] );
		shuffle( $remaining_suspects );
		$number_of_new_suspects_in_next_lineup = max( floor( count( $remaining_suspects ) / 2 ), 1 );
		$new_suspects_in_next_lineup = array_slice( $remaining_suspects, 0, $number_of_new_suspects_in_next_lineup );

		$case['suspects_under_interrogation'] = $new_suspects_in_next_lineup;
		return $case;
	}
}
