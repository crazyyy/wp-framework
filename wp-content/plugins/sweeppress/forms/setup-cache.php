<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-install-block">
    <h4>
		<?php esc_html_e( "Purge estimates cache", "sweeppress" ); ?>
    </h4>
    <div>
		<?php

		sweeppress_settings()->purge_sweeper_cache();

		esc_html_e( "Cached data has been purged.", "sweeppress" );

		?>
    </div>
</div>
