<?php

use Dev4Press\v42\Core\Quick\File;

$list  = sweeppress_core()->available();
$_auto = array(
	'sweepers' => 0,
	'tasks'    => 0,
	'records'  => 0,
	'size'     => 0,
);

foreach ( $list as $category => $sweepers ) {
	foreach ( $sweepers as $sweeper ) {
		if ( $sweeper->for_auto_cleanup() && $sweeper->is_sweepable() ) {
			$_auto['sweepers'] ++;

			foreach ( $sweeper->get_tasks() as $task => $data ) {
				if ( $data['records'] > 0 || $data['size'] > 0 ) {
					$_auto['tasks'] ++;
					$_auto['records'] += $data['records'];
					$_auto['size']    += $data['size'];
				}
			}
		}
	}
}

require( SWEEPPRESS_PATH . 'forms/misc-notices-backup.php' );

?>
<div class="d4p-group d4p-dashboard-card sweeper-dashboard-auto">
    <h3>
		<?php esc_html_e( "Auto Sweep", "sweeppress" ); ?>
        <a class="d4p-kb-group" href="https://support.dev4press.com/kb/article/auto-and-quick-sweeping/" target="_blank" rel="noopener">KB</a>
    </h3>
    <div class="d4p-group-inner">
        <div id="sweeppress-information-auto">
            <div class="sweeppress-info-block">
                <p><?php esc_html_e( "From here, you can run automatic cleanup of WordPress database that includes some of the sweepers. Auto sweeping is not available for many of the sweepers, because of the limitations of some of the sweepers, or the performance issues that some sweepers can cause.", "sweeppress" ); ?></p>
                <p><?php esc_html_e( "Switch to Quick Sweep Mode to see all Sweepers available for quick cleanup. If you want to get full control over all Sweepers, read additional information and limitations for some sweepers, visit the Sweep panel.", "sweeppress" ); ?></p>
                <p><?php esc_html_e( "Make sure to check out plugin Settings panel and options related to additional Sweepers control.", "sweeppress" ); ?></p>
            </div>
            <div class="sweeppress-request-block">
                <dl>
                    <dt><?php esc_html_e( "Auto Sweepers", "sweeppress" ); ?>:</dt>
                    <dd><?php echo esc_html( sweeppress_core()->get_sweepers_count( 'auto' ) ); ?></dd>
                    <dt><?php esc_html_e( "Active Sweepers", "sweeppress" ); ?>:</dt>
                    <dd><?php echo esc_html( $_auto['sweepers'] ); ?></dd>
                </dl>
                <dl>
                    <dt><?php esc_html_e( "Tasks", "sweeppress" ); ?>:</dt>
                    <dd><?php echo esc_html( $_auto['tasks'] ); ?></dd>
                    <dt><?php esc_html_e( "Records", "sweeppress" ); ?>:</dt>
                    <dd><?php echo esc_html( $_auto['records'] ); ?></dd>
                    <dt><?php esc_html_e( "Size", "sweeppress" ); ?>:</dt>
                    <dd><?php echo File::size_format( absint( $_auto['size'] ), 1 ); ?></dd>
                </dl>
                <button type="button" class="button-primary" data-nonce="<?php echo wp_create_nonce( "sweeppress-dashboard-auto-sweep" ); ?>"><?php esc_html_e( "Auto Sweep", "sweeppress" ); ?></button>
                <button type="button" class="button-secondary"><?php esc_html_e( "Switch to Quick Sweep Mode", "sweeppress" ); ?></button>
            </div>
        </div>
        <div id="sweeppress-results-auto" style="display: none">
            <div class="sweeppress-results-loader">
                <i class="d4p-icon d4p-ui-spinner d4p-icon-spin"></i>
                <span><?php esc_html_e( "Please wait for the sweeping to finish...", "sweeppress" ); ?></span>
            </div>
        </div>
    </div>
</div>
<div style="display: none">
    <div title="<?php esc_attr_e( "Are you sure?", "sweeppress" ); ?>" id="sweeppress-dialog-dashboard-auto">
        <div class="sweeppress-inner-content">
            <p><?php esc_html_e( "Auto Sweep will run most of the available Sweepers and will show you results after it finishes the process. Do not close this window while the process is running.", "sweeppress" ); ?></p>
            <p><?php esc_html_e( "Are you sure you want to proceed with the auto sweeping process?", "sweeppress" ); ?></p>
        </div>
    </div>
</div>
