<?php

use Dev4Press\v42\Core\Quick\File;
use Dev4Press\v42\Core\Quick\Sanitize;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$list = sweeppress_core()->available();

?>
<div class="d4p-group d4p-dashboard-card sweeper-dashboard-overview" style="display: none">
    <h3>
		<?php esc_html_e( "Quick Sweep", "sweeppress" ); ?>
        <input title="<?php esc_attr_e( "Toggle all Sweepers", "sweeppress" ); ?>" class="sweeppress-dashboard-check-all" type="checkbox"/>
    </h3>
    <div class="d4p-group-inner">
        <div class="sweeppress-quick-info">
			<?php echo sprintf( esc_html__( "There are total of %s sweepers available for Quick sweeping. All %s sweepers are only available via Sweep panel!", "sweeppress" ), "<strong>'" . sweeppress_core()->get_sweepers_count( 'quick' ) . "'</strong>", "<strong>'" . sweeppress_core()->get_sweepers_count() . "'</strong>" ); ?>
            <br/>
			<?php esc_html_e( "This list currently shows only sweepers and tasks that have something to sweep.", "sweeppress" ); ?>
            <br/>
			<?php echo sprintf( esc_html__( "To see more information about all available sweepers, you can do it via %s.", "sweeppress" ), '<a href="admin.php?page=sweeppress-sweep">' . esc_html__( "Sweep Panel", "sweeppress" ) . '</a>' ); ?>
        </div>

        <form data-status="idle" action="" method="post" id="sweeppress-form-quick">
			<?php

			if ( empty( $list ) ) {
				?>

                <p><?php esc_html_e( "There are no sweepers currently available.", "sweeppress" ); ?></p>

				<?php
			} else {
				$_sweeper_count = 0;

				foreach ( $list as $category => $sweepers ) {
					foreach ( $sweepers as $sweeper ) {
						if ( $sweeper->for_quick_cleanup() && $sweeper->is_sweepable() ) {
							$_sweeper_count ++;

							?>

                            <div class="sweeppress-item-wrapper">
                                <h5>
									<?php echo esc_html( $sweeper->title() ); ?>
                                    <input class="sweeppress-sweeper-check" type="checkbox"/>
                                </h5>
                                <div class="sweeppress-item-inside">
									<?php

									foreach ( $sweeper->get_tasks() as $task => $data ) {
										$info          = array();
										$is_cpt        = isset( $data['type'] ) && $data['type'] == 'post_type';
										$data['items'] = $data['items'] ?? 0;

										if ( $data['items'] > 0 || $data['records'] > 0 || $data['size'] > 0 ) {
											$item_name = 'sweeppress[sweeper][' . $sweeper->get_category() . '][' . $sweeper->get_code() . '][' . $task . ']';

											$item_class = array( 'sweeppress-item-task' );

											if ( $is_cpt ) {
												$item_class[] = $data['registered'] ? 'task-is-registered' : 'task-is-missing';
											}

											?>
                                            <div class="<?php echo Sanitize::html_classes( $item_class ); ?>">
												<?php

												if ( $is_cpt && ! $data['registered'] ) {
													echo '<i title="' . esc_attr__( "Not currently registered.", "sweeppress" ) . '" class="d4p-icon d4p-ui-warning"></i> ';
												}

												echo esc_html( $data['title'] );

												if ( isset( $data['real_title'] ) ) {
													echo ' [<span>' . esc_html( $data['real_title'] ) . '</span>]';
												}

												echo ' (<span class="sweeppress-item-task-stats">';

												if ( $data['items'] > 0 ) {
													echo '<span>' . sprintf( esc_html( $sweeper->items_count_n( absint( $data['items'] ) ) ), '<strong>' . absint( $data['items'] ) . '</strong>' ) . '</span>';
												}

												if ( $data['records'] > 0 ) {
													$_records = absint( $data['records'] );
													echo '<span>' . sprintf( esc_html( _n( "%s record", "%s records", $_records, "sweeppress" ) ), '<strong>' . $_records . '</strong>' ) . '</span>';
												}

												if ( $data['size'] > 0 ) {
													echo '<span>' . File::size_format( absint( $data['size'] ) ) . '</span>';
												}

												echo '</span>)';

												echo '<input data-size="' . esc_attr( $data['size'] ) . '" data-records="' . esc_attr( $data['records'] ) . '" class="sweeppress-task-check" type="checkbox" value="sweep" name="' . esc_attr( $item_name ) . '" />';

												?>
                                            </div>
											<?php
										}
									}

									?>
                                </div>
                            </div>

							<?php
						}
					}
				}

				if ( $_sweeper_count == 0 ) {
					?>

                    <p><?php esc_html_e( "There are no sweepers currently available.", "sweeppress" ); ?></p>

					<?php
				} else {
					?>

                    <div class="sweeppress-sweeper-wrapper">
                        <div class="sweeppress-sweeper-counters">
							<?php esc_html_e( "Records", "sweeppress" ); ?>: <strong>0</strong> &middot;
							<?php esc_html_e( "Size", "sweeppress" ); ?>: <span>0 B</span>
                        </div>
                        <div class="sweeppress-sweeper-controls">
                            <input type="submit" value="<?php esc_attr_e( "Run the Sweep", "sweeppress" ); ?>" class="button-primary" disabled/>
                            <input type="hidden" value="<?php echo wp_create_nonce( 'sweeppress-dashboard-quick-sweep' ); ?>" name="sweeppress[nonce]"/>
                        </div>
                    </div>

					<?php
				}
			}

			?>
        </form>
        <div id="sweeppress-results-quick" style="display: none">
            <div class="sweeppress-results-loader">
                <i class="d4p-icon d4p-ui-spinner d4p-icon-spin"></i>
                <span><?php esc_html_e( "Please wait for the sweeping to finish...", "sweeppress" ); ?></span>
            </div>
        </div>
    </div>
</div>
