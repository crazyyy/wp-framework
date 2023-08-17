<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-group d4p-dashboard-card d4p-card-double">
    <h3><?php esc_html_e( "Plugin Status", "sweeppress" ); ?></h3>
    <div class="d4p-group-inner">
        <div class="d4p-status-message" style="margin: 0 0 .5em;">
			<?php if ( SWEEPPRESS_SIMULATION ) { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-maintenance">
                    <i class="d4p-icon d4p-ui-warning"></i> <?php esc_html_e( "Simulation", "sweeppress" ); ?>
                </span>
				<?php esc_html_e( "The plugin works in simulation mode, data is not removed!", "sweeppress" ); ?>
			<?php } else { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-ok">
                    <i class="d4p-icon d4p-ui-check"></i> <?php esc_html_e( "OK", "sweeppress" ); ?>
                </span>
				<?php esc_html_e( "Everything appears to be in order.", "sweeppress" ); ?>
			<?php } ?>
        </div>
        <div class="d4p-status-message" style="margin: 0 0 .5em;">
			<?php if ( sweeppress()->is_rest_enabled() ) { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-green">
                    <i class="d4p-icon d4p-ui-shortcode"></i> <?php esc_html_e( "REST API", "sweeppress" ); ?>
                </span>
			<?php } else { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-red">
                    <i class="d4p-icon d4p-ui-times"></i> <?php esc_html_e( "REST API", "sweeppress" ); ?>
                </span>
			<?php }
			if ( sweeppress()->is_cli_enabled() ) { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-green">
                    <i class="d4p-icon d4p-ui-code"></i> <?php esc_html_e( "WP CLI", "sweeppress" ); ?>
                </span>
			<?php } else { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-red">
                    <i class="d4p-icon d4p-ui-times"></i> <?php esc_html_e( "WP CLI", "sweeppress" ); ?>
                </span>
			<?php } ?>
			<?php esc_html_e( "Sweeper support modules status", "sweeppress" ); ?>
        </div>
        <div class="d4p-status-message">
		    <?php if ( sweeppress()->is_estimates_cache_enabled() ) { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-green">
                    <i class="d4p-icon d4p-ui-briefcase"></i> <?php esc_html_e( "Estimates Cache", "sweeppress" ); ?>
                </span>
		    <?php } else { ?>
                <span class="d4p-card-badge d4p-badge-right d4p-badge-red">
                    <i class="d4p-icon d4p-ui-times"></i> <?php esc_html_e( "Estimates Cache", "sweeppress" ); ?>
                </span>
		    <?php } ?>
		    <?php esc_html_e( "Other SweepPress features", "sweeppress" ); ?>
        </div>
        <hr/>
        <div class="d4p-status-message" style="margin: 0 0 .5em;">
            <span class="d4p-card-badge d4p-badge-right d4p-badge-blue"><i class="d4p-icon d4p-ui-tag"></i> <?php echo esc_html( sweeppress_core()->get_sweepers_count() ); ?></span>
			<?php esc_html_e( "Number of included Sweepers", "sweeppress" ); ?>
        </div>
		<?php if ( sweeppress_core()->get_sweepers_count( 'disabled' ) > 0 ) { ?>
            <div class="d4p-status-message" style="margin: 0 0 .5em;">
                <span class="d4p-card-badge d4p-badge-right d4p-badge-red"><i class="d4p-icon d4p-ui-tag"></i> <?php echo esc_html( sweeppress_core()->get_sweepers_count( 'disabled' ) ); ?></span>
				<?php esc_html_e( "Number of disabled Sweepers", "sweeppress" ); ?>
                <span class="d4p-status-inline-help" title="<?php esc_attr_e( "Some sweepers depend on the multisite network installation, or third party plugins that are not found on this website.", "sweeppress" ); ?>"><i class="d4p-icon d4p-ui-question"></i></span>
            </div>
		<?php } ?>
    </div>
</div>