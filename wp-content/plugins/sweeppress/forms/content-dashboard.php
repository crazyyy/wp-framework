<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-content">
    <div class="d4p-cards-wrapper">
		<?php

		include( SWEEPPRESS_PATH . 'forms/content-dashboard-info.php' );
		include( SWEEPPRESS_PATH . 'forms/content-dashboard-auto.php' );
		include( SWEEPPRESS_PATH . 'forms/content-dashboard-cleanup.php' );
		include( SWEEPPRESS_PATH . 'forms/content-dashboard-database.php' );
		include( SWEEPPRESS_PATH . 'forms/content-dashboard-pro.php' );

		?>
    </div>
</div>