<?php

use Dev4Press\Plugin\SweepPress\Basic\Database;
use Dev4Press\v42\Core\Quick\File;
use Dev4Press\v42\Core\Quick\Sanitize;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$list = sweeppress_core()->available();

$total      = 0;
$active     = 0;
$items      = array();
$categories = array();

foreach ( $list as $category => $sweepers ) {
	$active_for_category = 0;

	foreach ( $sweepers as $sweeper ) {
		$total ++;

		if ( $sweeper->is_sweepable() ) {
			$active ++;
			$active_for_category ++;
		}
	}

	$categories[ $category ] = $active_for_category;
}

Database::instance();

?>
<div class="d4p-content d4p-sweeper-content">
	<?php require( SWEEPPRESS_PATH . 'forms/misc-notices-backup.php' ); ?>

    <div id="sweeppress-results-wrapper" class="d4p-group" style="max-width: 1000px" hidden>
        <h3><?php esc_html_e( "Sweep Progress Report", "sweeppress" ); ?></h3>
        <div class="d4p-group-inner">
            <div id="sweeppress-results-sweeper">
                <div class="sweeppress-results-loader">
                    <i class="d4p-icon d4p-ui-spinner d4p-icon-spin"></i>
                    <span><?php esc_html_e( "Please wait for the sweeping to finish...", "sweeppress" ); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="sweeppress-sweepers-wrapper">
        <div class="sweeppress-sweepers-controls">
            <dl>
                <dt><?php esc_html_e( "Sweepers Available", "sweeppress" ); ?></dt>
                <dd>
					<?php

					echo sprintf( esc_html__( "Active: %s / Total: %s", "sweeppress" ), '<strong>' . esc_html( $active ) . '</strong>', '<strong>' . esc_html( $total ) . '</strong>' );

					if ( $active < $total ) {
						echo '<button class="toggle-empty-tasks" type="button" title="' . esc_attr__( "Toggle Empty Sweepers", "sweeppress" ) . '" aria-expanded="false"><i aria-hidden="true" class="d4p-icon d4p-ui-eye"></i></button>';
					}

					?>
                </dd>
            </dl>
        </div>

		<?php

		foreach ( $list as $category => $sweepers ) {
			echo '<h4 data-cat="' . esc_attr( $category ) . '" id="sweeper-category-' . esc_attr( $category ) . '" class="sweeper-category-label ' . ( $categories[ $category ] == 0 ? 'empty-sweeper-category' : '' ) . '">' . esc_html( sweeppress_core()->get_category_label( $category ) ) . '</h4>';

			foreach ( $sweepers as $sweeper ) {
				$classes = array(
					'sweeppress-item-wrapper',
					'sweeppress-item-cat-' . $sweeper->get_category(),
				);

				if ( ! $sweeper->is_sweepable() ) {
					$classes[] = 'empty-sweeper';
				}

				$affected_tables = $sweeper->affected_tables();

				?>

                <div class="<?php echo Sanitize::html_classes( $classes ); ?>">
                    <h5>
						<?php

						echo esc_html( $sweeper->title() );
						echo '<button class="toggle-section toggle-help" type="button" title="' . esc_attr__( "Toggle Help", "sweeppress" ) . '" aria-expanded="false" aria-controls="sweeper-info-' . esc_attr( $sweeper->get_unique_id() ) . '"><i aria-hidden="true" class="d4p-icon d4p-ui-question-sqaure"></i></button>';

						if ( ! empty( $sweeper->limitations() ) ) {
							echo '<button class="toggle-section toggle-limits" type="button" title="' . esc_attr__( "Toggle Limitations", "sweeppress" ) . '" aria-expanded="false" aria-controls="sweeper-limit-' . esc_attr( $sweeper->get_unique_id() ) . '"><i aria-hidden="true" class="d4p-icon d4p-ui-exclamation-square"></i></button>';
						}

						if ( ! empty( $affected_tables ) ) {
							echo '<button class="toggle-section toggle-tables" type="button" title="' . esc_attr__( "Toggle Affected Tables", "sweeppress" ) . '" aria-expanded="false" aria-controls="sweeper-tables-' . esc_attr( $sweeper->get_unique_id() ) . '"><i aria-hidden="true" class="d4p-icon d4p-ui-database"></i></button>';
						}

						if ( $sweeper->is_sweepable() && $sweeper->has_empty_tasks() && ! $sweeper->is_no_size() ) {
							echo '<button class="toggle-empty" type="button" title="' . esc_attr__( "Toggle Empty Tasks", "sweeppress" ) . '" aria-expanded="false"><i aria-hidden="true" class="d4p-icon d4p-ui-eye"></i></button>';
						}

						if ( $sweeper->is_sweepable() ) {
							echo '<input class="sweeppress-sweeper-check" type="checkbox" />';
						}

						?>
                    </h5>
                    <div class="sweeppress-item-help" hidden id="sweeper-info-<?php echo esc_attr( $sweeper->get_unique_id() ); ?>">
                        <p>
							<?php echo esc_html( $sweeper->description() ); ?>
                        </p>
						<?php

						if ( ! empty( $sweeper->help() ) ) {
							echo wp_kses_post( sweeppress_strings_array_to_list( $sweeper->help() ) );

							$_last_used = sweeppress_settings()->get_sweeper_last_used_timestamp( $sweeper->get_code() );

							if ( $_last_used > 0 ) {
								echo '<div class="sweeppress-item-last-used">' . sprintf( esc_html__( "This sweeper was last used: %s ago.", "sweeppress" ), '<strong>' . human_time_diff( time(), $_last_used ) . '</strong>' ) . '</div>';
							}
						}

						?>
                    </div>
					<?php

					if ( ! empty( $affected_tables ) ) {
						?>

                        <div class="sweeppress-item-tables" hidden id="sweeper-tables-<?php echo esc_attr( $sweeper->get_unique_id() ); ?>">
                            <p><?php esc_html_e( "This sweeper affects database tables listed below.", "sweeppress" ); ?></p>
                            <ul>
                                <li><?php echo join( '</li><li>', $affected_tables ); ?></li>
                            </ul>
                        </div>

						<?php
					}

					if ( ! empty( $sweeper->limitations() ) ) {
						?>

                        <div class="sweeppress-item-limit" hidden id="sweeper-limit-<?php echo esc_attr( $sweeper->get_unique_id() ); ?>">
                            <p><?php esc_html_e( "This sweeper has few limitations listed below.", "sweeppress" ); ?></p>
							<?php echo wp_kses_post( sweeppress_strings_array_to_list( $sweeper->limitations() ) ); ?>
                        </div>

						<?php
					}

					?>
                    <div class="sweeppress-item-inside">
						<?php

						$tasks = $sweeper->is_no_size();
						$total = array(
							'tasks'   => 0,
							'items'   => 0,
							'records' => 0,
							'size'    => 0,
						);

						foreach ( $sweeper->get_tasks() as $task => $data ) {
							if ( $tasks ) {
								$total['tasks'] ++;
							}

							$info          = array();
							$is_cpt        = isset( $data['type'] ) && $data['type'] == 'post_type';
							$data['items'] = $data['items'] ?? 0;

							if ( $tasks || ( $data['items'] > 0 || $data['records'] > 0 || $data['size'] > 0 ) ) {
								$item_class = array( 'sweeppress-item-task' );
								$item_name  = 'sweeppress[sweeper][' . $sweeper->get_category() . '][' . $sweeper->get_code() . '][' . $task . ']';

								if ( $is_cpt ) {
									$item_class[] = $data['registered'] ? 'task-is-registered' : 'task-is-missing';
								}

								echo '<div class="' . Sanitize::html_classes( $item_class ) . '">';

								if ( $is_cpt && ! $data['registered'] ) {
									echo '<i title="' . esc_attr__( "Not currently registered.", "sweeppress" ) . '" class="d4p-icon d4p-ui-warning"></i> ';
								}

								echo esc_html( $data['title'] );

								if ( isset( $data['real_title'] ) ) {
									echo ' [<span>' . esc_html( $data['real_title'] ) . '</span>]';
								}

								if ( $data['items'] > 0 || $data['records'] > 0 || $data['size'] > 0 ) {
									echo ' (<span class="sweeppress-item-task-stats">';

									if ( $data['items'] > 0 ) {
										$total['items'] += absint( $data['items'] );
										echo '<span>' . sprintf( esc_html( $sweeper->items_count_n( absint( $data['items'] ) ) ), '<strong>' . absint( $data['items'] ) . '</strong>' ) . '</span>';
									}

									if ( $data['records'] > 0 ) {
										$_records         = absint( $data['records'] );
										$total['records'] += $_records;
										echo '<span>' . sprintf( esc_html( _n( "%s record", "%s records", $_records, "sweeppress" ) ), '<strong>' . $_records . '</strong>' ) . '</span>';
									}

									if ( $data['size'] > 0 ) {
										$total['size'] += absint( $data['size'] );
										echo '<span>' . File::size_format( absint( $data['size'] ) ) . '</span>';
									}

									echo '</span>)';
								}

								echo '<input data-size="' . esc_attr( $data['size'] ) . '" data-records="' . esc_attr( $data['records'] ) . '" class="sweeppress-task-check" type="checkbox" value="sweep" name="' . esc_attr( $item_name ) . '" />';

								echo '</div>';
							} else {
								echo '<div class="sweeppress-item-task empty-task">';
								echo esc_html( $data['title'] );

								if ( isset( $data['real_title'] ) ) {
									echo ' [<span>' . esc_html( $data['real_title'] ) . '</span>]';
								}

								echo '</div>';
							}
						}

						?>
                        <div class="sweeppress-item-total">
							<?php

							if ( $total['size'] > 0 ) {
								$percentage = $sweeper->calculate_percentage( $total['size'] );
								$total_size = File::size_format( $sweeper->affected_tables_size(), 2, ' ', false );

								if ( $percentage < 0.5 ) {
									$percentage = '< 0.5';
								}

								echo '<span title="' . esc_attr( sprintf( __( "Estimated from the total size of affected tables (%s).", "sweeppress" ), $total_size ) ) . '" class="sweeppress-affected-percentage">' . esc_html( $percentage ) . '%</span>';
							}

							?>
                            <p>
								<?php

								if ( $total['tasks'] > 0 || $total['items'] > 0 || $total['records'] > 0 || $total['size'] > 0 ) {
									echo '<strong>' . esc_html__( "Totals", "sweeppress" ) . ':</strong>';

									echo ' <span class="sweeppress-item-task-stats">';

									if ( $total['tasks'] > 0 ) {
										echo '<span>' . sprintf( esc_html( $sweeper->tasks_count_n( absint( $total['tasks'] ) ) ), '<strong>' . absint( $total['tasks'] ) . '</strong>' ) . '</span>';
									}

									if ( $total['items'] > 0 ) {
										echo '<span>' . sprintf( esc_html( $sweeper->items_count_n( absint( $total['items'] ) ) ), '<strong>' . absint( $total['items'] ) . '</strong>' ) . '</span>';
									}

									if ( $total['records'] > 0 ) {
										$_records = absint( $total['records'] );
										echo '<span>' . sprintf( esc_html( _n( "%s record", "%s records", $_records, "sweeppress" ) ), '<strong>' . $_records . '</strong>' ) . '</span>';
									}

									if ( $total['size'] > 0 ) {
										echo '<span>' . File::size_format( absint( $total['size'] ) ) . '</span>';
									}

									if ( $sweeper->is_cached() ) {
										echo '<span><strong>' . esc_html__( "From Cache", "sweeppress" ) . '</strong></span>';
									}

									echo '</span>';
								} else {
									esc_html_e( "Nothing to sweep.", "sweeppress" );
								}

								?>
                            </p>
                        </div>
                    </div>
                </div>

				<?php
			}
		}

		?>
    </div>
    <input type="hidden" value="<?php echo wp_create_nonce( 'sweeppress-sweep-panel-sweeper' ); ?>" name="sweeppress[nonce]"/>
</div>