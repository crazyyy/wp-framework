<?php

use Dev4Press\v42\Core\Quick\File;
use Dev4Press\v42\Core\Quick\Sanitize;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$list   = sweeppress_settings()->list_statistics();
$period = isset( $_GET['period'] ) ? Sanitize::slug( $_GET['period'] ) : '';

if ( ! isset( $list[ $period ] ) ) {
	$period = '';
}

$statistics = sweeppress_settings()->get_statistics( $period );

?>
<div class="d4p-content">
	<?php if ( ! isset( $statistics['sweepers'] ) ) { ?>
        <p><?php esc_html_e( "There is no data to show here.", "sweeppress" ); ?></p>
	<?php } else { ?>
        <div class="d4p-group">
            <h3><?php esc_html_e( "Basic Statistics", "sweeppress" ); ?></h3>
            <div class="d4p-group-inner">
                <dl>
                    <dt><?php esc_html_e( "Period", "sweeppress" ); ?></dt>
                    <dd><?php echo esc_html( $statistics['label'] ); ?></dd>
                </dl>
                <hr/>
                <dl>
                    <dt><?php esc_html_e( "Sources", "sweeppress" ); ?></dt>
                    <dd>
						<?php echo esc_html__( "Quick", "sweeppress" ) . ': ' . absint( $statistics['quick'] ); ?><br/>
						<?php echo esc_html__( "Sweep", "sweeppress" ) . ': ' . absint( $statistics['panel'] ); ?><br/>
						<?php echo esc_html__( "Scheduler", "sweeppress" ) . ': ' . absint( $statistics['scheduler'] ); ?>
                        <br/>
						<?php echo esc_html__( "Auto", "sweeppress" ) . ': ' . absint( $statistics['auto'] ); ?><br/>
						<?php echo esc_html__( "CLI", "sweeppress" ) . ': ' . absint( $statistics['cli'] ); ?><br/>
						<?php echo esc_html__( "REST", "sweeppress" ) . ': ' . absint( $statistics['rest'] ); ?>
                    </dd>
                </dl>
                <hr/>
                <dl>
                    <dt><?php esc_html_e( "Sweepers Run", "sweeppress" ); ?></dt>
                    <dd><?php echo absint( $statistics['jobs'] ); ?></dd>
                    <dt><?php esc_html_e( "Sweeper Tasks Run", "sweeppress" ); ?></dt>
                    <dd><?php echo absint( $statistics['tasks'] ); ?></dd>
                    <dt><?php esc_html_e( "Records Removed", "sweeppress" ); ?></dt>
                    <dd><?php echo absint( $statistics['records'] ); ?></dd>
                    <dt><?php esc_html_e( "Space Recovered", "sweeppress" ); ?></dt>
                    <dd><?php echo File::size_format( absint( $statistics['size'] ) ); ?></dd>
                    <dt><?php esc_html_e( "Sweeping Time", "sweeppress" ); ?></dt>
                    <dd><?php echo ceil( $statistics['time'] ) . ' ' . esc_html__( "seconds", "sweeppress" ); ?></dd>
                </dl>
                <hr/>
                <dl>
                    <dt><?php esc_html_e( "Total Space Recovered (With Database Cleanup)", "sweeppress" ); ?></dt>
                    <dd><?php echo File::size_format( absint( $statistics['size_total'] ) ); ?></dd>
                </dl>
            </div>
        </div>
        <div class="d4p-group">
            <h3><?php esc_html_e( "Individual Sweepers", "sweeppress" ); ?></h3>
            <div class="d4p-group-inner sweeppress-statistics-sweeper">
				<?php foreach ( $statistics['sweepers'] as $sweeper => $data ) { ?>
                    <h5><?php echo sweeppress_core()->get_sweeper_title( $sweeper ); ?></h5>
                    <dl>
                        <dt><?php esc_html_e( "Sweeps Counter", "sweeppress" ); ?></dt>
                        <dd><?php echo absint( $data['counts'] ?? 1 ); ?></dd>
                        <dt><?php esc_html_e( "Records Removed", "sweeppress" ); ?></dt>
                        <dd><?php echo absint( $data['records'] ); ?></dd>
                        <dt><?php esc_html_e( "Space Recovered", "sweeppress" ); ?></dt>
                        <dd><?php echo File::size_format( absint( $data['size'] ) ); ?></dd>
                        <dt><?php esc_html_e( "Sweeping Time", "sweeppress" ); ?></dt>
                        <dd><?php echo ceil( $data['time'] ) . ' ' . esc_html__( "seconds", "sweeppress" ); ?></dd>
                    </dl>
				<?php } ?>
            </div>
        </div>
	<?php } ?>
</div>
